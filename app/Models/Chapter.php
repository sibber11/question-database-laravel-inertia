<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    use HasFactory;

    protected $perPage = 10;
    protected $fillable = [
        'name',
        'semester_id',
        'course_id',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'chapter_id');
    }
}
