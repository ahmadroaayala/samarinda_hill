<?php
/**
 * Module: Cluster Showcase
 * @package KarsaStart
 */

$wrapper_class = $args['wrapper_class'] ?? '';
$items = $args['items'] ?? [];

if (empty($items))
  return;

dump($items);
?>

<section class="py-8 md:py-12">
  <div class="container">
    <div class="flex flex-col gap-4 ">
      <?php foreach ($items as $item): ?>
        <article class="grid 
      grid-cols-1 md:grid-cols-[auto_1fr] 
      md:grid-rows-[auto_1fr]
      rounded-2xl overflow-hidden
      bg-surface-container
      p-4
      ">

          <div class="aspect-3/4 h-80 md:row-span-2 md:col-span-1">
            <img
              class="object-cover h-full"
              src="<?= esc_url($item['thumbnail_url']) ?>"
              alt="<?= esc_attr($item['title']) ?>"
              loading="lazy"
              decoding="async">
          </div>

          <div class="md:col-span-1">
            <h2><?= esc_html($item['title']) ?></h2>
          </div>

          <div class="md:col-span-1 flex flex-col gap-3">
            <?php foreach ($item['units'] as $unit): ?>
              <article class="flex items-center gap-3">
                <img
                  class="size-16 object-cover shrink-0"
                  src="<?= esc_url($unit['thumbnail_url']) ?>"
                  alt="<?= esc_attr($unit['title']) ?>"
                  loading="lazy">
                <h3><?= esc_html($unit['title']) ?></h3>
              </article>
            <?php endforeach; ?>
          </div>

        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>