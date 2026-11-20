<?php
/**
 * Component: Card Facility
 * @package KarsaStart
 */

$wrapper_class = $args['wrapper_class'] ?? '';

$title = $args['title'] ?? 'Card Title';
$excerpt = $args['excerpt'] ?? null;

?>

<div
  class="p-4 border border-outline/20 rounded-2xl shadow-sm <?= esc_attr($wrapper_class) ?>">
  <h3>
    <?= esc_html($title) ?>
  </h3>

  <?php if ($excerpt): ?>
    <p><?= esc_html($excerpt) ?></p>
  <?php endif ?>
</div>