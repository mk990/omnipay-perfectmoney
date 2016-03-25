<?php

namespace Omnipay\Perfectmoney\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Perfectmoney\Support\Helpers;
use Exception;

class CompletePurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function __construct(RequestInterface $request, $data, $passphrase)
    {
        parent::__construct($request, $data);
        $this->passphrase = $passphrase;
    }

    public function isSuccessful()
    {
        // check if the response has valid signature
        //$this->isValid();

        return ($this->data['PAYMENT_BATCH_NUM'] != 0) ? true : false;
    }

    public function isCancelled()
    {
        return ($this->data['PAYMENT_BATCH_NUM'] == 0) ? true : false;
    }

    public function isRedirect()
    {
        return false;
    }

    public function getRedirectUrl()
    {
        return null;
    }

    public function getRedirectMethod()
    {
        return null;
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getMessage()
    {
        return $this->data;
    }

    protected function isValid()
    {
        $request_hash = Helpers::getRequestHash($this->data, $this->passphrase);

        if ($request_hash != $this->data['V2_HASH'])
            throw new Exception("Hash cannot be authorized, request is not secure");
    }
}
