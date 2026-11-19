<?php
namespace KarsaStart;

class Format
{
  public static function rupiah(int|string $price): string
  {
    if (empty($price) || !is_numeric($price)) {
      return __('Hubungi Kami', 'karsa_start');
    }

    $price = (float) $price;

    return 'Rp' . number_format($price, 0, ',', '.');
  }
}
