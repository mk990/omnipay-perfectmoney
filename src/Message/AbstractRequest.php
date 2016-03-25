<?php

namespace Omnipay\Perfectmoney\Message;

use Omnipay\Common\Message\AbstractRequest as OmnipayRequest;

abstract class AbstractRequest extends OmnipayRequest
{
    protected $liveEndpoint = 'https://perfectmoney.is/api/step1.asp';
    protected $testEndpoint = 'https://perfectmoney.is/api/step1.asp';

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
