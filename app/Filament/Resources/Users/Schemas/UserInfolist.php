<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('first_name')
                    ->label('نام'),
                TextEntry::make('last_name')
                    ->label('نام خانوادگی'),
                TextEntry::make('phone')
                    ->label('همراه'),
                TextEntry::make('email')
                    ->label('ایمیل'),
                TextEntry::make('phone_verified_at')
                    ->label('تاریخ تایید همراه')
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-')
                    ->placeholder('-'),
                TextEntry::make('email_verified_at')
                    ->label('تاریخ تایید ایمیل')
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-')
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('تاریخ ویرایش')
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-')
                    ->placeholder('-'),
            ]);
    }
}
