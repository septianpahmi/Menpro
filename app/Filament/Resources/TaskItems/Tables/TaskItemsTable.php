<?php

namespace App\Filament\Resources\TaskItems\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;

class TaskItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultGroup('task.name')
            ->columns([
                TextColumn::make('task.users.name')
                    ->label('User Assigned')
                    ->badge()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Task Item')
                    ->searchable(),
                TextColumn::make('task.start_date')
                    ->label('Start')
                    ->date('d/m/Y'),
                TextColumn::make('task.end_date')
                    ->label('Finish')
                    ->date('d/m/Y'),
                TextColumn::make('task.duration')
                    ->label('Duration')
                    ->suffix(' Day'),
                TextColumn::make('results.file_path')
                    ->label('Hasil Pekerjaan')
                    ->color('success')
                    ->badge()
                    ->icon('heroicon-o-link')
                    ->formatStateUsing(fn($state) => $state ? ' Preview' : '-') // tampilkan ikon/link
                    ->url(fn($state) => $state ? Storage::url($state) : null, true) // klik buka file
                    ->openUrlInNewTab()
                    ->tooltip('Klik untuk membuka hasil'),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('uploadResult')
                    ->label('Upload Hasil')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        FileUpload::make('file_path')
                            ->label('File Hasil')
                            ->directory('task-results')
                            ->disk('public')
                            ->visibility('public')
                            ->required(),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->nullable(),
                    ])
                    ->action(function (array $data, $record) {
                        $record->results()->create([
                            'file_path'   => $data['file_path'],
                            'notes'       => $data['notes'] ?? null,
                            'uploaded_by' => Auth::id(),
                            'status'      => 'approved',
                        ]);
                    })
                    ->modalHeading('Upload Hasil Pekerjaan')
                    ->modalSubmitActionLabel('Kirim')
                    ->visible(fn($record) => ! $record->results()->exists()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
