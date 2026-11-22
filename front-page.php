<?php

use KarsaStart\Helpers;
/**
 * View: Root Front Page
 * @package KarsaStart
 */



$cluster_query = new WP_Query([
  'post_type' => 'cluster',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'orderby' => 'title',
  'order' => 'ASC',
  'no_found_rows' => true,
]);

$unit_query = new WP_Query(
  [
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
  ]
);

$facility_query = new WP_Query([
  'post_type' => 'facility',
  'post_status' => 'publish',
  'posts_per_page' => 3,
  'orderby' => 'title',
  'order' => 'ASC',
  'no_found_rows' => true,
]);

// SET CACHE
$queries = [$cluster_query, $unit_query, $facility_query];
foreach ($queries as $query) {
  if (!empty($query->posts)) {
    update_post_thumbnail_cache($query);
  }
}

// NORMALIZATION
// Hero normalization
$normalize_hero_items = static function (array $unit_ids): array {
  usort($unit_ids, static function (int $a, int $b): int {
    $price_a = (int) (get_field('price', $a) ?: PHP_INT_MAX);
    $price_b = (int) (get_field('price', $b) ?: PHP_INT_MAX);

    return $price_a <=> $price_b;
  });

  $items = [];
  $fallback_image = Helpers::get_image_placeholder_url('fallback-2-undraw');

  foreach ($unit_ids as $unit_id) {
    $raw_cluster = get_field('parent_cluster', $unit_id);
    $cluster_id = $raw_cluster instanceof WP_Post ? $raw_cluster->ID : absint($raw_cluster);
    $cluster_title = $cluster_id > 0 ? get_the_title($cluster_id) : __('Samarinda Hill', 'karsa_start');
    $cluster_thumb = $cluster_id > 0 ? get_the_post_thumbnail_url($cluster_id, 'full') : '';

    if (!isset($items[$cluster_id])) {
      $items[$cluster_id] = [
        'id' => $cluster_id,
        'title' => $cluster_title,
        'thumb_url' => $cluster_thumb ?: $fallback_image,
        'units' => []
      ];
    }

    $items[$cluster_id]['units'][] = [
      'id' => $unit_id,
      'title' => get_the_title($unit_id),
      'url' => get_the_permalink($unit_id),
      'thumb_url' => get_the_post_thumbnail_url($unit_id, 'medium') ?: $fallback_image,
      'price' => get_field('price', $unit_id)
    ];
  }

  return array_values($items);
};
// Cluster normalization
$normalize_cluster_items = static function (array $cluster_ids, array $unit_ids): array {
  $fallback_image = Helpers::get_image_placeholder_url('fallback-2-undraw');
  $items = [];

  foreach ($cluster_ids as $cluster_id) {
    if (!isset($items[$cluster_id])) {
      $items[$cluster_id] = [
        'title' => get_the_title($cluster_id)
      ];
    }

  }

  return $items;
};
// Facility normalization
$normalize_facility_items = static function (array $facility_ids): array {
  $items = [];
  $fallback_image = Helpers::get_image_placeholder_url('fallback-2-undraw');

  foreach ($facility_ids as $facility_id) {
    $items[] = [
      'post_url' => get_the_permalink($facility_id),
      'thumbnail_url' => get_the_post_thumbnail_url($facility_id, 'large') ?: $fallback_image,
      'title' => get_the_title($facility_id),
      'excerpt' => get_the_excerpt($facility_id)
    ];
  }

  return $items;
};

// DATA ASSIGNMENT
// Hero 
$unit_ids = wp_list_pluck($unit_query->posts, 'ID');
$hero_items = $normalize_hero_items($unit_ids);
// Cluster
$cluster_ids = wp_list_pluck($cluster_query->posts, 'ID');
$cluster_items = $normalize_cluster_items($cluster_ids, $unit_ids);
dump($cluster_items);
// Facility
$facility_ids = wp_list_pluck($facility_query->posts, 'ID');
$facility_items = $normalize_facility_items($facility_ids);

get_header();
?>

<!-- HERO MODULE -->
<?php
Helpers::module('hero-main', [
  'items' => $hero_items
]);
?>

<!-- FACILITY MODULE -->
<?php
Helpers::module('facility-showcase', [
  'archive_url' => get_post_type_archive_link('facility'),
  'archive_url_label' => __('Lihat semua fasilitas', 'karsa_start'),
  'title' => __('Fasilitas', 'karsa_start'),
  'items' => $facility_items
]);
?>

<?php get_footer();