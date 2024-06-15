<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'semester_id' => ['required'],
            'name' => ['required'],
            'course_id' => ['required'],
            'chapter_id' => ['required'],
        ];
    }
}
