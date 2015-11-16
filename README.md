# WooCommerce 'Gift Aid' plugin

A plugin for WooCommerce that adds the option for donors to reclaim Gift Aid at the checkout.

## About

If you're a charitable organisation based in the UK using WooCommerce to accept donations, it is highly likely that you need to give your donors the option to reclaim [Gift Aid](https://www.gov.uk/donating-to-charity/gift-aid) so that you can claim an extra 25p for every £1 they give.

WooCommerce Gift Aid removes the need for any bespoke development to add this feature. Once installed, the plugin offers the following functionality:

- A new section is added to the checkout with a customisable Gift Aid explanation and accompanying checkbox empowering the donor to reclaim Gift Aid on their donation.
- If the donor elects to reclaim Gift Aid, confirmation of this will be added to both the order confirmation/thank you page and to the order confirmation email.
- Configurable settings added to the *Products* tab in the WooCommerce settings:
    - Checkbox to enable/disable the feature
    - Label for the checkbox e.g. 'Click here to reclaim Gift Aid'
    - Heading field for the Gift Aid section at the checkout (optional, defaults to 'Reclaim Gift Aid')
    - Description field to explain Gift Aid to the donor so that they can make a choice.
- Gift Aid column added to the *Orders* screen with a simple Yes/No to reflect the donor's choice.
- The donor's Gift Aid choice will be added to the order details section of the *Edit Order* screen.
- Gift Aid column and associated data will be added automatically to CSV files exported using the WooCommerce [Order/Customer CSV Export](http://www.woothemes.com/products/ordercustomer-csv-export/) plugin.
- Gift Aid markup is inserted via AJAX if the user switches from a non-UK country to the United Kingdom.

WooCommerce Gift Aid is also fully translatable (both the admin area and front-end) and comes complete with the necessary language files (en_GB).

## Requirements

WooCommerce Gift Aid requires at least WooCommerce 2.2.3 to function correctly.

## Installation

1. Upload the `woocommerce-gift-aid` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin in the 'Products' tab of the WooCommerce settings

## Known Issues

Due to the fact that WooCommerce core is missing the ability to use the `woocommerce_get_settings_` filter to add settings to either the *checkout* or *tax* tabs we're having to put them in the *Products* tab for now. 

Adding a dedicated tab just for this plugin's settings is overkill, so it's unlikely that this particular workaround will be implemented in the meantime.

Any future update to the plugin that changes the tab in which the settings can be found will have no impact on your saved settings or any of the advertised functionality.

## Changelog

**1.1.0** - *16.11.2015* - Gift Aid markup inserted via AJAX if switching to the UK from another country.
**1.0.0** - *14.09.2015* - First stable release.
