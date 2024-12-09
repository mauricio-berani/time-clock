<?php

namespace App\Enums\Auth;

enum Roles: string
{
    case EMPLOYEE      = 'employee';
    case ADMINISTRATOR = 'administrator';

    public function label(): string
    {
        return match ($this) {
            self::EMPLOYEE      => 'Funcionário',
            self::ADMINISTRATOR => 'Administrador',
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
