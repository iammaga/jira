<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['To Do', 'In Progress', 'Done'];
        foreach ($statuses as $status) {
            Status::create(['name' => $status]);
        }
    }
}
