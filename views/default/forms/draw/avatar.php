<?php

namespace Draw;

elgg_load_css('wColorPicker');
elgg_load_css('jquery.wPaint');
elgg_require_js('draw/main');

echo <<<HTML
<div id="wPaint" style="position:relative; margin: 0 auto; width: 600px; height: 400px; border: 1px solid black;">

</div>

HTML;

echo '<div class="center mtm">';
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
echo elgg_view('input/hidden', array('id' => 'draw-image-result', 'value' => '', 'name' => 'draw-image-result'));
echo elgg_view('input/submit', array('value' => elgg_echo('draw:save:avatar')));
echo '</div>';
