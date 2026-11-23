<?php
namespace KarsaStart\Project;

use KarsaStart\Core\Helpers;

class Normalizer
{
  public static function hero_items(array $unit_ids): array
  {
    usort($unit_ids, static function (int $a, int $b): int {
      $price_a = (int) (get_field('price', $a) ?: PHP_INT_MAX);
      $price_b = (int) (get_field('price', $b) ?: PHP_INT_MAX);

      return $price_a <=> $price_b;
    });

    $items = [];
    $fallback_image = Helpers::get_image_placeholder_url('fallback-2-undraw');

    foreach ($unit_ids as $unit_id) {
      $raw_cluster = get_field('parent_cluster', $unit_id);
      $cluster_id = $raw_cluster instanceof \WP_Post ? $raw_cluster->ID : absint($raw_cluster);
      $cluster_title = $cluster_id > 0 ? get_the_title($cluster_id) : __('Samarinda Hill', 'karsa_start');
      $cluster_thumb = $cluster_id > 0 ? get_the_post_thumbnail_url($cluster_id, 'full') : '';

      if (!isset($items[$cluster_id])) {
        $items[$cluster_id] = [
          'id' => $cluster_id,
          'title' => $cluster_title,
          'thumbnail_url' => $cluster_thumb ?: $fallback_image,
          'units' => []
        ];
      }

      $items[$cluster_id]['units'][] = [
        'id' => $unit_id,
        'title' => get_the_title($unit_id),
        'post_url' => get_the_permalink($unit_id),
        'thumbnail_url' => get_the_post_thumbnail_url($unit_id, 'medium') ?: $fallback_image,
        'price' => get_field('price', $unit_id)
      ];
    }

    return array_values($items);
  }

  public static function units_by_cluster(array $cluster_ids, array $unit_ids): array
  {
    $fallback_image = Helpers::get_image_placeholder_url('fallback-2-undraw');
    $items = [];

    foreach ($cluster_ids as $cluster_id) {
      if (!isset($items[$cluster_id])) {
        $items[$cluster_id] = [
          'id' => $cluster_id,
          'title' => get_the_title($cluster_id),
          'post_url' => get_the_permalink($cluster_id),
          'thumbnail_url' => get_the_post_thumbnail_url($cluster_id, 'large') ?: $fallback_image,
          'units' => []
        ];
      }
    }

    foreach ($unit_ids as $unit_id) {
      $raw_cluster = get_field('parent_cluster', $unit_id);
      $cluster_id = $raw_cluster instanceof \WP_Post ? $raw_cluster->ID : absint($raw_cluster);

      $items[$cluster_id]['units'][] = [
        'id' => $unit_id,
        'title' => get_the_title($unit_id),
        'post_url' => get_the_permalink($unit_id),
        'thumbnail_url' => get_the_post_thumbnail_url($unit_id, 'medium') ?: $fallback_image,
        'price' => get_field('price', $unit_id)
      ];
    }

    return $items;
  }

  public static function facility_items(array $facility_ids): array
  {
    $items = [];
    $fallback_image = Helpers::get_image_placeholder_url('fallback-2-undraw');

    foreach ($facility_ids as $facility_id) {
      $items[] = [
        'post_url' => get_the_permalink($facility_id),
        'thumbnail_url' => get_the_post_thumbnail_url($facility_id, 'large') ?: $fallback_image,
        'title' => get_the_title($facility_id),
        'excerpt' => get_the_excerpt($facility_id)
      ];
    }

    return $items;
  }
}