<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use App\Enums\Education;
use App\Models\IranCity;
use App\Models\IranProvince;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\Radio;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تعیین وضعیت')
                    ->schema([
                        Flex::make([                            
                            Toggle::make('is_legal')
                                ->label('شخصیت حقوقی')
                                ->live(),
                            Toggle::make('is_vip')
                                ->label('سفیر ویژه')
                                ->live(),
                            Toggle::make('is_foreign')
                                ->label('خارج از کشور')
                                ->live(),                         
                            Radio::make('gender_id')
                                ->label('جنسیت')
                                ->options([
                                    1 => 'مرد',
                                    2 => 'زن',
                                ])
                                ->inline()

                        ])                          
                ])                
                ->columnSpanFull(),
                Section::make('استان و شهر و تحصیلات')
                    ->schema([
                        Flex::make([
                            Select::make('province')
                                ->label('استان')
                                ->options(IranProvince::all()->pluck('name', 'id')->toArray())
                                ->reactive() 
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $set('city', null);
                                })
                                ->required(),

                            Select::make('city')
                                ->label('شهر')
                                ->options(function (callable $get) {
                                    $provinceId = $get('province');
                                    if (!$provinceId) {
                                        return [];
                                    }
                                    return IranCity::where('province_id', $provinceId)
                                        ->pluck('name', 'id')
                                        ->toArray();
                                })
                                ->required()
                                ->disabled(fn (callable $get) => !$get('province')),
                            Select::make('education')
                                ->label('تحصیلات')
                                ->options(Education::options())
                                ->default(fn ($record) => $record?->education?->value)
                                ->required(),
                        ])->from('md'),
                    ])
                    ->hidden(fn(Get $get) => $get('is_foreign'))
                    ->columnSpanFull(),
                
                Section::make('اطلاعات ضروری')
                    ->schema([
                        Flex::make([
                            TextInput::make('code')
                                ->label('کد سفیر')
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
                                ->label('همراه')
                                ->regex('/^09\d{9}$/')
                                ->unique(table: User::class)
                                ->required(),
                            TextInput::make('password')
                                ->label('کلمه عبور')
                                ->password()
                                ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                                ->dehydrated(fn($state) => filled($state))
                                ->required(fn(string $operation) => $operation === 'create'),
                        ])->from('md')
                ])->columnSpanFull(),
                Section::make('مشخصات اصلی')
                    ->schema([
                        Flex::make([
                            TextInput::make('first_name')
                                ->label('نام')
                                ->hidden(fn(Get $get) => $get('is_legal')),
                            TextInput::make('last_name')
                                ->label('نام خانوادگی')
                                ->hidden(fn(Get $get) => $get('is_legal')),
                            TextInput::make('company_name')
                                ->label('نام شرکت')
                                ->visible(fn(Get $get) => $get('is_legal')),
                            TextInput::make('job_title')->label('عنوان شغلی'),
                            Select::make('gender_id')
                                ->label('جنسیت')
                                ->options([
                                    1 => 'مرد',
                                    2 => 'زن',
                                ])
                                ->nullable()
                                ->searchable(false)
                                ->placeholder('انتخاب کنید'),
                        Select::make('education')
                            ->label('تحصیلات')
                            ->options(Education::options())
                            ->nullable()
                            ->placeholder('انتخاب کنید'),
                        ])->from('md'),
                        Flex::make([
                            
                            TextInput::make('email')
                                ->label('ایمیل')
                                ->unique(table: User::class)
                                ->email(),
                        ])->from('md'),
                        
                ])->columnSpanFull(),
                
                Section::make('تایید')
                    ->schema([
                        Flex::make([
                            DateTimePicker::make('phone_verified_at')->label('تاریخ تایید همراه')->jalali(),
                            DateTimePicker::make('email_verified_at')->label('تاریخ تایید ایمیل')->jalali(),
                        ])
                ])->columnSpanFull(),
            ]);
    }
}
