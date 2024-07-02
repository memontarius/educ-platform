<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Lecture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(app(Group::class)->getTable())->truncate();

        Group::factory()->count(10)->create();
    }
}
