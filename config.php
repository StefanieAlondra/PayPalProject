<?php
require 'paypal1/autoload.php';

define('URL_SITIO','http://localhost/paypal');

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AdNQxcwDtWNNkN8GPyDBTN08Lp8t-d74SFrH21T5ZiuxV-X8P5nh1gZAhjTChW_axlqFa0Ea8l04ecL9',    //CLIENTE ID
        'EH4LFwvMusbuXZec0GvBwXD7D9EJ5N4aJL2vBkrfGm3Esc1B0-VbDxt4DhHIlaTF-Ynz8nUdVJLykOmN'      //SECRET
    )
);
//var_dump($apiContext);