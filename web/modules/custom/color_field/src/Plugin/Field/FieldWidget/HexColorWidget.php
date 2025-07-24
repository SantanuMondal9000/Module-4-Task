<?php

namespace Drupal\color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'rgb_hex_color_text_widget' widget.
 *
 * @FieldWidget(
 *   id = "hex_color_widget",
 *   label = @Translation("Hex Color"),
 *   field_types = {
 *     "rgb_hex_color"
 *   }
 * )
 */
class HexColorWidget extends WidgetBase {

  /**
   * The formElement() will create the filed to give the color code.
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = $items[$delta]->hex ?? '#000000';
    $element['hex'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hex Color'),
      '#default_value' => $value,
      '#size' => 7,
      '#maxlength' => 7,
      '#placeholder' => '#RRGGBB',
    ];
    return $element;
  }

}
