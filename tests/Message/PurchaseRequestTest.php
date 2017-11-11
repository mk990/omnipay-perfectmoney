<?php

namespace Omnipay\Perfectmoney\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{

    /**
     *
     * @var PurchaseRequest
     *
     */
    private $request;

    protected function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setAccount('Account');
        $this->request->setAccountName('AccountName');
        $this->request->setBaggageFields('BaggageFields');
        $this->request->setPassphrase('Passphrase');
        $this->request->setCurrency('Currency');
        $this->request->setAmount('10.00');
        $this->request->setReturnUrl('ReturnUrl');
        $this->request->setCancelUrl('CancelUrl');
        $this->request->setNotifyUrl('NotifyUrl');
        $this->request->setTransactionId(1);
        $this->request->setLanguage('Language');
        $this->request->setDescription('Description');
        $this->request->setDescriptionNoChange(0);
        $this->request->setAvailablePaymentMethods('all');
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $expectedData = [
            'PAYEE_ACCOUNT' => 'Account',
            'PAYEE_NAME' => 'AccountName',
            'PAYMENT_UNITS' => 'CURRENCY',
            'PAYMENT_ID' => 1,
            'PAYMENT_AMOUNT' => '10.00',
            'STATUS_URL' => 'NotifyUrl',
            'PAYMENT_URL' => 'ReturnUrl',
            'NOPAYMENT_URL' => 'CancelUrl',
            'INTERFACE_LANGUAGE' => 'Language',
            'SUGGESTED_MEMO' => 'Description',
            'SUGGESTED_MEMO_NOCHANGE' => 0,
            'AVAILABLE_PAYMENT_METHODS' => 'all',

        ];

        $this->assertEquals($expectedData, $data);
    }

    public function testSendSuccess()
    {
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('https://perfectmoney.is/api/step1.asp', $response->getRedirectUrl());
        $this->assertEquals('POST', $response->getRedirectMethod());
    }


}