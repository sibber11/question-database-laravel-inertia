<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'semester_id' => ['required'],
            'course_id' => ['required'],
        ];
    }
}
