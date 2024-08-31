<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public function changeSemesterCourse()
    {

        if (request()->filled('chapter_id')) {
            $chapter = Chapter::find(request('chapter_id'));
            if (empty($chapter)) {
                Session::forget('chapter_id');
                return back();
            }
            Session::put('chapter_id', $chapter->id);
            Session::put('course_id', $chapter->course_id);
            Session::put('semester_id', $chapter->semester_id);
            return back();
        } else {
            Session::forget('chapter_id');
        }

        if (request()->filled('course_id')) {
            $course = Course::find(request('course_id'));
            if (empty($course)) {
                Session::forget('course_id');
                return back();
            }
            Session::put('course_id', $course->id);
            Session::put('semester_id', $course->semester_id);
            return back();
        } else {
            Session::forget('course_id');
        }

        if (request()->filled('semester_id')) {
            Session::put('semester_id', request()->input('semester_id'));
        } else {
            Session::forget('semester_id');
        }

        return back();
    }
}
