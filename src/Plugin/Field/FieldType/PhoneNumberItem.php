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
 *   description = {
 *     @Translation("Stores a phone number and an extension number."),
 *     @Translation("Allows a standard E164 format for the phone number."),
 *     @Translation("Allows a fallback format for the phone number."),
 *   },
 *   category = "ewp_core",
 *   default_widget = "ewp_phone_number_default",
 *   default_formatter = "ewp_phone_number_default"
 * )
 */
class PhoneNumberItem extends FieldItemBase {

  const E164 = 'e164';
  const EXT = 'ext';
  const OTHER = 'other_format';

  const LABEL_E164 = 'Number';
  const LABEL_EXT = 'Extension';
  const LABEL_OTHER = 'Other format';

  const MAX_LENGTH_E164 = 16;
  const MAX_LENGTH_EXT = 5;
  const MAX_LENGTH_OTHER = 32;

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties[self::E164] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_E164));

    $properties[self::EXT] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_EXT));

    $properties[self::OTHER] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup(self::LABEL_OTHER));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        self::E164 => [
          'type' => 'varchar',
          'length' => self::MAX_LENGTH_E164,
        ],
        self::EXT => [
          'type' => 'varchar',
          'length' => self::MAX_LENGTH_EXT,
        ],
        self::OTHER => [
          'type' => 'varchar',
          'length' => self::MAX_LENGTH_OTHER,
        ],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraints = parent::getConstraints();
    $constraint_manager = \Drupal::typedDataManager()
      ->getValidationConstraintManager();

    $field_label = $this->getFieldDefinition()->getLabel();

    $constraints[] = $constraint_manager->create('ComplexData', [
      self::E164 => [
        'Regex' => [
          'pattern' => "/^\+[1-9]\d{1,14}$/",
          'message' => $this
            ->t('%field_label: %prop does not match the E.164 format.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_E164,
            ]),
        ],
        'Length' => [
          'max' => self::MAX_LENGTH_E164,
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_E164,
              '@max' => self::MAX_LENGTH_E164,
            ]),
        ],
      ],
      self::EXT => [
        'Regex' => [
          'pattern' => "/^\d{1,5}$/",
          'message' => $this
            ->t('%field_label: %prop must contain only digits, up to five.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_EXT,
            ]),
        ],
        'Length' => [
          'max' => self::MAX_LENGTH_EXT,
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_EXT,
              '@max' => self::MAX_LENGTH_EXT,
            ]),
        ],
      ],
      self::OTHER => [
        'Length' => [
          'max' => self::MAX_LENGTH_OTHER,
          'maxMessage' => $this
            ->t('%field_label: %prop may not be longer than @max characters.', [
              '%field_label' => $field_label,
              '%prop' => self::LABEL_OTHER,
              '@max' => self::MAX_LENGTH_OTHER,
            ]),
        ],
      ],
    ]);

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $e164 = $this->get(self::E164)->getValue();
    $e164_empty = ($e164 === NULL || $e164 === '');

    $other = $this->get(self::OTHER)->getValue();
    $other_empty = ($other === NULL || $other === '');

    return ($e164_empty && $other_empty);
  }

}
