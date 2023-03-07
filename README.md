Omnipay: Redsys (+bizum) driver
===============

**RedSys driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP >7.1 This package implements RedSys (formerly Sermepa) support for Omnipay.

This is an extension of the original package by [nazka](nazka/sermepa-omnipay) which seems to be stalled since years
ago.
This package features:

- Support for Omnipay 3.X
- Support for Redsys 3DS2
- Support for Redsys Bizum
- Dictionary of Redsys payment methods
- Dictionary of transaction types
- Transaction compatibility with payment method is checked to ensure validity of request

Requirements
------------

- PHP >= 7.1
- Composer (`curl -s http://getcomposer.org/installer | php`)

Installation
------------
Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply run:

```sh
composer require eseperio/omnipay-redsys
```

Basic Usage
-----------

Create a gateway instance for RedSys:

```php
$gateway = Omnipay::create('Sermepa');
```

Now define all the parameters for the purchase request:

```php
$gateway->setMerchantCode('my_merchant_code');
$gateway->setMerchantKey('my_merchant_key');
$gateway->setTransactionType('my_transaction_type');
$gateway->setCurrency('my_currency');
$gateway->setCancelUrl('my_cancel_url');
$gateway->setReturnUrl('my_return_url');
$gateway->setMerchantUrl('my_merchant_url');
$gateway->setMerchantName('my_shop_name');
$gateway->setMerchantPaymethod('my_pay_method');
$gateway->setSignatureMode('my_signature_mode');
$gateway->setConsumerLanguage(0);
$gateway->setTerminal('my_terminal');
```

> **Important**: Redsys expects the amount to be an integer, where the last 2 digits are decimals.

To convert the amount to an integer you can use the following code:

```php
number_format($amount, 2, '', '');
```



For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.


Upgrade to Omnipay 3.X
-----------

Changes for use with Omnipay 3.0

- Currency: Use the code of ISO-4217 (https://en.wikipedia.org/wiki/ISO_4217#Active_codes) instead a number. ('
  EUR' => '978')

Additional Parameter
-----------

If you want to avoid having to multiply the value by 100 just add a new parameter ( multiply=true ) to the purchase
function.

Additional Callback
-----------
Redsys has an additional callback ( Respuesta online ) that may be active in your redsys platform and therefore must be
implemented. This new callback cannot follow the normal usage of Omnipay.
You need to implement checkCallbackResponse() and decodeCallbackResponse().
