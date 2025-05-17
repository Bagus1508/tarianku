<?php

namespace App\Filament\Resources\DanceResource\Pages;

use App\Filament\Resources\DanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDance extends CreateRecord
{
    protected static string $resource = DanceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
