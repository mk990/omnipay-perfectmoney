<?php

namespace Omnipay\Perfectmoney;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'amount' => '0.1',
            'currency' => 'USD',
            'transactionId' => 123,
            'description' => 'Order: 123',
            'cancelUrl' => 'https://url.com/cancel',
            'returnUrl' => 'https://url.com/return',
            'notifyUrl' => 'https://url.com/notify',
        ]);

        $this->assertInstanceOf('Omnipay\Perfectmoney\Message\PurchaseRequest', $request);
        $this->assertSame('0.10', $request->getAmount());
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase();

        $this->assertInstanceOf('\Omnipay\Perfectmoney\Message\CompletePurchaseRequest', $request);
    }

    public function testRefund()
    {
        $request = $this->gateway->refund([
            'payeeAccount' => 'U12345678',
            'amount' => 0.1,
            'description' => 'Testing perfectmoney',
            'currency' => 'USD',
        ]);

        $this->assertInstanceOf('\Omnipay\PerfectMoney\Message\RefundRequest', $request);
        $this->assertSame('U12345678', $request->getPayeeAccount());
    }

}