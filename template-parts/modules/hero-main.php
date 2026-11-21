<?php
/**
 * Module: Hero Main
 * @package KarsaStart
 */

$items = $args['items'] ?? [];

if (empty($items)) {
  return;
}

$first = $items[0];

$bg_list = array_map(fn($item) => [
  'id' => $item['cluster']['id'],
  'url' => $item['cluster']['image_url'],
  'alt' => $item['cluster']['image_alt']
], $items);

?>
<section class="relative min-h-[60vh] py-8 md:py-12 flex flex-col overflow-hidden"
  x-data='{
    bgs: <?= htmlspecialchars(wp_json_encode($bg_list), ENT_QUOTES, 'UTF-8') ?>,
    index: 0,
    get currentBg() {
      return this.bgs[this.index] || this.bgs[0];
    },
    init() {
      [...new Set(this.bgs.map(bg => bg.url))].forEach(url => {
        const img = new Image();
        img.src = url;
      });
    },
    next() {
      this.index = (this.index + 1) % this.bgs.length;
    },
    prev() {
      this.index = (this.index - 1 + this.bgs.length) % this.bgs.length;
    },
  }'>


  <img
    src="<?= esc_url($first['cluster']['image_url']) ?>"
    alt="<?= esc_attr($first['cluster']['image_alt']) ?>"
    :src="currentBg.url"
    :alt="currentBg.alt"
    fetchpriority="high"
    decoding="async"
    class="absolute inset-0 size-full object-cover object-center pointer-events-none">

  <div
    aria-hidden="true"
    class="absolute inset-0 bg-linear-to-t from-overlay/90 via-overlay/45 to-overlay/15 pointer-events-none"></div>

  <div class="relative mt-auto z-10 container flex flex-col gap-4">
    <div class="flex flex-col gap-2">
      <h1 class="text-white">Ruang Tumbuh Nyaman untuk Setiap Fase Keluarga</h1>
      <p class="text-white/80">
        Menyatukan hunian tropis kontemporer dengan taman tematik, jalur jogging track, dan sistem keamanan satu pintu
        24 jam dalam satu kawasan terpadu.
      </p>
    </div>

    <div class="mx-auto">
      <?php foreach ($items as $item): ?>
        <div class="h-80 aspect-square rounded-2xl overflow-hidden">
          <img
            class="aspect-square object-cover"
            src="<?= esc_url(get_the_post_thumbnail_url($item['id'])) ?>"
            alt="<?= esc_attr(get_the_title($item['id'])) ?>">
        </div>
      <?php endforeach ?>
    </div>

  </div>
</section>