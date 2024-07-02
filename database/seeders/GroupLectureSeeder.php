<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Lecture;
use Illuminate\Database\Seeder;

class GroupLectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lectures = Lecture::all()->toArray();

        foreach(Group::all() as $group) {
            $planningLectures = $lectures;
            $random = rand(3, count($planningLectures));
            $maxLectureQuantity = 12;
            $lectureQuantity = max(3, min($random, $maxLectureQuantity));

            for ($i = 0; $i < $lectureQuantity; $i++) {
                $index = rand(0, count($planningLectures) - 1);
                $lectureId = $planningLectures[$index]['id'];

                $group->lectures()->attach($lectureId, [
                    'group_id' => $group->id,
                    'order_number' => rand(0, 100)
                ]);

                unset($planningLectures[$index]);
                $planningLectures = array_values($planningLectures);
            }

            $group->save();
        }
    }
}
