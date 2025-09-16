<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Project Detail')
                    ->description('Enter the project detail')
                    ->schema([
                        TextInput::make('name')
                            ->label('Project Name')
                            ->required(),
                        Textarea::make('description')
                            ->label('Description'),
                        Grid::make(3)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->required(),
                                DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->required(),
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'planning' => 'Planning',
                                        'ongoing' => 'Ongoing',
                                        'done' => 'Done',
                                        'hold' => 'Hold',
                                    ])
                                    ->default('planning'),
                            ]),
                    ])
                    ->compact()
                    ->columnSpanFull(),
            ]);
    }
}
