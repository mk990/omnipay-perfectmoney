<?php

namespace Omnipay\PerfectMoney\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;

class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * @return array|mixed
     * @throws InvalidRequestException
     * @throws InvalidResponseException
     */
    public function getData()
    {
        $theirHash = (string)$this->httpRequest->request->get('V2_HASH');
        $ourHash   = $this->createResponseHash($this->httpRequest->request->all());

        if ($theirHash !== $ourHash) {
            throw new InvalidResponseException("Callback hash does not match expected value");
        }

        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    /**
     * @param $parameters
     * @return string
     * @throws InvalidRequestException
     */
    public function createResponseHash($parameters)
    {
        $this->validate('passphrase');

        return strtoupper(md5(implode(':', [
            $parameters['PAYMENT_ID'],
            $parameters['PAYEE_ACCOUNT'],
            $parameters['PAYMENT_AMOUNT'],
            $parameters['PAYMENT_UNITS'],
            $parameters['PAYMENT_BATCH_NUM'],
            $parameters['PAYER_ACCOUNT'],
            strtoupper(md5($this->getPassphrase())),
            $parameters['TIMESTAMPGMT'],
        ])));
    }
}
