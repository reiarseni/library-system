<?php

namespace App\Filament\Resources\RackResource\Pages;

use App\Filament\Resources\RackResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRacks extends ListRecords
{
    protected static string $resource = RackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('sm')

                ->modalHeading('Crear nuevo rack')
                ->slideOver(false)
                ->modalAlignment('center'),
        ];
    }
}
