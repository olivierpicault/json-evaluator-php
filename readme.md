# json-evaluator-php

The PHP version of [json-evaluator](https://github.com/olivierpicault/json-evaluator).

## Installation

```
composer require olivierpicault/json-evaluator-php
```

## Basic usage

```php
use JsonEvaluator\Evaluate;

// Basic instance
$instance = [
    'compare'   => [
        'type'  => 'string',
        'value' => 'olivier',
    ],
    'compareTo' => [
        'type'  => 'string',
        'value' => 'stéphane',
    ],
    'operator'  => '=='
];

// Instance is expected to be type of stdClass
$instance = json_decode(json_encode($instance, 0));

// Fields is expected to be type of array
$fields = [];

$evaluator = new Evaluate();
$evaluator->evaluate($instance, $fields); // false
```

## Tests

```
composer test
```
