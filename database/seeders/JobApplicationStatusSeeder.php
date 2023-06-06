<?php

namespace Database\Seeders;

use App\JobApplicationStatus;
use Illuminate\Database\Seeder;

class JobApplicationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emp_types = ['Applied', 'Invited', 'Rejected', 'Accepted', 'Declined'];

        foreach ($emp_types as $emp_type) {
            JobApplicationStatus::create(['emp_type' => $emp_type]);
        }
    }
}
