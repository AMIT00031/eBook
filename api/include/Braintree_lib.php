<?php
define("ROOT_FOLDER","/red-listed/development/");
define("DOCUMENTROOT",$_SERVER['DOCUMENT_ROOT'].ROOT_FOLDER);

class Braintree_lib {

    function __construct() {
        
        require_once(DOCUMENTROOT . 'third_party/Braintree/Braintree.php');
        require_once(DOCUMENTROOT . 'braintree_config.php');
        
        Braintree_Configuration::environment($braintree_environment);
        Braintree_Configuration::merchantId($braintree_merchant_id);
        Braintree_Configuration::publicKey($braintree_public_key);
        Braintree_Configuration::privateKey($braintree_private_key);
    }

    function create_client_token() {
        $clientToken = Braintree_ClientToken::generate();
        return $clientToken;
    }

    function savecard($card_info) {
        $result = Braintree_Customer::create($card_info);
        dump($result);
        die;
        if ($result->success === true) {
            # Generated credit card token
            return $result->creditCard->token;
        } else {
            return $this->_parse_errors($result);
        }
    }

    function getCustomter() {
        $result = Braintree_Customer::all();
        dump($result);
        die;
        if ($result->success === true) {
            # Generated credit card token
            return $result->creditCard->token;
        } else {
            return $this->_parse_errors($result);
        }
    }

    function deleteCustomer($custId) {
        $result = Braintree_Customer::delete($custId);
        dump($result);
        die;
        if ($result->success === true) {
            # Generated credit card token
            return $result->creditCard->token;
        } else {
            return $this->_parse_errors($result);
        }
    }

    // parses errors from Braintree result object and saves them for later use
    private function _parse_errors($result) {
        $this->last_errors = array();
        foreach ($result->errors->deepAll() AS $error) {
            $this->last_errors[] = $error->code . ': ' . $error->message;
        }
    }

    function last_errors() {
        return $this->last_errors;
    }

    function checkout($card_info = array(), $amount) {

        $card_info = array(
            'number' => '4111111111111111',
            'expirationDate' => '12/2022'
        );
        $result = Braintree_Transaction::sale(array('amount' => 10,
                    'creditCard' => $card_info
                        )
        );
        
        if ($result->success) {
            return $result->transaction;
        } else {
            return false;
        }
    }

    function payWithSaveCard() {
        $card_info = array(
            'token' => '7z4ydh'
        );
        $result = Braintree_Transaction::sale(array('amount' => 10,
                    'creditCard' => $card_info
                        )
        );
        $result = Braintree_Transaction::sale([
                    'amount' => $amount,
                    'creditCard' => $card_info
        ]);

        if ($result->success) {
            return $result->transaction;
        } else {
            return false;
        }
    }

    function checkout_with_nonce($amount, $nonce) {
        try {
          
            $result = Braintree_Transaction::sale([
                        'amount' => $amount,
                        'paymentMethodNonce' => $nonce
            ]);
            if ($result->success) {
                return $result->transaction;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

}
