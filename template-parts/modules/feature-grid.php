<?php
/**
 * Module: Feature grid
 */

use KarsaStart\Helpers;

$wrapper_class = $args['wrapper_class'] ?? 'bg-surface';

$title = $args['title'] ?? __('Judul', 'karsa_start');
$title_class = $args['title_class'] ?? 'text-left';
$items = $args['items'] ?? [];

?>

<section class="py-8 md:py-12 <?= esc_attr($wrapper_class) ?>">
  <div class="container flex flex-col gap-6">
    <h2 class="<?= esc_attr($title_class) ?>"><?= esc_html($title) ?></h2>

    <?php if (!empty($items)): ?>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($items as $item): ?>
          <?php Helpers::component('cards/card-feature', [
            'icon' => $item['icon'],
            'title' => $item['title'],
            'description' => $item['description']
          ]) ?>
        <?php endforeach ?>
      </div>
    <?php endif ?>
  </div>
</section>
