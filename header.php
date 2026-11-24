<?php

use KarsaStart\Core\Taxonomy;
/**
 * View: Root Header
 * @package KarsaStart
 */

$nav_items = [
  [
    'url' => get_post_type_archive_link('cluster'),
    'label' => __('Cluster', 'karsa_start')
  ],
  [
    'url' => get_post_type_archive_link('unit'),
    'label' => __('Unit', 'karsa_start')
  ]
];

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div id="page" class="min-h-screen flex flex-col">

    <!-- Header Template Here -->
    <header class="sticky z-100 top-0 py-4 bg-surface border-b border-b-outline/60 shadow-md">
      <div class="container flex items-center justify-between">

        <div>
          <a href="<?= esc_url(home_url('/')) ?>">
            <span class="font-serif flex flex-col font-bold text-on-surface leading-tight ">
              <span>Samarinda</span>
              <span>Hill</span>
            </span>
          </a>
        </div>

        <!-- MOBILE NAV -->
        <div
          x-data="{ open: true }"
          @click.outside="open = false"
          class="relative flex items-center">
          <!-- TRIGGER -->
          <button @click="open = !open" type="button" class="cursor-pointer">
            <i x-show="!open" data-lucide="menu"></i>
            <i x-show="open" x-cloak data-lucide="x"></i>
          </button>

          <nav x-show="open" class="absolute top-full right-0 mt-2 w-2xs" x-transition>
            <div class=" p-4 bg-surface-bright border border-outline/20 shadow-md rounded-lg">
              <div class="flex flex-col gap-2">
                <?php foreach ($nav_items as $item): ?>
                  <a href="<?= esc_url($item['url']) ?>">
                    <?= esc_html($item['label']) ?>
                  </a>
                <?php endforeach ?>
              </div>
            </div>
          </nav>
        </div>

      </div>
    </header>

    <main id="content" class="flex-1 flex flex-col">