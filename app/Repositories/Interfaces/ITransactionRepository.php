<?php
namespace App\Repositories\Interfaces;

interface ITransactionRepository {

    public function create($wallet_id, $data);
        
 
    public function syncronize($wallet_id, $transaction_data);
        

    public function get_by_txid($txid);
   

    public function get_by_wallet($wallet_id);
        
    
}