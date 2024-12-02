# CNPJ Validator

Este pacote PHP permite validar se um CNPJ é válido  de acordo com as novas regras do cnpj.

## Instalação

Você pode instalar o pacote via Composer:

```bash
composer require dtgfranca/cnpj-validator
 ```


## Utilização
Após instalar o pacote, vocé pode utiliza-lo da seguinte maneira:
```php
use CnpjValidator\Cnpj;

$cnpj = '12.ABC.345/01DE-35';

if (Cnpj::isValid($cnpj)) {
    echo "CNPJ válido!";
} else {
    echo "CNPJ inválido!";
}
```

