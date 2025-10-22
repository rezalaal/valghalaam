<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\FiltersLayout;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('id', 'DESC'))
            ->columns([
                TextColumn::make('code')
                    ->label('کد سفیر')
                    ->searchable(),
                TextColumn::make('inviter.first_name')
                ->label('دعوت‌کننده')
                ->formatStateUsing(fn ($state, $record) =>
                    $record->inviter
                        ? $record->inviter->first_name . ' ' . $record->inviter->last_name
                        : '—'
                )
                ->sortable()
                ->searchable(),
                TextColumn::make('first_name')
                    ->label('نام')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('نام خانوادگی')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('همراه')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('ایمیل')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email_verified_at')
                    ->label('تاریخ تایید ایمیل')
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('تاریخ ویرایش')
                    ->formatStateUsing(fn ($state) => $state ? (verta($state))->format('Y/m/d') : '-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('is_legal')
                    ->label('شخصیت حقوقی')
                    ->query(fn(Builder $query) => $query->where('is_legal', true)),
                Filter::make('is_vip')
                    ->label('سفیر ویژه')
                    ->query(fn(Builder $query) => $query->where('is_vip', true)),
                Filter::make('is_foreign')
                    ->label('خارج از کشور')
                    ->query(fn(Builder $query) => $query->where('is_foreign', true))
            ], layout: FiltersLayout::AboveContent)  
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
