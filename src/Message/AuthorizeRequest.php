<?php

namespace Omnipay\Redsys\Message;

use Omnipay\Redsys\Dictionaries\TransactionTypes;

/**
 * Redsys Authorize Request
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
