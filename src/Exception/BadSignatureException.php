<?php

namespace Omnipay\Redsys\Exception;

/**
 * BadSignatureException
 *
 * @author Javier Sampedro <jsampedro77@gmail.com>
 */
class BadSignatureException extends \Exception
{
    protected $message = 'Invalid signature';
}
