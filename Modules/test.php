<?php
$bytes = random_bytes(5);
var_dump(bin2hex($bytes));

echo $bytes;

echo '<br><br><br><br>';

$randomNum=substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstvwxyz', 36)), 0, 10);
echo $randomNum;
echo '<br><br><br><br>';
if('A'>0) {
    echo 'JEST';
}else{
    echo 'NIE JEST';
}

echo '<br><br><br>';


$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$x = pathinfo($url);
echo '<br><br><br>';
echo $x['filename'] ;
?>