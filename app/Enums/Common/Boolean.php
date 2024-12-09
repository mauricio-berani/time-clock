<?php

namespace App\Enums\Common;

enum Boolean: string
{
    case YES   = 'Yes';
    case NO    = 'No';

    public function label(): string
    {
        return match ($this) {
            self::YES  => 'Sim',
            self::NO   => 'Não',
        };
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label(),
            'value' => $this->value,
        ];
    }

    public static function options(): array
    {
        return array_map(fn($item) => $item->toArray(), self::cases());
    }
}
