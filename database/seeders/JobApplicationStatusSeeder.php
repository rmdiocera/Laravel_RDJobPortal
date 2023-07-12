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
        $statuses = ['Applied', 'Invited', 'Rejected', 'Accepted', 'Declined'];

        foreach ($statuses as $status) {
            JobApplicationStatus::create(['status' => $status]);
        }
    }
}
