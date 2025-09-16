<?php

namespace App\Filament\Resources\FinanceSchedules\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FinanceScheduleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }
}
