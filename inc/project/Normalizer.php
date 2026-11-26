<?php
namespace KarsaStart\Project;

use KarsaStart\Core\Helpers;
use KarsaStart\Core\Taxonomy;

class Normalizer
{
  private static function fallback_image(): string
  {
    static $url = null;
    return $url ??= Helpers::get_image_placeholder_url('fallback-2-undraw');
  }

  public static function units_by_cluster(array $cluster_ids, array $unit_ids): array
  {
    $items = [];

    foreach ($cluster_ids as $cluster_id) {
      $cluster_facility_field = get_field('cluster_facility', $cluster_id);
      $cluster_facility = wp_list_pluck(array_map(fn($id) => get_post($id), $cluster_facility_field), 'ID');

      if (!isset($items[$cluster_id])) {
        $items[$cluster_id] = [
          'id' => $cluster_id,
          'title' => get_the_title($cluster_id),
          'post_url' => get_the_permalink($cluster_id),
          'thumbnail_url' => get_the_post_thumbnail_url($cluster_id, 'full') ?: self::fallback_image(),
          'excerpt' => get_the_excerpt($cluster_id),
          'cluster_facility' => self::facility_items($cluster_facility),
          'location' => implode(
            ', ',
            wp_list_pluck(Taxonomy::sort_terms_by_hierarchy(
              get_the_terms($cluster_id, 'location'),
              'bottom_up'
            ), 'name'),
          ),
          'units' => []
        ];
      }
    }

    usort($unit_ids, static function (int $a, int $b): int {
      $price_a = (int) (get_field('price', $a) ?: PHP_INT_MAX);
      $price_b = (int) (get_field('price', $b) ?: PHP_INT_MAX);
      return $price_a <=> $price_b;
    });

    foreach ($unit_ids as $unit_id) {
      $raw_cluster = get_field('parent_cluster', $unit_id);
      $cluster_id = $raw_cluster instanceof \WP_Post ? $raw_cluster->ID : absint($raw_cluster);

      $items[$cluster_id]['units'][] = [
        'id' => $unit_id,
        'title' => get_the_title($unit_id),
        'post_url' => get_the_permalink($unit_id),
        'thumbnail_url' => get_the_post_thumbnail_url($unit_id, 'large') ?: self::fallback_image(),
        'price' => get_field('price', $unit_id)
      ];
    }

    return array_values($items);
  }

  public static function facility_items(array $facility_ids): array
  {
    $items = [];


    foreach ($facility_ids as $facility_id) {
      $items[] = [
        'id' => $facility_id,
        'post_url' => get_the_permalink($facility_id),
        'thumbnail_url' => get_the_post_thumbnail_url($facility_id, 'large') ?: self::fallback_image(),
        'title' => get_the_title($facility_id),
        'excerpt' => get_the_excerpt($facility_id)
      ];
    }

    return $items;
  }

  public static function cluster(int $id): array
  {
    $title = get_the_title($id);
    $excerpt = get_the_excerpt($id);
    $content = get_the_content($id);
    $address = get_field('address', $id);

    $location = implode(
      ', ',
      wp_list_pluck(Taxonomy::sort_terms_by_hierarchy(
        get_the_terms($id, 'location'),
        'bottom_up'
      ), 'name'),
    );

    $thumbnail = [
      'id' => get_post_thumbnail_id($id),
      'url' => get_the_post_thumbnail_url($id, 'large') ?: self::fallback_image(),
      'alt' => $title
    ];

    $siteplan_field = get_field('cluster_siteplan', $id);
    $siteplan = [
      'id' => $siteplan_field['id'],
      'url' => $siteplan_field['id'] ? wp_get_attachment_url($siteplan_field['id'], 'large') : self::fallback_image(),
      'alt' => __('Siteplan', 'karsa_start') . ' ' . $title
    ];

    $gallery = [
      $thumbnail,
      $siteplan
    ];

    $google_maps_url = get_field('google_maps_url') ?: '#';

    $cluster_facility_field = !empty(get_field('cluster_facility')) ? get_field('cluster_facility') : [];
    $cluster_facility = !empty($cluster_facility_field) ? self::facility_items($cluster_facility_field) : [];

    $cluster = [
      'id' => $id,
      'title' => $title,
      'excerpt' => $excerpt,
      'content' => $content,
      'address' => $address,
      'location' => $location,
      'full_address' => $address . ', ' . $location,
      'thumbnail' => $thumbnail,
      'siteplan' => $siteplan,
      'gallery' => $gallery,
      'google_maps_url' => $google_maps_url,
      'cluster_facility' => $cluster_facility
    ];

    return $cluster;
  }

}