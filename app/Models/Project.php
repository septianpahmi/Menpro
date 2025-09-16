<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function rab()
    {
        return $this->hasMany(Rab::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
