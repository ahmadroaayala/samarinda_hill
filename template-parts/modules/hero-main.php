<?php
/**
 * Module: Hero Main
 * @package KarsaStart
 */

$items = $args['items'] ?? [];

if (empty($items)) {
  return;
}

$unique_bgs = [];
foreach ($items as $item) {
  $cid = (string) ($item['cluster']['id'] ?? '');
  if ($cid !== '' && !isset($unique_bgs[$cid])) {
    $unique_bgs[$cid] = [
      'id' => $cid,
      'url' => $item['cluster']['image_url'],
      'alt' => $item['cluster']['image_alt'],
    ];
  }
}

$cluster_map = array_map(
  fn($item) => (string) ($item['cluster']['id'] ?? ''),
  $items
);

?>
<section
  class="relative min-h-[80vh] py-8 md:py-12 flex flex-col overflow-hidden"
  x-data='{ // for hero bg
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
  <?php $bg_i = 0;
  foreach ($unique_bgs as $cid => $bg): ?>
    <img
      src="<?= esc_url($bg['url']) ?>"
      alt="<?= esc_attr($bg['alt']) ?>"
      :class="activeCluster === '<?= esc_js($cid) ?>' ? 'opacity-100' : 'opacity-0'"
      <?= $bg_i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
      decoding="async"
      class="absolute inset-0 size-full object-cover object-center pointer-events-none transition-opacity ease-out">
    <?php $bg_i++; endforeach; ?>

  <div
    aria-hidden="true"
    class="absolute inset-0 bg-linear-to-t from-overlay/95 via-overlay/50 to-overlay/20 pointer-events-none">
  </div>

  <div
    class="relative z-10 
    mt-auto 
    container 
    flex flex-col md:flex-row
    md:items-center
    gap-8
    pt-20">

    <div class="flex flex-col gap-2">
      <h1 class=" text-white text-4xl md:text-5xl">Ruang Tumbuh Nyaman untuk Setiap Fase Keluarga</h1>
      <p class="text-white/80">
        Menyatukan hunian tropis kontemporer dengan taman tematik, jalur jogging track, dan sistem keamanan satu pintu
        24 jam dalam satu kawasan terpadu.
      </p>
    </div>

    <div>
      <!-- render unit and set initial state -->
      <?php foreach ($items as $i => $item): ?>
        <div
          x-show="index === <?= (int) $i ?>"
          x-on:click="next()"
          <?= $i > 0 ? 'style="display: none;"' : '' ?>
          class="flex justify-center">

          <article
            class="bg-surface-transparent flex flex-col gap-4">
            <img
              class="aspect-4/3 object-cover rounded-2xl"
              src="<?= esc_url(get_the_post_thumbnail_url($item['id'])) ?>"
              alt="<?= esc_attr(get_the_title($item['id'])) ?>">

            <div x-on:click.stop>
              <div class="flex gap-4 items-center justify-center">
                <button
                  type="button"
                  x-on:click="prev()"
                  class="inline-flex p-2 rounded-full">
                  <i data-lucide="chevron-left" class="size-4 text-on-primary"></i>
                </button>

                <div class="w-8 inline-flex items-center justify-center gap-1 text-sm text-on-primary">
                  <span x-text="index + 1"></span> / <span
                    class="text-on-primary/60"><?= esc_html(count($items)) ?></span>
                </div>

                <button
                  type="button"
                  x-on:click="next()"
                  class="inline-flex p-2 rounded-full">
                  <i data-lucide="chevron-right" class="size-4 text-on-primary"></i>
                </button>
              </div>
            </div>

          </article>

        </div>
      <?php endforeach ?>
    </div>

  </div>
</section>