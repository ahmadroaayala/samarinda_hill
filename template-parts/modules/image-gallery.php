<?php
/**
 * Module: Image Gallery
 * @package KarsaStart
 */

$wrapper_class = $args['wrapper_class'] ?? '';
$gallery = $args['gallery'] ?? [];

if (empty($gallery) || !is_array($gallery)) {
  return;
}

$total = count($gallery);
?>

<div
  x-data="{
    index: 0,
    total: <?= (int) $total ?>,
    next() {
      this.index = (this.index + 1) % this.total;
    },
    prev() {
      this.index = (this.index - 1 + this.total) % this.total;
    },
  }"
  class="bg-surface-bright rounded-2xl overflow-hidden <?= esc_attr($wrapper_class); ?>">

  <div class="relative w-full h-[40vh] md:h-[60vh] flex items-center justify-center overflow-hidden">
    <?php foreach ($gallery as $i => $image): ?>
      <div
        <?= $i > 0 ? 'style="display: none;"' : '' ?>
        x-show="index === <?= (int) $i ?>"
        class="size-full flex items-center justify-center">
        <img
          <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
          class="object-cover"
          src="<?= esc_url($image['url'] ?? '') ?>"
          alt="<?= esc_attr($image['alt'] ?? '') ?>">
      </div>
    <?php endforeach; ?>

    <?php if ($total > 1): ?>
      <?php
      $button_wrapper_class = 'cursor-pointer inline-flex items-center justify-center size-9 xs:size-10 rounded-full bg-black/10 hover:bg-black/20 backdrop-blur-md border border-white/20 transition-colors';
      ?>
      <button
        type="button"
        x-on:click="prev()"
        aria-label="<?= esc_attr__('Foto sebelumnya', 'karsa_start') ?>"
        class="<?= esc_attr($button_wrapper_class) ?> absolute left-4">
        <i data-lucide="chevron-left" class="size-4 text-white"></i>
      </button>

      <button
        type="button"
        x-on:click="next()"
        aria-label="<?= esc_attr__('Foto berikutnya', 'karsa_start') ?>"
        class="<?= esc_attr($button_wrapper_class) ?> absolute right-4">
        <i data-lucide="chevron-right" class="size-4 text-white"></i>
      </button>
    <?php endif; ?>
  </div>

</div>