# Atlas

[![Build Status](https://travis-ci.org/clippings/atlas.png?branch=master)](https://travis-ci.org/clippings/atlas)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/clippings/atlas/badges/quality-score.png?s=429880c25663a4c0c4768fbb4158abe048726e82)](https://scrutinizer-ci.com/g/clippings/atlas/)
[![Code Coverage](https://scrutinizer-ci.com/g/clippings/atlas/badges/coverage.png?s=e32088c682e67d1c7eec28b58f9c6a34a2123ed7)](https://scrutinizer-ci.com/g/clippings/atlas/)
[![Latest Stable Version](https://poser.pugx.org/clippings/atlas/v/stable.png)](https://packagist.org/packages/clippings/atlas)


```php
AbstractQuery::select()
  ->from('table', 'alias')
  ->from('table')
  ->where(['name' => 2])
  ->whereRaw('adsasd ? adsasd jasda', $param1, $param2))
  ->whereRaw('new sql', $param1, $param2)
  ->order('name', 'ASC')
  ->group('name')
  ->group('name', 'direction')
  ->where('((name = ?) OR (param = ?) AND gate = ?)', $name, $param, $gate)
  ->joinAlias('table', 'alias', 'column = column2 AND column = ?', $name1, 'LEFT')
  ->join('table', ['column' => 'column2'])
  ->limit(10)
  ->offset(20)
  ->column('name')
  ->select('name', 'alias')
  ->select([['IF (name = ?) AS name', $name], 'param']);
```
## License

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin as part of [clippings.com](http://clippings.com)

Under BSD-3-Clause license, read LICENSE file.
