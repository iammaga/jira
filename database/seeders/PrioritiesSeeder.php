<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = ['Low', 'Medium', 'High'];
        foreach ($priorities as $priority) {
            Priority::create(['name' => $priority]);
        }
    }
}
