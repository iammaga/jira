<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create([
            'name' => 'Project A',
            'description' => 'First project',
            'created_by' => 1,
        ]);

        Project::create([
            'name' => 'Project B',
            'description' => 'Second project',
            'created_by' => 1,
        ]);
    }
}
