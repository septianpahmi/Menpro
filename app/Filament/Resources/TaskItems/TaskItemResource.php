<?php

namespace App\Filament\Resources\TaskItems;

use App\Filament\Resources\TaskItems\Pages\CreateTaskItem;
use App\Filament\Resources\TaskItems\Pages\EditTaskItem;
use App\Filament\Resources\TaskItems\Pages\ListTaskItems;
use App\Filament\Resources\TaskItems\Pages\ViewTaskItem;
use App\Filament\Resources\TaskItems\Schemas\TaskItemForm;
use App\Filament\Resources\TaskItems\Schemas\TaskItemInfolist;
use App\Filament\Resources\TaskItems\Tables\TaskItemsTable;
use App\Models\TaskItem;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TaskItemResource extends Resource
{
    protected static ?string $model = TaskItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static ?string $recordTitleAttribute = 'TaskItem';
    protected static ?int $navigationSort = 5;
    protected static string | UnitEnum | null $navigationGroup = 'Main Data';

    public static function form(Schema $schema): Schema
    {
        return TaskItemForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaskItemInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaskItemsTable::configure($table);
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
            'index' => ListTaskItems::route('/'),
            'create' => CreateTaskItem::route('/create'),
            'view' => ViewTaskItem::route('/{record}'),
            'edit' => EditTaskItem::route('/{record}/edit'),
        ];
    }
}
