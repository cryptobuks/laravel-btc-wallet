<?php
use App\Repositories\Interfaces\IWalletRepository;
use App\Services\BitGoClient as BitGoClient;
 

namespace App\Repositories;

class WalletRepository implements \App\Repositories\Interfaces\IWalletRepository {


    public function list(){
        return \App\Models\Wallet::get();
    }

    public function create($data){
        return \App\Models\Wallet::create($data);
    }

    public function get_missing_wallets($user_id){ 
        $existingWallets = \App\Models\Wallet::where('user_id', '=', $user_id)->pluck('currency_id');
        $currencies = \App\Models\Currency::whereNotIn('id', $existingWallets)->where('is_enabled' , '=', true)->get();
        return $currencies;
    }

    public function get_by_identifier($identifier){
        return \App\Models\Wallet::where('identifier', '=', $identifier)->get()->first();
    }

    public function get_by_user($user_id){
        return \App\Models\Wallet::where('user_id', '=', $user_id)->get();
    }

    public function update($id, $data){
        \App\Models\Wallet::where('identifier', '=', $id)->update($data);
    }

    public function get_currency_by_code($code){
        return \App\Models\Currency::where('code', '=', $code)->first();
        
    }
 
}

?>