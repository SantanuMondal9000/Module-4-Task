<?php

namespace Drupal\color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'rgb_text_with_background' formatter.
 *
 * @FieldFormatter(
 *   id = "rgb_text_with_background",
 *   label = @Translation("RGB Text with Background"),
 *   field_types = {
 *     "rgb_hex_color"
 *   }
 * )
 */
class RgbTextWithBackgroundFormatter extends FormatterBase {

  /**
   * The viewElements function will show the user select color code with color.
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $color = $item->hex;
      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#value' => $this->t('Color: @color', ['@color' => $color]),
        '#attributes' => [
          'style' => "background-color: {$color}; color: white; padding: 10px; border-radius: 4px;",
        ],
      ];
    }
    return $elements;
  }

}
