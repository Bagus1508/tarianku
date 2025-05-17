<?php

namespace App\Filament\Resources\DanceResource\Pages;

use App\Filament\Resources\DanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDance extends EditRecord
{
    protected static string $resource = DanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
