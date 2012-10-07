<?php

// include our procedural functions
require_once 'lib/functions.php';

// register for events
elgg_register_event_handler('init', 'system', 'draw_init');
elgg_register_event_handler('pagesetup', 'system', 'draw_pagesetup');


function draw_init() {
  elgg_extend_view('css/elgg', 'draw/css');
  
  if (elgg_get_plugin_setting('avatar', 'draw') != 'no') {
    elgg_extend_view('forms/avatar/upload', 'draw/avataredit', 499);
  }
  
  // register css for drawing
  elgg_register_css('draw/slider', elgg_get_site_url() . 'mod/draw/js/range/jquery.ui.slider.css');
  
  // register js for drawing
  elgg_register_js('draw/slider', elgg_get_site_url() . 'mod/draw/js/range/slider.js');
  elgg_register_js('draw/raphael', elgg_get_site_url() . 'mod/draw/js/raphael/raphael-min.js');
  elgg_register_js('draw/rgbcolor', elgg_get_site_url() . 'mod/draw/js/raphael/rgbcolor.js');
  elgg_register_js('draw/canvg', elgg_get_site_url() . 'mod/draw/js/raphael/canvg.js');
  elgg_register_js('draw/raphael-svg', elgg_get_site_url() . 'mod/draw/js/raphael/raphael-to-svg.js');
  elgg_register_js('draw/colorpicker', elgg_get_site_url() . 'mod/draw/js/raphael/colorwheel.js');
  elgg_register_js('draw/draw', elgg_get_site_url() . 'mod/draw/js/draw.js');
  
  // register our actions
  if (elgg_get_plugin_setting('file', 'draw') != 'no') {
    elgg_register_action('draw/file', dirname(__FILE__) . '/actions/draw/file.php');
  }
  
  if (elgg_get_plugin_setting('avatar', 'draw') != 'no') {
    elgg_register_action('draw/avatar', dirname(__FILE__) . '/actions/draw/avatar.php');
  }
  
  elgg_register_page_handler('draw', 'draw_page_handler');
  
  elgg_register_plugin_hook_handler('view', 'page/elements/owner_block', 'draw_sidebar');
  
  elgg_register_ajax_view('draw/convert');
}


/**
 * draw/file/<container_guid> - save drawing as file with container_guid
 * draw/avatar/<owner_guid> - save drawing as avatar for user/group guid
 * 
 * @param array $page
 */
function draw_page_handler($page) {
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


/**
 *  Set up our navigation
 */
function draw_pagesetup() {
  if (elgg_get_plugin_setting('file', 'draw') == 'no') {
    return;
  }
  
  if (elgg_get_context() == 'file' && elgg_is_logged_in()) {
    $page_owner = elgg_get_page_owner_entity();
    $createlink = false;
    
    if (!$page_owner) {
      $page_owner = elgg_get_logged_in_user_entity();
    }
    
    if ($page_owner->canEdit()) {
      $createlink = true;
    }
    
    if (!$createlink && elgg_instanceof($page_owner, 'group') && $page_owner->isMember()) {
      $createlink = true;
    }
    
    if ($createlink) {
      elgg_register_menu_item('title', array(
        'name' => 'draw',
        'href' => 'draw/file/' . $page_owner->guid,
        'text' => elgg_echo('draw:picture'),
        'class' => 'elgg-button elgg-button-action',
        'contexts' => array('file'),
        'priority' => 1000
      ));
    }
  }
}


function draw_sidebar($hook, $type, $return, $params) {
  if (elgg_get_context() == 'draw') {
    return '';
  }
}