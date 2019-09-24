<?php

namespace App\Console\Commands;
use App\Services\BitGoClient;
use Illuminate\Support\Str;
use App\Repositories\Interfaces\IWalletRepository;
use App\Repositories\Interfaces\IAddressRepository;
use Illuminate\Console\Command;

class GenerateWallet extends Command
{
    private $walletRepository;
    private $addressRepository;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:wallet {user?} {currency?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates Wallet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(IWalletRepository $walletRepository , IAddressRepository $addressRepository)
    {
        //
        
        $this->walletRepository = $walletRepository;
        $this->addressRepository = $addressRepository;

        $client = new BitGoClient(); 
        $user_id = $this->argument('user');
        $currency_code = $this->argument('currency');
        $currency = $this->walletRepository->get_currency_by_code($currency_code);
         
        if ($user_id && $currency) {
            
            
            $newWallet = $client->create_wallet([
                'coin' => $currency->code,
                'label'=> 'Wallet - '.$currency,
                'passphrase' => Str::random(20)
            ]);

            $wallet = $this->walletRepository->create([
                'user_id' => $user_id,
                'currency_id' => $currency->id,
                'identifier' => $newWallet['identifier'],
                'label' => $newWallet['label'],
                'pass_phrase' => $newWallet['pass_phrase'],
                'balance' => $newWallet['balance'],
                'last_update_time' => now()
            ]);

            $address = $this->addressRepository->create([
                'wallet_id' => $wallet->id,
                'address' => $newWallet['address']
            ]);
        
        }  
        
    }
}
