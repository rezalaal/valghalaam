<?php

namespace App\Filament\Resources\Campaigns\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
class CampaignInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('عنوان'),
                TextEntry::make('summary')
                    ->label('توضیحات مختصر')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->label('توضیحات مبسوط')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
