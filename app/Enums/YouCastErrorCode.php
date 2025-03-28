<?php

namespace App\Enums;

enum YouCastErrorCode: int
{
    case UNKNOWN_ERROR = 0;
    case SUCCESS = 1;
    case UNAUTHORIZED = 3;
    case UNKNOWN_MODULE = 4;
    case UNKNOWN_METHOD = 5;
    case MISSING_REQUIRED_FIELD = 6;
    case INVALID_JSON = 7;
    case INVALID_PARAMETER_TYPE = 10;
    case UNKNOWN_TOKEN = 20;
    case EXPIRED_TOKEN = 27;
    case UNKNOWN_CLIENT = 100;
    case TOO_MANY_RESULTS = 103;
    case CLIENT_VALIDATION_ERROR = 104;
    case UNKNOWN_PACKAGE = 260;
    case UNKNOWN_SUBSCRIPTION = 500;
    case DUPLICATE_LOGIN = 14000;
    case INVALID_CREDENTIALS = 14001;

    public static function getName(int $code): string
    {
        return match ($code) {
            self::UNKNOWN_ERROR->value => 'Erro desconhecido',
            self::SUCCESS->value => 'Sucesso',
            self::UNAUTHORIZED->value => 'Não autorizado',
            self::UNKNOWN_MODULE->value => 'Módulo desconhecido',
            self::UNKNOWN_METHOD->value => 'Método desconhecido',
            self::MISSING_REQUIRED_FIELD->value => 'Campo obrigatório ausente',
            self::INVALID_JSON->value => 'JSON inválido',
            self::INVALID_PARAMETER_TYPE->value => 'Tipo do parâmetro inválido',
            self::UNKNOWN_TOKEN->value => 'Token não conhecido',
            self::EXPIRED_TOKEN->value => 'Token expirado',
            self::UNKNOWN_CLIENT->value => 'Cliente desconhecido',
            self::TOO_MANY_RESULTS->value => 'Muitos resultados para o login informado',
            self::CLIENT_VALIDATION_ERROR->value => 'Erro na validação do cliente',
            self::UNKNOWN_PACKAGE->value => 'Pacote desconhecido',
            self::UNKNOWN_SUBSCRIPTION->value => 'Inscrição desconhecida',
            self::DUPLICATE_LOGIN->value => 'Login duplicado',
            self::INVALID_CREDENTIALS->value => 'Senha ou usuário incorreto',
            default => 'Erro não mapeado'
        };
    }
}
