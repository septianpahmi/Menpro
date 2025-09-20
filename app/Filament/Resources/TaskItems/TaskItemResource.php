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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TaskItemResource extends Resource
{
    protected static ?string $model = TaskItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static ?string $recordTitleAttribute = 'TaskItem';
    protected static ?int $navigationSort = 5;
    protected static string | UnitEnum | null $navigationGroup = 'Main Data';


    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user?->role === 'admin') {
            return $query;
        }

        return match ($user?->role) {
            // Surveyor => hanya task yang ditugaskan ke dirinya
            'surveyor' => $query->whereHas('task.users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            }),

            // Desainer => task miliknya + semua task user role surveyor
            'desainer' => $query->whereHas('task.users', function ($q) use ($user) {
                $q->where('users.id', $user->id)
                    ->orWhere('users.role', 'surveyor');
            }),

            // Drafter => task miliknya + semua task surveyor + semua task desainer
            'drafter' => $query->whereHas('task.users', function ($q) use ($user) {
                $q->where('users.id', $user->id)
                    ->orWhereIn('users.role', ['surveyor', 'desainer']);
            }),

            // Role lain => hanya task yang ditugaskan ke dirinya
            default => $query->whereHas('task.users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            }),
        };
    }
    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();

        $query = static::getModel()::query()
            ->where('status', 'pending');

        if ($user?->role !== 'admin') {
            $query->whereHas('task.users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        return $query->count();
    }

    public static function canDeleteAny(): bool
    {
        return Auth::user()?->role === 'admin';
    }


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
