# CNPJ Validator

Este pacote PHP permite validar se um CNPJ é válido  de acordo com as novas regras do cnpj.

## Instalação

Primeiro adicione este repositório privado no seu arquivo composer.json:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url":  "https://git.sebraemg.com.br/plataforma/sdk-php.git"
    }
  ]
}
 ```

```bash
composer require sebraemg/cnpj-validator
 ```


## Utilização
Após instalar o pacote, vocé pode utiliza-lo da seguinte maneira:
```php
use SebraeMG\ValidadorNovoCnpj\CNPJ;

$cnpj = '12.ABC.345/01DE-35';

if (Cnpj::isValid($cnpj)) {
    echo "CNPJ válido!";
} else {
    echo "CNPJ inválido!";
}
```

