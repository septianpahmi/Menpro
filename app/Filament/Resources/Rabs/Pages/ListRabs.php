<?php

namespace App\Filament\Resources\Rabs\Pages;

use App\Filament\Resources\Rabs\RabResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRabs extends ListRecords
{
    protected static string $resource = RabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
