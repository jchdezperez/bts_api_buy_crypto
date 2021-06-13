<?php

namespace src;

class PaymentApiCall {

    private $bearerToken;

    private $baseUrl = 'https://www.braintechsystem.com/api/bts';

    public function __construct($bearerToken)
    {
        $this->bearerToken = $bearerToken;
    }

    /**
     * Create or add wallet
     *
     * @param Int $userCode
     * @return void
     */
    public function createWallet($userCode) {
        $params = [
            'userCode'      => (int) $userCode
        ];
        return $this->executeRequest('/v01/payments/wallet/create', $params);
    }

    /**
     * Get list of all wallets
     *
     * @param Int $userCode
     * @return void
     */
    public function getWallets($userCode) {
        $params = [
            'userCode'      => (int) $userCode
        ];
        return $this->executeRequest('/v01/payments/wallet/list', $params);
    }

    /**
     * Get description of your wallet
     *
     * @param Int $userCode
     * @param String $tokenWallet
     * @return void
     */
    public function getInfoWallet($userCode, $tokenWallet) {
        $params = [
            'userCode'      => (int) $userCode,
            'tokenWallet'   => (string) $tokenWallet,
        ];
        return $this->executeRequest('/v01/payments/wallet/info', $params);
    }



    
    /**
     * Get list all hashes
     *
     * @return void
     */
    public function getAllHash($userCode) {
        $params = [
            'userCode'      => (int) $userCode
        ];
        return $this->executeRequest('/v01/payments/hash/list', $params);
    }

    /**
     * Get list all hashes by rank
     * 
     * Rank 1: bronce
     * Rank 2: plata
     * Rank 3: oro
     *
     * @return void
     */
    public function getAllHashByRank($rank, $userCode) {
        $params = [
            'userCode'      => (int) $userCode,
            'rank'          => (string) $rank
        ];
        return $this->executeRequest('/v01/payments/hash/rank', $params);
    }

    /**
     * Create a purchase against a Hash 
     *
     * @param String $cryptoToken
     * @param Int $userCode
     * @return void
     */
    public function createCharge($cryptoToken, $userCode) {
        $params = [
            'userCode'      => (int) $userCode,
            'cryptoToken'   => (string) $cryptoToken
        ];
        return $this->executeRequest('/v01/payments/charge/create', $params);
    }

    /**
     * Basic to API CRYPTO call
     *
     * @param String $endpoint
     * @param Array $params
     * @return void
     */
    private function executeRequest($endpoint, $params)
    {
        $curl = curl_init();
        $jsonParams = json_encode($params);

        curl_setopt_array($curl, array(
                CURLOPT_URL                 => $this->baseUrl.$endpoint,
                CURLOPT_RETURNTRANSFER      => true,
                CURLOPT_MAXREDIRS           => 3,
                CURLOPT_TIMEOUT             => 120,
                CURLOPT_FOLLOWLOCATION      => true,
                CURLOPT_HTTP_VERSION        => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST       => "POST",
                CURLOPT_POSTFIELDS          => $jsonParams,
                CURLOPT_HTTPHEADER          => array(
                    "Content-Type: application/json",
                    'Authorization: Bearer '.$this->bearerToken
                ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

}
