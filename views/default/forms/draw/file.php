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

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));

echo elgg_view('forms/file/upload');