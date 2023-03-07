<?php

namespace Omnipay\Redsys\Dictionaries;

class PayMethods
{
    const PAY_METHOD_BIZUM = 'z';
    const PAY_METHOD_CARD = 'C';
    const PAY_METHOD_PAYPAL = 'p';
    const PAY_METHOD_TRANSFER = 'R';
    const PAY_METHOD_MASTERPASS = 'N';

    public static function supportedOperationTypes()
    {
        return [
            self::PAY_METHOD_BIZUM => [
                TransactionTypes::AUTHORIZATION,
                TransactionTypes::SPLIT_PREAUTHORIZATION,
                TransactionTypes::SPLIT_CONFIRMATION,
            ],
            self::PAY_METHOD_PAYPAL => [
                TransactionTypes::AUTHORIZATION,
                TransactionTypes::PREAUTHORIZATION,
                TransactionTypes::PAYGOLD,
            ],
            self::PAY_METHOD_CARD => true, // all transaction types are supported
            self::PAY_METHOD_TRANSFER => [
                TransactionTypes::AUTHORIZATION,
                TransactionTypes::PAYGOLD,
            ],
            self::PAY_METHOD_MASTERPASS => [
                TransactionTypes::AUTHORIZATION,
                TransactionTypes::SPLIT_PREAUTHORIZATION,
                TransactionTypes::PAYGOLD,
            ],
        ];
    }
}
