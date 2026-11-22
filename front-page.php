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
    'meta_key' => 'price',
    'orderby' => [
      'meta_value_num' => 'ASC',
      'title' => 'ASC',
    ],
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
  'posts_per_page' => -1,
  'orderby' => 'title',
  'order' => 'ASC',
  'no_found_rows' => true,
]);

if (!empty($cluster_query->posts)) {
  update_post_thumbnail_cache($cluster_query);
}

if (!empty($unit_query->posts)) {
  update_post_thumbnail_cache($unit_query);
}

$normalize_hero_items = static function (array $unit_ids): array {
  $fallback_image = Helpers::get_image_placeholder_url('fallback-2-undraw');
  $items = [];

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

$unit_ids = wp_list_pluck($unit_query->posts, 'ID');
$hero_items = $normalize_hero_items($unit_ids);

get_header();
?>

<!-- HERO -->
<?php
Helpers::module('hero-main', [
  'items' => $hero_items
]);
?>

<?php get_footer();