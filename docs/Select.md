# Select Query

Selecting data is performed with Query\Select object. You usually don't create it directly, but use the ``select`` method of your DB object, so it knows from where to retrieve the data.

```php
$select = DB::get()->select()->from('users');

$result = $select->execute();

foreach ($result as $row) {
    var_dump($row);
}
```

## Inspecting

If you want to see the SQL that the select object will generate you can use the ``sql`` method. This will give you the raw SQL that will be sent to the driver, with all the placeholders as "?".

```php
$select = DB::get()->select()->from('users')->where('name', 'test');

// SELECT * FROM users WHERE name = ?
echo $select->sql();
```

You can get the fully rendered sql with all the placeholders properly filled, using ``humanize`` method.

```php
$select = DB::get()->select()->from('users')->where('name', 'test');

// SELECT * FROM users WHERE name = 'test'
echo $select->humanize();
```

> __Warning!__ Do not use ``humanize`` to send sql to the database as the escaping is rudimentary and may fail. Internally only ``sql`` method is used to comunicate with the server.

## Select type

SQL has special keywords that you can place in front of your select. Those keywords can be provided with the ``type`` method.

```php
$select = DB::get()->select()->from('users');

// Distinct select
// SELECT DISTINCT * FROM users
$select->type('DISTINCT');
```

## Selecting a table

To set a table to select from,  use the ``from`` method. It accepts two arguments - __tableName__ and __alias__. If you want do a nested select, you can provide a Query\Select class.

If you want to use a custom sql with some parameters, you can pass an SQL\SQL object.

```php
$select = DB::get()->select();

// Normal select
// SELECT * FROM users
$select->from('users');

// Aliased select
// SELECT * FROM users AS clients
$select->from('users', 'clients');

// Nested select
// SELECT * FROM (SELECT FROM clients) AS external
$nested = DB::get()->select()->from('clients');
$select->from($nested, 'external');

// Custom SQL
// SELECT * FROM sql_func('my test') AS test
$select->from(new SQL\SQL('sql_func(?)', ['my test']));
```

## Selecting columns

To set columns to select, use the ``column`` method. It will append a column name to the columns list. It accepts two arguments - __columnName__ and __alias__. If you want to prepend a column to the list use ``prependColumn``.

If you want to use a custom sql with some parameters, you can pass an SQL\SQL object.

If you do not provide a column, generic "*" is used.

```php
$select = DB::get()->select()->from('users');

// No column provided
// SELECT * FROM users
$select;

// Normal column
// SELECT name FROM users
$select->column('name');

// Aliased column
// SELECT name AS username FROM users
$select->column('name', 'username');

// Wildcard column
// SELECT users.* FROM users
$select->column('users.*');

// Multiple Columns
// SELECT name, email AS mail FROM users
$select
    ->column('name')
    ->column('email', 'mail');

// Prepend Columns
// SELECT email AS mail, name FROM users
$select
    ->column('name')
    ->prependColumn('email', 'mail');

// Custom SQL
// SELECT sql_func('my test') AS alias_name FROM users
$select->column(new SQL\SQL('sql_func(?)', ['my test']), 'alias_name');
```

## Where condition

You can assign where conditions using ``where``, ``whereIn``, ``whereLike``, ``whereNot`` or ``whereRaw`` methods. Each of them accepts two arguments __columnName__ and __value__.

Calling the methods multiple times will "AND" all the conditions. If you need to provide "OR" conditions, use the ``whereRaw`` method.

```php
$select = DB::get()->select()->from('users');

// Single value
// SELECT * FROM users WHERE id = 1
$select->where('id', 1);

// Multiple conditions
// SELECT * FROM users WHERE id = 1 AND name = 'test'
$select
    ->where('id', 1)
    ->where('name', 'test');

// Array of values
// SELECT * FROM users WHERE id IN (1, 3)
$select->whereIn('id', [1, 3]);

// LIKE condition
// SELECT * FROM users WHERE name LIKE '%test%'
$select->whereLike('name', '%test%');

// Negative condition
// SELECT * FROM users WHERE name != 'test'
$select->whereNot('name', 'test');

// Custom column SQL
// SELECT * FROM users WHERE name = IF(id = 5, 'test', 'test2') OR name = 'test3'
$select->whereRaw("name = IF(id = 5, 'test', 'test2') OR name = 'test3'", [5, 'test', 'test2']);
```

## Joining tables

You can join multiple tables using ``join`` and ``joinAliased`` methods. The table name can be a custom SQL,
using the SQL\SQL object. Columns conditions are set with a raw string. Optionally you can set them as array,
as [column1 => column2] which will represent an "ON column1 = column2" condition.

