<?php

namespace Omnipay\Perfectmoney\Message;

class RefundRequest extends AbstractRequest
{
    protected $endpoint = 'https://perfectmoney.is/acct/confirm.asp';

    public function getData()
    {
        $this->validate('accountId', 'payeeAccount', 'amount', 'paymentId', 'description');

        $data['AccountID'] = $this->getAccountId();
        $data['PassPhrase'] = $this->getPassword();
        $data['Payer_Account'] = $this->getAccount();
        $data['Payee_Account'] = $this->getPayeeAccount();
        $data['Amount'] = $this->getAmount();
        $data['PAYMENT_ID'] = $this->getPaymentId();
        $data['Memo'] = $this->getDescription();
        $data['PAY_IN'] = '1';

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->get($this->endpoint, null, ['query' => $data])->send();

        return $this->response = new RefundResponse($this, $httpResponse->getBody(true));
    }
}
