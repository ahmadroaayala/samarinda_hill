<?php

use KarsaStart\Core\Format;
/**
 * Module: Hero Main
 * @package KarsaStart
 */

$items = $args['items'] ?? [];

if (empty($items)) {
  return;
}

$slides = [];
$slides = [];
foreach ($items as $cluster) {
  $cid = (string) ($cluster['id'] ?? '');
  $cluster_title = (string) ($cluster['title'] ?? '');

  foreach ($cluster['units'] ?? [] as $unit) {
    $slides[] = [
      'cluster_id' => $cid,
      'cluster_title' => $cluster_title,
      'unit' => $unit,
    ];
  }
}

if (empty($slides)) {
  return;
}

$cluster_map = array_column($slides, 'cluster_id');

?>

<section
  class="relative min-h-[80vh] py-20 flex flex-col overflow-hidden"
  x-data='{
  clusterMap: <?= htmlspecialchars(wp_json_encode($cluster_map), ENT_QUOTES, 'UTF-8') ?>,
  index: 0,
  get activeCluster() {
  return this.clusterMap[this.index] || "";
  },
  next() {
  this.index = (this.index + 1) % this.clusterMap.length;
  },
  prev() {
  this.index = (this.index - 1 + this.clusterMap.length) % this.clusterMap.length;
  },
  }'>

  <!-- render cluster bg and set initial state -->
  <?php
  foreach ($items as $c_id => $cluster): ?>
    <img
      src="<?= esc_url($cluster['thumbnail_url']) ?>"
      alt="<?= esc_attr($cluster['title']) ?>"
      :class="activeCluster === '<?= esc_js((string) $cluster['id']) ?>' ? 'opacity-100' : 'opacity-0'"
      <?= $c_id === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
      decoding="async"
      class="absolute inset-0 size-full object-cover object-center pointer-events-none transition-opacity ease-out">
  <?php endforeach; ?>

  <div
    aria-hidden="true"
    class="absolute inset-0 bg-linear-to-r from-overlay/80 via-overlay/50 to-overlay/20 pointer-events-none">
  </div>

  <div
    class="relative z-10 container grid md:grid-cols-12 gap-8
    ">

    <div class="md:col-span-7 self-end flex flex-col gap-2">
      <h1 class="text-white max-w-lg text-4xl md:text-5xl/tighter">Ruang Tumbuh Nyaman untuk Setiap Fase Keluarga</h1>
      <p class="text-white/80 leading-relaxed md:leading-loose">
        Menyatukan hunian tropis kontemporer dengan taman tematik, jalur jogging track, dan sistem keamanan satu pintu
        24 jam dalam satu kawasan terpadu.
      </p>
    </div>

    <div class="md:col-span-5 items-center flex flex-col gap-4">
      <div>
        <?php foreach ($slides as $i => $slide):
          $unit = $slide['unit'];
          ?>
          <article
            x-show="index === <?= (int) $i ?>"
            <?= $i > 0 ? 'style="display: none;"' : '' ?>
            class="w-full rounded-2xl max-w-72 grid gap-4 items-center bg-surface-bright p-4">
            <div
              x-on:click="next()"
              title="<?= esc_attr__('Klik untuk unit berikutnya', 'karsa_start') ?>"
              class="group relative aspect-4/3 rounded-lg overflow-hidden cursor-pointer bg-on-surface">
              <img
                class="size-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
                src="<?= esc_url($unit['thumbnail_url']) ?>"
                alt="<?= esc_attr($unit['title']) ?>">

              <?php if ($slide['cluster_title'] !== ''): ?>
                <div class="absolute top-2 left-2">
                  <span class="badge badge--neutral">
                    <span class="label">
                      <?= esc_html($slide['cluster_title']) ?>
                    </span>
                  </span>
                </div>
              <?php endif; ?>
            </div>

            <div class="flex flex-col gap-4 ">
              <div class="flex flex-col gap-1">
                <h2 class=" text-on-surface text-lg/snug">
                  <?= esc_html($unit['title']) ?>
                </h2>


                <p class="text-sm text-on-surface-subtle">
                  <?= esc_html__('Mulai ', 'karsa_start') . Format::rupiah($unit['price']) ?>
                </p>

              </div>

              <a href="<?= esc_url($unit['post_url']) ?>" class="btn btn--primary w-full">
                <span class="label">
                  <?= esc_html__('Lihat Detail Unit', 'karsa_start') ?>
                </span>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
        </di>
      </div>

      <div class="flex gap-4 items-center justify-center">
        <button
          type="button"
          x-on:click="prev()"
          aria-label="<?= esc_attr__('Unit sebelumnya', 'karsa_start') ?>"
          class="cursor-pointer inline-flex items-center justify-center size-9 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 transition-colors">

          <i data-lucide="chevron-left" class="size-4 text-white"></i>
        </button>

        <div
          class="min-w-12 inline-flex items-center justify-center gap-2 text-sm font-medium tabular-nums">
          <span x-text="index + 1" class="text-white">1</span>
          <span class="text-white/40">/</span>
          <span class="text-white/60">
            <?= esc_html(count($slides)) ?>
          </span>
        </div>

        <button
          type="button"
          x-on:click="next()"
          aria-label="<?= esc_attr__('Unit berikutnya', 'karsa_start') ?>"
          class="cursor-pointer inline-flex items-center justify-center size-9 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 transition-colors">
          <i data-lucide="chevron-right" class="size-4 text-white"></i>
        </button>
      </div>

    </div>
</section>