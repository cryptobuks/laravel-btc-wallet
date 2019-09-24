<?php
namespace App\Repositories\Interfaces;

interface IWalletRepository {

    public function list();
    
    public function get_missing_wallets($user_id);

    public function create($data);

    public function get_by_identifier($id);

    public function get_by_user($user_id);

    public function update($id, $data); 

}