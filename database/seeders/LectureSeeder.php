<?php

namespace Database\Seeders;

use App\Models\Lecture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(app(Lecture::class)->getTable())->truncate();

        Lecture::factory()->count(40)->create();
    }
}
