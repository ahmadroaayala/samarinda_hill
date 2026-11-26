<?php
/**
 * Component: Card Cluster in Archive
 * @package KarsaStart
 */

use KarsaStart\Core\Format;
use KarsaStart\Core\Helpers;

$cluster = $args['cluster'] ?? [];
$min_price = $args['min_price'] ?? 0;

?>

<article
  class="group bg-surface-bright border border-outline/20 hover:border-primary/60 shadow-sm rounded-2xl overflow-hidden">
  <!-- Cluster image -->
  <div class="overflow-hidden">
    <a href="<?= esc_url($cluster['post_url']) ?>">
      <img
        loading="lazy"
        class="aspect-video object-cover group-hover:scale-105 transition-transform"
        src="<?= esc_url($cluster['thumbnail_url']) ?>"
        alt="<?= esc_attr($cluster['title']) ?>">
    </a>
  </div>


  <div class="p-4 md:p-6 flex flex-col gap-4 md:gap-6">

    <!-- Cluster Info -->
    <div class="flex flex-col gap-3">
      <div class="flex flex-col gap-1">
        <a href="<?= esc_url($cluster['post_url']) ?>">
          <h2 class="text-lg lg:text-xl  group-hover:underline transition-colors">
            <?= esc_html($cluster['title']) ?>
          </h2>
        </a>

        <span
          class="text-xs text-on-surface-subtle truncate line-clamp-1">
          <?= esc_html($cluster['location']) ?>
        </span>

      </div>
      <p class="line-clamp-3 text-sm">
        <?= esc_html($cluster['excerpt']) ?>
      </p>
    </div>

    <!-- Facility -->
    <div class="flex flex-col gap-2">
      <span class="font-semibold text-on-surface">
        <?= __('Fasilitas Cluster', 'karsa_start') ?>
      </span>

      <div class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-none">
        <?php
        foreach ($cluster['cluster_facility'] as $facility): ?>
          <span
            class="group shrink-0 snap-start inline-flex items-center border border-outline/40 hover:border-primary/60 shadow-sm rounded-lg overflow-hidden transition-colors">
            <img
              loading="lazy"
              class="aspect-square h-8 object-cover"
              src="<?= esc_url($facility['thumbnail_url']) ?>" alt="">

            <span class="font-sans font-medium text-xs text-on-surface px-3">
              <?= esc_html($facility['title']) ?>
            </span>
          </span>
        <?php endforeach;
        ?>
      </div>
    </div>

    <!-- Price -->
    <span class="flex flex-col gap-1">
      <span class="text-sm text-on-surface-subtle">
        <?= esc_html(__('Harga mulai dari ', 'karsa_start')) ?>
      </span>
      <span class="font-bold text-lg  text-primary">
        <?= esc_html(Format::rupiah($min_price)) ?>
      </span>
    </span>

  </div>
</article>