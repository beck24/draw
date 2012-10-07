<?php

echo elgg_view('input/dropdown', array(
    'name' => 'params[file]',
    'value' => $vars['entity']->file ? $vars['entity']->file : 'yes',
    'options_values' => array(
        'yes' => elgg_echo('option:yes'),
        'no' => elgg_echo('option:no')
    )
));

echo " " . elgg_echo('draw:settings:file');

echo "<br><br>";

echo elgg_view('input/dropdown', array(
    'name' => 'params[avatar]',
    'value' => $vars['entity']->avatar ? $vars['entity']->avatar : 'yes',
    'options_values' => array(
        'yes' => elgg_echo('option:yes'),
        'no' => elgg_echo('option:no')
    )
));

echo " " . elgg_echo('draw:settings:avatar');
echo "<br><br>";