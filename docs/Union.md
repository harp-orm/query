# Union Query

If you need to combine the results of multiple selects from differnt tables into one result, you can use the [Union object](/src/Union.php). You usually don't create it directly, but use the ``union`` method of your DB object, so it knows where to insert the data.

```php
use Harp\Query\DB;

$db = new DB('mysql:dbname=test-db;host=127.0.0.1', 'root');

$select1 = $db->select()
    ->from('users')
    ->column('name')
    ->where('name', 'Tom');

$select2 = $db->select()
    ->from('profiles')
    ->where('name', 'John')
    ->column('name');

$union = $db->union()
    ->select($select1)
    ->select($select2);

$result = $union->execute();

foreach ($result as $row) {
    var_dump($row);
}
```

## Inspecting

If you want to see what SQL the union object will generate you can use the ``sql`` method. This will give you the raw SQL that will be sent to the driver, with all the placeholders as "?".

```php
$select1 = $db->select()
    ->from('users')
    ->column('name')
    ->where('name', 'Tom');

$select2 = $db->select()
    ->from('profiles')
    ->where('name', 'John')
    ->column('name');

$union = DB::union()
    ->select($select1)
    ->select($select2);

// (SELECT name FROM users WHERE name = ?)
// UNION
// (SELECT name FROM profiles WHERE name = ?)
echo $insert->sql();
```

You can get the fully rendered sql with all the placeholders properly filled, using ``humanize`` method.

```php
// (SELECT name FROM users WHERE name = 'Tom')
// UNION
// (SELECT name FROM profiles WHERE name = 'John')
echo $insert->humanize();
```

> __Warning!__ Do not use ``humanize`` to send sql to the database as the escaping is rudimentary and may fail. Internally only ``sql`` method is used to communicate with the server.

## Oreder and Limit

You can add "order" and "limit" to the union sql to be applied to the whole result.

```php
$select1 = $db->select()
    ->from('users')
    ->column('name')
    ->where('name', 'Tom');

$select2 = $db->select()
    ->from('profiles')
    ->where('name', 'John')
    ->column('name');

// (SELECT name FROM users WHERE name = ?)
// UNION
// (SELECT name FROM profiles WHERE name = ?)
// ORDER BY name, DESC
// LIMIT 20
$union = DB::union()
    ->select($select1)
    ->select($select2)
    ->order('name', 'DESC')
    ->limit(20);
```

## Clearing

Sometimes you will need to clear the previously set values. To do that you need to call one of the ``clear\*`` methods.

- __clearOrder__()
- __clearLimit__()
- __clearSelects__()

## Method list

A full list of available query methods:

- __order__($column, $direction = null)
- __limit__($limit)
- __select__(Select $select)
