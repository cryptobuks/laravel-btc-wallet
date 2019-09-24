<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    protected $fillable = [
        'wallet_id'     ,
                'txid'               ,
                'tx'                  ,
                'sender_address'      ,
                'receiver_address'   ,
                'amount'             ,
                'fee'               
    ];
}
