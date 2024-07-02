<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Lecture;
use App\Models\Student;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;

class ListenedLectureSeeder extends Seeder
{
    /** @var Generator */
    protected $faker;

    public function __construct()
    {
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = Group::all();
        $lectures = Lecture::all();

        foreach ($groups as $group) {
            $listenedLectures = $this->faker->randomElements($lectures, rand(3, 10), false);
            $listenedLectureIds = collect($listenedLectures)->pluck('id')->toArray();
            $group->listenedLectures()->attach($listenedLectureIds);

            /** @var Student $student */
            foreach ($group->students as $student) {
                $lectureQuantity = rand(0, count($listenedLectureIds) - 1);
                $studentListenedLectureIds = $this->faker->randomElements($listenedLectureIds, $lectureQuantity);

                if (count($studentListenedLectureIds) > 0) {
                    $student->listenedLectures()->attach($studentListenedLectureIds);
                    $student->save();
                }
            }
        }
    }
}
