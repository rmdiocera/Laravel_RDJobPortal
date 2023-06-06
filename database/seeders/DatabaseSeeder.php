<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            CourseSeeder::class,
            CurrencySeeder::class,
            DegreeSeeder::class,
            EmploymentTypeSeeder::class,
            GenderSeeder::class,
            IndustrySeeder::class,
            JobLevelSeeder::class,
            NationalitySeeder::class,
            JobApplicationStatusSeeder::class
        ]);
    }
}
