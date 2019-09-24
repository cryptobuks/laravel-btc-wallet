<?php
namespace App\Repositories\Interfaces;

interface IAddressRepository {

    public function create($data);
 
    public function get_by_wallet($wallet_id);

}