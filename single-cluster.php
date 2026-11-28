<?php
/**
 * View: Single Cluster
 * @package KarsaStart
 */

use KarsaStart\Core\Breadcrumb;
use KarsaStart\Core\Helpers;
use KarsaStart\Project\Normalizer;

global $post;
$cluster_id = $post->ID;
$cluster = Normalizer::cluster($cluster_id);

$breadcrumb_items = Breadcrumb::single('cluster');

$gallery_map = array_column($cluster['gallery'], 'id');

get_header();
?>

<div id="page" class="flex-1 py-8">
  <div class="flex flex-col gap-6">

    <!-- Breadcrumb -->
    <div class="container">
      <?php Helpers::component('breadcrumb', [
        'items' => $breadcrumb_items
      ]); ?>
    </div>

    <div class="container flex flex-col gap-6">

      <!-- Image gallery -->
      <?php Helpers::module('image-gallery', [
        'gallery' => $cluster['gallery'],
        'wrapper_class' => ''
      ]); ?>

      <div
        class="flex flex-col gap-1">
        <h1><?= esc_html($cluster['title']) ?></h1>
        <p class="text-sm text-on-surface-subtle"><?= esc_html($cluster['full_address']) ?></p>
      </div>

      <?php if (!empty($cluster['cluster_facility'])): ?>
        <!-- <?php dump($cluster['cluster_facility']); ?> -->
        <div class="flex flex-col gap-2">
          <h2><?= __('Fasilitas cluster', 'karsa_start') ?></h2>

          <div class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-none">
            <?php foreach ($cluster['cluster_facility'] as $facility): ?>
              <div
                class="w-40 group shrink-0 snap-start flex flex-col gap-2">
                <img
                  loading="lazy"
                  class="aspect-4/3 object-cover rounded-2xl overflow-hidden"
                  src="<?= esc_url($facility['thumbnail_url']) ?>" alt="">

                <h3 class="font-medium text-sm/tight text-on-surface-variant">
                  <?= esc_html($facility['title']) ?>
                </h3>
              </div>
            <?php endforeach; ?>
          </div>

        </div>
      <?php endif; ?>

    </div>

  </div>
</div>



<?php get_footer();