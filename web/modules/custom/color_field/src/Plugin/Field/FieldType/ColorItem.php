<?php

namespace Drupal\color_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'rgb_hex_color' field type.
 *
 * @FieldType(
 *   id = "rgb_hex_color",
 *   label = @Translation("Color Filed"),
 *   description = @Translation("Stores a hex color code like #FF00FF."),
 *   default_widget = "string_textfield",
 *   default_formatter = "string"
 * )
 */
class ColorItem extends FieldItemBase {

  /**
   * The schema function will create the coulmn hex to store the color value in the database.
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'hex' => [
          'type' => 'varchar',
          'length' => 7,
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * Property definitions (used for widgets and access).
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['hex'] = DataDefinition::create('string')
      ->setLabel(t('Hex Color'));

    return $properties;
  }

  /**
   * Required property names.
   */
  public static function mainPropertyName() {
    return 'hex';
  }

  /**
   * Validation and checking for field values.
   */
  public function isEmpty() {
    $value = $this->get('hex')->getValue();
    return $value === NULL || $value === '';
  }

}
