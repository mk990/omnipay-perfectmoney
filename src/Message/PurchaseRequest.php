<?php

namespace Omnipay\Perfectmoney\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('account', 'accountName', 'currency', 'amount');

        $data['PAYEE_ACCOUNT'] = $this->getAccount();
        $data['PAYEE_NAME'] = $this->getAccountName();
        $data['PAYMENT_UNITS'] = $this->getCurrency(); // USD, EUR or OAU
        $data['PAYMENT_ID'] = $this->getTransactionId();
        $data['PAYMENT_AMOUNT'] = $this->getAmount();
        $data['STATUS_URL'] = $this->getNotifyUrl();
        $data['PAYMENT_URL'] = $this->getReturnUrl();
        $data['NOPAYMENT_URL'] = $this->getCancelUrl();
        $data['INTERFACE_LANGUAGE'] = $this->getLanguage();
        $data['SUGGESTED_MEMO'] = $this->getDescription();
        $data['SUGGESTED_MEMO_NOCHANGE'] = $this->getDescriptionNoChange(); // 0 or 1
        $data['AVAILABLE_PAYMENT_METHODS'] = $this->getAvailablePaymentMethods(); // account, voucher, sms, wire, all

        // set baggage fields
        if (is_array($this->getBaggageFields())) {
            $data['BAGGAGE_FIELDS'] = implode(' ', array_keys($this->getBaggageFields()));
            foreach ($this->getBaggageFields() as $field => $value) {
                $data[$field] = $value;
            }
        }

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data, $this->getEndpoint());
    }
}
