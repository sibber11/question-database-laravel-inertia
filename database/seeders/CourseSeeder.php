<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['name' => 'Artificial Intelligence', 'semester_id' => 7],
            ['name' => 'Compiler Design and Construction', 'semester_id' => 7],
            ['name' => 'Computer Graphics', 'semester_id' => 7],
            ['name' => 'E-Commerce and Web Engineering', 'semester_id' => 7],

            ['name' => 'Network and Information Security', 'semester_id' => 8],
            ['name' => 'Information System Management', 'semester_id' => 8],
            ['name' => 'Natural Language Processing', 'semester_id' => 8],
        ];

        foreach ($courses as $course) {
            if (Course::where('name', $course['name'])->exists()) continue;
            Course::create($course);
        }
    }
}
