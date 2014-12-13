<?php

namespace Draw;

gatekeeper();

$page_owner = elgg_get_page_owner_entity();

if (!$page_owner->canEdit()) {
  register_error(elgg_echo('draw:invalid:permissions'));
  forward(REFERRER);
}

$title = elgg_echo('draw:avatar');

// setup breadcrumb navigation
elgg_push_breadcrumb($page_owner->name, $page_owner->getURL());
elgg_push_breadcrumb(elgg_echo('avatar:edit'), 'avatar/edit/'.$page_owner->username);
elgg_push_breadcrumb(elgg_echo('draw:avatar'));


$content = elgg_view_form('draw/avatar', array(), array('guid' => $page_owner->guid));
$content .= elgg_view('graphics/ajax_loader');

$body = elgg_view_layout('content', array(
    'title' => $title,
    'content' => $content,
    'filter' => false,
    'sidebar' => elgg_view('draw/sidebar')
));

echo elgg_view_page($title, $body);