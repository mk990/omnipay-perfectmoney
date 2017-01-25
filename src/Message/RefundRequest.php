<?php

namespace Omnipay\Perfectmoney\Message;

class RefundRequest extends AbstractRequest
{
    protected $endpoint = 'https://perfectmoney.is/acct/confirm.asp';

    public function getAccount()
    {
        return $this->getParameter('account');
    }

    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getPayerAccount()
    {
        return $this->getParameter('payerAccount');
    }

    public function setPayerAccount($value)
    {
        return $this->setParameter('payerAccount', $value);
    }

    public function getPayeeAccount()
    {
        return $this->getParameter('payeeAccount');
    }

    public function setPayeeAccount($value)
    {
        return $this->setParameter('payeeAccount', $value);
    }

    public function getPaymentId()
    {
        return $this->getParameter('paymentId');
    }

    public function setPaymentId($value)
    {
        return $this->setParameter('paymentId', $value);
    }

    public function getData()
    {
        $this->validate('accountId', 'payerAccount', 'payeeAccount', 'amount', 'paymentId', 'description');

        $data['AccountID'] = $this->getAccountId();
        $data['PassPhrase'] = $this->getPassword();
        $data['Payer_Account'] = $this->getPayerAccount();
        $data['Payee_Account'] = $this->getPayeeAccount();
        $data['Amount'] = $this->getAmount();
        $data['PAYMENT_ID'] = $this->getPaymentId();
        $data['Memo'] = $this->getDescription();
        $data['PAY_IN'] = '1';

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->get($this->endpoint, null, ['query'=>$data])->send();
        return $this->response = new RefundResponse($this, $httpResponse->getBody(true));
    }
}
