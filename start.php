<?php

namespace Draw;

const PLUGIN_ID = 'draw';
const UPGRADE_VERSION = 20141210;

require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/functions.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

function init() {

	// register our actions
	if (elgg_get_plugin_setting('file', PLUGIN_ID) != 'no') {
		elgg_extend_view('forms/file/upload', 'draw/fileedit', 499);
		elgg_register_plugin_hook_handler('action', 'file/upload', __NAMESPACE__ . '\\file_upload');
	}

	if (elgg_get_plugin_setting('avatar', PLUGIN_ID) != 'no') {
		elgg_extend_view('forms/avatar/upload', 'draw/avataredit', 499);
		elgg_register_action('draw/avatar', __DIR__ . '/actions/draw/avatar.php');
	}

	register_js();

	elgg_register_ajax_view('draw/avatarmodal');
	elgg_register_ajax_view('draw/filemodal');
}
