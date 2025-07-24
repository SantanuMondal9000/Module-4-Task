<?php

namespace Drupal\color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'rgb_input_widget' widget.
 *
 * @FieldWidget(
 *   id = "rgb_input_widget",
 *   label = @Translation("RGB Inputs"),
 *   field_types = {
 *     "rgb_hex_color"
 *   }
 * )
 */
class RgbInputWidget extends WidgetBase {

  /**
   * The formElement() will create the RGB field for user select the color code.
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $hex = $items[$delta]->hex ?? '#000000';
    [$r, $g, $b] = sscanf(ltrim($hex, '#'), "%02x%02x%02x");

    $element['r'] = [
      '#type' => 'number',
      '#title' => $this->t('R'),
      '#default_value' => $r,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['g'] = [
      '#type' => 'number',
      '#title' => $this->t('G'),
      '#default_value' => $g,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['b'] = [
      '#type' => 'number',
      '#title' => $this->t('B'),
      '#default_value' => $b,
      '#min' => 0,
      '#max' => 255,
    ];

    return $element;
  }

  /**
   * The messageFormValues() will convert the RGB value to hex value.
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$value) {
      if (isset($value['r'], $value['g'], $value['b'])) {
        $value['hex'] = sprintf("#%02x%02x%02x", $value['r'], $value['g'], $value['b']);
        unset($value['r'], $value['g'], $value['b']);
      }
    }
    return $values;
  }

}
