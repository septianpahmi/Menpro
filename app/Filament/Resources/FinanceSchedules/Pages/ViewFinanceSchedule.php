<?php

namespace App\Filament\Resources\FinanceSchedules\Pages;

use App\Filament\Resources\FinanceSchedules\FinanceScheduleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFinanceSchedule extends ViewRecord
{
    protected static string $resource = FinanceScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
