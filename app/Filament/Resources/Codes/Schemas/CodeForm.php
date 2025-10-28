<?php

namespace App\Filament\Resources\Codes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('کد سفیر')
                    ->required(),
                Toggle::make('is_reserved')
                    ->label('رزروشده')
                    ->required(),
                TextInput::make('price')
                    ->label('قیمت')
                    ->numeric()
                    ->prefix('تومن'),
                Select::make('user_id')
                    ->label('کاربر')
                    ->relationship('user', 'last_name') 
                    ->searchable(['first_name', 'last_name', 'phone', 'email'])
                    ->preload()
                    ->nullable(),
            ]);
    }
}
