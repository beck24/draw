<?php

namespace Draw;

function title_menu($hook, $type, $return, $params) {
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