<?php

$str = "{\"h0\":\"恶魔巫师\",\"h1\":\"痛苦女王\"}";

$strObj = json_decode($str);

print_r($strObj);

$h = 'h0';


foreach ($strObj as $k => $v) {
	echo $k.'<br>';
	echo $v.'<br>';
}

echo '<br>';

$a = array();

$a['aa'] = 1234;

print_r($a[0]);

?>