<?php

namespace Database\Seeders;

use App\Nationality;
use Illuminate\Database\Seeder;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = countries();

        foreach ($countries as $iso_alpha_2 => $country) {
            $demonym = country($iso_alpha_2)->getDemonym();
            
            if ($demonym != "") {
                Nationality::create(['nationality' => $demonym]);
            }
        }
    }
}
