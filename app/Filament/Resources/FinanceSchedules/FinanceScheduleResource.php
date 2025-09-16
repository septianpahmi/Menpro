<?php

namespace App\Filament\Resources\FinanceSchedules;

use App\Filament\Resources\FinanceSchedules\Pages\CreateFinanceSchedule;
use App\Filament\Resources\FinanceSchedules\Pages\EditFinanceSchedule;
use App\Filament\Resources\FinanceSchedules\Pages\ListFinanceSchedules;
use App\Filament\Resources\FinanceSchedules\Pages\ViewFinanceSchedule;
use App\Filament\Resources\FinanceSchedules\Schemas\FinanceScheduleForm;
use App\Filament\Resources\FinanceSchedules\Schemas\FinanceScheduleInfolist;
use App\Filament\Resources\FinanceSchedules\Tables\FinanceSchedulesTable;
use App\Models\FinanceSchedule;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FinanceScheduleResource extends Resource
{
    protected static ?string $model = FinanceSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCurrencyDollar;

    protected static ?string $recordTitleAttribute = 'FinanceSchedule';
    protected static ?int $navigationSort = 6;
    protected static string | UnitEnum | null $navigationGroup = 'Finance';

    public static function form(Schema $schema): Schema
    {
        return FinanceScheduleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FinanceScheduleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinanceSchedulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFinanceSchedules::route('/'),
            'create' => CreateFinanceSchedule::route('/create'),
            'view' => ViewFinanceSchedule::route('/{record}'),
            'edit' => EditFinanceSchedule::route('/{record}/edit'),
        ];
    }
}
