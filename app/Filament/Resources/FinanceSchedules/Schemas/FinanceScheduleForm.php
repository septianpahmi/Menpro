<?php

namespace App\Filament\Resources\FinanceSchedules\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;

class FinanceScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    Grid::make(2)
                        ->schema([
                            Select::make('project_id')
                                ->label('Select Project')
                                ->relationship('project', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('type')
                                ->options([
                                    'CF' => 'CF',
                                    'DP' => 'DP',
                                    'Deadline SPH' => 'Deadline SPH',
                                    'Deadline Design' => 'Deadline Design',
                                    'Deadline DED' => 'Deadline DED',
                                    'Deadline Produksi' => 'Deadline Produksi',
                                    'Deadline Pemasangan' => 'Deadline Pemasangan',
                                ])
                                ->required(),
                        ]),
                    Grid::make(3)
                        ->schema([
                            DatePicker::make('due_date'),
                            DatePicker::make('completed_at'),
                            Select::make('status')
                                ->options(['pending' => 'Pending', 'done' => 'Done'])
                                ->default('pending')
                                ->required(),
                        ]),
                ])->columnSpanFull(),

            ]);
    }
}
