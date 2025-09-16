<?php

namespace App\Filament\Resources\Rabs\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class RabForm
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
                            TextInput::make('title')
                                ->required(),
                        ]),
                    TextInput::make('total_amount')
                        ->required()
                        ->numeric()
                        ->default(0.0),
                    Textarea::make('description')
                        ->columnSpanFull(),
                    Hidden::make('uploaded_by')
                        ->default(fn() => Auth::id()),
                    FileUpload::make('file_path')
                        ->required()
                        ->disk('public')
                        ->visibility('public')
                        ->maxSize(2048)
                        ->acceptedFileTypes([
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ])
                        ->directory('RAB')
                        ->columnSpanFull(),
                ])->columnSpanFull(),
            ]);
    }
}
