<?php

namespace Omnipay\Redsys\Dictionaries;
/**
 * Types of transactions supported by sermepa
 * @author eseperio
 */
class TransactionTypes
{
    const AUTHORIZATION = 0;
    const PREAUTHORIZATION = 1;
    const PREAUTHORIZATION_REPLACEMENT = 11;
    const CONFIRMATION = 2;
    const REFUND = 3;
    const SPLIT_PREAUTHORIZATION = 7;
    const SPLIT_CONFIRMATION = 8;
    const CANCELLATION = 9;
    const PAYGOLD = 15;
    const CHIP_AUTHENTICATION = 17;
    const REFUND_NO_ORIGINAL = 34;
    const BETTING_PRIZE = 37;
    const PAYMENT_CANCELLATION = 45;
    const REFUND_CANCELLATION = 46;
    const SPLIT_CONFIRMATION_CANCELLATION = 47;
}
