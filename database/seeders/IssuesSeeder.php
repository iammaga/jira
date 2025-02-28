<?php

namespace Database\Seeders;

use App\Models\Issue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Issue::create([
            'project_id' => 1,
            'title' => 'Fix login bug',
            'description' => 'Users cannot login under certain conditions',
            'type_id' => 1,
            'priority_id' => 3,
            'status_id' => 1,
            'assignee_id' => 2,
            'created_by' => 1,
        ]);

        Issue::create([
            'project_id' => 2,
            'title' => 'Add user registration',
            'description' => 'Implement user registration feature',
            'type_id' => 2,
            'priority_id' => 2,
            'status_id' => 2,
            'assignee_id' => 2,
            'created_by' => 1,
        ]);
    }
}
