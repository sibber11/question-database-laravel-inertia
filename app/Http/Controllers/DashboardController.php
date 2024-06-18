<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectResource;
use App\Models\Course;
use App\Models\Question;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'semesters' => SelectResource::collection(Semester::all()),
            'courses' => SelectResource::collection(Course::when(session('semester_id'), fn(Builder $query, $value) => $query->where('semester_id', $value))->get()),
            'semester_id' => session('semester_id'),
            'course_id' => session('course_id'),
            'statistics' => [
                'total_questions' => Question::count(),
                'answered_questions' => Question::whereNotNull('answer')->count(),
                'un_answered_questions' => Question::whereNull('answer')->count(),
            ],
        ]);
    }
}
