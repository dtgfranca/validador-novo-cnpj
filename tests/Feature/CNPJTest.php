<?php

declare(strict_types=1);

namespace Tests\Feature\CNPJTest;

use Dtgfranca\ValidadorNovoCnpj\CNPJ;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CNPJTest extends TestCase
{
    #[DataProvider('cnpjsInvalidos')]
    public function testCpnjNaoValido(string $cnpj): void
    {
        $this->assertFalse(CNPJ::isValid($cnpj));
    }

    #[DataProvider('cnpjsValidos')]
    public function testCpnjValido(string $cnpj): void
    {
        $this->assertTrue(CNPJ::isValid($cnpj));
    }

    public function testGerarCnpjValidoFormatado(): void
    {
        $cnpj = CNPJ::gerar(true);
        $this->assertTrue(CNPJ::isValid($cnpj));
    }

    public function testGerarCnpjValidoNaoFormatado(): void
    {
        $cnpj = CNPJ::gerar();
        $this->assertTrue(CNPJ::isValid($cnpj));
    }

    public function testFormatarCnpj(): void
    {
        $this->assertSame('12.ABC.345/01DE-35', CNPJ::formatar('12ABC34501DE35'));
    }

    public function testFormatarCnpjComTamanhoInvalido(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        CNPJ::formatar('123');
    }

    public static function cnpjsValidos(): array
    {
        return [
            'CNPJ formatado 1' => ['90.021.382/0001-22'],
            'CNPJ formatado 2' => ['90.024.778/0001-23'],
            'CNPJ formatado 3' => ['90.025.108/0001-21'],
            'CNPJ formatado 4' => ['90.025.255/0001-00'],
            'CNPJ formatado 5' => ['90.024.420/0001-09'],
            'CNPJ formatado 6' => ['90.024.781/0001-47'],
            'CNPJ formatado 7' => ['04.740.714/0001-97'],
            'CNPJ formatado 8' => ['44.108.058/0001-29'],
            'CNPJ formatado 9' => ['90.024.780/0001-00'],
            'CNPJ formatado 10' => ['90.024.779/0001-78'],
            'CNPJ numérico sem máscara' => ['00000000000191'],
            'CNPJ alfanumérico sem máscara' => ['ABCDEFGHIJKL80'],
            'CNPJ alfanumérico formatado' => ['12.ABC.345/01DE-35'],
        ];
    }

    public static function cnpjsInvalidos(): array
    {
        return [
            'Vazio' => [''],
            'Apenas caracteres especiais' => ['!@#$%&*-_=+^~'],
            'Caractere inválido no meio' => ['0123456?789ABC'],
            'Caractere inválido no fim' => ['0123456789ABC#'],
            'Letra minúscula' => ['12.ABc.345/01DE-35'],
            'Dígitos a menos' => ['0000000000019'],
            'Dígitos a mais' => ['000000000001911'],
            'Letra no segundo DV' => ['0000000000019L'],
            'Letra no primeiro DV' => ['000000000001P1'],
            'DV inválido' => ['00000000000192'],
            'DV inválido com letras' => ['ABCDEFGHIJKL81'],
            'CNPJ zerado' => ['00000000000000'],
            'CNPJ zerado com máscara' => ['00.000.000/0000-00'],
        ];
    }
}
