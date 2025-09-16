<?php

namespace App\Filament\Resources\Reports\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    Select::make('project_id')
                        ->label('Select Project')
                        ->relationship('project', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Hidden::make('user_id')
                        ->default(fn() => Auth::id()),
                    Textarea::make('content')
                        ->required(),
                    FileUpload::make('file_path')
                        ->required()
                        ->disk('public')
                        ->visibility('public')
                        ->maxSize(5120)
                        ->directory('Report'),
                ])->columnSpanFull(),
            ]);
    }
}
