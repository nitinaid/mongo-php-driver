--TEST--
Test for PHP-394: Crashes and mem leaks.
--SKIPIF--
<?php if (version_compare(PHP_VERSION, "5.4.0", "ge")) { exit("skip This test requires PHP version prior to PHP5.4"); }?>
<?php require "tests/utils/standalone.inc";?>
--INI--
allow_call_time_pass_reference=On
--FILE--
<?php
require_once "tests/utils/server.inc";

class dummy {}

function errhandler() {
       unset($GLOBALS['arr1'][0]);
       return true;
}

$arr1 = array(new dummy, 1);
$oldhandler = set_error_handler("errhandler");

$x = new MongoCollection;
if ($x) {
    $x->batchInsert(&$arr1, $info);
}
restore_error_handler();

echo "I am alive\n";
?>
===DONE===
--EXPECT--
I am alive
===DONE===
