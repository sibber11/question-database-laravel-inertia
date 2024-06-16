<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'semester_id' => Semester::inRandomOrder()->value('id'),
            'course_id' => Course::inRandomOrder()->value('id'),
            'chapter_id' => Chapter::inRandomOrder()->value('id'),
        ];
    }
}
