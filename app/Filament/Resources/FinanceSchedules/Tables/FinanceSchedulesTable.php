<?php

namespace App\Filament\Resources\FinanceSchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FinanceSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                SelectColumn::make('type')
                    ->options([
                        'CF' => 'CF',
                        'DP' => 'DP',
                        'Deadline SPH' => 'Deadline SPH',
                        'Deadline Design' => 'Deadline Design',
                        'Deadline DED' => 'Deadline DED',
                        'Deadline Produksi' => 'Deadline Produksi',
                        'Deadline Pemasangan' => 'Deadline Pemasangan',
                    ]),
                TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('completed_at')
                    ->date()
                    ->sortable(),
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
