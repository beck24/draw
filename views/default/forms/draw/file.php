<?php

namespace Draw;

elgg_load_css('wColorPicker');
elgg_load_css('jquery.wPaint');
elgg_require_js('wPaint.text');

echo <<<HTML
<div id="wPaint" style="position:relative; margin: 0 auto; width: 600px; height: 400px; border: 1px solid black;">

</div>

HTML;

$existing = '';
$file = get_entity($vars['guid']);
if (elgg_instanceof($file, 'object', 'file') && $file->simpletype == 'image') {
	$path = $file->getFilenameOnFilestore();
	$contents = file_get_contents($path);
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$existing =  "data:image/{$type};base64," . base64_encode($contents);
}

echo elgg_view('input/hidden', array('id' => 'draw-image-result', 'name' => 'draw-image-result', 'value' => ''));
//echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
echo elgg_view('input/hidden', array('name' => 'draw-existing', 'value' => $existing));

echo '<div class="center mtm">';
echo elgg_view('output/url', array(
	'text' => elgg_echo('draw:done'),
	'href' => '#',
	'class' => 'elgg-button elgg-button-submit draw-image-select'
));
echo '</div>';