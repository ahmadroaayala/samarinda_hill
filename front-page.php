<?php
/**
 * View: Root Front Page
 * @package KarsaStart
 */


$facility_args = [
  'post_type' => 'facility',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'orderby' => 'title',
  'order' => 'ASC',
  'no_found_rows' => true,
];

$facility_query = new WP_Query($facility_args);
dump($facility_query->posts);

get_header();
?>

<!-- Fasilitas -->
<?php if ($facility_query->have_posts()): ?>
  <section class="py-8 md:py-12">
    <div class="container">
      <h2><?= esc_html(__('Fasilitas', 'KarsaStart')) ?></h2>

      <div>
        <?php while ($facility_query->have_posts()):
          $facility_query->the_post();
          ?>

          <div>
            <h3><?= esc_html(get_the_title()) ?></h3>
            <p><?= esc_html(get_the_excerpt()) ?></p>
          </div>

        <?php endwhile ?>
        <?php wp_reset_postdata() ?>
      </div>

      <?php ?>
      <?php ?>
    </div>
  </section>
<?php endif ?>

<?php get_footer();