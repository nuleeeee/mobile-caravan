<?php
session_start();
$bridzbr = $_POST["bridzbr"];

$_SESSION['brnumb']  = $bridzbr;

echo $bridzbr;

?>