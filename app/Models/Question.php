<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'title',
        'description',
        'answer',
        'semester_id',
        'course_id',
        'chapter_id',
        'topic_id',
    ];

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}
