--TEST--
mysql_errno()
--SKIPIF--
<?php require_once('skipif.inc'); ?>
--FILE--
<?php
include "connect.inc";

$tmp    = NULL;
$link   = NULL;

if (false !== ($tmp = @mysql_errno()))
	printf("[001] Expecting boolean/false, got %s/%s\n", gettype($tmp), $tmp);

if (false !== ($tmp = @mysql_errno($link)))
	printf("[002] Expecting boolean/false, got %s/%s\n", gettype($tmp), $tmp);

if (!is_null($tmp = @mysql_errno($link, 'too many args')))
	printf("[002b] Expecting NULL, got %s/%s\n", gettype($tmp), $tmp);

if (!$link = my_mysql_connect($host, $user, $passwd, $db, $port, $socket)) {
	printf("[003] Cannot connect to the server using host=%s, user=%s, passwd=***, dbname=%s, port=%s, socket=%s\n",
		$host, $user, $db, $port, $socket);
}
var_dump(mysql_errno($link));

if (!mysql_query('DROP TABLE IF EXISTS test', $link)) {
	printf("[004] Failed to drop old test table: [%d] %s\n", mysql_errno($link), mysql_errno($link));
}

mysql_query('SELECT * FROM test', $link);
var_dump(mysql_errno($link));

mysql_close($link);

var_dump(mysql_errno($link));

if ($link = @mysql_connect($host . '_unknown', $user . '_unknown', $passwd, true)) {
	printf("[005] Can connect to the server using host=%s, user=%s, passwd=***, dbname=%s, port=%s, socket=%s\n",
		$host . '_unknown', $user . '_unknown', $db, $port, $socket);
}
var_dump(mysql_errno());

print "done!";
?>
--EXPECTF--
int(0)
int(%d)

Warning: mysql_errno(): %d is not a valid MySQL-Link resource in %s on line %d
bool(false)
int(%d)
done!