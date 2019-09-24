<?php
use App\Repositories\Interfaces\ITransactionRepository;
use App\Services\BitGoClient as BitGoClient;
 

namespace App\Repositories;

class AddressRepository implements Interfaces\ITransactionRepository {

    public function create($wallet_id, $data){
        return \App\Models\Transaction::create([
            'wallet_id'          => $wallet_id,
            'txid'               => $data['txid'],
            'tx'                 => json_encode($data),
            'sender_address'     => $data['inputs'][0]['address'],
            'receiver_address'   => $data['outputs'][0]['address'],
            'amount'             => $data['baseValue'],
            'fee'                => $data['fee']
        ]);
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
        return \App\Models\Transaction::where('wallet_id', '=', $wallet_id)->get();
    }
}
?>