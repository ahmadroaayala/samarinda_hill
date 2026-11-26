<?php
/**
 * Component: Badge Facility
 * @package KarsaStart
 */

$facility = $args['facility'] ?? [];
$is_link = $args['is_link'] ?? false;
$tag = tag_escape($is_link ? 'a' : 'span');
?>

<<?= $tag ?>
  <?= $is_link ? 'href="' . esc_url($facility['post_url']) . '"' : '' ?>
  class="group shrink-0 snap-start inline-flex items-center border border-outline/40 hover:border-primary/60 shadow-sm
  rounded-lg overflow-hidden transition-colors">
  <img
    loading="lazy"
    class="aspect-square h-8 object-cover"
    src="<?= esc_url($facility['thumbnail_url']) ?>" alt="">

  <span class="font-sans font-medium text-xs text-on-surface px-3">
    <?= esc_html($facility['title']) ?>
  </span>

</<?= $tag ?>>