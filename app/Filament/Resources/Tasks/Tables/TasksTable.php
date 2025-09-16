<?php

namespace App\Filament\Resources\Tasks\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('project.name')
                    ->sortable()
                    ->label('Project Name')
                    ->searchable(),
                TextColumn::make('users.name')
                    ->label('User Assigned')
                    ->searchable()
                    ->badge(),
                TextColumn::make('name')
                    ->label('Task Name')
                    ->searchable(),
                TextColumn::make('duration')
                    ->label('Duration')
                    ->suffix(' Day'),
                IconColumn::make('progress')
                    ->boolean(),
            ])
            ->filters([
                Filter::make('progress')
                    ->query(fn(Builder $query) => $query->where('progress', true)),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
