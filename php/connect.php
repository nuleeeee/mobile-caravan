<?php
$settings = array();
$counter = 0;
define('DB_SERVER', "localhost");
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'password');
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$GLOBALS['brnumb'] = 7; // branch id
$brCPU = 	"LUC"; // branch capitals
$brName = "LUCENA"; // branch
$savepath  = "";
?>
