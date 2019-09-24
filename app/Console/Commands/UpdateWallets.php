<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BitGoClient;
use App\Repositories\Interfaces\IWalletRepository; 

class UpdateWallets extends Command
{
    private $walletRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:wallet {wallet?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(IWalletRepository $walletRepository)
    {
        //
        $this->walletRepository = $walletRepository;

        $wallets = $this->walletRepository->list();
        $client = new BitGoClient();
        $requested_wallet = $this->argument('wallet');
        if (!$requested_wallet) {    
            //print("Running scheduled job");
            foreach ($wallets as $wallet) {
                $wallet_data = $client->get_wallet_info([
                    'coin' => $wallet->currency->code,
                    'id' => $wallet->identifier
                ]);

                $this->walletRepository->update($wallet->identifier, [
                    'balance' => $wallet_data['balance']
                ]);
            }
        } else {
            //print("Updating Wallet" . $requested_wallet);
            $wallet = $this->walletRepository->get_by_identifier($requested_wallet);
            $wallet_data = $client->get_wallet_info([
                'coin' => $wallet->currency->code,
                'id' => $wallet->identifier
            ]);

            $this->walletRepository->update($wallet->identifier, [
                'balance' => $wallet_data['balance'],
                'last_update_time' => now()
            ]);
        }

    }
}
