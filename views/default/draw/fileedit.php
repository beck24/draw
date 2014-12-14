<?php

namespace Draw;

elgg_load_js('lightbox');
elgg_load_css('lightbox');

elgg_load_css('wColorPicker');
elgg_load_css('jquery.wPaint');
elgg_require_js('draw/main');

$guid = $vars['entity'] ? $vars['entity']->guid : 0;

echo '<div>';
echo elgg_view('output/url', array(
    'href' => 'ajax/view/draw/filemodal?guid=' . $guid,
    'text' => elgg_echo('draw:picture'),
    'is_trusted' => true,
    'class' => 'elgg-button elgg-button-action elgg-lightbox'
));
echo '</div>';

echo '<div class="draw-target"></div>';

echo elgg_view('input/hidden', array(
	'id' => 'draw-image-result',
	'name' => 'draw-image-result',
	'value' => ''
));