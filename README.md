# EWP Phone Number

Drupal implementation of the EWP Phone Number Type.

See the **Erasmus Without Paper** specification for more information:

  - [EWP Phone Number Types](https://github.com/erasmus-without-paper/ewp-specs-types-phonenumber/tree/v1.0.1)

## Installation

Include the repository in your project's `composer.json` file:

    "repositories": [
        ...
        {
            "type": "vcs",
            "url": "https://github.com/EuropeanUniversityFoundation/ewp_phone_number"
        }
    ],

Then you can require the package as usual:

    composer require euf/ewp_phone_number

Finally, install the module:

    drush en ewp_phone_number

## Usage

The **Phone Number** field type becomes available in the Field UI so it can be added to any fieldable entity like any other field type.
