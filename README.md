# nette-locale
======

Locale

"geniv/nette-locale": ">=1.0"

extensions:
    locale: Locale\Bridges\Nette\Extension


# lokalizace
locale:
#	source: "DevNull"
    source: "Database"
    parameters:
        table: %tb_locale%
#	source: "Neon"
#	parameters:
#		default: "cs"
#		locales:
#			cs: "Čeština"
#			en: "English"
#			de: "Deutsch"
#		plurals:
#			cs: "$nplurals=3; $plural=($n==1) ? 1 : (($n>=2 && $n<=4) ? 2 : 0);"
#			en: "$nplurals=2; $plural=($n != 1) ? 0 : 1;"
#			de: "$nplurals=2; $plural=($n != 1) ? 0 : 1;"
#		alias:
#			sk: cs
#			pl: en

