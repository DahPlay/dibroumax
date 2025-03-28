<?php

namespace App\Enums;

enum PaymentStatusOrderAsaasEnum: string
{
    case CONFIRMED = 'CONFIRMED';
    case PENDING = 'PENDING';
    case OVERDUE = 'OVERDUE';
    case RECEIVED = 'RECEIVED';

    public function getName(): string
    {
        return match ($this) {
            self::CONFIRMED => 'CONFIRMADO',
            self::PENDING => 'PENDENTE',
            self::OVERDUE => 'VENCIDO',
            self::RECEIVED => 'RECEBIDO',
        };
    }
}
