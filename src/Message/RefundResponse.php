<?php

namespace Omnipay\PerfectMoney\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class RefundResponse extends AbstractResponse
{
    protected $redirectUrl;
    protected $message;
    protected $success;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data    = $data;
        $this->success = false;
        $this->parseResponse();
    }

    public function isSuccessful()
    {
        return $this->success;
    }

    public function getMessage()
    {
        return $this->message;
    }

    private function parseResponse()
    {
        if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $this->data, $result, PREG_SET_ORDER)) {
            $this->message = 'Invalid response';
            $this->success = false;
            return false;
        }

        $ar = [];
        foreach ($result as $item) {
            $key      = $item[1];
            $ar[$key] = $item[2];
        }


        if (isset($ar['ERROR'])) {
            $this->message = $ar['ERROR'];
            $this->success = false;
            return false;
        }

        return $this->success = true;
    }

}
