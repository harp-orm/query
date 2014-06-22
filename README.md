# Harp Query

[![Build Status](https://travis-ci.org/clippings/atlas.svg?branch=master)](https://travis-ci.org/clippings/atlas)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/clippings/atlas/badges/quality-score.png?s=429880c25663a4c0c4768fbb4158abe048726e82)](https://scrutinizer-ci.com/g/clippings/atlas/)
[![Code Coverage](https://scrutinizer-ci.com/g/clippings/atlas/badges/coverage.png?s=e32088c682e67d1c7eec28b58f9c6a34a2123ed7)](https://scrutinizer-ci.com/g/clippings/atlas/)
[![Latest Stable Version](https://poser.pugx.org/clippings/atlas/v/stable.svg)](https://packagist.org/packages/clippings/atlas)

A query builder library, extending PDO to allow writing queries in object oriented style.
Intelligently manages passing parameters to PDO's execute.

## Quick usage example

```php
use Harp\Query\DB;

DB::setConfig([
    'dsn' => 'mysql:dbname=test-db;host=127.0.0.1',
    'username' => 'root',
]);

$query = DB::select()
    ->from('users')
    ->where('seller', true)
    ->join('profiles', ['profiles.user_id' => 'users.id'])
    ->limit(10);

foreach ($query->execute() as $row) {
    var_dump($row);
}

echo "Executed:\n";
echo $query->humanize();
```

The query ``execute()`` method will generate a PDOStatement object that can be iterated over. All the variables are passed as position parameters ("seller = ?") so are properly escaped by the PDO driver.

## Connecting to the database

Connecting to the database is a 2 step process. First you need to define the configuration for the database, later you will use that configuration to create a connection object (``DB``). This allows to lazy-load the connection object.

```php
DB::setConfig([
    'dsn' => 'mysql:dbname=test-db;host=127.0.0.1',
    'username' => 'root',
]);

// ...
$db = DB::get();
```
After that you will use the database connection object (``$db``). To execute queries and retrieve data.

The available configuration options are:

 - dsn
 - username
 - password
 - driver_options

They go directly to the PDO consturct method. Here's an example:

```php
DB::setConfig([
    'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
    'username' => 'root',
    'password' => 'qkum4hctpwh',
    'driver_options' => [
        PDO::ATTR\_DEFAULT\_FETCH\_MODE => PDO::FETCH\_BOTH,
    ],
]);
```

You can connect to different databases by setting alternative configurations. The second argument of ``setConfig`` allows you to "name" a configuration. After that you can get the connection with this configuration by calling ``DB::get($name)``

```php
DB::setConfig(array(
    'dsn' => 'mysql:dbname=test-db;host=127.0.0.1',
    'username' => 'alternative',
), 'alternative-db');

// ...
$db = DB::get('alternative-db');
```

## Retrieving data (Select)

Tretrieve data from the database, use Query\Select class.

An example select:

```php

$select = DB::get()->select()
    ->from('users')
    ->column('users.*')
    ->where('username', 'Tom')
    ->whereIn('type', ['big', 'small'])
    ->limit(10)
    ->order('created_at', 'DESC');

$result = $select->execute();

foreach ($result as $row) {
    var_dump($row);
}
```

## Detailed docs

- [Query Select](/docs/Select.md)

## License

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin as part of [clippings.com](http://clippings.com)

Under BSD-3-Clause license, read LICENSE file.
