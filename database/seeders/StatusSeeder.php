<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'name' => 'Backlog',
            'color' => 'purple'
        ]);

        Status::create([
            'name' => 'To Do',
            'color' => 'blue'
        ]);

        Status::create([
            'name' => 'In Progress',
            'color' => 'yellow'
        ]);

        Status::create([
            'name' => 'In Review',
            'color' => 'orange'
        ]);

        Status::create([
            'name' => 'Done',
            'color' => 'green'
        ]);
    }
}
