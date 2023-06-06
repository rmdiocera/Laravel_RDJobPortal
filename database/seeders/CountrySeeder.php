<?php

namespace Database\Seeders;

use App\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = countries();

        // return $countries;
        foreach ($countries as $iso_alpha_2 => $country) {
            $name = country($iso_alpha_2)->getName();
            // $demonym = country($iso_alpha_2)->getDemonym();
            Country::create([
                'country_name' => $name,
                'country_code' => $iso_alpha_2
            ]);
        }
    }
}
