<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['nullable'],
            'answer' => ['nullable'],
            'semester_id' => ['nullable'],
            'course_id' => ['nullable'],
            'chapter_id' => ['nullable'],
            'topic_id' => ['nullable'],
        ];
    }
}
