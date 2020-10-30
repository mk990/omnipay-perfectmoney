<?php

namespace Omnipay\PerfectMoney\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    /**
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        // Validate required parameters before return data
        $this->validate('account', 'accountName', 'currency', 'amount');

        $data['PAYEE_ACCOUNT']             = $this->getAccount();
        $data['PAYEE_NAME']                = $this->getAccountName();
        $data['PAYMENT_AMOUNT']            = $this->getAmount();
        $data['PAYMENT_UNITS']             = $this->getCurrency(); // USD, EUR or OAU
        $data['PAYMENT_ID']                = $this->getTransactionId();
        $data['STATUS_URL']                = $this->getNotifyUrl();
        $data['PAYMENT_URL']               = $this->getReturnUrl();
        $data['NOPAYMENT_URL']             = $this->getCancelUrl();
        $data['INTERFACE_LANGUAGE']        = $this->getLanguage();
        $data['SUGGESTED_MEMO']            = $this->getDescription();
        $data['SUGGESTED_MEMO_NOCHANGE']   = $this->getDescriptionNoChange(); // 0 or 1
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
        return new PurchaseResponse($this, $data, $this->getEndpoint());
    }
}
