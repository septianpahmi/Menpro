<?php

namespace App\Filament\Resources\Rabs\Pages;

use App\Filament\Resources\Rabs\RabResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRab extends EditRecord
{
    protected static string $resource = RabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
