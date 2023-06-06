<?php

namespace Database\Seeders;

use App\Degree;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $degrees = ['Undergraduate', 'Technical/Vocational Course', 'Bachelor\'s Degree', 'Master\'s Degree', 'Doctorate Degree'];

        foreach ($degrees as $degree) {
            Degree::create(['degree' => $degree]);
        }
    }
}
