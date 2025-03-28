<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class Cpf implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $cpf = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cpf) !== 11) {
            $fail('O CPF deve ter 11 dígitos.');
            return;
        }

        if (preg_match('/^(\d)\1*$/', $cpf)) {
            $fail('O CPF informado é inválido.');
            return;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$t] != $d) {
                $fail('O CPF informado é inválido.');
                return;
            }
        }
    }
}
