<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Choices')
                    ->schema([
                        Flex::make([                            
                            Toggle::make('is_legal')
                                ->label('Legal')
                                ->live(),
                            Toggle::make('is_vip')
                                ->label('VIP')
                                ->live(),
                            Toggle::make('is_foreign')
                                ->label('Foreign')
                                ->live(), 
                        ])                          
                ])->columnSpanFull(),
                Section::make('Necessary Fields')
                    ->schema([
                        Flex::make([
                            TextInput::make('code')
                                ->unique(table: User::class)
                                ->rule('integer'),
                            Select::make('invited_by')
                                ->label('معرف')
                                ->options(function ($search) {
                                    // جستجو روی شماره تلفن، نام و نام خانوادگی
                                    return User::query()
                                        ->when($search, function ($query, $search) {
                                            $query->where('phone', 'like', "%{$search}%")
                                                ->orWhere('first_name', 'like', "%{$search}%")
                                                ->orWhere('last_name', 'like', "%{$search}%");
                                        })
                                        ->limit(50) // محدودیت تعداد برای سرعت بهتر
                                        ->get()
                                        ->mapWithKeys(function ($user) {
                                            $label = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
                                            $phone = $user->phone ?? '—';
                                            $display = $label ? "{$phone} — {$label}" : $phone;
                                            return [$user->id => $display];
                                        })
                                        ->toArray();
                                })
                                ->searchable()
                                ->preload(false)
                                ->nullable(),
                            TextInput::make('phone')
                                ->regex('/^09\d{9}$/')
                                ->unique(table: User::class)
                                ->required(),
                            TextInput::make('password')
                                ->password()
                                ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                                ->dehydrated(fn($state) => filled($state))
                                ->required(fn(string $operation) => $operation === 'create'),
                        ])->from('md')
                ])->columnSpanFull(),
                Section::make('Fields')
                    ->schema([
                        Flex::make([
                            TextInput::make('first_name')
                                ->hidden(fn(Get $get) => $get('is_legal')),
                            TextInput::make('last_name')
                                ->hidden(fn(Get $get) => $get('is_legal')),
                            TextInput::make('company_name')
                                ->visible(fn(Get $get) => $get('is_legal')),
                            TextInput::make('job_title'),
                        ])->from('md'),
                        Flex::make([
                            
                            TextInput::make('email')
                                ->label('Email address')
                                ->unique(table: User::class)
                                ->email(),
                        ])->from('md'),
                        
                ])->columnSpanFull(),
                
                Section::make('Verification Fields')
                    ->schema([
                        Flex::make([
                            DateTimePicker::make('phone_verified_at'),
                            DateTimePicker::make('email_verified_at'),
                        ])
                ])->columnSpanFull(),
            ]);
    }
}
