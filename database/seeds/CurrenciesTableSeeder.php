<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('currencies')->insert([
            'currency' => 'Bitcoin',
            'code' => 'tbtc',
            'units' => 100000000,
            'is_enabled' => true
        ]);
    }
}
