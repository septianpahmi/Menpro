<?php

namespace App\Filament\Resources\Tasks;

use BackedEnum;
use UnitEnum;
use App\Models\Task;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\Tasks\Pages\EditTask;
use App\Filament\Resources\Tasks\Pages\ViewTask;
use App\Filament\Resources\Tasks\Pages\ListTasks;
use App\Filament\Resources\Tasks\Pages\CreateTask;
use App\Filament\Resources\Tasks\Schemas\TaskForm;
use App\Filament\Resources\Tasks\Tables\TasksTable;
use App\Filament\Resources\Tasks\Schemas\TaskInfolist;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'project.name', 'assignedUser.name'];
    }
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name ?? '—';
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Project' => $record->project?->name ?? '-',
            'Due' => $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('d-m-Y') : '-',
        ];
    }
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Task';
    protected static ?int $navigationSort = 4;
    protected static string | UnitEnum | null $navigationGroup = 'Main Data';

    public static function form(Schema $schema): Schema
    {
        return TaskForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
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
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'view' => ViewTask::route('/{record}'),
            'edit' => EditTask::route('/{record}/edit'),
        ];
    }
}
