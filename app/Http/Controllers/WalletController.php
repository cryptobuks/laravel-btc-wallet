<?php

namespace App\Http\Controllers;

use Artisan;
use App\Services\BitGoClient;
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
            'wallet'  =>   $identifier  
         ]);
        $transactions = $this->transactionRepository->get_by_wallet($identifier);
        $wallet = $this->walletRepository->get_by_identifier($identifier);
        return view('wallet.transactions', [
            'transactions' => $transactions,
            'wallet'       => $wallet
        ]);
    }

    public function send(Request $request){
        $wallet_identifier = $request->input('identifier');
        $amount = $request->input('amount');
        $destination = $request->input('destination');
        $numblocks = $request->input('numblocks');
        Artisan::call('sync:wallet', [
            'wallet'  =>   $wallet_identifier  
         ]);
        $wallet = $this->walletRepository->get_by_identifier($wallet_identifier);

        $errors = [];
        if ($wallet->user_id != auth()->user()->id) {
            $errors[] = "Unauthorized access";
        }

        $units = $wallet->currency->units;

        if ($amount * $units > $wallet->balance) {
            $errors[] = "Not enough balance";
        }

        $client = new BitGoClient();
        if (!$client->check_receiver($destination)){
            $errors[] = "Invalid destination";
        }
        
        if (count($errors)) {
            return response($errors, 500)->header('Content-Type', 'application/json');
        } else {
            Artisan::call('generate:transaction', [
                'wallet'  =>   $wallet_identifier ,
                'amount'  =>   $amount * $units,
                'destination' => $destination,
                'numblocks' => $numblocks
             ]);
             return response('Transaction created', 201)->header('Content-Type', 'application/json');
        }
    }
}
