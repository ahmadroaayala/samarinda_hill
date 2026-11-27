<?php
/**
 * View: Single Cluster
 * @package KarsaStart
 */

use KarsaStart\Core\Breadcrumb;
use KarsaStart\Core\Helpers;
use KarsaStart\Project\Normalizer;

global $post;
$cluster_id = $post->ID;
$cluster = Normalizer::cluster($cluster_id);

$breadcrumb_items = Breadcrumb::single('cluster');

$gallery_map = array_column($cluster['gallery'], 'id');

get_header();
?>

<div id="page" class="flex-1 py-8">
  <div class="flex flex-col gap-6">

    <!-- Breadcrumb -->
    <div class="container">
      <?php Helpers::component('breadcrumb', [
        'items' => $breadcrumb_items
      ]); ?>
    </div>

    <div class="container grid gap-6 md:grid-rows-[auto_auto] md:grid-cols-12">

      <!-- Image gallery -->
      <?php Helpers::module('image-gallery', [
        'gallery' => $cluster['gallery'],
        'wrapper_class' => 'md:row-span-1 md:col-span-7'
      ]); ?>

      <div
        class="md:row-span-2 md:col-span-5 md:self-start md:sticky md:p-6 md:border md:border-outline/20 md:shadow-sm md:rounded-2xl overflow-hidden">
        <h1 class="text-xl"><?= esc_html($cluster['title']) ?></h1>
        <p class="text-sm text-on-surface-subtle"><?= esc_html($cluster['full_address']) ?></p>
      </div>

      <div class="md:row-span-1 md:col-span-7">
        <div>
          <?= $cluster['content'] ?>
        </div>

      </div>
    </div>

  </div>
</div>



<?php get_footer();