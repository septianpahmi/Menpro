<?php

namespace App\Filament\Resources\TaskItems\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TaskItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }
}
