<?php
/**
 * View: Archive Cluster
 * @package KarsaStart
 */

use KarsaStart\Core\Breadcrumb;
use KarsaStart\Core\Format;
use KarsaStart\Core\Helpers;
use KarsaStart\Project\Normalizer;

global $wp_query;

$breadcrumb_items = Breadcrumb::archive('cluster');

$cluster_ids = wp_list_pluck($wp_query->posts, 'ID');
$units = new WP_Query(
  [
    'post_type' => 'unit',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'fields' => 'ids',
    'no_found_rows' => true,
  ]
);

$cluster_items = Normalizer::units_by_cluster($cluster_ids, $units->posts);

get_header();
?>
<div id="page" class="py-8 md:py-12 bg-surface-bright">

  <div class="container">

    <div class="flex flex-col gap-4 sm:gap-6">

      <?php Helpers::component('breadcrumb', [
        'items' => $breadcrumb_items
      ]) ?>

      <div class="flex flex-col gap-4 sm:gap-6">
        <h1>Cluster</h1>

        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
          <?php
          foreach ($cluster_items as $cluster):
            $prices = array_filter(array_map('intval', array_column($cluster['units'] ?? [], 'price')));
            $min_price = !empty($prices) ? min($prices) : 0;

            Helpers::component('cards/card-cluster-archive', [
              'min_price' => $min_price,
              'cluster' => $cluster
            ]);
          endforeach;
          ?>
        </div>
      </div>

    </div>

  </div>

</div>



<?php get_footer();