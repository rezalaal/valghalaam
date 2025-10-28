<?php

namespace App\Enums;

enum Gender: int
{
    case Male = 1;
    case Female = 2;

    public function label(): string
    {
        return match($this) {
            self::Male => 'مرد',
            self::Female => 'زن',
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
