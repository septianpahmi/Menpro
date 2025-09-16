<?php

namespace App\Filament\Resources\Reports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->label('Project')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Uploaded By')
                    ->sortable(),
                TextColumn::make('content')
                    ->label('Content')
                    ->sortable(),
                TextColumn::make('file_path')
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        $ext = pathinfo($state, PATHINFO_EXTENSION);
                        return strtoupper($ext);
                    })
                    ->icon(fn($state) => match (pathinfo($state, PATHINFO_EXTENSION)) {
                        default => 'heroicon-o-paper-clip',
                    })
                    ->url(fn($record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),
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
