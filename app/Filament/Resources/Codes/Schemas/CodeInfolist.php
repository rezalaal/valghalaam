<?php

namespace App\Filament\Resources\Codes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CodeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code')
                    ->label('کد فیر'),
                IconEntry::make('is_reserved')
                    ->label('رزروشده')
                    ->boolean(),
                TextEntry::make('price')
                    ->label('قیمت')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('user.phone')
                    ->label('سفیر')
                    ->formatStateUsing(function ($state, $record) {
                        $user = $record->user;
                        if (!$user) return '-';
                        
                        return "{$user->first_name} {$user->last_name} - {$user->phone}";
                    })
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-'),
                TextEntry::make('updated_at')
                    ->label('تاریخ ویرایش')
                    ->dateTime()
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-'),
            ]);
    }
}
