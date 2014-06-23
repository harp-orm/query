# Update Query

Updating data is performed with an [Update object](/src/Update.php). You usually don't create it directly, but use the ``update`` method of your DB object, so it knows from where to delete the rows.

```php
use Harp\Query\DB;

$update = DB::get()->update()
    ->table('users')
    ->set([
        'name' => 'test',
        'score' => 100
    ])
    ->where('id', 123);

$update->execute();
```

## Inspecting

If you want to see what SQL the update object will generate you can use the ``sql`` method. This will give you the raw SQL that will be sent to the driver, with all the placeholders as "?".

```php
use Harp\Query\DB;

$update = DB::get()->update()
    ->table('users')
    ->set([
        'name' => 'test',
        'score' => 100
    ])
    ->where('id', 123);

// UPDATE users SET name = ?, score = ?
echo $update->sql();
```

You can get the fully rendered sql with all the placeholders properly filled, using ``humanize`` method.

```php
use Harp\Query\DB;

$update = DB::get()->update()
    ->table('users')
    ->set([
        'name' => 'test',
        'score' => 100
    ])
    ->where('id', 123);

// UPDATE users SET name = 'test', score = 100
echo $update->humanize();
```

> __Warning!__ Do not use ``humanize`` to send sql to the database as the escaping is rudimentary and may fail. Internally only ``sql`` method is used to communicate with the server.

## Update type

SQL has special keywords that you can place in front of your delete query. Those keywords can be provided with the ``type`` method.

```php
use Harp\Query\DB;

$update = DB::get()->update()
    ->table('users')
    ->set([
        'name' => 'test',
        'score' => 100
    ])
    ->where('id', 123);

// Update Ignore
// UPDATE IGNORE users SET name = 'test', score = 100
$update->type('IGNORE');
```

## Where condition

You can assign where conditions using ``where``, ``whereIn``, ``whereLike``, ``whereNot`` or ``whereRaw`` methods. Each of them accepts two arguments __column__ and __value__.

Calling the methods multiple times will "AND" all the conditions. If you need to provide "OR" conditions, use the ``whereRaw`` method.

```php
use Harp\Query\DB;

$update = DB::get()->update()->table('users')->set(['name' => 'test']);

// Single value
// UPDATE users SET name = 'test' WHERE id = 1
$update->where('id', 1);

// Multiple conditions
// UPDATE users SET name = 'test' WHERE id = 1 AND name = 'test'
$update
    ->where('id', 1)
    ->where('name', 'test');

// Array of values
// UPDATE users SET name = 'test' WHERE id IN (1, 3)
$update->whereIn('id', [1, 3]);

// LIKE condition
// UPDATE users SET name = 'test' WHERE name LIKE '%test%'
$update->whereLike('name', '%test%');

// Negative condition
// UPDATE users SET name = 'test' WHERE name != 'test'
$update->whereNot('name', 'test');

// Custom column SQL
// UPDATE users SET name = 'test' WHERE name = IF(id = 5, 'test', 'test2') OR name = 'test3'
$update->whereRaw("name = IF(id = ?, ?, ?) OR name = ?", [5, 'test', 'test2', 'test3']);
```

## Updating from multiple tables

To update more than one table simply call ``table`` multiple times.

```php
use Harp\Query\DB;

$update = DB::get()->update();

// UPDATE users,profiles SET users.name = 'test', profiles.username = 'test' WHERE users.id = profiles.user_id
$update
    ->table('users')
    ->table('profiles')
    ->set([
        'users.name' => 'test',
        'profiles.username' => 'test',
    ])
    ->whereRaw('users.id = profiles.user_id');
```

## Joining tables

Another way to update multiple tables is by using ``join`` or ``joinAliased`` methods.

The table name can be a custom SQL, using the SQL\SQL object. Columns conditions are set with a raw string. Optionally you can set them as array, as [column1 => column2] which will represent an "ON column1 = column2" condition.

```php
use Harp\Query\DB;

$update = DB::get()->update()->table('users')->set(['name' => 'test']);

// Normal join
// UPDATE users SET name = 'test' JOIN profiles ON users.id = profiles.user_id
$delete->join('profiles', ['users.id' => 'profiles.user_id']);

// Aliased join
// UPDATE users SET name = 'test' JOIN profiles AS prof ON users.id = prof.user_id
$delete->joinAliased('profiles', 'prof', ['users.id' => 'profiles.user_id']);

// Left join
// UPDATE users SET name = 'test' LEFT JOIN profiles ON users.id = profiles.user_id
$delete->join('profiles', ['users.id' => 'profiles.user_id'], 'LEFT');

// Multiple conditions join
// UPDATE users SET name = 'test' JOIN profiles ON users.id = profiles.user_id AND users.type = profiles.type
$delete->join('profiles', ['users.id' => 'profiles.user_id', 'users.type' => 'profiles.type']);

// USING conditions
// UPDATE users SET name = 'test' JOIN profiles USING (id)
$delete->join('profiles', 'USING (id)');

// Custom SQL
// UPDATE users SET name = 'test' JOIN profiles ON users.id = profiles.user_id AND users.type = 'profile'
$delete->join('profiles', new SQL\SQL('ON users.id = profiles.user_id AND users.type = ?', ['profile']);
```

## Setting multiple rows

Update class gives you the option of updating multiple rows with a single query. You can accomplish that with the ``setMultiple`` method.

Here's how to use it:

```php
use Harp\Query\DB;

$update = DB::get()->update()->table('users');

// UPDATE users
// SET
//     name = CASE id WHEN 2 THEN 'new name' WHEN 5 THEN 'name 2' ELSE name,
//     username = CASE id WHEN 2 THEN 'new username' ELSE username,
//     score = CASE id WHEN 6 THEN 300 ELSE score,
// WHERE id IN (2, 5, 6)
$update
    ->setMultiple([
        2 => [
            'name' => 'new name',
            'username' => 'new username',
        ],
        5 => [
            'name' => 'name 2',
        ],
        6 => [
            'score' = 300
        ]
    ]);
```
## Clearing

Sometimes you will need to clear the previously set values. To do that you need to call one of the ``clear\*`` methods.

- __clearSet__()
- __clearTable__()
- __clearJoin__()
- __clearLimit__()
- __clearOrder__()
- __clearType__()
- __clearWhere__()

## Method list

A full list of available query methods:

- __set__(array $values)
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
