# WooCommerce 'Gift Aid' plugin

A plugin for WooCommerce that enables a Gift Aid option at the checkout.

More details about what this plugin does are coming Real Soon Now™.

## Installation

1. Upload the `woocommerce-gift-aid` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin in the 'Products' tab of the WooCommerce settings

## Known Issues

Due to the fact that WooCommerce core is missing the ability to use the `woocommerce_get_settings_` filter to add settings to either the *checkout* or *tax* tabs we're having to put them in the *Products* tab for now. It's unlikely that a workaround will be implemented in the meantime.

## Changelog

**1.0.4** - *14.09.2015* - Added language files (en_GB).

**1.0.3** - *14.09.2015* - Added conditional check for fields added to the check out. Also added a default section heading.

**1.0.2** - *14.09.2015* - Renamed the meta label for the order column.

**1.0.1** - *14.09.2015* - Changed the way the Gift Aid status is added to the email template.

**1.0.0** - *14.09.2015* - Feature complete. Initial beta release. Needs testing in the wild.
