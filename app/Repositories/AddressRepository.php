<?php
use App\Repositories\Interfaces\IAddressRepository;
use App\Services\BitGoClient as BitGoClient;
 

namespace App\Repositories;

class AddressRepository implements Interfaces\IAddressRepository {

    public function create($data) {
        return \App\Models\Address::create($data);
    }
 
    public function get_by_wallet($wallet_id) {
        return \App\Models\Address::where('wallet_id', '=', $wallet_id)->get();
    }
}
?>