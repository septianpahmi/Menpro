<?php

namespace App\Filament\Resources\TaskItems\Pages;

use App\Filament\Resources\TaskItems\TaskItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTaskItem extends CreateRecord
{
    protected static string $resource = TaskItemResource::class;
}
