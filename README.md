# Php StringStream

[![Latest Stable Version](https://poser.pugx.org/ltd-beget/stringstream/version)](https://packagist.org/packages/ltd-beget/stringstream) 
[![Total Downloads](https://poser.pugx.org/ltd-beget/stringstream/downloads)](https://packagist.org/packages/ltd-beget/stringstream)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LTD-Beget/stringstream/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LTD-Beget/stringstream/?branch=master)
[![License MIT](http://img.shields.io/badge/license-MIT-blue.svg?style=flat)](https://github.com/LTD-Beget/stringstream/blob/master/LICENSE)

Php Stringstream data structure.

## Installation

```shell
composer require ltd-beget/stringstream
```

## Usage
```php
<?php
    use LTDBeget\stringstream\StringStream;
    
    require(__DIR__ . '/vendor/autoload.php');
    
    $stream = new StringStream("Hello, World!");
    
    do {
        if($stream->currentAscii()->isWhiteSpace()) {
            $stream->ignoreWhitespace();
        } else {
            echo $stream->current().PHP_EOL;
            $stream->next();
        }
    
    } while (! $stream->isEnd());

```

## License
released under the MIT License.
See the [bundled LICENSE file](LICENSE) for details.
