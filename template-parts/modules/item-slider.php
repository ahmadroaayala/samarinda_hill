<?php
/**
 * Module: Item slider
 */

$wrapper_class = $args['wrapper_class'] ?? 'bg-surface';
$title = $args['title'] ?? __('Daftar Item', 'karsa_start');
$url_link = $args['url_link'] ?? null;
$url_label = $args['url_label'] ?? __('Lebih Banyak', 'karsa_start');
$items = $args['items'] ?? [];

if (!($items instanceof \WP_Query) || !$items->have_posts()) {
  return;
}

?>

<section class="py-8 md:py-12 <?= esc_attr($wrapper_class) ?>">

  <div class="container">

    <div class="flex flex-col gap-6">

      <div class="flex flex-col xs:flex-row xs:items-center xs:justify-between gap-2">
        <h2>
          <?= esc_html($title) ?>
        </h2>

        <?php if ($url_link): ?>
          <a href="<?= esc_url($url_link ?: '#') ?>"
            class="font-medium text-sm text-primary flex items-center gap-1.5 hover:underline group">
            <?= esc_html($url_label) ?>
            <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
          </a>
        <?php endif ?>

      </div>

      <div class="flex gap-4 overflow-x-auto snap-x snap-mandatory scrollbar-none">
        <?php
        if ($items->have_posts()) {
          while ($items->have_posts()) {
            $items->the_post();
            // ITEM HERE
          }
        }
        ?>
      </div>

    </div>

  </div>

</section>
