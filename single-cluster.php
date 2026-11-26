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

<div id="page" class="flex-1 py-8 md:py-12 bg-surface-bright">
  <div class="container flex flex-col gap-6">

    <?php Helpers::component('breadcrumb', [
      'items' => $breadcrumb_items
    ]); ?>

    <div
      x-data='{ index: 0 }'>
      <div class="flex flex-col gap-4 bg-surface-dim rounded-2xl overflow-hidden p-4">

        <div class=" w-full h-[40vh] flex items-center justify-center">
          <?php foreach ($cluster['gallery'] as $i => $image): ?>
            <div
              <?= $i > 0 ? 'style="display: none;"' : '' ?>
              x-show="index === <?= (int) $i ?>"
              class="relative size-full flex items-center justify-center">
              <img
                <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
                class="max-h-full max-w-full w-auto h-auto object-contain"
                src="<?= esc_url($image['url']) ?>"
                alt="<?= esc_attr($image['alt']) ?>">

              <div class="absolute top-0 right-0">
                <span class="badge badge--primary">
                  <span class="label">
                    <?= esc_html($image['alt']) ?>
                  </span>
                </span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="flex gap-4 flex-nowrap overflow-x-auto scrollbar-none">
          <?php foreach ($cluster['gallery'] as $i => $image): ?>
            <button
              x-on:click="index = <?= (int) $i ?> "
              :class="index === <?= (int) $i ?>
              ? 'border-primary opacity-100'
              : 'border-transparent opacity-50 hover:opacity-85'"
              class="shrink-0 aspect-4/3 w-20 rounded-2xl overflow-hidden"
              type="button">
              <img
                class="object-cover h-full w-full"
                src="<?= esc_url($image['url']) ?>"
                alt="<?= esc_attr($image['alt']) ?>">
            </button>
          <?php endforeach ?>
        </div>

      </div>
    </div>

    <div>
      <h1><?= esc_html($cluster['title']) ?></h1>
      <p><?= esc_html($cluster['full_address']) ?></p>
    </div>
  </div>

</div>
</div>


<?php get_footer();