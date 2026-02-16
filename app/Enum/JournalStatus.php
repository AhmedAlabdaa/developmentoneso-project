<?php

namespace App\Enum;

enum JournalStatus: int
{
    case Draft = 0;
    case Posted = 1;
    case Void = 2;

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Posted => 'Posted',
            self::Void => 'Void',
        };
    }

    /**
     * Optional helpers
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
