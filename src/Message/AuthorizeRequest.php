<?php

namespace Omnipay\Sermepa\Message;

use Omnipay\Sermepa\Dictionaries\TransactionTypes;

/**
 * Sermepa (Redsys) Authorize Request
 *
 * @author Nerburish <nerburish@gmail.com>
 */
class AuthorizeRequest extends PurchaseRequest
{
    public function getTransactionType()
    {
        return TransactionTypes::PREAUTHORIZATION;
    }
}
