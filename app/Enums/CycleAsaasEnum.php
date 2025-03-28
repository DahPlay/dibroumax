<?php

namespace App\Enums;

enum CycleAsaasEnum: string
{
    case WEEKLY = 'WEEKLY';
    case BIWEEKLY = 'BIWEEKLY';
    case MONTHLY = 'MONTHLY';
    case BIMONTHLY = 'BIMONTHLY';
    case QUARTERLY = 'QUARTERLY';
    case SEMIANNUALLY = 'SEMIANNUALLY';
    case YEARLY = 'YEARLY';

    public function getName(): string
    {
        return match ($this) {
            self::WEEKLY => 'SEMANAL',
            self::BIWEEKLY => 'QUINZENAL',
            self::MONTHLY => 'MENSAL',
            self::BIMONTHLY => 'BIMENSTRAL',
            self::QUARTERLY => 'TRIMESTRAL',
            self::SEMIANNUALLY => 'SEMESTRAL',
            self::YEARLY => 'ANUAL',
        };
    }
}
