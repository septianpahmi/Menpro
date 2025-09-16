<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Task;
use Filament\Widgets\Widget;

class ProjectGanttChart extends Widget
{
    protected string $view = 'filament.widgets.project-gantt-chart';
    protected int|string|array $columnSpan = 'full';

    public function getTasks()
    {
        return Task::all()->map(function ($task) {
            return [
                'id'        => $task->id,
                'name'      => $task->name,
                'start'     => $task->start_date->format('Y-m-d'),
                'end'       => $task->end_date->format('Y-m-d'),
            ];
        });
    }


    public function getScripts(): array
    {
        return [
            'https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.min.js',
        ];
    }

    public function getStyles(): array
    {
        return [
            'https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.css',
        ];
    }
}
