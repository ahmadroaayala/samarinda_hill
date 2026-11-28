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
        class="absolute inset-0 size-full flex items-center justify-center"
        x-transition
        x-show="index === <?= (int) $i ?>">
        <img
          <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
          class="size-full object-cover"
          src="<?= esc_url($image['url'] ?? '') ?>"
          alt="<?= esc_attr($image['alt'] ?? '') ?>">
      </div>
    <?php endforeach; ?>

    <?php if ($total > 1):
      $button_wrapper_class = 'cursor-pointer inline-flex items-center justify-center size-10 rounded-full bg-overlay-dark/20 hover:bg-overlay-dark/40 backdrop-blur-sm border border-overlay-light/40 transition-colors';
      ?>

      <button
        type="button"
        x-on:click="prev()"
        aria-label="<?= esc_attr__('Foto sebelumnya', 'karsa_start') ?>"
        class="<?= esc_attr($button_wrapper_class) ?> absolute pr-0.5 left-4">
        <i data-lucide="chevron-left" class="size-6 stroke-3 text-overlay-light"></i>
      </button>

      <button
        type="button"
        x-on:click="next()"
        aria-label="<?= esc_attr__('Foto berikutnya', 'karsa_start') ?>"
        class="<?= esc_attr($button_wrapper_class) ?> absolute pl-0.5 right-4">
        <i data-lucide="chevron-right" class="size-6 stroke-3 text-overlay-light"></i>
      </button>

      <div
        class="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 inline-flex items-center gap-2 px-3 py-2 rounded-full bg-overlay-dark/20 hover:bg-overlay-dark/40 backdrop-blur-sm border border-overlay-light/40 ">
        <?php foreach ($gallery as $i => $image): ?>
          <button
            type="button"
            x-on:click="index = <?= (int) $i ?>"
            :aria-current="index === <?= (int) $i ?> ? 'true' : 'false'"
            aria-label="<?= esc_attr(sprintf(__('Foto %1$d dari %2$d', 'karsa_start'), $i + 1, $total)) ?>"
            :class="index === <?= (int) $i ?>
              ? 'w-6 bg-overlay-light'
              : 'w-2 bg-overlay-light/40 hover:bg-overlay-light/80'"
            class="h-2 rounded-full transition-all duration-300 cursor-pointer">
          </button>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</div>