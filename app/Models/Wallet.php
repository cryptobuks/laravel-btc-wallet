<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //
    protected $fillable = [
        'user_id'  ,
        'currency_id' ,
        'identifier'  ,
        'label'   ,
        'pass_phrase'  ,
        'balance' ,
        'last_update_time'
    ];


    public function addresses() {
        return $this->hasMany('App\Models\Address');
    }

    public function currency(){
        return $this->belongsTo('App\Models\Currency');
    }

}
