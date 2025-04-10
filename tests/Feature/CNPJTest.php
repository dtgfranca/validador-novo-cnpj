<?php declare(strict_types=1);
namespace Tests\Feature\CNPJTest;

use Dtgfranca\ValidadorNovoCnpj\CNPJ;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
class CNPJTest extends TestCase
{
    #[DataProvider('cnpjsInvalidos')]
    public function testCpnjNaoValido($cnpj): void
    {
        $this->assertFalse(CNPJ::isValid($cnpj));
    }

    #[DataProvider('cnpjsValidos')]
    public function testCpnjValido($cnpj): void
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
    public static function cnpjsValidos(): array
    {
        return [
            ['90.021.382/0001-22'],
            ['90.024.778/0001-23'],
            ['90.025.108/0001-21'],
            ['90.025.255/0001-00'],
            ['90.024.420/0001-09'],
            ['90.024.781/0001-47'],
            ['04.740.714/0001-97'],
            ['44.108.058/0001-29'],
            ['90.024.780/0001-00'],
            ['90.024.779/0001-78'],
            ['00000000000191'],
            ['ABCDEFGHIJKL80'],
            ['12.ABC.345/01DE-35'],
        ];
    }
    public static function cnpjsInvalidos(): array
    {

        return [
            'Cnpj Vazio' => [''],
            'Apenas caracteres não permitidos' => ["'!@#$%&*-_=+^~"],
            'Caracter não permitido no meio' => ['0123456?789ABC'],
            'Caracter não permitido no fim' => ['0123456789ABC#'],
            'Com letra minúscula' => ['12.ABc.345/01DE-35'],
            'Dígitos a menos' => ['0000000000019'],
            'Dígitos a mais' => ['000000000001911'],
            'Letra na posição do segundo DV' => ['0000000000019L'],
            'Letra na posição do primeiro DV' => ['000000000001P1'],
            'DV inválido' => ['00000000000192'],
            'DV Inválido com letras' => ['ABCDEFGHIJKL81'],
            'CNPJ zerado' => ['00000000000000'],
            'CNPJ zerado com máscara' => ['00.000.000/0000-00'],
        ];
    }

}
