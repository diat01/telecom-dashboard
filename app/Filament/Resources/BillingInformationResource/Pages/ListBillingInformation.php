<?php

namespace App\Filament\Resources\BillingInformationResource\Pages;

use App\Filament\Resources\BillingInformationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBillingInformation extends ListRecords
{
    protected static string $resource = BillingInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
