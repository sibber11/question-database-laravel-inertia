<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'semester_id' => ['required', 'exists:semesters,id'],
        ];
    }

}
