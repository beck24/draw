<?php

namespace Draw;

function draw_group_gatekeeper($group, $forward = true, $url = '') {
  if (!elgg_instanceof($group, 'group')) {
    return true;
  }
  
  if (!$group->isMember() && !$group->canEdit()) {
    if ($forward) {
      register_error('draw:group_gatekeeper');
      forward($url);
    }
    else {
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