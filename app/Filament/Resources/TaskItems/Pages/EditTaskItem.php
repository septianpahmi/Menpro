<?php

namespace App\Filament\Resources\TaskItems\Pages;

use App\Filament\Resources\TaskItems\TaskItemResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTaskItem extends EditRecord
{
    protected static string $resource = TaskItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
