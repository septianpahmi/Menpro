<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Carbon\Carbon;
use App\Models\TaskItem;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Wizard\Step;

class TaskForm
{
    protected static function calculateDuration($start, $end): ?int
    {
        if (! $start || ! $end) {
            return null;
        }

        try {
            $startDate = Carbon::parse($start);
            $endDate   = Carbon::parse($end);

            return $startDate->diffInDays($endDate) + 1; // +1 biar termasuk hari pertama
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Wizard::make([
                    Step::make('Task Detail')
                        ->schema([

                            Select::make('project_id')
                                ->label('Select Project')
                                ->relationship('project', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Grid::make(2)
                                ->schema([
                                    Select::make('role')
                                        ->label('Select Role')
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

                                    Select::make('users')
                                        ->label('Assign Users')
                                        ->multiple()
                                        ->searchable()
                                        ->preload()
                                        ->relationship(
                                            'users',
                                            'name',
                                            fn($query, $get) =>
                                            $get('role')
                                                ? $query->where('users.role', $get('role')) // kasih prefix tabel
                                                : $query
                                        )
                                        ->required(),

                                ]),
                            TextInput::make('name')
                                ->label('Task Name')
                                ->required(),
                            Grid::make(3)
                                ->schema([
                                    DatePicker::make('start_date')
                                        ->label('Start Date')
                                        ->reactive()
                                        ->required()
                                        ->afterStateUpdated(
                                            fn($state, callable $set, callable $get) =>
                                            $set('duration', self::calculateDuration($state, $get('end_date')))
                                        ),

                                    DatePicker::make('end_date')
                                        ->label('End Date')
                                        ->reactive()
                                        ->required()
                                        ->afterStateUpdated(
                                            fn($state, callable $set, callable $get) =>
                                            $set('duration', self::calculateDuration($get('start_date'), $state))
                                        ),

                                    TextInput::make('duration')
                                        ->label('Duration')
                                        ->suffix('Day')
                                        ->readonly()
                                        ->required(),
                                ]),
                        ]),
                    Step::make('Task Item')
                        ->schema([
                            Repeater::make('items')
                                ->label('Task Item')
                                ->relationship()
                                ->schema([
                                    Select::make('assigned_role')
                                        ->label('Role')
                                        ->options(TaskItem::$workflowOrder)
                                        ->required(),

                                    TextInput::make('name')->label('Item Name')->required(),
                                ])
                                ->createItemButtonLabel('Add Task Item'),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
