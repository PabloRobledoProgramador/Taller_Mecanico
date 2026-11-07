<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Mecanico = 'mecanico';
    case Cliente = 'cliente';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Mecanico => 'Mecánico',
            self::Cliente => 'Cliente',
        };
    }

    /** @return list<string> */
    public static function values(): array
    {
        return array_map(fn (self $r) => $r->value, self::cases());
    }
}
