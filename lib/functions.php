<?php

namespace Draw;
use FilePluginFile;
use ElggFile;

function draw_group_gatekeeper($group, $forward = true, $url = '') {
	if (!elgg_instanceof($group, 'group')) {
		return true;
	}

	if (!$group->isMember() && !$group->canEdit()) {
		if ($forward) {
			register_error('draw:group_gatekeeper');
			forward($url);
		} else {
			return false;
		}
	}

	return true;
}

function draw_imagepngtojpg($trans) {
	// Create a new true color image with the same size
	$w = imagesx($trans);
	$h = imagesy($trans);
	$white = imagecreatetruecolor($w, $h);

	// Fill the new image with white background
	$bg = imagecolorallocate($white, 255, 255, 255);
	imagefill($white, 0, 0, $bg);

	// Copy original transparent image onto the new image
	imagecopy($white, $trans, 0, 0, 0, 0, $w, $h);
	return $white;
}

function register_js() {

	elgg_register_css('wColorPicker', '/mod/' . PLUGIN_ID . '/vendors/wPaint/lib/wColorPicker.min.css');
	elgg_define_js('wColorPicker', array(
		'src' => '/mod/' . PLUGIN_ID . '/vendors/wPaint/lib/wColorPicker.min.js',
		'deps' => array('jquery')
	));

	elgg_register_css('jquery.wPaint', '/mod/' . PLUGIN_ID . '/vendors/wPaint/wPaint.min.css');
	elgg_define_js('jquery.wPaint', array(
		'src' => '/mod/' . PLUGIN_ID . '/vendors/wPaint/wPaint.min.js',
		'deps' => array('jquery', 'wColorPicker')
	));

	elgg_define_js('wPaint.menu', array(
		'src' => '/mod/' . PLUGIN_ID . '/vendors/wPaint/plugins/main/wPaint.menu.main.min.js',
		'deps' => array('jquery.wPaint')
	));

	elgg_define_js('wPaint.shapes', array(
		'src' => '/mod/' . PLUGIN_ID . '/vendors/wPaint/plugins/shapes/wPaint.menu.main.shapes.min.js',
		'deps' => array('jquery.wPaint')
	));

	elgg_define_js('wPaint.file', array(
		'src' => '/mod/' . PLUGIN_ID . '/vendors/wPaint/plugins/file/wPaint.menu.main.file.min.js',
		'deps' => array('jquery.wPaint')
	));

	elgg_define_js('wPaint.text', array(
		'src' => '/mod/' . PLUGIN_ID . '/vendors/wPaint/plugins/text/wPaint.menu.text.min.js',
		'deps' => array('wPaint.menu', 'wPaint.shapes')
	));
}

function create_file($options) {
	
	$file = new FilePluginFile();
	$file->subtype = "file";
	$file->title = $options['title'];
	$file->description = $options['description'];
	$file->access_id = $options['access_id'];
	$file->container_guid = $options['container_guid'];
	$file->owner_guid = $options['owner_guid'];
	$file->tags = $options['tags'];


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

	copy($options['image'], $file->getFilenameOnFilestore());

// turn png into jpg
// Open original PNG image
	$png = imagecreatefrompng($options['image']);
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
			$thumb->owner_guid = $options['owner_guid'];
			//$thumb->setMimeType('image/png');
			$thumb->setMimeType('image/jpeg');

			$thumb->setFilename($prefix . "thumb" . $filestorename);
			$thumb->open("write");
			$thumb->write($thumbnail);
			$thumb->close();

			$file->thumbnail = $prefix . "thumb" . $filestorename;
			unset($thumbnail);
		}

		$thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 153, 153, true);
		if ($thumbsmall) {
			$thumb->setFilename($prefix . "smallthumb" . $filestorename);
			$thumb->open("write");
			$thumb->write($thumbsmall);
			$thumb->close();
			$file->smallthumb = $prefix . "smallthumb" . $filestorename;
			unset($thumbsmall);
		}

		$thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 600, 600, false);
		if ($thumblarge) {
			$thumb->setFilename($prefix . "largethumb" . $filestorename);
			$thumb->open("write");
			$thumb->write($thumblarge);
			$thumb->close();
			$file->largethumb = $prefix . "largethumb" . $filestorename;
			unset($thumblarge);
		}

		return $file->guid;
	}

	return false;
}


function update_file($file, $img) {
	copy($img, $file->getFilenameOnFilestore());

// turn png into jpg
// Open original PNG image
	$png = imagecreatefrompng($img);
// Transform to white-background JPEG
	$jpg = draw_imagepngtojpg($png);
// Save new image
	imagejpeg($jpg, $file->getFilenameOnFilestore(), 100);

	$guid = $file->save();
	
	$mime_type = $file->detectMimeType($file->getFilenameOnFilestore(), 'image/jpeg');
	$file->setMimeType($mime_type);
	$file->simpletype = file_get_simple_type($mime_type);

// if image, we need to create thumbnails (this should be moved into a function)
	if ($guid && $file->simpletype == "image") {
		$file->icontime = time();

		$thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 60, 60, true);
		if ($thumbnail) {
			$thumb = new ElggFile();
			$thumb->owner_guid = $options['owner_guid'];
			//$thumb->setMimeType('image/png');
			$thumb->setMimeType('image/jpeg');

			$thumb->setFilename($prefix . "thumb" . $filestorename);
			$thumb->open("write");
			$thumb->write($thumbnail);
			$thumb->close();

			$file->thumbnail = $prefix . "thumb" . $filestorename;
			unset($thumbnail);
		}

		$thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 153, 153, true);
		if ($thumbsmall) {
			$thumb->setFilename($prefix . "smallthumb" . $filestorename);
			$thumb->open("write");
			$thumb->write($thumbsmall);
			$thumb->close();
			$file->smallthumb = $prefix . "smallthumb" . $filestorename;
			unset($thumbsmall);
		}

		$thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 600, 600, false);
		if ($thumblarge) {
			$thumb->setFilename($prefix . "largethumb" . $filestorename);
			$thumb->open("write");
			$thumb->write($thumblarge);
			$thumb->close();
			$file->largethumb = $prefix . "largethumb" . $filestorename;
			unset($thumblarge);
		}

		return $file->guid;
	}
}