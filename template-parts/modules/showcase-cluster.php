<?php
/**
 * Module: Showcase Cluster
 * @package KarsaStart
 */

use KarsaStart\Core\Format;
use KarsaStart\Core\Helpers;

$wrapper_class = $args['wrapper_class'] ?? '';
$clusters = $args['items'] ?? [];

if (empty($clusters))
  return;

?>

<section class="py-12 md:py-16 bg-surface-bright">
  <div class="container flex flex-col gap-6">

    <div class="content-container flex flex-col gap-1 text-center">
      <h2 class="leading-snug">
        <?= esc_html__('Cluster pilihan untuk tumbuh bersama keluarga', 'karsa_start') ?>
      </h2>

      <p class="text-base text-on-surface-subtle">
        <?= esc_html__('Kawasan hunian asri dengan suasana aman untuk menemani setiap langkah keluargamu.', 'karsa_start') ?>
      </p>
    </div>

    <div
      class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-none md:grid md:grid-cols-3">
      <?php foreach ($clusters as $cluster):
        $total_unit = count($cluster['units']);
        dump(get_the_terms($cluster['id'], 'cluster_feature'));
        ?>
        <article class="shrink-0 w-60 md:w-auto flex flex-col gap-4">
          <div class="relative aspect-4/3 object-cover rounded-2xl overflow-hidden">
            <img class="size-full object-cover"
              src="<?= esc_url($cluster['thumbnail_url']) ?>"
              alt="<?= esc_attr($cluster['title']) ?>">
            <span class="absolute z-10 bottom-2 left-2 badge badge--transparent-dark">
              <span class="label"><?= esc_html($total_unit . ' ' . __('unit rumah', 'karsa_start')) ?></span>
            </span>
          </div>

          <div class="px-1 flex gap-4">
            <div class="flex flex-col gap-1">
              <h3><?= esc_html($cluster['title']) ?></h3>
              <p class="text-sm md:text-base text-on-surface-subtle line-clamp-3"><?= esc_html($cluster['excerpt']) ?></p>
            </div>
            <div class="self-center">
              <a href="<?= esc_url($cluster['post_url']) ?>" class="btn btn--neutral btn--outline rounded-full">
                <i data-lucide="arrow-right" class="icon "></i>
              </a>
            </div>
          </div>
        </article>
      <?php endforeach ?>
    </div>

  </div>
</section>