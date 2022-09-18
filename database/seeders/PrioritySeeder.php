<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::create([
            'name' => 'Low',
            'color' => 'gray'
        ]);

        Priority::create([
            'name' => 'Medium',
            'color' => 'amber'
        ]);

        Priority::create([
            'name' => 'High',
            'color' => 'pink'
        ]);

        Priority::create([
            'name' => 'Critical',
            'color' => 'red'
        ]);
    }
}
