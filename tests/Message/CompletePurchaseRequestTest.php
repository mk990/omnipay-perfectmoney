<?php

namespace Omnipay\PerfectMoney\Tests\Message;

use Mockery as m;
use Omnipay\PerfectMoney\Message\CompletePurchaseRequest;
use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseRequestTest extends TestCase
{

    private $request;

    protected function setUp()
    {
        $arguments = [$this->getHttpClient(), $this->getHttpRequest()];
        $this->request = (new m)->mock('Omnipay\PerfectMoney\Message\CompletePurchaseRequest[getEndpoint]', $arguments);
        $this->request->setAccount('Account');
        $this->request->setAccountName('AccountName');
        $this->request->setPassphrase('Passphrase');
    }

    public function testCreateResponseHash()
    {
        $parameters = [
            'PAYMENT_ID' => '1488022447',
            'PAYEE_ACCOUNT' => 'U123456789',
            'PAYMENT_AMOUNT' => '0.10',
            'PAYMENT_UNITS' => 'USD',
            'PAYMENT_BATCH_NUM' => '636723',
            'PAYER_ACCOUNT' => 'U04174047283211',
            'TIMESTAMPGMT' => '1488022539',
        ];

        $passwordHash = strtoupper(md5($this->request->getPassphrase()));

        $expectedFingerprint = "{$parameters['PAYMENT_ID']}:{$parameters['PAYEE_ACCOUNT']}:{$parameters['PAYMENT_AMOUNT']}:{$parameters['PAYMENT_UNITS']}:{$parameters['PAYMENT_BATCH_NUM']}:{$parameters['PAYER_ACCOUNT']}:{$passwordHash}:{$parameters['TIMESTAMPGMT']}";

        $fingerprint = $this->request->createResponseHash($parameters);
        $this->assertEquals(strtoupper(md5($expectedFingerprint)), $fingerprint);
    }

    public function testSendSuccess()
    {
//        $parameters = [
//            'PAYMENT_ID' => '1488022447',
//            'PAYEE_ACCOUNT' => 'U123456789',
//            'PAYMENT_AMOUNT' => '0.10',
//            'PAYMENT_UNITS' => 'USD',
//            'PAYMENT_BATCH_NUM' => '636723',
//            'PAYER_ACCOUNT' => 'U04174047283211',
//            'TIMESTAMPGMT' => '1488022539',
//        ];

        $httpRequest = new HttpRequest([], [
            'PAYEE_ACCOUNT' => 'U123456789',
            'PAYMENT_ID' => '1488022447',
            'PAYMENT_AMOUNT' => '0.10',
            'PAYMENT_UNITS' => 'USD',
            'PAYMENT_BATCH_NUM' => '636723',
            'PAYER_ACCOUNT' => 'U04174047283211',
            'TIMESTAMPGMT' => '1488022539',
            'V2_HASH' => '34669B3A76D5F2F8F37A490EF1CE0409',
        ]);
        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request->setPassphrase('Passphrase');
        $response = $request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('1488022447', $response->getTransactionId());
        $this->assertEquals('0.10', $response->getAmount());
        $this->assertEquals('USD', $response->getCurrency());
    }

}