<?php

namespace Drupal\ewp_phone_number\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_phone_number_default' formatter.
 *
 * @FieldFormatter(
 *   id = "ewp_phone_number_default",
 *   label = @Translation("Default"),
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
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    $output = '';
    $e164 = $item->e164;
    $ext = $item->ext;
    $other = $item->other_format;
    if (!empty($e164)) {
      $output = $e164;
    } elseif (!empty($other)) {
      $output = $other;
    }
    if (!empty($output) && !empty($ext)) {
      $output .= ' ext '.$ext;
    }
    return $output;
  }

}
