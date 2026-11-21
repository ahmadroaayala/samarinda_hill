<?php

use KarsaStart\Helpers;
/**
 * View: Root Front Page
 * @package KarsaStart
 */

// CLUSTER ARGS AND QUERY 
$cluster_args = [
  'post_type' => 'cluster',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'orderby' => 'title',
  'order' => 'ASC',
  'no_found_rows' => true,
];
$cluster_query = new WP_Query($cluster_args);


// UNIT ARGS AND QUERY
$unit_args = [
  'post_type' => 'unit',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'orderby' => 'title',
  'order' => 'ASC',
  'no_found_rows' => true,
  'meta_query' => [
    [
      'key' => 'availability_status',
      'value' => 'ready',
      'compare' => '=',
    ],
  ],
];
$unit_query = new WP_Query($unit_args);


// FACILITY ARGS AND QUERY
$facility_args = [
  'post_type' => 'facility',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'orderby' => 'title',
  'order' => 'ASC',
  'no_found_rows' => true,
];
$facility_query = new WP_Query($facility_args);

get_header();
?>

<!-- HERO -->
<?php
$hero_items = [];
$fallback_image = Helpers::get_image_placeholder_url('fallback-2-undraw');

foreach ($unit_query->posts as $unit) {
  // CLUSTER
  // Cluster parent
  $raw_cluster = get_field('parent_cluster', $unit->ID);
  $cluster_id = $raw_cluster instanceof WP_Post ? $raw_cluster->ID : absint($raw_cluster);

  // Cluster title and thumbnail
  $cluster_title = $cluster_id > 0 ? get_the_title($cluster_id) : __('Samarinda Hill', 'karsa_start');
  $cluster_thumb = $cluster_id > 0 ? get_the_post_thumbnail_url($cluster_id, 'full') : '';


  $hero_items[] = [
    'id' => $unit->ID,
    'title' => get_the_title($unit),
    'url' => get_the_permalink($unit),
    'cluster' => [
      'id' => $cluster_id,
      'image_url' => $cluster_thumb ?: $fallback_image,
      'image_alt' => $cluster_title,
    ]
  ];
}

Helpers::module('hero-main', [
  'items' => $hero_items,
]);
?>

<!-- FACILITY -->
<?php
Helpers::module('facility-showcase', [
  'archive_url' => get_post_type_archive_link('facility'),
  'archive_url_label' => __('Semua fasilitas', 'karsa_start'),
  'title' => __('Fasilitas', 'karsa_start'),
  'items' => $facility_query
]);
?>


<?php get_footer();