Locale
======

Plural forms documents: http://docs.translatehouse.org/projects/localization-guide/en/latest/l10n/pluralforms.html

In case new item must by added char `$` and add brackets `(`, `)`! Otherwise function `EVAL` has problem with correct evaluate plural form.

It is recommended change position plurals index number (eg: 0 => `0 oken, 5 oken`, 1 => `1 okno`, 2 => `2 okna, 3 okna`).

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
"php": ">=7.0.0",
"nette/nette": ">=2.4.0",
"dibi/dibi": ">=3.0.0"
```

Include in application
----------------------

### available source drivers:
- Dibi (dibi + cache)
- Array (array configure)
- DevNull (ignore locale)

neon configure:
```neon
extensions:
    locale: Locale\Bridges\Nette\Extension
```

neon configure extension:
```neon
# locale
locale:
#   debugger: true
#   autowired: true
#   onRequest: application.application
#   driver: Locale\Drivers\DevNullDriver(1)
#   driver: Locale\Drivers\ArrayDriver(%default%, %locales%, %plurals%, %alias%)
    driver: Locale\Drivers\DibiDriver(%tablePrefix%)
```

neon configure:
```neon
parameters:
    default: "cs"
    locales:
       cs: "Čeština"
       en: "English"
       de: "Deutsch"
    plurals:
       cs: "$nplurals=3; $plural=($n==1) ? 1 : (($n>=2 && $n<=4) ? 2 : 0);"
       en: "$nplurals=2; $plural=($n != 1) ? 0 : 1;"
       de: "$nplurals=2; $plural=($n != 1) ? 0 : 1;"
       ru: "$nplurals=3; $plural=($n%10==1 && $n%100!=11 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2);"
    alias:
       sk: cs
       pl: en
```

usage:
```php
use Locale\Locale;
$locale = $this->context->getByType(ILocale::class);

// or

/** @var Locale\ILocale @inject */
public $locale;

// methods implements `ILocale`:
getListName(): array;
getListId(): array;
getLocales(): array;

getCode(bool $upper = false): string
setCode(string $code)

// is correct locale set? with method: setCode()
isReady(): bool

getId(): int
getIdDefault(): string

getCodeDefault(bool $upper = false): string
isDefaultLocale(): bool
getPlural(): string
getIdByCode(string $code): int
```

### description
`onRequest` is default in `Nette\Application\Application` via `application.application`:

via: _vendor/nette/application/src/Application/Application.php:41_ (Nette\Application\Application)

```php
public function onRequest(Application $application, Request $request) {}
```
