<?php

$page_owner = elgg_get_page_owner_entity();

echo elgg_view('output/url', array(
    'href' => 'draw/avatar/' . $page_owner->username,
    'text' => elgg_echo('draw:avatar'),
    'is_trusted' => true,
    'class' => 'elgg-button elgg-button-action'
));

echo '<br><br>';
echo '----  ' . elgg_echo('draw:or') . '  ----';
echo '<br><br>';
