<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IWalletRepository;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\ITransactionRepository;

class WalletController extends Controller
{
    //
    private $walletRepository;
    private $addressRepository;
    private $transactionRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IWalletRepository $walletRepository , IAddressRepository $addressRepository, ITransactionRepository $transactionRepository)
    {
        
        $this->middleware('auth'); 

        $this->walletRepository = $walletRepository;
        $this->addressRepository = $addressRepository;
        $this->transactionRepository = $transactionRepository;
    }


    public function generate_address(Request $request){
        Artisan::call('generate:address', [
            'wallet'  => $request->input('wallet_id')
         ]);

         return redirect('home');   
    }

    public function generate_wallet(){
        // initial - hardcode for TBTC
        $currency = 'tbtc';
        Artisan::call('generate:wallet', [
            'user'  => auth()->user()->id,
            'currency' => $currency
         ]);

         return redirect('home');   
    }

    public function transactions(Request $request, $identifier){ 
        Artisan::call('sync:transactions', [
            'wallet'  => $request->input(' {{ $identifier }} ')
         ]);
        $transactions = $this->transactionRepository->get_by_wallet($identifier);
        $wallet = $this->walletRepository->get_by_identifier($identifier);
        return view('wallet.transactions', [
            'transactions' => $transactions,
            'wallet'       => $wallet
        ]);
    }
}
