<?php

namespace App\Filament\Resources\Campaigns\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('summary'),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
