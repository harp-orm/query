# Cherry 

[![Build Status](https://travis-ci.org/OpenBuildings/cherry.png?branch=master)](https://travis-ci.org/OpenBuildings/cherry)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/OpenBuildings/cherry/badges/quality-score.png?s=e9d8fb56ba6287ac409e35a485445071ad52eebe)](https://scrutinizer-ci.com/g/OpenBuildings/cherry/)
[![Code Coverage](https://scrutinizer-ci.com/g/OpenBuildings/cherry/badges/coverage.png?s=80b3817f7aa1d6b14e56a45ba054f44cb4df695b)](https://scrutinizer-ci.com/g/OpenBuildings/cherry/)
[![Latest Stable Version](https://poser.pugx.org/openbuildings/cherry/v/stable.png)](https://packagist.org/packages/openbuildings/cherry)

A lightweight query builder. Inspired by Kohana's Database module. Only handles building queries, you'll need to execute them yourself.

## Basic Usage Example

Here's a quick example:

```php
$query = new Query_Select;
$query
	->select('name', 'email')
	->from('users')
	->where('id', '=', 10)
	->limit(1);

$compiler = new Compiler;
echo $compiler->compile($query); 
// Will output: 
// SELECT name, email FROM users WHERE id = 10 LIMIT 1
```

## Queries and Compilers

This library makes a distinction of building your query object, and compiling it down to SQL - the idea is that the query object is universal, but you can compile it down to a different SQL dialect. There is even a "Pretty" compiler that outputs pretty printed SQL.

There are currently 3 compilers:

* [Compiler](src/Openbuildings/Cherry/Compiler.php) - compile down to normal SQL
* [Compiler_Parametrized](src/Openbuildings/Cherry/Compiler_Parametrized.php) - all the variables in the SQL get replaced with "?" placeholders, so you can pass them down to your driver of choice. ``Query`` objects have ->parameters() method to give them to you as a nice array.
* [Compiler_Pretty](src/Openbuildings/Cherry/Compiler_Pretty.php) - compile to human readable SQL with new lines where necessary.

## Select Query

Available methods:

* ``distinct()`` add a "distinct" clause to the select query
* ``from($table1, $table2)`` add "FROM" tables, accepts multiple arguments for each table name, you can also assign aliases with array('tablename', 'alias')
* ``limit($limit)`` set LIMIT to the query
* ``offset($offset)`` set OFFSET to the query
* ``select($column1, $column2)`` set columns, accepts multiple arguments for each column name, you can also assign aliases with array('column', 'alias')
* ``select_array(array($column1, $column2))`` same as column, just pass whole array instead of multiple arguments.
* ``join($table, $type = NULL)`` add join clause. to set aliases use array('tablename', 'alias'). Last argument is used to assign "LEFT" or "INNER" etc.
* ``on($column, $operator, $foreign_column)`` assign "ON" condition to the last join, e.g. ON column2 = column2
* ``using($columns)`` assign "USING" condition to the last join, e.g. USIGN (column1, column2)
* ``group_by($column, $direction = NULL)`` - add a GROUP BY statement to the query, any subsequent calls will add more of these, separated by commas.
* ``order_by($column, $direction = NULL)`` - add a ORDER BY statement to the query, any subsequent calls will add more of these, separated by commas.
* ``and_where($column, $operator, $value)`` - add a WHERE statement to the query, values. If called multiple times will add them with "AND" operator, values are properly escaped - generally with positional properties (e.g. "?")
* ``where($column, $operator, $value)`` - shorthand for ``and_where``
* ``or_where($column, $operator, $value)`` - add a WHERE statement to the query, using the OR operator. values are properly escaped
* ``and_where_open()`` - start a group (basically open parenthesis). Added with an "AND" operator e.g. ``something AND (...)``
* ``and_where_close()`` - close parenthesis opened previously
* ``where_open()`` - shorthand for ``and_where_open``
* ``where_close()`` - shorthand for ``and_where_close``
* ``or_where_open()`` - start a group (basically open parenthesis). Added with an "OR" operator e.g. ``something OR (...)``
* ``or_where_close()`` - close parenthesis opened previously
* ``and_having($column, $operator, $value)`` - add a HAVING to to the query, values. If called multiple times will add them with "AND" operator, values are properly escaped - generally with positional properties (e.g. "?")
* ``having($column, $operator, $value)`` - shorthand for ``and_having``
* ``or_having($column, $operator, $value)`` - add a HAVING statement to the query, using the OR operator. values are properly escaped
* ``and_having_open()`` - start a group (basically open parenthesis). Added with an "AND" operator e.g. ``something AND (...)``
* ``and_having_close()`` - close parenthesis opened previously
* ``having_open()`` - shorthand for ``and_having_open``
* ``having_close()`` - shorthand for ``and_having_close``
* ``or_having_open()`` - start a group (basically open parenthesis). Added with an "OR" operator e.g. ``something OR (...)``
* ``or_having_close()`` - close parenthesis opened previously

Example of building a query object:

```php
$query = new Query_Update();
$query
	->select('id', 'name', 'email', array(new Statement_Expression('COUNT(images.id)'), 'images_count')
	->from('users')
	->join('images')
	->on('images.user_id', '=', 'users.id')
	->where('users.name', 'LIKE', '%test')
	->where_open()
		->where('users.id', '!=', 10)
		->or_where('users.name', '!=', "test")
	->where_close()
	->having('images_count', '>', 5);

$compiler = new Compiler;
echo $compiler->compile($query); 
// Will output: 
// SELECT id, name, email, COUNT(images.id) 
// FROM users 
// JOIN images ON images.user_id = users.id 
// WHERE users.name LIKE "%test" AND (users.id != 10 OR users.name != "test") 
// HAVING images_count > 5
```

## Update Query

Available methods:

* ``table($table1, $table2)`` add table names to update 
* ``set($pairs)`` an array with key value pairs to set
* ``value($name, $value)`` set a single value, if $value is NULL, "NULL" is set
* ``limit($limit)`` set LIMIT to the query
* ``order_by($column, $direction = NULL)`` - add a ORDER BY statement to the query, any subsequent calls will add more of these, separated by commas.
* ``and_where($column, $operator, $value)`` - add a WHERE statement to the query, values. If called multiple times will add them with "AND" operator, values are properly escaped - generally with positional properties (e.g. "?")
* ``where($column, $operator, $value)`` - shorthand for ``and_where``
* ``or_where($column, $operator, $value)`` - add a WHERE statement to the query, using the OR operator. values are properly escaped
* ``and_where_open()`` - start a group (basically open parenthesis). Added with an "AND" operator e.g. ``something AND (...)``
* ``and_where_close()`` - close parenthesis opened previously
* ``where_open()`` - shorthand for ``and_where_open``
* ``where_close()`` - shorthand for ``and_where_close``
* ``or_where_open()`` - start a group (basically open parenthesis). Added with an "OR" operator e.g. ``something OR (...)``
* ``or_where_close()`` - close parenthesis opened previously

```php
$query = new Query_Update();
$query
	->table('users', 'images')
	->set(array('images.name' => new Statement_Expression('CONCAT(users.name, images.name)')))
	->where('users.name', 'LIKE', '%test')
	->where_open()
		->where('users.id', '!=', 10)
		->or_where('users.name', '!=', "test")
	->where_close();

$compiler = new Compiler;
echo $compiler->compile($query); 
// Will output: 
// UPDATE users, image
// SET images.name = CONCAT('users.name, images.name')
// WHERE users.name LIKE "%test" AND (users.id != 10 OR users.name != "test") 
```

## License

Copyright (c) 2012-2013, OpenBuildings Ltd. Developed by Ivan Kerin as part of [clippings.com](http://clippings.com)

Under BSD-3-Clause license, read LICENSE file.
