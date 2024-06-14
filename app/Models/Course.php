<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'semester_id',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
