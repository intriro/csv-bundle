IntriroCsvBundle
=====================
[![Latest Stable Version](https://poser.pugx.org/intriro/csv-bundle/v/stable.svg)](https://packagist.org/packages/intriro/csv-bundle) 
[![Total Downloads](https://poser.pugx.org/intriro/csv-bundle/downloads.svg)](https://packagist.org/packages/intriro/csv-bundle) 
[![License](https://poser.pugx.org/intriro/csv-bundle/license.svg)](https://packagist.org/packages/intriro/csv-bundle)

Provides integration of the [**goodby/csv**][goodby-csv-homepage] library into Symfony2.


About Goodby CSV
---------------

Goodby CSV is a high memory efficient flexible and extendable open-source CSV import/export library for PHP.

Documentation is available [here][goodby-csv-homepage].


Installation
------------

This bundle can be installed using [composer](http://getcomposer.org) by adding the following in the `require` section of your `composer.json` file:

```json
{
    "require": {
        "intriro/csv-bundle": "0.1.*"
    }
}
```

## Register the bundle

You must register the bundle in your kernel:

``` php
<?php

// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(

        // ...

        new Intriro\Bundle\CsvBundle\IntriroCsvBundle(),
    );

    // ...
}
```


Configuration
-------------

TODO

## Configuring importers

``` yaml
# app/config/config.yml
intriro_csv:
    importers:
        foo: ~  # uses the default configuration

        bar:
            delimiter: "\t"         # Customize delimiter. Default value is comma(,)
            enclosure: "'"          # Customize enclosure. Default value is double quotation(")
            escape: "\\"            # Customize escape character. Default value is backslash(\)
            to_charset: UTF-8       # Customize target encoding. Default value is null, no converting.
            from_charset: SJIS-win  # Customize CSV file encoding. Default value is null.
```
Importers are ment to get data from a CSV file into your PHP code. The defined importers from the sample configuration are available as services in the container as `intriro_csv.importer.foo` and `intriro_csv.importer.bar`. 

The services are instances of `Goodby\CSV\Import\Standard\Lexer`.

## Configuring exporters

``` yaml
# app/config/config.yml
intriro_csv:
    exporters:
        foo: ~  # uses the default configuration

        bar:
            delimiter: "\t"         # Customize delimiter. Default value is comma(,)
            enclosure: "'"          # Customize enclosure. Default value is double quotation(")
            escape: "\\"            # Customize escape character. Default value is backslash(\)
            to_charset: SJIS-win    # Customize target encoding. Default value is null, no converting.
            from_charset: UTF-8     # Customize CSV file encoding. Default value is null.
            file_mode: w            # Customize file mode and choose either write or append. Default value is write ('w'). See fopen() php docs
```

The defined exporters from the sample configuration are available as services in the container as `intriro_csv.exporter.foo` and `intriro_csv.exporter.bar`. 

The services are instances of `Goodby\CSV\Export\Standard\Exporter`.

License
-------

This bundle is released under the MIT license. See the complete license in the bundle:

    src/Resources/meta/LICENSE



[goodby-csv-homepage]: https://github.com/goodby/csv
