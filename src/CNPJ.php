<?php
namespace Dtgfranca\ValidadorNovoCnpj;

class CNPJ
{
    private static  $tamanhoCnpjSemDV =  12;
    private static $pesosDV = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    private static  $cnpjZerado = '00000000000000';

    public static function isValid(string $cnpj):bool
    {
        if( !self::temCaracteresNaoPermitidos($cnpj)) {
            $cnpj = self::removeMascara($cnpj);
            if($cnpj !==  self::$cnpjZerado && self::temFormatoCnpj($cnpj)) {
                $dv  = self::calculaDV( self::atribuiValorParaCalculoDv(self::removeDV($cnpj)));
                return  $dv === self::obtemDv($cnpj);
            }

        }

        return false;


    }

    private static function temCaracteresNaoPermitidos (string $cnpj): bool
    {

        return preg_match('/[^A-Z\d.\/-]/i', $cnpj);
    }
    private static function removeMascara(string $cnpj):string
    {

        return preg_replace('/[.\-\/]/', '', $cnpj);
    }
    private static  function removeDV(string $cnpj):string
    {

        return substr($cnpj, 0, 12);
    }
    private static  function obtemDv(string $cnpj):string
    {
        return substr($cnpj,-2);
    }
    private  static function temFormatoCnpj(string $cnpj):bool
    {
        return preg_match('/^([A-Z\d]){12}(\d){2}$/', $cnpj);
    }

    private static function calculaDV(array $valor):string
    {

        $dv1 = 0;
        $dv2 = 0;
        for ($i = 0; $i < count($valor); $i++) {
            $dv1 += $valor[$i] * self::$pesosDV[$i + 1];
            $dv2 += $valor[$i] * self::$pesosDV[$i];
        }
        $valor1 = ($dv1 % 11) < 2 ? 0 : 11 - ($dv1 % 11);
        $dv2 += $valor1 * self::$pesosDV[self::$tamanhoCnpjSemDV];
        $valor2 = ($dv2 % 11) < 2 ? 0 : 11 - ($dv2 % 11);
        return "{$valor1}{$valor2}";

    }
    private static function atribuiValorParaCalculoDv(string $cnpj):array
    {
        /*
         * Para cada um dos caracteres do CNPJ, atribuir o valor da coluna “Valor para cálculo do DV”,
         * conforme a tabela abaixo (ou subtrair 48 do “Valor ASCII”):
         */
        $cnpj = str_split($cnpj);
        for ($i = 0; $i < count($cnpj); $i++) {
            $cnpj[$i] = (int) ord($cnpj[$i]) - 48;
        }
        return  $cnpj;
    }
}

