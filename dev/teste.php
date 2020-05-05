<?php
$cmd = 'cat /etc/*-release';
exec($cmd, $output);
print_r($output);
echo 'Operating System: '.php_uname('s').'<br>'; // echo PHP_OS;
echo 'Release Name: '.php_uname('r').'<br>';
echo 'Version: '.php_uname('v').'<br>';
echo 'Machine Type: '.php_uname('m').'<br>';


date_default_timezone_set('Africa/Maputo');
echo strtotime("now")."<br/>";;
$now = new DateTime();
echo $now->getTimestamp(); 
echo "<br>".date("Y-m-d H:i:s");

echo phpinfo();

?>
