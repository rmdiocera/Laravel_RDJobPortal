<?php

namespace Database\Seeders;

use App\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = json_decode(file_get_contents(public_path('storage\json\currencies.json')));

        foreach ($currencies as $code => $currency) {
            Currency::create(['currency' => $code]);
        }
    }
}
