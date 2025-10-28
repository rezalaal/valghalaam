<?php

namespace App\Filament\Resources\Codes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use PhpParser\Node\Stmt\Label;

class CodesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('کد سفیر')
                    ->searchable(),
                IconColumn::make('is_reserved')
                    ->label('رزرو')
                    ->boolean(),
                TextColumn::make('price')
                    ->label('قیمت')
                    ->money()
                    ->sortable(),
                TextColumn::make('user.phone')
                    ->label('نام سفیر')                    
                    ->sortable(),
                TextColumn::make('user.first_name')
                    ->label('نام خانوادگی سفیر')                    
                    ->sortable(),
                TextColumn::make('user.last_name')
                    ->label('تلفن سفیر')                    
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('تاریخ ویرایش')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
