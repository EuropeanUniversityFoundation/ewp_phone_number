<?php

namespace Drupal\ewp_phone_number\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_phone_number_default' formatter.
 *
 * @FieldFormatter(
 *   id = "ewp_phone_number_default",
 *   label = @Translation("Default (plain text)"),
 *   field_types = {
 *     "ewp_phone_number"
 *   }
 * )
 */
class PhoneNumberDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      // Implement default settings.
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
      // Implement settings form.
    ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'ewp_phone_number_default',
        '#e164' => $item->e164,
        '#ext' => $item->ext,
        '#other_format' => $item->other_format,
      ];
    }

    return $elements;
  }

}