```php
$select = DB::get()->select()->from('users');

// Normal join
// SELECT * FROM users JOIN profiles ON users.id = profiles.user_id
$select->join('profiles', ['users.id' => 'profiles.user_id']);

// Aliased join
// SELECT * FROM users JOIN profiles AS prof ON users.id = prof.user_id
$select->joinAliased('profiles', 'prof', ['users.id' => 'profiles.user_id']);

// Left join
// SELECT * FROM users LEFT JOIN profiles ON users.id = profiles.user_id
$select->join('profiles', ['users.id' => 'profiles.user_id'], 'LEFT');

// Multiple conditions join
// SELECT * FROM users JOIN profiles ON users.id = profiles.user_id AND users.type = profiles.type
$select->join('profiles', ['users.id' => 'profiles.user_id', 'users.type' => 'profiles.type']);

// USING conditions
// SELECT * FROM users JOIN profiles USING (id)
$select->join('profiles', 'USING (id)');

// Custom SQL
// SELECT * FROM users JOIN profiles ON users.id = profiles.user_id AND users.type = 'profile'
$select->join('profiles', new SQL\SQL('ON users.id = profiles.user_id AND users.type = ?', ['profile']);
```

## Ordering and grouping

You can assign "ORDER BY" and "GROUP BY" statements with ``order`` and ``group`` methods.

If you want to use a custom sql with some parameters, you can pass an SQL\SQL object.

```php
$select = DB::get()->select()->from('users');

// Normal order
// SELECT * FROM users ORDER BY id
$select->order('id');

// Descending order
// SELECT * FROM users ORDER BY id DESC
$select->order('id', 'DESC');

// Multiple orders
// SELECT * FROM users ORDER BY id DESC, created_at ASC
$select
    ->order('id', 'DESC')
    ->order('created_at', 'ASC');

// Normal group
// SELECT * FROM users GROUP BY id
$select->group('id');

// Descending group
// SELECT * FROM users GROUP BY id DESC
$select->group('id', 'DESC');

// Multiple groups
// SELECT * FROM users GROUP BY id DESC, created_at ASC
$select
    ->group('id', 'DESC')
    ->group('created_at', 'ASC');
```

## Limit and offset

You can set limit and offset via ``limit`` and ``offset`` methods.

```php
$select = DB::get()->select()->from('users');

// Limit
// SELECT * FROM users LIMIT 10
$select->limit(10);

// Limit and offset
// SELECT * FROM users LIMIT 10 OFFSET 100
$select
    ->limit(10)
    ->offset(100);
```

## Having condition

You can assign having conditions using ``having``, ``havingIn``, ``havingLike``, ``havingNot`` or ``havingRaw`` methods. Each of them accepts two arguments __columnName__ and __value__.

Calling the methods multiple times will "AND" all the conditions. If you need to provide "OR" conditions, use the ``havingRaw`` method.

```php
$select = DB::get()->select()->from('users');

// Single value
// SELECT * FROM users HAVING id = 1
$select->having('id', 1);

// Multiple conditions
// SELECT * FROM users HAVING id = 1 AND name = 'test'
$select
    ->having('id', 1);
    ->having('name', 'test');

// Array of values
// SELECT * FROM users HAVING id IN (1, 3)
$select->havingIn('id', [1, 3]);

// LIKE condition
// SELECT * FROM users HAVING name LIKE '%test%'
$select->havingLike('name', '%test%');

// Negative condition
// SELECT * FROM users HAVING name != 'test'
$select->havingNot('name', 'test');

// Custom column SQL
// SELECT * FROM users HAVING name = IF(id = 5, 'test', 'test2') OR name = 'test3'
$select->havingRaw("name = IF(id = 5, 'test', 'test2') OR name = 'test3'", [5, 'test', 'test2']);
```

## Clearing

Sometimes you will need to clear the previously set values. To do that you need to call one of the ``clear\*`` methods.

- clearColumns()
- clearFrom()
- clearGroup()
- clearHaving()
- clearJoin()
- clearLimit()
- clearOffset()
- clearOrder()
- clearType()
- clearWhere()

## Appendix

A full list of available query methods:

- column($column, $alias = null)
- from($table, $alias = null)
- group($column, $direction = null)
- having($column, $value)
- havingIn($column, array $values)
- havingLike($column, $value)
- havingNot($column, $value)
- havingRaw($sql, $parameters)
- join($table, $conditions, $type)
- joinAliased($table, $alias, $conditions, $type)
- limit($limit)
- offset($offset)
- order($column, $direction = null)
- prependColumn($column, $alias = null)
- type($type)
- where($column, $value)
- whereIn($column, array $values)
- whereLike($column, $value)
- whereNot($column, $value)
- whereRaw($sql, $parameters)
