<?php

namespace App\Filament\Resources\RackResource\Pages;

use App\Filament\Resources\RackResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRack extends CreateRecord
{
    protected static string $resource = RackResource::class;

    public static function getModalWidth(): string
    {
        return 'sm';
    }

}
