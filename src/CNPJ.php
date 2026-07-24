<?php

declare(strict_types=1);

namespace Dtgfranca\ValidadorNovoCnpj;

class CNPJ
{
    private const TAMANHO_SEM_DV = 12;
    private const PESOS_DV = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    private const CNPJ_ZERADO = '00000000000000';
    private const ORD_ZERO = 48;
    private const CARACTERES_VALIDOS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function isValid(string $cnpj): bool
    {
        if (self::temCaracteresInvalidos($cnpj)) {
            return false;
        }

        $cnpj = self::removeMascara($cnpj);

        if ($cnpj === self::CNPJ_ZERADO || !self::temFormatoValido($cnpj)) {
            return false;
        }

        $dvCalculado = self::calculaDV(
            self::paraArrayDeValores(
                self::removeDV($cnpj)
            )
        );

        return $dvCalculado === self::obtemDV($cnpj);
    }

    public static function gerar(bool $formatado = false): string
    {
        $cnpjSemDV = self::gerarAlfanumerico(self::TAMANHO_SEM_DV);
        $dv = self::calculaDV(self::paraArrayDeValores($cnpjSemDV));
        $cnpjCompleto = $cnpjSemDV . $dv;

        return $formatado
            ? self::formatar($cnpjCompleto)
            : $cnpjCompleto;
    }

    private static function temCaracteresInvalidos(string $cnpj): bool
    {
        return (bool) preg_match('/[^A-Z\d.\/-]/i', $cnpj);
    }

    private static function removeMascara(string $cnpj): string
    {
        return preg_replace('/[.\-\/]/', '', $cnpj);
    }

    private static function removeDV(string $cnpj): string
    {
        return substr($cnpj, 0, self::TAMANHO_SEM_DV);
    }

    private static function obtemDV(string $cnpj): string
    {
        return substr($cnpj, -2);
    }

    private static function temFormatoValido(string $cnpj): bool
    {
        return (bool) preg_match('/^([A-Z\d]){12}(\d){2}$/', $cnpj);
    }

    /**
     * Calcula os dígitos verificadores conforme as regras do Serpro
     * para CNPJs alfanuméricos.
     */
    private static function calculaDV(array $valores): string
    {
        $somaDV1 = 0;
        $somaDV2 = 0;

        for ($i = 0; $i < count($valores); $i++) {
            $somaDV1 += $valores[$i] * self::PESOS_DV[$i + 1];
            $somaDV2 += $valores[$i] * self::PESOS_DV[$i];
        }

        $primeiroDigito = ($somaDV1 % 11) < 2 ? 0 : 11 - ($somaDV1 % 11);
        $somaDV2 += $primeiroDigito * self::PESOS_DV[self::TAMANHO_SEM_DV];
        $segundoDigito = ($somaDV2 % 11) < 2 ? 0 : 11 - ($somaDV2 % 11);

        return $primeiroDigito . $segundoDigito;
    }

    /**
     * Converte cada caractere do CNPJ no seu "valor para cálculo do DV"
     * conforme a tabela do Serpro (caractere → valor ASCII - 48).
     */
    private static function paraArrayDeValores(string $cnpj): array
    {
        $caracteres = str_split($cnpj);

        return array_map(
            static fn (string $char): int => (int) ord($char) - self::ORD_ZERO,
            $caracteres
        );
    }

    /**
     * Gera uma string alfanumérica aleatória com o tamanho especificado.
     * Usa random_bytes para garantir segurança criptográfica.
     */
    private static function gerarAlfanumerico(int $tamanho): string
    {
        $caracteres = self::CARACTERES_VALIDOS;
        $totalCaracteres = strlen($caracteres);
        $resultado = '';

        for ($i = 0; $i < $tamanho; $i++) {
            $resultado .= $caracteres[random_int(0, $totalCaracteres - 1)];
        }

        return $resultado;
    }

    /**
     * Formata um CNPJ de 14 caracteres no formato XX.XXX.XXX/XXXX-XX.
     *
     * @throws \InvalidArgumentException
     */
    public static function formatar(string $cnpj): string
    {
        if (strlen($cnpj) !== 14) {
            throw new \InvalidArgumentException(
                'A string deve ter 14 caracteres para ser formatada como CNPJ.'
            );
        }

        return substr($cnpj, 0, 2) . '.' .
            substr($cnpj, 2, 3) . '.' .
            substr($cnpj, 5, 3) . '/' .
            substr($cnpj, 8, 4) . '-' .
            substr($cnpj, 12, 2);
    }
}
