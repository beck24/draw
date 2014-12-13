<?php

namespace Draw;

const PLUGIN_ID = 'draw';
const UPGRADE_VERSION = 20141210;

require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/functions.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

function init() {
  
  if (elgg_get_plugin_setting('avatar', 'draw') != 'no') {
    elgg_extend_view('forms/avatar/upload', 'draw/avataredit', 499);
  }
  
  
  // register our actions
  if (elgg_get_plugin_setting('file', 'draw') != 'no') {
    elgg_register_action('draw/file', __DIR__ . '/actions/draw/file.php');
  }
  
  if (elgg_get_plugin_setting('avatar', 'draw') != 'no') {
    elgg_register_action('draw/avatar', __DIR__ . '/actions/draw/avatar.php');
  }
  
  elgg_register_page_handler('draw', __NAMESPACE__ . '\\page_handler');
  
  elgg_register_plugin_hook_handler('register', 'menu:title', __NAMESPACE__ . '\\title_menu');
  
  elgg_register_ajax_view('draw/convert');
  
  register_js();
}


/**
 * draw/file/<container_guid> - save drawing as file with container_guid
 * draw/avatar/<owner_guid> - save drawing as avatar for user/group guid
 * 
 * @param array $page
 */
function page_handler($page) {
  gatekeeper();
  
  switch ($page[0]) {
    case 'file':
      if (elgg_get_plugin_setting('file', 'draw') == 'no') {
        return false;
      }
      
      elgg_set_page_owner_guid($page[1]);
      if (!elgg_is_active_plugin('file')) {
        return false;
      }
      if (include('pages/draw/file.php')) {
        return true;
      }
      break;
    
    case 'avatar':
      
      if (elgg_get_plugin_setting('avatar', 'draw') == 'no') {
        return false;
      }
      
      $user = get_user_by_username($page[1]);
      if (!$user) {
        $user = elgg_get_logged_in_user_guid();
      }
      elgg_set_page_owner_guid($user->guid);
      if (include('pages/draw/avatar.php')) {
        return true;
      }
      break;
  }
  
  return false;
}

