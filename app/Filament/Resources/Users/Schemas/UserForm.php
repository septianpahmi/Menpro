<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('email')
                                ->label('Email address')
                                ->email()
                                ->required(),
                        ]),
                    Grid::make(2)
                        ->schema([
                            TextInput::make('password')
                                ->password()
                                ->required(),
                            Select::make('role')
                                ->label('Postition')
                                ->options([
                                    'admin' => 'Admin',
                                    'surveyor' => 'Surveyor',
                                    'desainer' => 'Desainer',
                                    'drafter' => 'Drafter',
                                    'estimator' => 'Estimator',
                                    'supervisor' => 'Supervisor',
                                    'furchasing' => 'Furchasing',
                                    'keuangan' => 'Keuangan',
                                    'konten kreator' => 'Konten kreator',
                                ])
                                ->required(),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
