<?php

namespace App\Filament\Resources\TaskItems\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;

class TaskItemsTable
{
    public static function configure(Table $table): Table
    {

        return $table
            ->groups([
                Group::make('task.project.name')
                    ->label('Project')
                    ->collapsible(),
                Group::make('task.name')
                    ->label('Task')
                    ->collapsible(),
            ])
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
                TextColumn::make('status')
                    ->label('Status')
                    ->color(fn(string $state): string => match ($state) {
                        'done'       => 'success',
                        default      => 'primary',
                    })
                    ->badge(),
                TextColumn::make('results.file_path')
                    ->label('Hasil Pekerjaan')
                    ->color('info')
                    ->badge()
                    ->icon('heroicon-o-link')
                    ->formatStateUsing(fn($state) => $state ? ' Preview' : '-') // tampilkan ikon/link
                    ->url(fn($state) => $state ? Storage::url($state) : null, true) // klik buka file
                    ->openUrlInNewTab()
                    ->tooltip('Klik untuk membuka hasil'),

            ])
            ->filters([
                SelectFilter::make('project')
                    ->label('Filter by Project')
                    ->relationship('task.project', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
            ])
            ->recordActions([
                Action::make('approveResult')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->results()->where('status', 'submitted')->exists())
                    ->action(function ($record) {
                        $lastResult = $record->results()->latest()->first();

                        if ($lastResult) {
                            $lastResult->update(['status' => 'approved']);
                            $record->update(['status' => 'done']); // update task item jadi done
                        }
                    }),
                Action::make('rejectResult')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->results()->where('status', 'submitted')->exists())
                    ->action(function ($record) {
                        $lastResult = $record->results()->latest()->first();

                        if ($lastResult) {
                            if ($lastResult->file_path && Storage::disk('public')->exists($lastResult->file_path)) {
                                Storage::disk('public')->delete($lastResult->file_path);
                            }

                            $lastResult->delete();
                        }
                        $record->update(['status' => 'pending']); // biar balik ke in progress
                    }),
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
                            'status'      => 'submitted',
                        ]);
                    })
                    ->modalHeading('Upload Hasil Pekerjaan')
                    ->modalSubmitActionLabel('Kirim')
                    ->visible(
                        fn($record) =>
                        $record->canUpload() && ! $record->results()->exists()
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
