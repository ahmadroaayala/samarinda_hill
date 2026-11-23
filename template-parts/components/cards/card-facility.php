<?php
/**
 * Component: Card Facility
 * @package KarsaStart
 */

use KarsaStart\Core\Helpers;

$wrapper_class = $args['wrapper_class'] ?? '';
$title = $args['title'] ?? 'Card Title';
$post_url = $args['post_url'] ?? '#';

$thumbnail_url = !empty($args['thumbnail_url']) && is_string($args['thumbnail_url'])
  ? $args['thumbnail_url']
  : Helpers::get_image_placeholder_url('fallback-2-undraw');

$excerpt = $args['excerpt'] ?? null;

?>

<div
  class="group bg-surface-bright 
  border border-outline/20 hover:border-primary/60
  transition-colors
  rounded-2xl overflow-hidden 
  shadow-sm <?= esc_attr($wrapper_class) ?>">

  <div>
    <img
      class="aspect-4/3 w-full object-cover object-center"
      src="<?= esc_url($thumbnail_url) ?>"
      alt="<?= esc_attr($title) ?>">
  </div>

  <div class="p-4 lg:p-6 flex flex-col gap-4">
    <div class="flex flex-col gap-2">
      <h3 class="text-lg">
        <?= esc_html($title) ?>
      </h3>

      <?php if ($excerpt): ?>
        <p class="text-sm text-on-surface-subtle"><?= esc_html($excerpt) ?></p>
      <?php endif ?>
    </div>

    <a href="<?= esc_url($post_url) ?>"
      class="group inline-flex self-end items-center gap-1.5 text-on-surface-variant hover:text-primary transition-colors">
      <span class="text-sm font-medium"><?= __('Selengkapnya', 'karsa_start') ?></span>
      <i data-lucide="arrow-right" class="size-3.5 stroke-[1.5] group-hover:translate-x-1 transition-transform"></i>
    </a>


  </div>
</div>