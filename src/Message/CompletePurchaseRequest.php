<?php

namespace Omnipay\Perfectmoney\Message;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getSecret()
    {
        return $this->getParameter('passphrase');
    }

    public function setSecret($value)
    {
        return $this->setParameter('passphrase', $value);
    }

    public function getData()
    {
        $data = $this->httpRequest->request->all();

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data, $this->getSecret());
    }
}
