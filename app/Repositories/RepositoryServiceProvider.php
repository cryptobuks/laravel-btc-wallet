<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // //        
        $this->app->bind(
            'App\Repositories\Interfaces\IWalletRepository',
            'App\Repositories\WalletRepository',
        );

        $this->app->bind(
            'App\Repositories\Interfaces\IAddressRepository',
            'App\Repositories\AddressRepository'            
        );


        $this->app->bind(
            'App\Repositories\Interfaces\ITransactionRepository',
            'App\Repositories\TransactionRepository'            
        );
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
