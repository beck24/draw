<?php


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

/**
 * convenience function for registering js/css
 */
function draw_register_dependencies() {
  elgg_load_css('draw/slider');
  
  // load js for drawing
  elgg_load_js('draw/raphael');
  elgg_load_js('draw/rgbcolor');
  elgg_load_js('draw/canvg');
  elgg_load_js('draw/raphael-svg');
  elgg_load_js('draw/colorpicker');
  elgg_load_js('draw/draw');
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