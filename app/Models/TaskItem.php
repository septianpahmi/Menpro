<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class TaskItem extends Model
{
    protected $fillable = ['task_id', 'name', 'status', 'assigned_role'];

    public static array $workflowOrder = [
        'admin' => 0,
        'surveyor' => 1,
        'desainer' => 2,
        'drafter' => 3,
        'estimator' => 4,
        'supervisor' => 5,
        'furchasing' => 6,
        'keuangan' => 7,
        'konten kreator' => 8,
    ];
    public function canUpload(): bool
    {
        $user =  Filament::auth()->user();

        if (! $user) {
            return false; // kalau belum login
        }

        $role = $user->role;
        $order = self::$workflowOrder;

        if (! isset($order[$role])) {
            return false;
        }
        if ($this->assigned_role !== $role) {
            return false;
        }
        if ($order[$role] === 0) {
            return true;
        }

        $prevOrder = $order[$role] - 1;
        $prevRole = array_search($prevOrder, $order, true);

        if ($prevRole === false) {
            return true;
        }
        return ! $this->task
            ->items()
            ->where('assigned_role', $prevRole)
            ->where('status', '!=', 'done')
            ->exists();
    }


    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function results()
    {
        return $this->hasMany(TaskResult::class, 'task_item_id');
    }
}
