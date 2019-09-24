<?php
namespace App\Repositories\Interfaces;

interface IWalletRepository {

    public function get_missing_wallets($user_id);

    public function create($data);

    public function get_by_id($id);

    public function get_by_user($user_id);

    public function update($id, $data); 

}