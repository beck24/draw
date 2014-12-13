<?php

namespace Draw;

if (!elgg_get_plugin_setting('upgrade_version', PLUGIN_ID)) {
	elgg_set_plugin_setting('upgrade_version', 20141210, PLUGIN_ID);
}