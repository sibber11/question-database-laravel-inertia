<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public function changeSemesterCourse()
    {
        if (request()->filled('semester_id')) {
            Session::put('semester_id', request()->input('semester_id'));
        } else {
            Session::forget('semester_id');
        }

        if (request()->filled('course_id')) {
            $course = Course::find(request('course_id'));
            Session::put('course_id', $course->id);
            Session::put('semester_id', $course->semester_id);
        } else {
            Session::forget('course_id');
        }
        return back();
    }
}
