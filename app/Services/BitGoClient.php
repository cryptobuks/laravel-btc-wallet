<?php 

    use \GuzzleHttp\Client as GuzzleClient;

    namespace App\Services;

    class BitGoClient {
        
        private $API_KEY;
        private $API_URL;
        private $HEADERS; 


        function __construct(){
            $this->API_KEY = env("BITGO_API_KEY");
            $this->API_URL = env("BITGO_API_URL");

            $this->HEADERS = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->API_KEY
            ];
        } 


        private function get($url, $data = null) {
            $request_url = $this->API_URL . $url;
            $client = new \GuzzleHttp\Client([
                'headers' => $this->HEADERS
            ]);

            return json_decode($client->get($request_url, [ 
                        \GuzzleHttp\RequestOptions::JSON => $data 
                    ])->getBody()->getContents());

        }

        private function post($url, $data = null){
            $request_url = $this->API_URL . $url;
            
            $client = new \GuzzleHttp\Client([
                'headers' => $this->HEADERS
            ]);

            return json_decode($client->post($request_url, [ 
                        \GuzzleHttp\RequestOptions::JSON => $data 
                    ])->getBody()->getContents());

        }



        public function ping(){
            echo 'Hello World';
        }

        /*
        * Get last available price for currency
        *
        * @param integer
        */
        public function get_currency_price_in_usd($coin){
            $url = 'api/v2/'.$coin.'/market/latest';
            $response = $this->get($url);
            return $response -> latest ->  currencies -> USD -> last;
        }


        /*
        * Create wallet 
        *
        * @param array
        */
        public function create_wallet($data){
            $url = 'api/v2/'. $data['coin'] .'/wallet/generate';
            $response = $this->post($url, $data);
            $result = [
                'label'        => $response -> label,
                'coin'         => $response -> coin,
                'pass_phrase'  => $data['passphrase'],
                'balance'      => $response -> spendableBalance,
                'identifier'   => $response -> id,
                'address'      => $response -> receiveAddress -> address
            ];
            return $result;
        }

        public function get_wallet_info($data) {
            $url = 'api/v2/'.  $data['coin'] . '//wallet/' . $data['id'];
            $response = $this->get($url);
            $result = [
                'balance'   => $response->spendableBalance,
                'address'   => $response->receiveAddress->address
            ];
            return $result;
        }


        public function generate_address($data) {
            $url = 'api/v2/'.  $data['coin'] . '//wallet/' . $data['id'] . '//address';
            $response = $this->post($url);
            $result = [ 
                'address'   => $response->address
            ];
            return $result;
        }

        public function get_transactions_by_wallet($data){
            $url = 'api/v2/'.  $data['coin'] . '//wallet/' . $data['id'] . '//transfer';
            $response = $this->get($url);
            $result = [ 
                'transfers'   => $response->transfers
            ];

            //dd($result);
            return $result;
        }

        public function send_transaction($data){
            $url = 'api/v2/'.  $data['coin'] . '//wallet/' . $data['id'] . '//sendcoins';
            $response = $this->post($url, [
                'address' => $data['address'],
                'amount'  => $data['amount'],
                'walletPassphrase' => $data['passphrase'],
                'numBlocks' => $data['numblocks']
            ]); 

            
            return $response;
        }

        
        

    }


?> 