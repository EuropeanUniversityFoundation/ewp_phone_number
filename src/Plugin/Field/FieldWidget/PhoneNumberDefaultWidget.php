<?php

namespace Drupal\ewp_phone_number\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ewp_phone_number\Plugin\Field\FieldType\PhoneNumberItem;

/**
 * Plugin implementation of the 'ewp_phone_number_default' widget.
 *
 * @FieldWidget(
 *   id = "ewp_phone_number_default",
 *   module = "ewp_phone_numbert",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "ewp_phone_number"
 *   }
 * )
 */
class PhoneNumberDefaultWidget extends WidgetBase {

  const PLACEHOLDER_E164 = 'placeholder_e164';
  const PLACEHOLDER_EXT = 'placeholder_ext';
  const PLACEHOLDER_OTHER = 'placeholder_other';

  const T_E164 = ['%field' => PhoneNumberItem::LABEL_E164];
  const T_EXT = ['%field' => PhoneNumberItem::LABEL_EXT];
  const T_OTHER = ['%field' => PhoneNumberItem::LABEL_OTHER];

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      self::PLACEHOLDER_E164 => '+000111222333444',
      self::PLACEHOLDER_EXT => '12345',
      self::PLACEHOLDER_OTHER => 'Any other format',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $text = 'Text shown inside the %field field until a value is entered.';
    $hint = 'Usually a sample value or description of the expected format.';

    $elements[self::PLACEHOLDER_E164] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder for %field', self::T_E164),
      '#default_value' => $this->getSetting(self::PLACEHOLDER_E164),
      '#description' => $this->t($text . ' ' . $hint, self::T_E164),
    ];

    $elements[self::PLACEHOLDER_EXT] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder for %field', self::T_EXT),
      '#default_value' => $this->getSetting(self::PLACEHOLDER_EXT),
      '#description' => $this->t($text, self::T_EXT),
    ];

    $elements[self::PLACEHOLDER_OTHER] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder for %field', self::T_OTHER),
      '#default_value' => $this->getSetting(self::PLACEHOLDER_OTHER),
      '#description' => $this->t($text, self::T_OTHER),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    if (!empty($this->getSetting(self::PLACEHOLDER_E164))) {
      $summary[] = $this->t('Placeholder: @placeholder', [
        '@placeholder' => $this->getSetting(self::PLACEHOLDER_E164),
      ]);
    }

    if (!empty($this->getSetting(self::PLACEHOLDER_EXT))) {
      $summary[] = $this->t('Placeholder: @placeholder', [
        '@placeholder' => $this->getSetting(self::PLACEHOLDER_EXT),
      ]);
    }

    if (!empty($this->getSetting(self::PLACEHOLDER_OTHER))) {
      $summary[] = $this->t('Placeholder: @placeholder', [
        '@placeholder' => $this->getSetting(self::PLACEHOLDER_OTHER),
      ]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = $element + [
      '#type' => 'details',
    ];

    $element[PhoneNumberItem::E164] = [
      '#type' => 'tel',
      '#title' => $this->t(PhoneNumberItem::LABEL_E164),
      '#default_value' => $items[$delta]->e164 ?? NULL,
      '#size' => PhoneNumberItem::MAX_LENGTH_E164,
      '#placeholder' => $this->getSetting(self::PLACEHOLDER_E164),
      '#maxlength' => PhoneNumberItem::MAX_LENGTH_E164,
    ];

    $element[PhoneNumberItem::EXT] = [
      '#type' => 'textfield',
      '#title' => $this->t(PhoneNumberItem::LABEL_EXT),
      '#default_value' => $items[$delta]->ext ?? NULL,
      '#size' => PhoneNumberItem::MAX_LENGTH_EXT,
      '#placeholder' => $this->getSetting(self::PLACEHOLDER_EXT),
      '#maxlength' => PhoneNumberItem::MAX_LENGTH_EXT,
    ];

    $element[PhoneNumberItem::OTHER] = [
      '#type' => 'textfield',
      '#title' => $this->t(PhoneNumberItem::LABEL_OTHER),
      '#default_value' => $items[$delta]->other_format ?? NULL,
      '#size' => PhoneNumberItem::MAX_LENGTH_OTHER,
      '#placeholder' => $this->getSetting(self::PLACEHOLDER_OTHER),
      '#maxlength' => PhoneNumberItem::MAX_LENGTH_OTHER,
      '#description' => $this->t('Backwards compatibility: read only.'),
      '#attributes' => [
        'readonly' => 'readonly',
      ],
    ];

    return $element;
  }

}
