<?php

namespace App\Filament\Resources\TaskItems\Pages;

use App\Filament\Resources\TaskItems\TaskItemResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTaskItem extends ViewRecord
{
    protected static string $resource = TaskItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
        ];
    }
}
