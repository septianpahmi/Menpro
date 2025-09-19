<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->sortable()
                    ->label('Client')
                    ->searchable(),
                TextColumn::make('name')
                    ->sortable()
                    ->label('Project Name')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->color(fn(string $state): string => match ($state) {
                        'done'       => 'success',
                        default      => 'primary',
                    })
                    ->badge(),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date('d-m-Y'),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->date('d-m-Y'),
            ])
            ->filters([
                //
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
