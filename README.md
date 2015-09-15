# WooCommerce 'Gift Aid' plugin

A plugin for WooCommerce that adds the option for donors to reclaim Gift Aid at the checkout.

## About

If you're a charitable organisation based in the UK using WooCommerce to accept donations, it is highly likely that you need to give your donors the option to reclaim [Gift Aid](https://www.gov.uk/donating-to-charity/gift-aid) so that you can claim an extra 25p for every £1 they give.

WooCommerce Gift Aid removes the need for any bespoke development to add this feature. Once installed, the plugin offers the following functionality:

- A new section is added to the checkout with a customisable Gift Aid explanation and accompanying checkbox empowering the donor to reclaim Gift Aid on their donation.
- If the donor elects to reclaim Gift Aid, confirmation of this will be added to both the thank you page and to the order confirmation email.
- Configurable settings added to the *Products* tab in the WooCommerce settings:
    - Checkbox to enable/disable the feature
    - Label for the checkbox e.g. 'Click here to reclaim Gift Aid'
    - Heading field for the Gift Aid section at the checkout (optional, defaults to 'Reclaim Gift Aid')
    - Description field to explain Gift Aid to the donor so that they can make a choice.
- Gift Aid column added to the *Orders* screen with a simple Yes/No to reflect the donor's choice.
- The donor's Gift Aid choice will be added to the order details section of the *Edit Order* screen.
- Gift Aid column and associated data will be added automatically to CSV files exported using the WooCommerce [Order/Customer CSV Export](http://www.woothemes.com/products/ordercustomer-csv-export/) plugin.

WooCommerce Gift Aid is also fully translatable and comes complete with the necessary language files (en_GB).

## Installation

1. Upload the `woocommerce-gift-aid` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin in the 'Products' tab of the WooCommerce settings

## Known Issues

Due to the fact that WooCommerce core is missing the ability to use the `woocommerce_get_settings_` filter to add settings to either the *checkout* or *tax* tabs we're having to put them in the *Products* tab for now. It's unlikely that a workaround will be implemented in the meantime.

## Changelog

**1.0.4** - Added language files (en_GB).

**1.0.3** - Added conditional check for fields added to the check out. Also added a default section heading.

**1.0.2** - Renamed the meta label for the order column.

**1.0.1** - Changed the way the Gift Aid status is added to the email template.

**1.0.0** - Feature complete. Initial beta release. Needs testing in the wild.
