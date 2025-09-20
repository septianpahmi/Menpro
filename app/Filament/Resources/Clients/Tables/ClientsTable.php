<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('projects')
                    ->label('Project')
                    ->icon('heroicon-o-briefcase')
                    ->color('info')
                    ->modalHeading('Daftar Project')
                    ->modalContent(function ($record) {
                        $projects = $record->projects; // relasi User -> Projects
                        if ($projects->isEmpty()) {
                            return 'User ini belum memiliki project.';
                        }

                        return view('filament.components.user-projects', [
                            'projects' => $projects,
                        ]);
                    })
                    ->modalWidth('3xl')
                    ->modalSubmitAction(false),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
