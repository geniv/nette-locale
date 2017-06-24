Locale
======

Installation
------------

```sh
$ composer require geniv/nette-locale
```
or
```json
"geniv/nette-locale": ">=1.0"
```

internal dependency:
```json
"nette/nette": ">=2.4.0",
"dibi/dibi": ">=3.0.0"
```

Include in application
----------------------

available source drivers:
- database (dibi + cache)
- neon (filesystem)
- devnull (ignore locale)

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
```
