<?php

namespace Drupal\ewp_phone_number\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'ewp_phone_number' field type.
 *
 * @FieldType(
 *   id = "ewp_phone_number",
 *   label = @Translation("Phone number"),
 *   description = @Translation("EWP Phone number type"),
 *   category = @Translation("EWP Contact"),
 *   default_widget = "ewp_phone_number_default",
 *   default_formatter = "ewp_phone_number_default"
 * )
 */
class PhoneNumberItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['e164'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Number'));

    $properties['ext'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Extension'));

    $properties['other_format'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Other format'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'e164' => [
          'type' => 'varchar',
          'length' => 16,
        ],
        'ext' => [
          'type' => 'varchar',
          'length' => 5,
        ],
        'other_format' => [
          'type' => 'varchar',
          'length' => 32,
        ],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints = parent::getConstraints();

    $max_length_e164 = 16;
    $max_length_ext = 5;
    $max_length_other = 32;
    $constraints[] = $constraint_manager->create('ComplexData', [
      'e164' => [
        'Length' => [
          'max' => $max_length_e164,
          'maxMessage' => t('%name: the number may not be longer than @max characters.', ['%name' => $this->getFieldDefinition()->getLabel(), '@max' => $max_length_e164]),
        ],
      ],
      'ext' => [
        'Length' => [
          'max' => $max_length_ext,
          'maxMessage' => t('%name: the number may not be longer than @max characters.', ['%name' => $this->getFieldDefinition()->getLabel(), '@max' => $max_length_ext]),
        ],
      ],
      'other_format' => [
        'Length' => [
          'max' => $max_length_other,
          'maxMessage' => t('%name: the number may not be longer than @max characters.', ['%name' => $this->getFieldDefinition()->getLabel(), '@max' => $max_length_other]),
        ],
      ],
    ]);

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $e164 = $this->get('e164')->getValue();
    $other = $this->get('other_format')->getValue();
    return ($e164 === NULL || $e164 === '') && ($other === NULL || $other === '');
  }

}
