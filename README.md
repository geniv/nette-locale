Locale
======

Plural forms documents: http://docs.translatehouse.org/projects/localization-guide/en/latest/l10n/pluralforms.html

In case new item must by added char `$` and add brackets `(`, `)`! Otherwise function `EVAL` has problem with correct evaluate plural form.

It is recommended change sort plurals form number (eg: 0 => `0 oken, 5 oken`, 1 => `1 okno`, 2 => `2 okna, 3 okna`).

Installation
------------

```sh
$ composer require geniv/nette-locale
```
or
```json
"geniv/nette-locale": ">=1.0.0"
```

require:
```json
"php": ">=5.6.0",
"nette/nette": ">=2.4.0",
"dibi/dibi": ">=3.0.0"
```

Include in application
----------------------

available source drivers:
- Database (dibi + cache)
- Neon (filesystem)
- DevNull (ignore locale)

neon configure:
```neon
extensions:
    locale: Locale\Bridges\Nette\Extension
```

neon configure extension:
```neon
# lokalizace
locale:
#   debugger: false
#   source: "DevNull"
    source: "Database"
    tablePrefix: %tablePrefix%
#   source: "Neon"
#   default: "cs"
#   locales:
#       cs: "Čeština"
#       en: "English"
#       de: "Deutsch"
#   plurals:
#       cs: "$nplurals=3; $plural=($n==1) ? 1 : (($n>=2 && $n<=4) ? 2 : 0);"
#       en: "$nplurals=2; $plural=($n != 1) ? 0 : 1;"
#       de: "$nplurals=2; $plural=($n != 1) ? 0 : 1;"
#   alias:
#       sk: cs
#       pl: en
```

```php
use Locale\Locale;
$locale = $this->context->getByType(Locale::class);

// or

/** @var Locale\Locale @inject */
public $locale;

// methods:
$locale->getListName() : array
$locale->getListId() : array
$locale->getLocales() : array
$locale->getCode() : string
$locale->setCode() : void
$locale->getId() : int
$locale->getIdDefault() : int
$locale->getCodeDefault() : string
$locale->isDefaultLocale() : bool
$locale->getPlural() : string
$locale->getIdByCode() : string
```
