# Cypher Query Builder

**This package is still a work in progress, what I have tested works so far but should not be used in a production environment yet**

The purpose of this package was to create a fluent interface for building Cypher queries to use with a neo4j Graph Database.
This package is not designed to actually run the queries for you, I am developing another package for that currently.

## Installation

Using composer (when published)

```bash
$ composer require juststeveking/cypher-query-builder
```

You are then free to use it as needed within your projects.

## Usage

Using this library is very simple, you start a cypher query and using the available clauses programmatically build up your cypher query string.

```php
<?php

define(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$query = Cypher::query()
    ->match('Person', 'person')
    ->where('person', 'name', '=', 'Tom Hanks')
    ->return('person')
    ->raw();
```

The above code will create the following Cypher query:

```cypher
MATCH (person:Person) WHERE person.name = "Tom Hanks" RETURN person
```


## Available Clauses

Below are example of how to use the currently available clauses:


#### MATCH

Create a match clause for your query:

```php
public function match(string $label, string $variable = '') : void;
```

```php
Cypher::query()->match('Person', 'person');
```


#### WHERE

Create a where clause for your query:

```php
public function where(string $variable, string $attribute, string $operator, $value, bool $or = false) : void
```

Create a simple one condition where statement:
```php
Cypher::query()->where('person', 'attribute', '=', 'Some Value');
```

Create an AND where statement:
```php
Cypher::query()
    ->where('person', 'attribute', '=', 'Some Value')
    ->where('person', 'email', '=', 'test@email.com');
```

Create an OR where statement:
```php
Cypher::query()
    ->where('person', 'attribute', '=', 'Some Value')
    ->where('person', 'email', '=', 'test@email.com', true);
```
Currently I have only fully tested strings in where statements, but integers and doubles should also work with basic test coverage.


#### RETURN

Create a return clause for your query:

```php
public function return(string $variable, string $attribute = '') : void
```

Returning the entire node:
```php
Cypher::query()->return('person');
```

Returning a specific attribute:
```php
Cypher::query()->return('person', 'age');
```


### Other Clauses not yet completed

- Create
- Delete
- Remove
- Set

## Tests

There is a composer script available to run the tests:

```bash
$ composer run test
```

However, if you are unable to run this please use the following command:

```bash
$ ./vendor/bin/phpunit --testdox
```

## Security

If you discover any security related issues, please email juststevemcd@gmail.com instead of using the issue tracker.
