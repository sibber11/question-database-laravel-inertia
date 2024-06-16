<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Question;
use App\Models\Semester;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'answer' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'semester_id' => 7,
            'course_id' => Course::inRandomOrder()->value('id'),
            'chapter_id' => Chapter::inRandomOrder()->value('id'),
            'topic_id' => Topic::inRandomOrder()->value('id'),
        ];
    }
}
