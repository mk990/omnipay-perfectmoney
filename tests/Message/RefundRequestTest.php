<?php

namespace Omnipay\PerfectMoney\Tests\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\PerfectMoney\Message\PurchaseRequest;
use Omnipay\PerfectMoney\Message\RefundRequest;
use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{

    /**
     *
     * @var PurchaseRequest
     *
     */
    private $request;

    protected function setUp()
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->setPayeeAccount('PayeeAccount');
        $this->request->setAmount('10.00');
        $this->request->setDescription('Description');
        $this->request->setPassword('Password');
        $this->request->setAccount('Account');
        $this->request->setAccountId('AccountId');
        $this->request->setPaymentId('PaymentId');
    }

    /**
     * @throws InvalidRequestException
     */
    public function testGetData()
    {
        $data = $this->request->getData();

        $expectedData = [
            'PassPhrase'    => 'Password',
            'Payer_Account' => 'Account',
            'Payee_Account' => 'PayeeAccount',
            'Amount'        => '10.00',
            'Memo'          => 'Description',
            'PAY_IN'        => '1',
            'AccountID'     => 'AccountId',
            'PAYMENT_ID'    => 'PaymentId',
        ];

        $this->assertEquals($expectedData, $data);
    }

    public function testSendSuccess()
    {
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
    }

    public function testSendError()
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setPayeeAccount('PayeeAccount');
        $this->request->setAmount('10.00');
        $this->request->setDescription('Description');
        $this->request->setPassword('Password');
        $this->request->setAccount('Account');
        $this->request->setAccountId('AccountId');
        $this->request->setPaymentId('PaymentId');

        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
    }

}