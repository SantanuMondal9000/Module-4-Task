<?php

namespace Drupal\color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'rgb_color_picker_widget' widget.
 *
 * @FieldWidget(
 *   id = "rgb_color_picker_widget",
 *   label = @Translation("Color Picker"),
 *   field_types = {
 *     "rgb_hex_color"
 *   }
 * )
 */
class ColorPickerWidget extends WidgetBase {

  /**
   * The formElement function will create the field for select the color.
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = $items[$delta]->hex ?? '#000000';
    $element['hex'] = [
      '#type' => 'color',
      '#title' => $this->t('Pick a color'),
      '#default_value' => $value,
    ];
    return $element;
  }

}
