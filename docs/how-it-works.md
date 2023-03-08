# How it works

Redsys payment offers multiple payment methods, but for this driver, we use payment with redirection. This means that
the user will be redirected to the Redsys payment page where they will enter their card details and confirm the payment.
After confirmation, the user will be redirected to the URL provided as `returnUrl` if they click ok, or to the URL
provided as `cancelUrl` if they click cancel. However, neither of these URLs will receive a valid confirmation. Instead,
Redsys will send a request to the URL provided as `merchantUrl` with the transaction result. This is the only way to
confirm if the payment was successful or not, and it is the only URL that we can trust.

## Omnipay Requests and Responses

Omnipay relies on requests and responses to function, but Redsys does not work the same way. To make it work, this
driver creates many request and response classes, but they are not real requests or real responses. They are instead a
proxy from Redsys to Omnipay.

For instance, when requesting a payment, we use the `purchase()->send()` method to create and send a request. This
request is not real, but it creates an instance of `PurchaseResponse()` that is returned as the response for that fake
request. This response directly indicates that a redirection is needed, and the redirection URL is the Redsys payment
page.

The same happens with the `completePurchase()` method. It fakes a request, and the response is not a real response, but
rather the content received from Redsys wrapped in a response class. You have to call this method in the URL we provided
as `merchantUrl` to receive the response from Redsys.
