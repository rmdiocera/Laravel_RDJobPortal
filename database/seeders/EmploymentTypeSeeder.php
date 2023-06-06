<?php

namespace Database\Seeders;

use App\EmpType;
use Illuminate\Database\Seeder;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emp_types = ['Full-time', 'Part-time', 'Contract'];

        foreach ($emp_types as $emp_type) {
            EmpType::create(['emp_type' => $emp_type]);
        }
    }
}
