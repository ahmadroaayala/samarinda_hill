<?php
/**
 * Project Hooks
 * @package KarsaStart
 */

if (!defined('ABSPATH')) {
  exit;
}

// Autoload plugin
add_action('tgmpa_register', function () {
  $plugins = [
    [
      'name' => 'Advanced Custom Fields',
      'slug' => 'advanced-custom-fields',
      'required' => true,
    ],
    [
      'name' => 'ACF Galerie 4',
      'slug' => 'acf-galerie-4',
      'required' => true,
    ],
  ];

  $config = [
    'id' => 'karsa-start-tgmpa',
    'has_notices' => true,
    'dismissable' => true,
    'is_automatic' => true,
  ];

  tgmpa($plugins, $config);
});

add_action('pre_get_posts', function (\WP_Query $query) {
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  // Arhive Cluster
  if ($query->is_post_type_archive('cluster')) {
    $query->set('posts_per_page', 6);
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('no_found_rows', true);
  }
});