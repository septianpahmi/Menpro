<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['project_id', 'name', 'duration', 'start_date', 'end_date', 'progress'];
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function items()
    {
        return $this->hasMany(TaskItem::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_users')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function results()
    {
        return $this->hasMany(TaskResult::class);
    }
}
