<?php

namespace Omnipay\PerfectMoney\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class RefundResponse extends AbstractResponse
{
    protected $message;
    protected $success;

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
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

        $arr = [];
        foreach ($result as $item) {
            $key      = $item[1];
            $arr[$key] = $item[2];
        }


        if (isset($arr['ERROR'])) {
            $this->message = $arr['ERROR'];
            $this->success = false;
            return false;
        }

        return $this->success = true;
    }

}
