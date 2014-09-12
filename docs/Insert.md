# Insert Query

Selecting data is performed with an [Insert object](/src/Insert.php). You usually don't create it directly, but use the ``insert`` method of your DB object, so it knows where to insert the data.

Use ``getLastInsertId`` to get the ID of the newly added records. If multiple records have been inserted, it will return the ID of the first one.

```php
use Harp\Query\DB;

$db = new DB('mysql:dbname=test-db;host=127.0.0.1', 'root');

$insert = $db->insert()
    ->into('users')
    ->set([
        'name' => 'test',
        'score' => 100
    ]);

$insert->execute();

echo $insert->getLastInsertId();
```

## Inspecting

If you want to see what SQL the insert object will generate you can use the ``sql`` method. This will give you the raw SQL that will be sent to the driver, with all the placeholders as "?".

```php
$insert = $db->insert()
    ->into('users')
    ->set([
        'name' => 'test',
        'score' => 100
    ]);

// INSERT INTO users SET name = ?, score = ?
echo $insert->sql();
```

You can get the fully rendered sql with all the placeholders properly filled, using ``humanize`` method.

```php
$insert = $db->insert()
    ->into('users')
    ->set([
        'name' => 'test',
        'score' => 100
    ]);

// INSERT INTO users SET name = 'test', score = 100
echo $insert->humanize();
```

> __Warning!__ Do not use ``humanize`` to send sql to the database as the escaping is rudimentary and may fail. Internally only ``sql`` method is used to communicate with the server.

## Insert type

SQL has special keywords that you can place in front of your insert query. Those keywords can be provided with the ``type`` method.

```php
$insert = $db->insert()
    ->type('IGNORE')
    ->into('users')
    ->set(['name' => 'test']);

// Insert Ignore
// INSERT IGNORE INTO users SET name = 'test'
$insert->type('IGNORE');
```

## Inserting a single row with SET

To insert one row into a database use the ``set`` method, it accepts an array of column => value. All the values will be placed as placeholders and escaped properly.

```php
$insert = $db->insert()->into('users');

// Normal select
// INSERT INTO users SET name = 'test', score = 100
$insert
    ->set([
        'name' => 'test',
        'score' => 100
    ]);
```

## Inserting multiple rows with COLUMNS ... VALUES

To insert multiple rows into a database use can the ``columns`` and ``values`` methods. You need to call ``columns`` once with the column names, and then can call ``values`` multiple times for each row. All the values will be placed as placeholders and escaped properly.

```php
$insert = $db->insert()->into('users');

// Normal select
// INSERT INTO users (name, score) VALUES ('Tom', 100), ('John', 200)
$insert
    ->columns('name', 'score')
    ->values('Tom', 100)
    ->values('John', 200);
```

## Inserting rows based on a SELECT

You can insert rows, based on a select, using ``columns`` and ``select`` methods. You need to call ``columns`` once with the column names, then pass a ``Select`` object with the ``select`` method.

```php
$insert = $db->insert()->into('users');

// Normal select
// INSERT INTO users (name, score) SELECT username, popularity FROM profiles WHERE name = 10
$insert
    ->columns('name', 'score')
    ->select(
        DB::select()
            ->from('profiles')
            ->column('username')
            ->column('popularity')
            ->where('name', 10)
    );
```

## Clearing

Sometimes you will need to clear the previously set values. To do that you need to call one of the ``clear\*`` methods.

- __clearTable__()
- __clearColumns__()
- __clearValues__()
- __clearSet__()
- __clearSelect__()

## Method list

A full list of available query methods:

- __into__($table)
- __columns__(array $columns)
- __values__(array $values)
- __set__(array $values)
- __select__(Select $select)
- __getLastInsertId__()
