<?php

namespace Drupal\color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'rgb_text_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "rgb_text_formatter",
 *   label = @Translation("RGB: Text Display"),
 *   field_types = {
 *     "rgb_hex_color"
 *   }
 * )
 */
class RgbTextFormatter extends FormatterBase {

  /**
   * This function will create one html p tag and display in the page with the color code and color.
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $color = $item->hex;
      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'p',
        '#value' => $this->t('Color: @color', ['@color' => $color]),
        '#attributes' => [
          'style' => "color: {$color};",
        ],
      ];
    }
    return $elements;
  }

}
