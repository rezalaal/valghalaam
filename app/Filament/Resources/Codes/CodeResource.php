<?php

namespace App\Filament\Resources\Codes;

use App\Filament\Resources\Codes\Pages\CreateCode;
use App\Filament\Resources\Codes\Pages\EditCode;
use App\Filament\Resources\Codes\Pages\ListCodes;
use App\Filament\Resources\Codes\Pages\ViewCode;
use App\Filament\Resources\Codes\Schemas\CodeForm;
use App\Filament\Resources\Codes\Schemas\CodeInfolist;
use App\Filament\Resources\Codes\Tables\CodesTable;
use App\Models\Code;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CodeResource extends Resource
{
    protected static ?string $model = Code::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'code';

    protected static ?string $pluralModelLabel = 'کدهای سفیر';

    protected static ?string $modelLabel = 'کد سفیر';



    public static function form(Schema $schema): Schema
    {
        return CodeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CodeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CodesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCodes::route('/'),
            'create' => CreateCode::route('/create'),
            'view' => ViewCode::route('/{record}'),
            'edit' => EditCode::route('/{record}/edit'),
        ];
    }
}
