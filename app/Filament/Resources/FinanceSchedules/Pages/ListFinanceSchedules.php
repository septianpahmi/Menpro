<?php

namespace App\Filament\Resources\FinanceSchedules\Pages;

use App\Filament\Resources\FinanceSchedules\FinanceScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFinanceSchedules extends ListRecords
{
    protected static string $resource = FinanceScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
