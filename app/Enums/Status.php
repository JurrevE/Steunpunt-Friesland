<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasLabel
{
    case True = 'Ja';

    case False = 'Nee';


    public function getLabel(): string
    {
        return match ($this) {
            self::True => 'Ja',
            self::False => 'Nee',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::True => 'succes',
            self::False => 'warning',
        };
    }
}