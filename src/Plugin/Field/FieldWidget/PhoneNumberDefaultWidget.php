<?php

namespace Drupal\ewp_phone_number\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

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

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'placeholder_e164' => '+000111222333444',
      'placeholder_ext' => '12345',
      'placeholder_other' => 'Any other format',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['placeholder_e164'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder for Number'),
      '#default_value' => $this->getSetting('placeholder_e164'),
      '#description' => t('Text that will be shown inside the Number field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    $elements['placeholder_ext'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder for Extension'),
      '#default_value' => $this->getSetting('placeholder_ext'),
      '#description' => t('Text that will be shown inside the Extension field until a value is entered.'),
    ];

    $elements['placeholder_other'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder for Other format'),
      '#default_value' => $this->getSetting('placeholder_other'),
      '#description' => t('Text that will be shown inside the Other format field until a value is entered.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    if (!empty($this->getSetting('placeholder_e164'))) {
      $summary[] = t('Placeholder: @placeholder', ['@placeholder' => $this->getSetting('placeholder_e164')]);
    }

    if (!empty($this->getSetting('placeholder_ext'))) {
      $summary[] = t('Placeholder: @placeholder', ['@placeholder' => $this->getSetting('placeholder_ext')]);
    }

    if (!empty($this->getSetting('placeholder_other'))) {
      $summary[] = t('Placeholder: @placeholder', ['@placeholder' => $this->getSetting('placeholder_other')]);
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

    $element['e164'] = [
      '#type' => 'tel',
      '#title' => t('Number'),
      '#default_value' => isset($items[$delta]->e164) ? $items[$delta]->e164 : NULL,
      '#size' => 16,
      '#placeholder' => $this->getSetting('placeholder_e164'),
      '#maxlength' => $this->getFieldSetting('max_length_e164'),
    ];

    $element['ext'] = [
      '#type' => 'textfield',
      '#title' => t('Extension'),
      '#default_value' => isset($items[$delta]->ext) ? $items[$delta]->ext : NULL,
      '#size' => 5,
      '#placeholder' => $this->getSetting('placeholder_ext'),
      '#maxlength' => $this->getFieldSetting('max_length_ext'),
    ];

    $element['other_format'] = [
      '#type' => 'textfield',
      '#title' => t('Other format'),
      '#default_value' => isset($items[$delta]->other_format) ? $items[$delta]->other_format : NULL,
      '#size' => 32,
      '#placeholder' => $this->getSetting('placeholder_other'),
      '#maxlength' => $this->getFieldSetting('max_length_other'),
      '#description' => t('Backwards compatibility only.'),
    ];

    return $element;
  }

}
