<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskResult extends Model
{
    protected $fillable = [
        'task_item_id',
        'uploaded_by',
        'notes',
        'status',
    ];

    public function taskItem()
    {
        return $this->belongsTo(TaskItem::class);
    }
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
    public function files()
    {
        return $this->hasMany(ResultFile::class);
    }
}
