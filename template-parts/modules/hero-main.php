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
    grid
    md:grid-cols-12
    gap-8
    ">

    <div class="md:col-span-7 self-center flex flex-col gap-2">
      <h1 class="text-white text-4xl md:text-5xl">Ruang Tumbuh Nyaman untuk Setiap Fase Keluarga</h1>
      <p class="text-white/80 leading-relaxed md:text-lg/relaxed">
        Menyatukan hunian tropis kontemporer dengan taman tematik, jalur jogging track, dan sistem keamanan satu pintu
        24 jam dalam satu kawasan terpadu.
      </p>
    </div>

    <div class="md:col-span-5 justify-self-center flex flex-col gap-4">
      <div>
        <?php foreach ($items as $i => $item):
          $unit_id = (int) $item['id'];
          $unit_title = get_the_title($unit_id);
          $unit_url = get_permalink($unit_id);
          $unit_thumb = get_the_post_thumbnail_url($unit_id, 'large') ?: ($item['cluster']['image_url'] ?? '');

          $cluster_title = $item['cluster']['title'] ?? (!empty($item['cluster']['id']) ? get_the_title((int) $item['cluster']['id']) : '');

          $raw_price = (int) ($item['price'] ?? get_field('price', $unit_id) ?: 0);
          $price_label = $item['price_short'] ?? ($raw_price > 0 ? 'Rp' . number_format($raw_price / 1_000_000, 0, ',', '.') . ' Jt' : '');
          ?>

          <article
            x-show="index === <?= (int) $i ?>"
            <?= $i > 0 ? 'style="display: none;"' : '' ?>
            class="w-full max-w-72 rounded-2xl 
            bg-white/10 
            backdrop-blur-md 
            border border-white/20 
            p-4 
            shadow-2xl 
            flex flex-col
            gap-4">
            <!-- Thumbnail Unit + Badge Cluster -->
            <div
              x-on:click="next()"
              title="<?= esc_attr__('Klik untuk unit berikutnya', 'karsa_start') ?>"
              class="group relative aspect-4/3 rounded-2xl overflow-hidden cursor-pointer bg-on-surface">
              <img
                class="size-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
                src="<?= esc_url($unit_thumb) ?>"
                alt="<?= esc_attr($unit_title) ?>">

              <?php if ($cluster_title !== ''): ?>
                <div class="absolute top-2 left-2">
                  <span
                    class="badge badge--neutral badge--inverse">
                    <span class="label"><?= esc_html($cluster_title) ?></span>
                  </span>
                </div>
              <?php endif; ?>
            </div>

            <!-- Detail Unit & CTA -->
            <div class="px-1 pb-1 flex flex-col gap-4">
              <div class="flex flex-col gap-1">
                <h2 class="font-serif font-semibold text-white text-lg leading-snug">
                  <?= esc_html($unit_title) ?>
                </h2>

                <?php if ($price_label !== ''): ?>
                  <p class="text-sm text-white/80">
                    <?= esc_html__('Mulai ', 'karsa_start') . esc_html($price_label) ?>
                  </p>
                <?php endif; ?>
              </div>

              <a href="<?= esc_url($unit_url) ?>" class="btn btn--primary w-full">
                <span class="label">
                  <?= esc_html__('Lihat Detail Unit', 'karsa_start') ?>
                </span>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <!-- Slider Action Button -->
      <div class="flex gap-4 items-center justify-center">
        <button
          type="button"
          x-on:click="prev()"
          aria-label="<?= esc_attr__('Unit sebelumnya', 'karsa_start') ?>"
          class="cursor-pointer 
          inline-flex items-center justify-center 
          size-9 
          rounded-full 
          bg-white/10 hover:bg-white/20 
          border border-white/20 
          transition">

          <i data-lucide="chevron-left" class="size-4 text-white"></i>
        </button>

        <div
          class="min-w-12 inline-flex items-center justify-center gap-2 text-sm font-medium tabular-nums">
          <span x-text="index + 1" class="text-white">1</span>
          <span class="text-white/40">/</span>
          <span class="text-white/60"><?= esc_html(count($items)) ?></span>
        </div>

        <button
          type="button"
          x-on:click="next()"
          aria-label="<?= esc_attr__('Unit berikutnya', 'karsa_start') ?>"
          class="cursor-pointer 
          inline-flex items-center justify-center 
          size-9 
          rounded-full 
          bg-white/10 hover:bg-white/20 
          border border-white/20 
          transition">
          <i data-lucide="chevron-right" class="size-4 text-white"></i>
        </button>
      </div>
    </div>

  </div>
</section>