<?php

namespace Omnipay\Redsys\Exception;

/**
 * Description of CallbackException
 *
 * @author Javier Sampedro <jsampedro77@gmail.com>
 */
class CallbackException extends \Exception
{
    protected $message = 'Redsys callback returned an error status code';
}
