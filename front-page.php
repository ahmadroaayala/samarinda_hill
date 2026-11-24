<?php
/**
 * View: Root Front Page
 * @package KarsaStart
 */

use KarsaStart\Core\Helpers;
use KarsaStart\Project\Normalizer;

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
foreach ([$cluster_query, $unit_query, $facility_query] as $query) {
  if (!empty($query->posts)) {
    update_post_thumbnail_cache($query);
  }
}

// DATA ASSIGNMENT
// Hero and Cluster
$unit_ids = wp_list_pluck($unit_query->posts, 'ID');
$cluster_ids = wp_list_pluck($cluster_query->posts, 'ID');
$cluster_items = Normalizer::units_by_cluster($cluster_ids, $unit_ids);
// Facility
$facility_ids = wp_list_pluck($facility_query->posts, 'ID');
$facility_items = Normalizer::facility_items($facility_ids);

get_header();
?>

<!-- HERO MODULE -->
<?php
Helpers::module('hero-main', [
  'items' => $cluster_items
]);
?>

<!-- CLUSTER MODULE -->
<?php
Helpers::module('cluster-showcase', [
  'items' => $cluster_items
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