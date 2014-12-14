<?php

namespace Draw;

elgg_load_js('lightbox');
elgg_load_css('lightbox');

elgg_load_css('wColorPicker');
elgg_load_css('jquery.wPaint');
elgg_require_js('wPaint.text'); // note - text will require everything else we need

$page_owner = elgg_get_page_owner_entity();

echo elgg_view('output/url', array(
    'href' => 'ajax/view/draw/avatarmodal?guid=' . $page_owner->guid,//'draw/avatar/' . $page_owner->username,
    'text' => elgg_echo('draw:avatar'),
    'is_trusted' => true,
    'class' => 'elgg-button elgg-button-action elgg-lightbox'
));

echo '<br><br>';
echo '----  ' . elgg_echo('draw:or') . '  ----';
echo '<br><br>';
