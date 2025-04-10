<?php
declare(strict_types=1);

if (!function_exists('stringsAleatorias')) {
    function stringsAleatorias(int $tamanho): string
    {
        $resultado = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($resultado),
            0, $tamanho);
    }
}

if (!function_exists('formatarCNPJ')) {
    function formatarCNPJ(string $cnpj): string
    {
        if (strlen($cnpj) !== 14) {
            throw new InvalidArgumentException("A string deve ter 14 caracteres para ser formatada como CNPJ.");
        }
        return substr($cnpj, 0, 2) . '.' .
            substr($cnpj, 2, 3) . '.' .
            substr($cnpj, 5, 3) . '/' .
            substr($cnpj, 8, 4) . '-' .
            substr($cnpj, 12, 2);
    }
}
