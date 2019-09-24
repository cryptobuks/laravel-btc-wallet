<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BitGoClient;
use App\Repositories\Interfaces\IWalletRepository; 
use App\Repositories\Interfaces\ITransactionRepository; 

class SyncTransactions extends Command
{
    private $walletRepository;
    private $transactionRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:transactions {wallet?}';

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
    public function handle(IWalletRepository $walletRepository, ITransactionRepository $transactionRepository)
    {
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
        //

        
        $wallet_id = $this->argument('wallet');
         
        if (!$wallet_id) {
            return;
        }
        $client = new BitGoClient();
        $wallet = $this->walletRepository->get_by_identifier($wallet_id);
        $transactions = $client-> get_transactions_by_wallet([
            'coin' => $wallet->currency->code,
            'id' => $wallet->identifier
        ])['transfers']; 
        foreach ($transactions as $transaction) {
            //dd($transaction);
            $this->transactionRepository->create($wallet->id, $transaction);
        }


    }
}
