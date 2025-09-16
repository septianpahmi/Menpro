<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskItem extends Model
{
    protected $fillable = ['task_id', 'name', 'status'];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function results()
    {
        return $this->hasMany(TaskResult::class, 'task_item_id');
    }
}
