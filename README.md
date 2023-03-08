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

### How it works

Redsys payment has multiple payment methods, but the one used by this driver is payment with redirection.
This means the user will be redirected to the Redsys payment page, where he will enter his card details and confirm the
payment. After that, the user will be redirected to the url you provided as `returnUrl` when it clicks ok
or to the url you provided as `cancelUrl` when it clicks cancel. But non of this url will receive a valid confirmation.
Redsys will send a request to the url you provided as `merchantUrl` with the result of the transaction, which is the
only
way to know if the payment was successful or not and the only one url we trust.

Omnipay relies on requests and responses to work, but that is not exactly how Redsys works. So, to make it work, this
driver creates many request and response classes, but they are not real requests, or real responses, but a proxy from
Redsys to Omnipay.
I.e; when requesting a payment, we use the method `purchase()->send()` to create and send a request,
but this request is not a real. It creates an instance of `PurchaseResponse()` that is returned as the response for
that fake request. This response directly indicates a redirection is needed, and the redirection url is the Redsys
payment page.

Same happens with `completePurchase()` method. It fakes a request, but the response is not a real response, but the
content received from Redsys. We have to call this method in the url we provided as `merchantUrl` to receive the
response from Redsys. 


Basic Usage
-----------

Create a gateway instance for RedSys:

```php
$gateway = Omnipay::create('Sermepa');
```

Now define all the parameters needed by the gateway:

```php
$gateway->setMerchantCode('my_merchant_code');
$gateway->setMerchantKey('my_merchant_key');
$gateway->setTransactionType(\Omnipay\Redsys\Dictionaries\TransactionTypes::AUTHORIZATION);
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

`setMerchantUrl` is the url where the gateway will send the response of the transaction. This url must be accessible

Next, create a request, which can be either a purchase (common) or an authorize request:

```php
$request = $gateway->purchase()
            ->setTitular('my_company_name')
            ->setAmount('my_total_amount')
            ->setTransactionId('my_transaction_id')
            ->setOrder('my_order_id')
            ->setTransactionReference('my_transaction_reference')
            ->setDescription('my_order_description');
    ],
]);
```

> **Important**: Redsys expects the transactionId to be an integer, and the amount to be an integer where the last 2
> digits are decimals.

Omnipay has many methods to set the amount, but this library has the method setAmount overrided to ensure that the
amount is an integer and the last 2 digits are decimals.

When you use `setAmount()`, the amount is formatted with `number_format($amount, 2, '', '')`.
You still can
use [`setAmountInteger()`](https://github.com/thephpleague/omnipay-common/blob/e1ebc22615f14219d31cefdf62d7036feb228b1c/src/Common/Message/AbstractRequest.php#L355)
to set the amount as an integer.

## Receiving the payment response

Now, on the route you provided as `merchantUrl` you can receive the response from Redsys:

```php 
$gateway = Omnipay::create('Sermepa');
$response = $gateway->completePurchase()->send();
if($response->isSuccessful()){
    // The payment was successful
    // Confirm your order or other stuff
    
    $orderId = $response->getTransactionId();
    
    // ...
}
```

### Using BIZUM

All the params are shared between card and bizum, so you can use the same gateway instance to create a bizum request.
The only difference is the payment method:

```php
// Set the payment method to BIZUM
$gateway->setMerchantPaymethod(PayMethods::PAY_METHOD_BIZUM);
// Bizum is only compatible with AUTHORIZATION transactions
$gateway->setTransactionType(TransactionTypes::AUTHORIZATION);
```

For other general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.


Upgrade to Omnipay 3.X
-----------

Changes for use with Omnipay 3.0

- Currency: Use the code of ISO-4217 (https://en.wikipedia.org/wiki/ISO_4217#Active_codes) instead a number. ('
  EUR' => '978')

Additional Callback
-----------
Redsys has an additional callback ( Respuesta online ) that may be active in your redsys platform and therefore must be
implemented. This new callback cannot follow the normal usage of Omnipay.
You need to implement checkCallbackResponse() and decodeCallbackResponse().
