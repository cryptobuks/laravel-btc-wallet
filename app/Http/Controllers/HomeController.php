<?php

namespace App\Http\Controllers;

use Artisan;
use DateTime;
use Illuminate\Http\Request;
use App\Services\BitGoClient as BitGoClient; 

use App\Repositories\Interfaces\IWalletRepository;
use App\Repositories\Interfaces\IAddressRepository;

class HomeController extends Controller
{ 

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $client = new BitGoClient();
        $wallets = $this->walletRepository->get_by_user(auth()->user()->id);
        foreach ($wallets as $wallet) {
            if ((new \DateTime($wallet->last_update_time)) ->getTimestamp() < time() - 600) { // if we have updated wallet BEFORE 10 minutes ago
 
                Artisan::call('sync:wallet', [
                    'wallet'  => $wallet->identifier
                ]);
            }
        }
        $data = [
            'price' => $client->get_currency_price_in_usd('tbtc'),
            'wallets' => $this->walletRepository->get_by_user(auth()->user()->id)
        ];

        return view('home', $data);
    }
}
