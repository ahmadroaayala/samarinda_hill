<?php
/**
 * View: Archive Cluster
 * @package KarsaStart
 */

use KarsaStart\Core\Breadcrumb;
use KarsaStart\Core\Helpers;
use KarsaStart\Core\Taxonomy;
use KarsaStart\Project\Normalizer;

global $wp_query;

$breadcrumb_items = Breadcrumb::archive('cluster');

$cluster_ids = wp_list_pluck($wp_query->posts, 'ID');
$clusters = Normalizer::cluster_archive($cluster_ids);


get_header();
?>
<div id="page" class="py-8 md:py-12">

  <div class="container">

    <div class="flex flex-col gap-6">

      <?php Helpers::component('breadcrumb', [
        'items' => $breadcrumb_items
      ]) ?>

      <div>
        <h1>Cluster</h1>

        <div>
          <?php foreach ($clusters as $cluster):
            dump(Taxonomy::sort_terms_by_hierarchy($cluster['id'], 'location')); ?>
            <article>
              <h2><?= esc_html($cluster['title']) ?></h2>
              <p class="line-clamp-3"><?= esc_html($cluster['excerpt']) ?></p>
            </article>
          <?php endforeach ?>
        </div>
      </div>

    </div>

  </div>

</div>



<?php get_footer();