<?php
/**
 * Project Hooks
 * @package KarsaStart
 */

if (!defined('ABSPATH')) {
  exit;
}

add_action('pre_get_posts', function (\WP_Query $query) {
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  // Arhive Cluster
  if ($query->is_post_type_archive('cluster')) {
    $query->set('posts_per_page', -1);
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('no_found_rows', true);
  }
});