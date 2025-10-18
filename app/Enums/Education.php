<?php

namespace App\Enums;

enum Education: int
{
    case Cycle = 0;
    case Diploma = 1;
    case Bachelor = 2;
    case Master = 3;
    case Doctorate = 4;

    public function label(): string
    {
        return match($this) {
            self::Cycle => 'سیکل',
            self::Diploma => 'دیپلم',
            self::Bachelor => 'کارشناسی',
            self::Master => 'کارشناسی ارشد',
            self::Doctorate => 'دکترا',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }

    public static function all(): array
    {
        return collect(self::cases())->map(fn($case) => [
            'id' => $case->value,
            'name' => $case->label(),
        ])->toArray();
    }

}
