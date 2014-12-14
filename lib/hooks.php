<?php

namespace Draw;

function file_upload($h, $t, $r, $p) {
	
	$img = get_input('draw-image-result', false, false);
	
	if (!preg_match('#^data:[\w/]+(;[\w=]+)*,[\w+/=%]+$#', $img)) {
		return $r;
	}
	
	$guid = (int) get_input('file_guid');
	$container_guid = (int) get_input('container_guid', 0);
	
	if (!$guid) {
		$title = get_input('title');
		if (!$title) {
			set_input('title', 'draw.jpg');
		}
		$options = array(
			'title' => get_input('title'),
			'container_guid' => $container_guid,
			'owner_guid' => elgg_get_logged_in_user_guid(),
			'description' => get_input('description', false),
			'access_id' => get_input('access_id'),
			'tags' => explode(",", get_input("tags")),
			'image' => $img
		);
		$guid = create_file($options);
		
		if ($guid) {
			set_input('file_guid', $guid); // set the input and let the default action run an update
		}
		return $r;
	}
	
	// we're updating a file
	// we just replace the file
	// standard action will ignore it
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'file')) {
		update_file($entity, $img);
	}
	
	return $r;
}