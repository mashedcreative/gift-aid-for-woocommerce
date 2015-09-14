# WooCommerce 'Gift Aid' plugin

A plugin for WooCommerce that enables a Gift Aid option at the checkout.

More documentation coming Real Soon Now™.

## Installation

1. Upload the `woocommerce-gift-aid` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin in the 'Products' tab of the WooCommerce settings

## Known Issues

Due to the fact that WooCommerce core is missing the ability to use either of the following to populate a more appropriate tab with our settings we're having to put them in the *Products* tab for now.

`woocommerce_get_settings_checkout`

`woocommerce_get_settings_tax`

## Changelog

**1.0.2** - *14.09.2015* - Renamed the meta label for the order column.

**1.0.1** - *14.09.2015* - Changed the way the Gift Aid status is added to the email template.

**1.0.0** - *14.09.2015* - Feature complete. Initial beta release. Needs testing in the wild.
