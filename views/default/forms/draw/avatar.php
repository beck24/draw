<?php

draw_register_dependencies();

echo <<<HTML
&nbsp;
<div id="canvaswrapper">
	<div id="canvas"></div>
</div>

<canvas id='realcanvas' width='500px' height='500px' style='border: 1px solid black;'></canvas>
HTML;

echo elgg_view('input/hidden', array('id' => 'draw-image-result', 'name' => 'draw-image-result', 'value' => ''));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));

echo '<div class="center">';
echo elgg_view('input/submit', array('value' => elgg_echo('draw:save:avatar')));
echo '</div>';