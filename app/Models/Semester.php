<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    protected $fillable = [
        'name'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'semester_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'semester_id');
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'semester_id');
    }
}
