<?php

use KarsaStart\Core\Format;
use KarsaStart\Core\Helpers;
/**
 * Module: Showcase Cluster
 * @package KarsaStart
 */

$wrapper_class = $args['wrapper_class'] ?? '';
$items = $args['items'] ?? [];

if (empty($items))
  return;

?>

<section class="py-8 md:py-12 bg-surface-bright">
  <div class="container flex flex-col gap-6">

    <?php Helpers::component('showcase-header', [
      'archive_url' => $args['archive_url'],
      'archive_url_label' => $args['archive_url_label'],
      'title' => $args['title']
    ]) ?>

    <div class="flex flex-col gap-8">
      <?php foreach ($items as $item):
        $prices = array_filter(array_map('intval', array_column($item['units'] ?? [], 'price')));
        $min_price = !empty($prices) ? min($prices) : 0;
        $cluster_features = get_the_terms($item['id'], 'cluster_feature');
        ?>
        <article class="grid grid-cols-2 md:grid-cols-6 grid-rows-[auto_1fr] gap-6">

          <div class="col-span-2 sm:col-span-1 md:col-span-2 md:row-span-2 rounded-2xl overflow-hidden">
            <img
              class="aspect-video sm:aspect-4/3 h-full object-cover"
              src="<?= esc_url($item['thumbnail_url']) ?>"
              alt="<?= esc_attr($item['title']) ?>"
              loading="lazy"
              decoding="async">
          </div>

          <div class="col-span-2 sm:col-span-1 md:col-span-4 md:row-span-1 flex flex-col sm:justify-center gap-4">

            <div class="flex flex-col gap-1">
              <h2 class="text-lg sm:text-2xl"><?= esc_html($item['title']) ?></h2>
              <span class="text-sm text-on-surface-subtle">
                <?= esc_html(__('Mulai dari ', 'karsa_start') . Format::rupiah($min_price)) ?>
              </span>
            </div>

            <?php if (!empty($cluster_features) && !is_wp_error($cluster_features)): ?>
              <div class="flex flex-wrap gap-2">
                <?php foreach ($cluster_features as $feature): ?>
                  <span class="badge badge--neutral">
                    <span class="label">
                      <?= esc_html($feature->name) ?>
                    </span>
                  </span>
                <?php endforeach ?>
              </div>
            <?php endif ?>

            <a class="group inline-flex self-start items-center gap-2 text-primary hover:underline"
              href="<?= esc_url($item['post_url']) ?>">
              <span class="font-medium text-sm truncate">
                <?= __('Detail cluster', 'karsa_start') ?>
              </span>
              <i data-lucide="arrow-right"
                class="w-4 h-4 stroke-[1.5] group-hover:translate-x-2 transition-transform"></i>
            </a>
          </div>

          <div class="col-span-2 sm:col-span-2 md:col-span-4 md:row-span-1 grid grid-cols-2 xs:grid-cols-3 gap-4">
            <?php foreach ($item['units'] as $unit):
              ?>
              <a href="<?= esc_url($unit['post_url']) ?>" class="block group">
                <article class="flex flex-col gap-3">
                  <img
                    class="aspect-4/3 rounded-2xl overflow-hidden group-hover:scale-105 transition-transform"
                    src="<?= esc_url($unit['thumbnail_url']) ?>"
                    alt="<?= esc_attr($unit['title']) ?>"
                    loading="lazy">
                  <div class="flex flex-col gap-1">
                    <h3 class="text-base group-hover:underline"><?= esc_html($unit['title']) ?></h3>
                    <span class="text-xs text-on-surface-subtle"><?= Format::rupiah($unit['price']) ?></span>
                  </div>
                </article>
              </a>
            <?php endforeach; ?>
          </div>

        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>