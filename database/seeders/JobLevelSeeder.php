<?php

namespace Database\Seeders;

use App\JobLevel;
use Illuminate\Database\Seeder;

class JobLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $job_levels = ['Entry Level', 'Mid-Level', 'Senior'];

        foreach ($job_levels as $job_level) {
            JobLevel::create(['job_level' => $job_level]);
        }
    }
}
