<?php
/**
 * View: Root Header
 * @package KarsaStart
 */
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
    <header class="py-4 bg-surface border-b border-b-outline/60 shadow-sm">
      <div class="container">

        <div>
          <span class="font-serif flex flex-col font-semibold text-on-surface leading-tight">
            <span>Samarinda</span>
            <span>Hill</span>
          </span>
        </div>

      </div>
    </header>

    <main id="content" class="flex-1 flex flex-col">