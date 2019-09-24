<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\BitGoClient;
use App\Repositories\Interfaces\IWalletRepository;
use App\Repositories\Interfaces\IAddressRepository;


class GenerateAddress extends Command
{

    private $walletRepository;
    private $addressRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:generate {wallet}';

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
    public function handle(IWalletRepository $walletRepository , IAddressRepository $addressRepository)
    {
        //
        $wallet_id = $this->argument('wallet'); 
        if (!$wallet_id) {
            return;
        }
        $this->walletRepository = $walletRepository;
        $this->addressRepository = $addressRepository;

        $client = new BitGoClient(); 
        $wallet = $this->walletRepository->get_by_identifier($wallet_id);
        if (!$wallet) {
            return;
        }

        $result = $client->generate_address([
            'coin' => $wallet->currency->code,
            'id'   => $wallet->identifier
        ]);

        if ($result) {
            $address = $this->addressRepository->create([
                'wallet_id' => $wallet->id,
                'address' => $result['address']
            ]);
        }

    }
}
