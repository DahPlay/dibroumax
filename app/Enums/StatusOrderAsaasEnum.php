<?php

namespace App\Enums;

enum StatusOrderAsaasEnum: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';

    public function getName(): string
    {
        return match ($this) {
            self::ACTIVE => 'ATIVO',
            self::INACTIVE => 'INATIVO',
        };
    }
}
