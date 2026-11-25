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
<div id="page" class="py-8 md:py-12">

  <div class="container">

    <div class="flex flex-col gap-6">

      <?php Helpers::component('breadcrumb', [
        'items' => $breadcrumb_items
      ]) ?>

      <div>
        <h1>Cluster</h1>

        <div>
          <?php foreach ($cluster_items as $cluster):
            $prices = array_filter(array_map('intval', array_column($cluster['units'] ?? [], 'price')));
            $min_price = !empty($prices) ? min($prices) : 0;

            ?>

            <article>

              <img
                src="<?= esc_url($cluster['thumbnail_url']) ?>"
                alt="<?= esc_attr($cluster['title']) ?>">

              <h2><?= esc_html($cluster['title']) ?></h2>

              <span class="text-xs text-on-surface-subtle line-clamp-1">
                <?= esc_html($cluster['location']) ?>
              </span>

              <p class="line-clamp-3"><?= esc_html($cluster['excerpt']) ?></p>

              <div>
                <?php foreach ($cluster['cluster_facility'] as $facility): ?>
                  <div>
                    <img src="<?= esc_url($facility['thumbnail_url']) ?>" alt="">
                    <h3><?= esc_html($facility['title']) ?></h3>
                  </div>
                <?php endforeach ?>
              </div>

              <span>
                <span><?= esc_html(__('Harga mulai dari ', 'karsa_start')) ?></span>
                <span>
                  <?= esc_html(Format::rupiah($min_price)) ?>
                </span>
              </span>

            </article>

          <?php endforeach ?>
        </div>
      </div>

    </div>

  </div>

</div>



<?php get_footer();