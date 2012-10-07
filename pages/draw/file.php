<?php
gatekeeper();

$page_owner = elgg_get_page_owner_entity();
draw_group_gatekeeper($page_owner, true, REFERRER);

elgg_unextend_view('page/layouts/content/sidebar', 'page/elements/owner_block');

$title = elgg_echo('draw:picture');

// setup breadcrumb navigation
if (elgg_instanceof($page_owner, 'group')) {
  $url = elgg_get_site_url() . 'file/group/' . $page_owner->guid . '/all';
}
else {
  $url = elgg_get_site_url() . 'file/owner/' . $page_owner->username;
}

elgg_push_breadcrumb(elgg_echo('file'), $url);
elgg_push_breadcrumb(elgg_echo('draw:picture'));


$content = elgg_view_form('draw/file', array('container_guid' => elgg_get_page_owner_guid()));
$content .= elgg_view('graphics/ajax_loader');

$body = elgg_view_layout('content', array(
    'title' => $title,
    'content' => $content,
    'filter' => false,
    'sidebar' => elgg_view('draw/sidebar')
));

echo elgg_view_page($title, $body);