<?php

namespace Omnipay\Perfectmoney\Support;

class Helpers {

    /**
     * Generate hash.
     * @param  array $parameters
     * @param  string $secret_key
     * @return string
     */
    public static function getRequestHash($parameters, $alternate_passphrase)
    {
        $fingerprint = "{$parameters['PAYMENT_ID']}:{$parameters['PAYEE_ACCOUNT']}:{$parameters['PAYMENT_AMOUNT']}:{$parameters['PAYMENT_UNITS']}:{$parameters['PAYMENT_BATCH_NUM']}:{$parameters['PAYER_ACCOUNT']}:{$alternate_passphrase}:{$parameters['TIMESTAMPGMT']}";

        return md5($fingerprint);
    }
}