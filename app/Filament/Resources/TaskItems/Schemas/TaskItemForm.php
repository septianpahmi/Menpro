<?php

namespace App\Filament\Resources\TaskItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TaskItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('task_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'in_progress' => 'In progress', 'done' => 'Done'])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
