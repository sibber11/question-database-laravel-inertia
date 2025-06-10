<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'questions' => ['nullable', 'string'],
            'answer' => ['nullable', 'string'],
            'semester_id' => ['nullable'],
            'course_id' => ['nullable'],
            'chapter_id' => ['nullable'],
            'topic_id' => ['nullable'],
            'tags' => ['nullable', 'array'],
            'create_multiple' => ['nullable', 'boolean'],
        ];
    }
}
