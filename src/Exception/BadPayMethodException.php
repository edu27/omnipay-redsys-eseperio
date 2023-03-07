<?php

namespace Omnipay\Redsys\Exception;


/**
 * BadPayMethodException
 * @author eseperio
 */
class BadPayMethodException extends \Exception
{
    protected $message = 'Wrong pay method selected';

}
