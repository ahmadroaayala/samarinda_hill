<?php

use KarsaStart\Helpers;
/**
 * View: Root Front Page
 * @package KarsaStart
 */

// CLUSTER ARGS AND QUERY 
$cluster_args = [
  'post_type' => 'facility',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'orderby' => 'title',
  'order' => 'ASC',
  'no_found_rows' => true,
];

$cluster_query = new WP_Query($cluster_args);
// END OF CLUSTER ARGS AND QUERY

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
// END FACILITY ARGS AND QUERY

get_header();
?>

<!-- Fasilitas -->
<?php Helpers::module('facility-slider', [
  'title' => __('Fasilitas', 'karsa_start'),
  'items' => $facility_query
]) ?>


<?php get_footer();