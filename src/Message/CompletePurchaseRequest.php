<?php

namespace Omnipay\Perfectmoney\Message;

use Omnipay\Common\Exception\InvalidResponseException;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $theirHash = (string)$this->httpRequest->request->get('V2_HASH');
        $ourHash = $this->createResponseHash($this->httpRequest->request->all());
        $paymountId = (string)$this->httpRequest->request->get('PAYMENT_ID');

        if ($theirHash !== $ourHash) {
            throw new InvalidResponseException("Callback hash does not match expected value");
        }

        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    public function createResponseHash($parameters)
    {
        $this->validate('passphrase');

        $alternate_password_hash = strtoupper(md5($this->getPassphrase()));
        $fingerprint = "{$parameters['PAYMENT_ID']}:{$parameters['PAYEE_ACCOUNT']}:{$parameters['PAYMENT_AMOUNT']}:{$parameters['PAYMENT_UNITS']}:{$parameters['PAYMENT_BATCH_NUM']}:{$parameters['PAYER_ACCOUNT']}:{$alternate_password_hash}:{$parameters['TIMESTAMPGMT']}";

        return strtoupper(md5($fingerprint));
    }
}
