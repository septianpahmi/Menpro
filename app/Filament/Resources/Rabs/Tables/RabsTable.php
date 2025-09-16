<?php

namespace App\Filament\Resources\Rabs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RabsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->sortable(),
                TextColumn::make('uploader.name')
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->money('idr', locale: 'id')
                    ->sortable(),
                TextColumn::make('file_path')
                    ->label('File')
                    ->formatStateUsing(function ($state) {
                        $ext = pathinfo($state, PATHINFO_EXTENSION);
                        return strtoupper($ext);
                    })
                    ->icon(fn($state) => match (pathinfo($state, PATHINFO_EXTENSION)) {
                        'pdf' => 'heroicon-o-document-text',
                        'xlsx', 'xls' => 'heroicon-o-table-cells',
                        'doc', 'docx' => 'heroicon-o-document',
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
