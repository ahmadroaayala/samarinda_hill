<?php
/**
 * Module: Showcase for Facility
 * @package KarsaStart
 */

use KarsaStart\Core\Helpers;

$wrapper_class = $args['wrapper_class'] ?? '';
$items = $args['items'] ?? [];

if (empty($items))
  return;
?>


<section
  class="py-8 md:py-12 <?= esc_attr($wrapper_class) ?>">
  <div class="container flex flex-col gap-6">

    <?php Helpers::component('showcase-header', [
      'archive_url' => $args['archive_url'],
      'archive_url_label' => $args['archive_url_label'],
      'title' => $args['title']
    ]) ?>

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