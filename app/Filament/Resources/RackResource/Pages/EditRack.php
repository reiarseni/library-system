<?php

namespace App\Filament\Resources\RackResource\Pages;

use App\Filament\Resources\RackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRack extends EditRecord
{
    protected static string $resource = RackResource::class;

    public static function getModalWidth(): string
    {
        return 'sm';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
