<?php

use KarsaStart\Helpers;
/**
 * Module: Facility Slider
 * @package KarsaStart
 */

$wrapper_class = $args['wrapper_class'] ?? '';

$title = $args['title'] ?? __('Judul', 'karsa_start');

$items = $args['items'] ?? [];

?>

<?php if (!empty($items)): ?>
  <section
    class="py-8 md:py-12 <?= esc_attr($wrapper_class) ?>">
    <div class="container">

      <h2><?= esc_html($title) ?></h2>

      <div>
        <?php while ($items->have_posts()):
          $items->the_post();

          Helpers::component('cards/card-facility', [
            'title' => get_the_title(),
            'excerpt' => get_the_excerpt()
          ]);

        endwhile;
        wp_reset_postdata(); ?>
      </div>

    </div>
  </section>

<?php endif ?>