<?php

namespace Omnipay\Redsys\Message;

/**
 * Redsys Complete Authorize Request
 */
class CompleteAuthorizeRequest extends CompletePurchaseRequest
{
    public function sendData($data)
    {
        return $this->response = new CompleteAuthorizeResponse($this, $data);
    }
}
