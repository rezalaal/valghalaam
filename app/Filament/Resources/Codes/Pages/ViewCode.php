<?php

namespace App\Filament\Resources\Codes\Pages;

use App\Filament\Resources\Codes\CodeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCode extends ViewRecord
{
    protected static string $resource = CodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
