<?php
/**
 * Elgg file uploader/edit action
 *
 * @package ElggFile
 */

// Get variables
$title = get_input("title", false);
$desc = get_input("description");
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$guid = (int) get_input('file_guid');
$tags = get_input("tags");
$data = get_input('draw-image-result', false, false);

if (!$data) {
  register_error(elgg_echo('draw:invalid:image'));
  forward(REFERER);
}

if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('file');

if (!$title) {
  $title = elgg_echo('draw:untitled');
}

$file = new FilePluginFile();
$file->subtype = "file";
$file->title = $title;
$file->description = $desc;
$file->access_id = $access_id;
$file->container_guid = $container_guid;

$tags = explode(",", $tags);
$file->tags = $tags;



$prefix = "file/";

$filestorename = elgg_strtolower(time() . 'draw.jpg');

$file->setFilename($prefix . $filestorename);
$mime_type = 'image/jpeg';

$file->setMimeType($mime_type);
$file->originalfilename = 'draw.jpg';
$file->simpletype = file_get_simple_type($mime_type);

// Open the file to guarantee the directory exists
$file->open("write");
$file->close();


//header("Location: $data"); exit;
preg_match('#^data:[\w/]+(;[\w=]+)*,[\w+/=%]+$#', $data);

copy($data, $file->getFilenameOnFilestore());

// turn png into jpg
// Open original PNG image
$png = imagecreatefrompng($data);
// Transform to white-background JPEG
$jpg = draw_imagepngtojpg($png);
// Save new image
imagejpeg($jpg, $file->getFilenameOnFilestore(), 100);

$guid = $file->save();

// if image, we need to create thumbnails (this should be moved into a function)
if ($guid && $file->simpletype == "image") {
	$file->icontime = time();
		
	$thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 60, 60, true);
	if ($thumbnail) {
		$thumb = new ElggFile();
		//$thumb->setMimeType('image/png');
    $thumb->setMimeType('image/jpeg');

    $thumb->setFilename($prefix."thumb".$filestorename);
		$thumb->open("write");
		$thumb->write($thumbnail);
		$thumb->close();

		$file->thumbnail = $prefix."thumb".$filestorename;
		unset($thumbnail);
	}

	$thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 153, 153, true);
	if ($thumbsmall) {
		$thumb->setFilename($prefix."smallthumb".$filestorename);
		$thumb->open("write");
		$thumb->write($thumbsmall);
		$thumb->close();
		$file->smallthumb = $prefix."smallthumb".$filestorename;
		unset($thumbsmall);
	}

	$thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 600, 600, false);
	if ($thumblarge) {
		$thumb->setFilename($prefix."largethumb".$filestorename);
		$thumb->open("write");
		$thumb->write($thumblarge);
		$thumb->close();
		$file->largethumb = $prefix."largethumb".$filestorename;
		unset($thumblarge);
	}
}


// file saved so clear sticky form
elgg_clear_sticky_form('file');


if ($guid) {
	$message = elgg_echo("file:saved");
	system_message($message);
	add_to_river('river/object/file/create', 'create', elgg_get_logged_in_user_guid(), $file->guid);
  forward($file->getURL());
} else {
	// failed to save file object - nothing we can do about this
	$error = elgg_echo("file:uploadfailed");
	register_error($error);
}

$container = get_entity($container_guid);
if (elgg_instanceof($container, 'group')) {
	forward("file/group/$container->guid/all");
} else {
	forward("file/owner/$container->username");
}
