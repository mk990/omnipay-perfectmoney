<?php

namespace Omnipay\Perfectmoney\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getAccount()
    {
        return $this->getParameter('account');
    }

    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    public function getAccountName()
    {
        return $this->getParameter('accountName');
    }

    public function setAccountName($value)
    {
        return $this->setParameter('accountName', $value);
    }

    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    public function getDescriptionNoChange()
    {
        return $this->getParameter('descriptionNoChange');
    }

    public function setDescriptionNoChange($value)
    {
        return $this->setParameter('descriptionNoChange', $value);
    }

    public function getStatusUrl()
    {
        return $this->getParameter('serviceUrl');
    }

    public function setStatusUrl($value)
    {
        return $this->setParameter('serviceUrl', $value);
    }

    public function getPaymentUrl()
    {
        return $this->getParameter('paymentUrl');
    }

    public function setPaymentUrl($value)
    {
        return $this->setParameter('paymentUrl', $value);
    }

    public function getNoPaymentUrl()
    {
        return $this->getParameter('noPaymentUrl');
    }

    public function setNoPaymentUrl($value)
    {
        return $this->setParameter('noPaymentUrl', $value);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function getBaggageFields()
    {
        return $this->getParameter('baggageFields');
    }

    public function setBaggageFields($value)
    {
        return $this->setParameter('baggageFields', $value);
    }

    public function getAvailablePaymentMethods()
    {
        return $this->getParameter('availablePaymentMethods');
    }

    public function setAvailablePaymentMethods($value)
    {
        return $this->setParameter('availablePaymentMethods', $value);
    }

    public function getData()
    {
        $this->validate('account', 'accountName', 'currency', 'amount', 'noPaymentUrl', 'noPaymentUrl');

        $data['PAYEE_ACCOUNT'] = $this->getAccount();
        $data['PAYEE_NAME'] = $this->getAccountName();
        $data['PAYMENT_UNITS'] = $this->getCurrency(); // USD, EUR or OAU
        $data['PAYMENT_ID'] = $this->getTransactionId();
        $data['PAYMENT_AMOUNT'] = $this->getAmount();
        $data['STATUS_URL'] = $this->getStatusUrl();
        $data['PAYMENT_URL'] = $this->getPaymentUrl();
        $data['NOPAYMENT_URL'] = $this->getNoPaymentUrl();
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
