<?php

namespace App\Filament\Resources\Rabs;

use App\Filament\Resources\Rabs\Pages\CreateRab;
use App\Filament\Resources\Rabs\Pages\EditRab;
use App\Filament\Resources\Rabs\Pages\ListRabs;
use App\Filament\Resources\Rabs\Pages\ViewRab;
use App\Filament\Resources\Rabs\Schemas\RabForm;
use App\Filament\Resources\Rabs\Schemas\RabInfolist;
use App\Filament\Resources\Rabs\Tables\RabsTable;
use App\Models\Rab;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RabResource extends Resource
{
    protected static ?string $model = Rab::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $recordTitleAttribute = 'Rab';
    protected static ?int $navigationSort = 5;
    protected static string | UnitEnum | null $navigationGroup = 'Finance';

    public static function form(Schema $schema): Schema
    {
        return RabForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RabInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RabsTable::configure($table);
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
            'index' => ListRabs::route('/'),
            'create' => CreateRab::route('/create'),
            'view' => ViewRab::route('/{record}'),
            'edit' => EditRab::route('/{record}/edit'),
        ];
    }
}
