<?php
/**
 * Module: Facility Showcase
 * @package KarsaStart
 */

use KarsaStart\Core\Helpers;

$wrapper_class = $args['wrapper_class'] ?? '';

$archive_url = $args['archive_url'] ?? '';
$archive_url_label = $args['archive_url_label'] ?? __('Lebih banyak', 'karsa_start');

$title = $args['title'] ?? __('Judul', 'karsa_start');
$items = $args['items'] ?? [];

if (empty($items))
  return;
?>


<section
  class="py-8 md:py-12 <?= esc_attr($wrapper_class) ?>">
  <div class="container flex flex-col gap-6">

    <div class="flex
      flex-col xs:flex-row
      xs:items-baseline 
      xs:justify-between 
      gap-2 
      ">
      <h2><?= esc_html($title) ?></h2>

      <?php if ($archive_url !== ''): ?>
        <a href="<?= esc_url($archive_url) ?>"
          class="group text-primary inline-flex items-center gap-1.5 text-sm hover:underline">
          <span><?= esc_html($archive_url_label) ?></span>
          <i
            data-lucide="arrow-right"
            class="size-3.5 stroke-[1.5] group-hover:translate-x-1 transition-transform"></i>
        </a>
      <?php endif; ?>

    </div>

    <div
      class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-none md:grid md:grid-cols-3">
      <?php foreach ($items as $item): ?>

        <?php
        Helpers::component('cards/card-facility', [
          'wrapper_class' => 'w-60 md:w-auto shrink-0 snap-start',
          'post_url' => $item['post_url'],
          'thumbnail_url' => $item['thumbnail_url'],
          'title' => $item['title'],
          'excerpt' => $item['excerpt']
        ]); ?>

      <?php endforeach ?>
    </div>

  </div>
</section>