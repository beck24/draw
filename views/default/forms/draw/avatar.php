<?php

namespace Draw;

elgg_load_css('wColorPicker');
elgg_load_css('jquery.wPaint');
elgg_require_js('draw/main');

echo <<<HTML
<div style="position:relative; height: 60px;">Hello</div>
<div id="wPaint" style="position:relative; margin: 0 auto; width: 80%px; height: 400px">

</div>

HTML;

echo elgg_view('input/hidden', array('id' => 'draw-image-result', 'name' => 'draw-image-result', 'value' => ''));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));

echo '<div class="center">';
echo elgg_view('input/submit', array('value' => elgg_echo('draw:save:avatar')));
echo '</div>';