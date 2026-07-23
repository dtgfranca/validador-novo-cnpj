# CNPJ Validator

Este pacote PHP permite validar se um CNPJ é válido  de acordo com as novas regras do cnpj.

## Instalação

Você pode instalar o pacote via Composer:

```bash
composer require dtgfranca/validador-novo-cnpj
 ```


## Utilização
Após instalar o pacote, vocé pode utiliza-lo da seguinte maneira:
```php
use Dtgfranca\ValidadorNovoCnpj\CNPJ;

$cnpj = '12.ABC.345/01DE-35';

if (Cnpj::isValid($cnpj)) {
    echo "CNPJ válido!";
} else {
    echo "CNPJ inválido!";
}
```
Caso haja necessidade de gerar um CNPJ válido, vocé pode utiliza-lo da seguinte maneira:

```php
use Dtgfranca\ValidadorNovoCnpj\CNPJ;

$cnpj = CNPJ::gerar(true); // true para formatado "ZB.DVI.P3O/WRH2-58", false para não formatado "ZBDVIP3OWRH258"
```

## Ferramenta Online

Se você não precisa gerar CNPJs diretamente pelo PHP ou apenas deseja testar rapidamente, utilize a ferramenta online:

👉 https://tools.diegofranca.dev/

Ela permite:

- ✅ Gerar CNPJs alfanuméricos válidos
- ✅ Gerar CNPJs com ou sem formatação
- ✅ Validar CNPJs
- ✅ Copiar o resultado com um clique

Ideal para desenvolvedores, QAs e testes de aplicações.
