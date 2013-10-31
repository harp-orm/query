Backup/restore environment variables: globals, static vars, kohana configs

Each environment group that you add allows has a unique name of "naming" its variables so that it knows how to handle their backup

 - '_POST', '_GET', '_FILES', '_SERVER', '_COOKIE' and '_SESSION' are handled by the 'Environment_Group_Globals',
 - 'REMOTE_HOST', 'CLIENT_IP' and all the other variables inside the '_SERVER' variable are handled by Environment_Group_Server (this is used to easily backup restore only sertain variables of the $_SERVER super global)
 - 'SomeClass::$variable' is used to handle stativ variables - it can backup / restore public, protected and private ones by Environment_Group_Static
 - 'group.config_var' is used to handle Kohana config settings by Environment_Group_Config - this is used only in a Kohana Framwork environment

Example: 

```php
$environment = new Environment(array(
	'globals' => new Environment_Group_Globals(),
	'server' => new Environment_Group_Server(),
	'static' => new Environment_Group_Static(),
));

$environment->backup_and_set(array(
	'_POST' => array('new stuff'),
	'REMOTE_HOST' => 'example.com',
	'MyClass::$private_var' => 10
));

// Do some stuff that changes / uses these variables

$environment->restore();
```
