<?php
include "../../php/allfunction.php";

$brlogin = $_POST['branch'];

$briptosave = check_user_branch($brlogin);

define('DB_SERVERONLINE', $briptosave);
$dbonlineserver = mysqli_connect(DB_SERVERONLINE, DB_USERNAME, DB_PASSWORD);

// Check the connection
if (mysqli_error($dbonlineserver) != "") {
    echo "NO CONNECTION";
    return;
}

$formidz = 1;
$var_invidz = $_POST["var_invidz"];
$nanoidz = $_POST["nanoidz"];

$cashieridz = $_SESSION['login_user'];

$sqlupdate = "UPDATE sales_mbd$lstIpall.invdet SET nanoidz = $nanoidz WHERE invidz = $var_invidz";
mysqli_query($dbonlineserver, $sqlupdate);

mysqli_close($dbonlineserver);
?>