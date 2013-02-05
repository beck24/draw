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


function draw_title_menu($hook, $type, $return, $params) {
  // inspect the menu items only if we're in files
  if (elgg_get_context() == 'file' && elgg_is_logged_in() && is_array($return)) {
	$createlink = false;
	foreach ($return as $key => $item) {
	  if ($item->getName() == 'add') {
		$createlink = true;
	  }
	}
	
	$owner = elgg_get_page_owner_entity();
	
	if ($createlink && elgg_instanceof($owner)) {
	  $draw = new ElggMenuItem('draw', elgg_echo('draw:picture'), 'draw/file/' . $owner->guid);
	  $draw->setLinkClass('elgg-button elgg-button-action');
	  
	  $return[] = $draw;
	}
  }
  
  return $return;
}