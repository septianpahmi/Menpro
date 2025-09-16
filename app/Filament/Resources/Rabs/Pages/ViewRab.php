<?php

namespace App\Filament\Resources\Rabs\Pages;

use App\Filament\Resources\Rabs\RabResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRab extends ViewRecord
{
    protected static string $resource = RabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
