<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BitGoClient;
use App\Repositories\Interfaces\IWalletRepository; 
use App\Repositories\Interfaces\ITransactionRepository; 

class GenerateTransaction extends Command
{
    private $walletRepository;
    private $transactionRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:transaction {wallet} {amount} {destination} {numblocks?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates and transmits transaction';

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
        $amount = $this->argument('amount');
        $destination = $this->argument('destination');
        $num_blocks = $this->argument('numblocks');
        if (!$num_blocks){
            $num_blocks = 2; // set default value, just in case :)
        }
        if (!($wallet_id && $amount && $destination)) {
            return;
        }

        $client = new BitGoClient();

        $wallet = $this->walletRepository->get_by_identifier($wallet_id);
        $client->send_transaction([
            'coin' => $wallet->currency->code,
            'amount' => $amount,
            'numblocks' => $num_blocks,
            'address' => $destination,
            'passphrase' => $wallet->pass_phrase,
            'id' => $wallet->identifier

        ]);

    }
}
