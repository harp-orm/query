# Atlas

[![Build Status](https://travis-ci.org/clippings/atlas.png?branch=master)](https://travis-ci.org/clippings/atlas)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/clippings/atlas/badges/quality-score.png?s=e77125ba3a3e183fc8e697dc45fb8a7b5e6e9334)](https://scrutinizer-ci.com/g/clippings/atlas/)
[![Code Coverage](https://scrutinizer-ci.com/g/clippings/atlas/badges/coverage.png?s=9a58da3bc0c9e16ab2dcf8019ca265149a5b15e1)](https://scrutinizer-ci.com/g/clippings/atlas/)
[![Latest Stable Version](https://poser.pugx.org/clippings/atlas/v/stable.png)](https://packagist.org/packages/clippings/atlas)

* In table and column selects:
	* an associated array means "reference" => "alias"
	* normal array means multiple references
	* if an item of a normal array is an array, asume a "SQL" object with parameters
* In where / having clause
	* an associative array means "column" = "value", if value is an array, operator is "IN", if value is NULL, operator is "IS"
	* if a normal array / string - asume it's a "SQL" object
	* multiple "where" invocations are added with "AND"
* In join clause
	* associative array represents an ON clause with column = column2, added with "AND"
	* if normal array asume a "SQL" object
	* last optional parameter is "LEFT", "RIGHT" ... etc
	* first parameter is either string for table of associative array with table => alias

```php
Query::select()
	->from(['table' => 'alias', 'table2' => 'name'])
	->from([new SQL('(SELECT id from table) AS name'), 'table2' => 'name'])
	->where(['name' => 2])
	->where(SQL('adsasd ? adsasd jasda', $param1, $param2))
	->where(['new sql', $param1, $param2])
	->order(['name' => 'ASC', 'param' => 'ASC'])
	->group('name')
	->group(['name', 'field'])
	->where(['((name = ?) OR (param = ?) AND gate = ?)', $name, $param, $gate])
	->where('name = ? AND name > ?', $name1, $name2)
	->join(['table' => 'alias'], ['column = column2 AND column = ?', $name1], 'LEFT')
	->join('table', ['column' => 'column2'])
	->limit(10)
	->offset(20)
	->select(['name', 'param'])
	->select(['name' => 'pasta', 'param'])
	->select([['IF (name = ?) AS name', $name], 'param']);
```
## License

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin as part of [clippings.com](http://clippings.com)

Under BSD-3-Clause license, read LICENSE file.
