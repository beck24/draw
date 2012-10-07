<?php
/**
 * Avatar upload action
 */

$guid = get_input('guid');
$owner = get_entity($guid);
$data = get_input('draw-image-result', false, false);

if (!$owner || !($owner instanceof ElggUser) || !$owner->canEdit()) {
	register_error(elgg_echo('avatar:upload:fail'));
	forward(REFERER);
}

if (!$data) {
  register_error(elgg_echo('draw:invalid:image'));
  forward(REFERER);
}

preg_match('#^data:[\w/]+(;[\w=]+)*,[\w+/=%]+$#', $data);

    // use ElggFile to create the directory if it doesn't exist
    $file = new ElggFile();
		$file->owner_guid = $guid;
		$file->setFilename("profile/{$guid}tmp.jpg");
		$file->open('write');
		$file->close();
    $tmp = $file->getFilenameOnFilestore();
    
// turn png into jpg
// Open original PNG image
$png = imagecreatefrompng($data);
// Transform to white-background JPEG
$jpg = draw_imagepngtojpg($png);
// Save new image
imagejpeg($jpg, $tmp, 100);

$icon_sizes = elgg_get_config('icon_sizes');

// get the images and save their file handlers into an array
// so we can do clean up if one fails.
$files = array();
foreach ($icon_sizes as $name => $size_info) {
	$resized = get_resized_image_from_existing_file($tmp, $size_info['w'], $size_info['h'], $size_info['square'], 0, 0, 0, 0, $size_info['upscale']);

	if ($resized) {
		//@todo Make these actual entities.  See exts #348.
		$file = new ElggFile();
		$file->owner_guid = $guid;
		$file->setFilename("profile/{$guid}{$name}.jpg");
		$file->open('write');
		$file->write($resized);
		$file->close();
		$files[] = $file;
	} else {
		// cleanup on fail
		foreach ($files as $file) {
			$file->delete();
		}

		register_error(elgg_echo('avatar:resize:fail'));
		forward(REFERER);
	}
}

unlink($tmp);

// reset crop coordinates
$owner->x1 = 0;
$owner->x2 = 0;
$owner->y1 = 0;
$owner->y2 = 0;

$owner->icontime = time();
if (elgg_trigger_event('profileiconupdate', $owner->type, $owner)) {
	system_message(elgg_echo("avatar:upload:success"));

	$view = 'river/user/default/profileiconupdate';
	elgg_delete_river(array('subject_guid' => $owner->guid, 'view' => $view));
	add_to_river($view, 'update', $owner->guid, $owner->guid);
}

forward(elgg_get_site_url() . 'avatar/edit/' . $owner->username);
