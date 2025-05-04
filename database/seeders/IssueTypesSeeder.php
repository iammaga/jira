<?php

namespace Database\Seeders;

use App\Models\IssueType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssueTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Bug', 'Feature', 'Task'];
        foreach ($types as $type) {
            IssueType::firstOrCreate(['name' => $type]);
        }
    }
}
