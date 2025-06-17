<?php

namespace Drupal\ewp_phone_number\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'ewp_phone_number_simple' formatter.
 */
#[FieldFormatter(
  id: 'ewp_phone_number_simple',
  label: new TranslatableMarkup('Simple (plain text)'),
  field_types: [
    'ewp_phone_number',
  ],
)]
class PhoneNumberSimpleFormatter extends FormatterBase {

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

    if (!empty($item->e164)) {
      $output = $item->e164;
    }
    elseif (!empty($item->other_format)) {
      $output = $item->other_format;
    }

    if (!empty($output) && !empty($item->ext)) {
      $output .= ' ext ' . $item->ext;
    }

    return $output;
  }

}
