<?php
/**
 * Module: Component Header
 * @package KarsaStart
 */

$archive_url = $args['archive_url'] ?? '';
$archive_url_label = $args['archive_url_label'] ?? __('Lebih banyak', 'karsa_start');
$title = $args['title'] ?? __('Judul', 'karsa_start');

?>

<div class="flex flex-col xs:flex-row xs:items-baseline xs:justify-between gap-1">
  <h2><?= esc_html($title) ?></h2>

  <?php if ($archive_url !== ''): ?>
    <a href="<?= esc_url($archive_url) ?>"
      class="group text-primary inline-flex items-center gap-2 text-sm hover:underline">
      <span class="font-medium"><?= esc_html($archive_url_label) ?></span>

      <i
        data-lucide="arrow-right"
        class="size-4 stroke-[1.5] group-hover:translate-x-1 transition-transform"></i>
    </a>
  <?php endif; ?>

</div>