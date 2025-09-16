<?php

namespace App\Filament\Resources\Tasks\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\View;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;

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
                TextColumn::make('results.file_path')
                    ->label('Hasil Terakhir')
                    ->formatStateUsing(fn($state) => $state ? basename($state) : '-')
                    ->url(fn($state) => $state ? Storage::url($state) : null, true)
                    ->openUrlInNewTab(),

                TextColumn::make('results.status')
                    ->label('Status Hasil')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'approved'  => '✅ Approved',
                        'rejected'  => '❌ Rejected',
                        'submitted' => '⏳ Menunggu Review',
                        default     => '-',
                    }),

            ])
            ->filters([
                Filter::make('progress')
                    ->query(fn(Builder $query) => $query->where('progress', true)),
            ])
            ->recordActions([
                ViewAction::make(),
                // EditAction::make(),
                Action::make('Timeline')
                    ->label('Timeline')
                    ->slideOver()
                    ->modalWidth(Width::FiveExtraLarge)
                    ->form([
                        View::make('tasks.timeline')
                            ->viewData(fn($record) => ['record' => $record]),
                    ]),

                Action::make('uploadResult')
                    ->label('Upload Hasil')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        FileUpload::make('file_path')
                            ->label('File Hasil')
                            ->directory('task-results')
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
                    ->modalSubmitActionLabel('Kirim'),
                Action::make('reviewResult')
                    ->label('Review Hasil')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn($record) => $record->results()->exists())
                    ->form([
                        Select::make('status')
                            ->label('Update Status')
                            ->options([
                                'approved' => 'Approve',
                                'rejected' => 'Reject',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data, $record) {
                        $latestResult = $record->results()->latest()->first();
                        if ($latestResult) {
                            $latestResult->update(['status' => $data['status']]);
                        }
                    })
                    ->modalHeading('Review Hasil Pekerjaan')
                    ->modalSubmitActionLabel('Update'),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
