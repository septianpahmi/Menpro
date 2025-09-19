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
use Filament\Tables\Columns\ViewColumn;
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
                TextColumn::make('hasil')
                    ->label('Hasil Pekerjaan')
                    ->getStateUsing(function ($record) {
                        return $record->results
                            ->flatMap->files
                            ->map(function ($file) {
                                $url = Storage::url($file->file_path);
                                $name = basename($file->file_path);
                                return "<a href='{$url}' target='_blank' class='text-blue-600 hover:underline'> 📂"
                                    . \Illuminate\Support\Str::limit($name, 10) // batasi nama 20 karakter
                                    . "</a>";
                            })
                            ->implode('<br>');
                    })
                    ->html()
                    ->tooltip(function ($record) {
                        return $record->results
                            ->flatMap->files
                            ->map(fn($file) => basename($file->file_path))
                            ->implode("\n"); // tooltip tampil semua nama file
                    }),

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
                Action::make('viewResult')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('default')
                    ->modalHeading('Detail Hasil Pekerjaan')
                    ->visible(fn($record) => $record->status === 'done' && $record->results()->exists())
                    ->modalContent(function ($record) {
                        $lastResult = $record->results()->latest()->first();

                        if (! $lastResult) {
                            return 'Tidak ada hasil yang tersedia.';
                        }

                        return view('filament.components.view-task-result', [
                            'result' => $lastResult,
                        ]);
                    })
                    ->slideOver()
                    ->modalSubmitAction(false),

                Action::make('approveResult')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->tooltip('Approve')
                    ->requiresConfirmation()
                    ->visible(fn($record) =>
                    Auth::user()?->role === 'admin'
                        && $record->results()->where('status', 'submitted')->exists())
                    ->action(function ($record) {
                        $lastResult = $record->results()->latest()->first();

                        if ($lastResult) {
                            $lastResult->update(['status' => 'approved']);
                            $record->update(['status' => 'done']);

                            if ($record->assigned_role === 'admin') {
                                $record->task->project->update(['status' => 'done']);
                            }
                        }
                    }),
                Action::make('rejectResult')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->visible(fn($record) => Auth::user()?->role === 'admin'
                        && $record->results()->where('status', 'submitted')->exists())
                    ->action(function ($record) {
                        $lastResult = $record->results()->latest()->with('files')->first();

                        if ($lastResult) {
                            foreach ($lastResult->files as $file) {
                                if (Storage::disk('public')->exists($file->file_path)) {
                                    Storage::disk('public')->delete($file->file_path);
                                }
                                $file->delete();
                            }

                            $lastResult->delete();
                        }

                        $record->update(['status' => 'pending']);
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
                            ->multiple()
                            ->required(),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->nullable(),
                    ])
                    ->action(function (array $data, $record) {
                        $result = $record->results()->create([
                            'notes'       => $data['notes'] ?? null,
                            'uploaded_by' => Auth::id(),
                            'status'      => 'submitted',
                        ]);

                        foreach ($data['file_path'] as $path) {
                            $result->files()->create(['file_path' => $path]);
                        }
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
                    DeleteBulkAction::make()
                        ->visible(fn() => Auth::user()?->role === 'admin'),
                ]),
            ]);
    }
}
