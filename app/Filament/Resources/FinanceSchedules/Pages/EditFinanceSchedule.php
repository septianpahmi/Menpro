<?php

namespace App\Filament\Resources\FinanceSchedules\Pages;

use App\Filament\Resources\FinanceSchedules\FinanceScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFinanceSchedule extends EditRecord
{
    protected static string $resource = FinanceScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
