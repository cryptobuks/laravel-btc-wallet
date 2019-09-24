<?php
use App\Repositories\Interfaces\ITransactionRepository;
use App\Services\BitGoClient as BitGoClient;
 

namespace App\Repositories;

class TransactionRepository implements Interfaces\ITransactionRepository {

    public function create($wallet_id, $data){
        $receiverAddress = ""; 
        foreach ($data->outputs as $output) {
            if ($output->value == $data->value){
                $receiverAddress = $output->address;
                break;
            }
        }
  
        $existing = \App\Models\Transaction::where('txid', '=', $data->txid)->get()->count();
         
        if (!$existing) {    
            return \App\Models\Transaction::create([
                'wallet_id'          => $wallet_id,
                'txid'               => $data->txid,
                'tx'                 => json_encode($data),
                'sender_address'     => $data->inputs[0]->address,
                'receiver_address'   => $receiverAddress,
                'amount'             => $data->baseValue,
                'fee'                => $data->feeString
            ]);
        }
    }
 
    public function syncronize($wallet_id, $transaction_data) {
        foreach ($transaction_data as $transaction) {
            $existing = $this->get_by_txid($transaction['txid']);
            if (!$existing) {
                $this->create($wallet_id, $transaction);
            }
        }
    }

    public function get_by_txid($txid) {
        return \App\Models\Transaction::where('txid', '=', $txid)->get();
    }

    public function get_by_wallet($wallet_id) { 
        return \App\Models\Transaction::whereIn('wallet_id', function($query) use ($wallet_id) {
            $query->from('wallets')->where('identifier', '=', $wallet_id)->select('id');
        })->get();
    }
}
?>