<?php

namespace Database\Seeders;

use App\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = ['Male', 'Female', 'Others'];

        foreach ($genders as $gender) {
            Gender::create(['gender' => $gender]);
        }
    }
}
