<?php

namespace Omnipay\Perfectmoney\Message;

use Guzzle\Plugin\Mock\MockPlugin;
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
        $mockPlugin = new MockPlugin();
        $mockPlugin->addResponse($this->getMockHttpResponse('RefundSuccess.txt'));
        $httpClient = $this->getHttpClient();
        $httpClient->addSubscriber($mockPlugin);

        $this->request = new RefundRequest($httpClient, $this->getHttpRequest());

        $this->request->setPayeeAccount('PayeeAccount');
        $this->request->setAmount('10.00');
        $this->request->setDescription('Description');
        $this->request->setPassword('Password');
        $this->request->setAccount('Account');
        $this->request->setAccountId('AccountId');
        $this->request->setPaymentId('PaymentId');
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $expectedData = [
            'PassPhrase' => 'Password',
            'Payer_Account' => 'Account',
            'Payee_Account' => 'PayeeAccount',
            'Amount' => '10.00',
            'Memo' => 'Description',
            'PAY_IN' => '1',
            'AccountID' => 'AccountId',
            'PAYMENT_ID' => 'PaymentId',
        ];

        $this->assertEquals($expectedData, $data);
    }

    public function testSendSuccess()
    {
        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testSendError()
    {
        $mockPlugin = new MockPlugin();
        $mockPlugin->addResponse($this->getMockHttpResponse('RefundError.txt'));
        $httpClient = $this->getHttpClient();
        $httpClient->addSubscriber($mockPlugin);

        $this->request = new RefundRequest($httpClient, $this->getHttpRequest());
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