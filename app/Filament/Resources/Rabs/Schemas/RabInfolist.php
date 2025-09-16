<?php

namespace App\Filament\Resources\Rabs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RabInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }
}
