# PHP-Slow-Hash

A slow hash class. The class will use the passed "string" and "salt", and using
known algorythms will hash the passed string. It will repeat the process, until
an optional third parameter "seconds" is met.

The final generated output will hold the hash and salt, as well as the passes
used to generate it in a single string. This is useful for convenience to store
the hash in a single database field.

The class has a "equals" function, which will compare a string with the hash,
and will return bollean (true or false) if it matches.

The class can safely hash non-ASCII strings, and salts. For instance,
Cyrillic, or Greek alphabets were tested successfully. Test results can be
seen here:
https://github.com/lesichkovm/PHP-Slow-Hash/blob/master/test/test_output.txt

This is standalone class with no external dependencies, and requirements.

Installation
============

Copy file to directory of your choice, and include at beginning of script

```php
<?php
require_once("SlowHash.php");
```

How to use:
============

1) To hash a string

```php
$string = "My Test String"; // String to hash
$salt = uniqueid(true);     // Unique salt
$seconds = 2.3;             // Minimum time in seconds required for hashing (may be floating number, i.e. 2.3s) 

$hash = SlowHash::($string, $salt, $seconds);
```

2) To compare string to a hash

```php
$equals = SlowHash::equals($string, $hash);
```

3) To use defaults. Defaults will automatically generate salt, and will be generated in no less than 3 seconds

```php
$hash = SlowHash::hash($string);
```
