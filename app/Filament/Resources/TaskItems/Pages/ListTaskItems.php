<?php

namespace App\Filament\Resources\TaskItems\Pages;

use App\Filament\Resources\TaskItems\TaskItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTaskItems extends ListRecords
{
    protected static string $resource = TaskItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
