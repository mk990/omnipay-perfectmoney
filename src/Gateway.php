<?php

namespace Omnipay\PerfectMoney;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\RequestInterface;

/**
 * Gateway Class
 * @method NotificationInterface acceptNotification(array $options = array())
 * @method RequestInterface authorize(array $options = array())
 * @method RequestInterface completeAuthorize(array $options = array())
 * @method RequestInterface capture(array $options = array())
 * @method RequestInterface fetchTransaction(array $options = [])
 * @method RequestInterface void(array $options = array())
 * @method RequestInterface createCard(array $options = array())
 * @method RequestInterface updateCard(array $options = array())
 * @method RequestInterface deleteCard(array $options = array())
 */
class Gateway extends AbstractGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName()
    {
        return 'PerfectMoney';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'account'      => '',
            'account_name' => '',
            'passphrase'   => '',
        );
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->getParameter('account');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setAccount(string $value)
    {
        return $this->setParameter('account', $value);
    }

    /**
     * @return string
     */
    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    /**
     * @return string
     */
    public function getAccountName()
    {
        return $this->getParameter('accountName');
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setAccountName($value)
    {
        return $this->setParameter('accountName', $value);
    }

    /**
     * @return string
     */
    public function getPassphrase()
    {
        return $this->getParameter('passphrase');
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setPassphrase($value)
    {
        return $this->setParameter('passphrase', $value);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PerfectMoney\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PerfectMoney\Message\CompletePurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PerfectMoney\Message\RefundRequest', $parameters);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
    }
}
