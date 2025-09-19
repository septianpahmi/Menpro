<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultFile extends Model
{
    protected $fillable = [
        'task_result_id',
        'file_path',
    ];

    public function result()
    {
        return $this->belongsTo(TaskResult::class, 'task_result_id');
    }
}
