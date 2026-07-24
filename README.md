# CNPJ Validator

Este pacote PHP permite validar se um CNPJ é válido de acordo com as novas regras alfanuméricas do CNPJ (Serpro).

## Instalação

```bash
composer require dtgfranca/validador-novo-cnpj
```

## Utilização

### Validar um CNPJ

```php
use Dtgfranca\ValidadorNovoCnpj\CNPJ;

$cnpj = '12.ABC.345/01DE-35';

if (CNPJ::isValid($cnpj)) {
    echo "CNPJ válido!";
} else {
    echo "CNPJ inválido!";
}
```

### Gerar um CNPJ válido

```php
use Dtgfranca\ValidadorNovoCnpj\CNPJ;

$cnpjFormatado = CNPJ::gerar(true);    // "ZB.DVI.P3O/WRH2-58"
$cnpjSimples   = CNPJ::gerar();         // "ZBDVIP3OWRH258"
```

### FormatAR um CNPJ

```php
use Dtgfranca\ValidadorNovoCnpj\CNPJ;

echo CNPJ::formatar('12ABC34501DE35'); // "12.ABC.345/01DE-35"
```

## Ferramenta Online

👉 https://tools.diegofranca.dev/

Gere e valide CNPJs alfanuméricos diretamente no browser.

---

## Testes

```bash
composer install
vendor/bin/phpunit
```

## Licença

MIT
