# Delete Query

Deleting data is performed with a [Delete object](/src/Delete.php). You usually don't create it directly, but use the ``delete`` method of your DB object, so it knows from where to delete the rows.

```php
use Harp\Query\DB;

$delete = DB::get()->delete()
    ->from('users')
    ->where('name', 10)
    ->order('name', 'DESC')
    ->limit(10);

$delete->execute();
```

## Inspecting

If you want to see what SQL the delete object will generate you can use the ``sql`` method. This will give you the raw SQL that will be sent to the driver, with all the placeholders as "?".

```php
use Harp\Query\DB;

$delete = DB::get()->delete()
    ->from('users')
    ->where('name', 10)
    ->limit(10);

// DELETE FROM users WHERE name = ? LIMIT 10
echo $delete->sql();
```

You can get the fully rendered sql with all the placeholders properly filled, using ``humanize`` method.

```php
use Harp\Query\DB;

$delete = DB::get()->delete()
    ->from('users')
    ->where('name', 10)
    ->limit(10);

// DELETE FROM users WHERE name = 'name' LIMIT 10
echo $delete->humanize();
```

> __Warning!__ Do not use ``humanize`` to send sql to the database as the escaping is rudimentary and may fail. Internally only ``sql`` method is used to communicate with the server.

## Delete type

SQL has special keywords that you can place in front of your delete query. Those keywords can be provided with the ``type`` method.

```php
use Harp\Query\DB;

$delete = DB::get()->delete()
    ->from('users')
    ->where('name', 10)
    ->limit(10);

// Delete Ignore
// DELETE IGNORE FROM users WHERE name = 'name' LIMIT 10
$delete->type('IGNORE');
```


## Where condition

You can assign where conditions using ``where``, ``whereIn``, ``whereLike``, ``whereNot`` or ``whereRaw`` methods. Each of them accepts two arguments __column__ and __value__.

Calling the methods multiple times will "AND" all the conditions. If you need to provide "OR" conditions, use the ``whereRaw`` method.

```php
use Harp\Query\DB;

$delete = DB::get()->delete()->from('users');

// Single value
// DELETE FROM users WHERE id = 1
$delete->where('id', 1);

// Multiple conditions
// DELETE FROM users WHERE id = 1 AND name = 'test'
$delete
    ->where('id', 1)
    ->where('name', 'test');

// Array of values
// DELETE FROM users WHERE id IN (1, 3)
$delete->whereIn('id', [1, 3]);

// LIKE condition
// DELETE FROM users WHERE name LIKE '%test%'
$delete->whereLike('name', '%test%');

// Negative condition
// DELETE FROM users WHERE name != 'test'
$delete->whereNot('name', 'test');

// Custom column SQL
// DELETE FROM users WHERE name = IF(id = 5, 'test', 'test2') OR name = 'test3'
$delete->whereRaw("name = IF(id = ?, ?, ?) OR name = ?", [5, 'test', 'test2', 'test3']);
```

## Deleting from multiple tables

To delete from more than one table use a combination of ``table`` and ``from`` methods. You can call these tables more than once for multiple tables. Tables in "from" will be used for matching selecting the rows, while rows will be deleted only from tables in "table".

```php
use Harp\Query\DB;

$delete = DB::get()->delete();

// DELETE users FROM users,profiles WHERE users.id = profiles.user_id
$delete
    ->table('users')
    ->from('users')
    ->from('profiles')
    ->whereRaw('users.id = profiles.user_id');
```

## Joining tables

Another way to delete using multiple tables is by using ``join`` or ``joinAliased`` methods.

The table name can be a custom SQL, using the SQL\SQL object. Columns conditions are set with a raw string. Optionally you can set them as array, as [column1 => column2] which will represent an "ON column1 = column2" condition.

```php
use Harp\Query\DB;

$delete = DB::get()->delete()->from('users');

// Normal join
// DELETE FROM users JOIN profiles ON users.id = profiles.user_id
$delete->join('profiles', ['users.id' => 'profiles.user_id']);

// Aliased join
// DELETE FROM users JOIN profiles AS prof ON users.id = prof.user_id
$delete->joinAliased('profiles', 'prof', ['users.id' => 'profiles.user_id']);

// Left join
// DELETE FROM users LEFT JOIN profiles ON users.id = profiles.user_id
$delete->join('profiles', ['users.id' => 'profiles.user_id'], 'LEFT');

// Multiple conditions join
// DELETE FROM users JOIN profiles ON users.id = profiles.user_id AND users.type = profiles.type
$delete->join('profiles', ['users.id' => 'profiles.user_id', 'users.type' => 'profiles.type']);

// USING conditions
// DELETE FROM users JOIN profiles USING (id)
$delete->join('profiles', 'USING (id)');

// Custom SQL
// DELETE FROM users JOIN profiles ON users.id = profiles.user_id AND users.type = 'profile'
$delete->join('profiles', new SQL\SQL('ON users.id = profiles.user_id AND users.type = ?', ['profile']);
```

## Clearing

Sometimes you will need to clear the previously set values. To do that you need to call one of the ``clear\*`` methods.

- __clearFrom__()
- __clearTable__()
- __clearJoin__()
- __clearLimit__()
- __clearOrder__()
- __clearType__()
- __clearWhere__()

## Method list

A full list of available query methods:

- __from__($table, $alias = null)
- __table__($table, $alias = null)
- __join__($table, $conditions, $type)
- __joinAliased__($table, $alias, $conditions, $type)
- __limit__($limit)
- __order__($column, $direction = null)
- __type__($type)
- __where__($column, $value)
- __whereIn__($column, array $values)
- __whereLike__($column, $value)
- __whereNot__($column, $value)
- __whereRaw__($sql, $parameters)
