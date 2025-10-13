<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
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
                                ->rule('integer'),
                            TextInput::make('phone')
                                ->required(),
                            TextInput::make('password')
                                ->password()
                                ->required(),
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
