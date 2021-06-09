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
     * Create a purchase against a Hash 
     *
     * @param String $cryptoToken
     * @param Int $userCode
     * @return void
     */
    public function createCharge($cryptoToken, $userCode) {
        $params = [
            'cryptoToken'   => (string) $cryptoToken,
            'userCode'      => (int) $userCode
        ];
        return $this->executeRequest('/v01/payments/create/charge', $params);
    }

    /**
     * Get list all hashes
     *
     * @return void
     */
    public function getAllHash() {
        $params = [];
        return $this->executeRequest('/v01/payments/all/hash', $params);
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
            'rank'          => (string) $rank,
            'userCode'      => (int) $userCode
        ];
        return $this->executeRequest('/v01/payments/all/hash/rank', $params);
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
