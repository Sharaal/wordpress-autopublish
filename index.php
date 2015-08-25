<?php
// outputformat: text/plain
header('Content-Type:text/plain');

// give the last cron 15 min time to run
$interval = getenv('INTERVAL') - (60 * 15);

// load the wordpress environment
require_once(getenv('WORDPRESS_PATH') . '/wp-load.php');

// get the last published post
$publish = get_posts(['numberposts' => 1, 'orderby' => 'post_date', 'order' => 'DESC', 'post_status' => 'publish'])[0];
echo 'latest post:' . "\n";
echo 'ID: ' . $publish->ID . ', title: ' . $publish->post_title . ', post_date: ' . $publish->post_date . "\n";
if (strtotime($publish->post_date) >= (time() - $interval)) {
    // found a post in the interval, so nothing to do
    echo "\n" . 'Nothing to publish, found current post.' . "\n";
    exit(0);
}

// get the earliest pending post
$pendings = get_posts(array('numberposts' => 1, 'orderby' => 'post_date', 'order' => 'ASC', 'post_status' => 'pending'));
if (count($pendings) == 0) {
    // no pending posts available to publish
    echo "\n" . 'Nothing to publish, no pending post available.' . "\n";
    exit(0);
}
$pending = $pendings[0];

// publish the pending post
echo "\n" . 'Publish pending post.' . "\n";
echo 'ID: ' . $pending->ID . ', title: ' . $pending->post_title . "\n";
$now = time();
wp_update_post(['ID' => $pending->ID, 'post_status' => 'publish', 'post_date' => date('Y-m-d H:i:s', $now), 'post_date_gmt' => gmdate('Y-m-d H:i:s', $now)]);
