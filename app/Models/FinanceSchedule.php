<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceSchedule extends Model
{
    protected $fillable = ['project_id', 'type', 'due_date', 'status', 'completed_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
