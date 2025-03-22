<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class PaymentConfig extends BaseConfig
{
    public $merchantId = '14266220685';
    public $serviceTypeId = '14200608975';
    public $apiKey = 'E47KFQPW';
    public $gatewayUrl = 'https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit';
    public $gatewayRRRPaymentUrl = 'https://login.remita.net/remita/ecomm/finalize.reg';
    public $checkStatusUrl = 'https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc';
    public $path;

    /*public $merchantId = '2547916';
    public $serviceTypeId = '4430731';
    public $apiKey = '1946';
    public $gatewayUrl = 'https://demo.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit';
    public $gatewayRRRPaymentUrl = 'https://demo.remita.net/remita/ecomm/finalize.reg';
    public $checkStatusUrl = 'https://demo.remita.net/remita/exapp/api/v1/send/api/echannelsvc';
    public $path;*/

    public function __construct()
    {
        $this->path = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    }
}
