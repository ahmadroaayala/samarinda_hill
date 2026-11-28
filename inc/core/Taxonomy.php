<?php
namespace KarsaStart\Core;

use WP_Error;

class Taxonomy
{

  public static function get_active_tree(string $taxonomy): array
  {
    // get all taxonomy that already have posts
    $terms = get_terms([
      'taxonomy' => $taxonomy,
      'hide_empty' => true,
      'orderby' => 'name',
      'order' => 'ASC',
    ]);

    if (is_wp_error($terms) || empty($terms)) {
      return [];
    }

    $indexed = [];

    foreach ($terms as $term) {
      $term->children = []; // add blank children array
      $indexed[$term->term_id] = $term; // register each term to $indexed and use the term_id as key
    }

    $tree = [];

    foreach ($indexed as $term) {
      if ($term->parent != 0 && isset($indexed[$term->parent])) {
        $indexed[$term->parent]->children[] = $term; // add term to it respective parent
      } else {
        $tree[] = $term; // if parent, then set is as a root
      }
    }

    return $tree;

  }

  public static function normalize_menu_items(array $items): array
  {
    $normalize = function ($item) use (&$normalize) {
      if (is_object($item)) {
        if ($item instanceof \WP_Term) {
          $link = get_term_link($item);
          $url = !is_wp_error($link) ? $link : '#';
          $label = $item->name;
        } else {
          $url = $item->url ?? get_permalink($item) ?? '#';
          $label = $item->title ?? $item->name ?? $item->post_title ?? '';
        }
        $children = $item->children ?? [];
      } else {
        $label = $item['label'] ?? $item['name'] ?? $item['title'] ?? '';
        $url = $item['url'] ?? $item['link'] ?? '#';
        $children = $item['children'] ?? [];
      }

      return [
        'label' => $label,
        'url' => $url,
        'children' => array_map($normalize, $children),
      ];
    };

    return array_map($normalize, $items);
  }


  public static function get_term_options(string $taxonomy, bool $grouped = true): array
  {
    if (is_tax($taxonomy)) {
      return [];
    }

    $terms = get_terms([
      'taxonomy' => $taxonomy,
      'hide_empty' => true,
    ]);

    if (is_wp_error($terms) || empty($terms)) {
      return [];
    }

    if (!$grouped || !is_taxonomy_hierarchical($taxonomy)) {
      return wp_list_pluck($terms, 'name', 'slug');
    }

    $terms_by_id = [];
    foreach ($terms as $term) {
      $terms_by_id[$term->term_id] = $term;
    }

    $root_terms = [];
    $children_by_root = [];

    foreach ($terms as $term) {
      if ($term->parent === 0 || !isset($terms_by_id[$term->parent])) {
        $root_terms[$term->term_id] = $term;
        continue;
      }

      $ancestor_id = $term->parent;
      $depth = 1;
      while (
        isset($terms_by_id[$ancestor_id]) &&
        $terms_by_id[$ancestor_id]->parent !== 0 &&
        isset($terms_by_id[$terms_by_id[$ancestor_id]->parent])
      ) {

        $ancestor_id = $terms_by_id[$ancestor_id]->parent;
        $depth++;
      }

      $prefix = $depth > 1 ? str_repeat('— ', $depth - 1) : '';
      $children_by_root[$ancestor_id][$term->slug] = $prefix . $term->name;
    }

    $options = [];
    foreach ($root_terms as $root_id => $root_term) {
      if (!empty($children_by_root[$root_id])) {
        $options[$root_term->name] = array_merge(
          [$root_term->slug => sprintf(__('Semua %s', 'karsa_start'), $root_term->name)],
          $children_by_root[$root_id]
        );
      } else {
        $options[$root_term->slug] = $root_term->name;
      }
    }
    return $options;
  }

  public static function sort_terms_by_hierarchy(array|false|WP_Error $terms, string $hierarchy = 'top_down'): array
  {

    if (empty($terms) || is_wp_error($terms)) {
      return [];
    }

    $paths = [];
    foreach ($terms as $term) {
      $ancestors = array_reverse(get_ancestors($term->term_id, $term->taxonomy, 'taxonomy'));
      $ancestors[] = $term->term_id;

      $paths[$term->term_id] = array_map(
        static fn(int $id): int => $id,
        $ancestors
      );
    }

    usort($terms, static function (\WP_Term $a, \WP_Term $b) use ($paths, $hierarchy): int {
      $comparison = $paths[$a->term_id] <=> $paths[$b->term_id];
      return $hierarchy === 'top_down' ? $comparison : -$comparison;
    });

    return $terms;
  }
}
