<?php

namespace Omnipay\Redsys\Message;

use Omnipay\Common\Message\AbstractRequest as AbstractRequestBase;

/**
 * Class AbstractRequest
 * @author E. Alamo https://github.com/Eseperio
 */
abstract class AbstractRequest extends AbstractRequestBase
{
    /**
     * Override the default Omnipay method to remove the decimal point and reduce the number of decimals to 2
     * as expected by Redsys
     * @param $value
     * @return \Omnipay\Redsys\Message\AbstractRequest
     */
    public function setAmount($value)
    {
        if (is_numeric($value)) {
            $value = number_format($value, 2, '', '');
        }
        return parent::setAmount($value);
    }
}
