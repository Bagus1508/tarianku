<?php

namespace App\Filament\Resources\DanceResource\Pages;

use App\Filament\Resources\DanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDances extends ListRecords
{
    protected static string $resource = DanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
