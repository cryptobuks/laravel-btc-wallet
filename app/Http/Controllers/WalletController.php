<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IWalletRepository;
use App\Repositories\Interfaces\IAddressRepository;

class WalletController extends Controller
{
    //
    private $walletRepository;
    private $addressRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IWalletRepository $walletRepository , IAddressRepository $addressRepository)
    {
        
        $this->middleware('auth'); 

        $this->walletRepository = $walletRepository;
        $this->addressRepository = $addressRepository;
    }


    public function generate(Request $request){
        Artisan::call('generate:address', [
            'wallet'  => $request->input('wallet_id')
         ]);

         return redirect('home');   
    }

    public function transactions(Request $request){
        Artisan::call('sync:transactions', [
            //'wallet'  => $request->input('wallet_id')
         ]);
    }
}
