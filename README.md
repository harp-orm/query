# Harp Query

[![Build Status](https://travis-ci.org/clippings/atlas.png?branch=master)](https://travis-ci.org/clippings/atlas)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/clippings/atlas/badges/quality-score.png?s=429880c25663a4c0c4768fbb4158abe048726e82)](https://scrutinizer-ci.com/g/clippings/atlas/)
[![Code Coverage](https://scrutinizer-ci.com/g/clippings/atlas/badges/coverage.png?s=e32088c682e67d1c7eec28b58f9c6a34a2123ed7)](https://scrutinizer-ci.com/g/clippings/atlas/)
[![Latest Stable Version](https://poser.pugx.org/clippings/atlas/v/stable.png)](https://packagist.org/packages/clippings/atlas)

A query builder library, extending PDO to allow writing queries in object oriented style.
Intelligently manages passing parameters to PDO's execute.

A Quick example:

```php
use Harp\Query\DB;

DB::setConfig('default', array(
    'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
    'username' => 'root',
));

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

## Configurations

You can use multiple configurations, and set them with ``setConfig``. All the queries use the 'default' config by default, but you can set them explicitly to alternative configs. The available config opyions are:

 - dsn
 - username
 - password
 - driver_options

They go directly to the PDO consturct method. Here's an example:

```php
use Harp\Query\DB;
use Harp\Query\Select;

DB::setConfig('default', [
    'dsn' => 'mysql:dbname=atlas;host=127.0.0.1',
    'username' => 'root',
]);

DB::setConfig('testing', [
    'dsn' => 'mysql:dbname=test-atlas;host=127.0.0.1',
    'username' => 'root',
    'password' => '***',
    'driver_options' => [
        PDO::ATTR\_DEFAULT\_FETCH\_MODE => PDO::FETCH\_BOTH,
    ],
]);

$config = DB::getConfig('testing');

$select = new Select(DB::get('testing'));

```

## Select

Tretrieve data from the database, use Query\Select class. It has the following methods:

 - columns
 - from
 - group
 - having
 - offset
 - join
 - where
 - order
 - limit


## License

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin as part of [clippings.com](http://clippings.com)

Under BSD-3-Clause license, read LICENSE file.
