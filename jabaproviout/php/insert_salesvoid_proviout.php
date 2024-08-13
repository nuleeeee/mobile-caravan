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

$invidz = $_POST["invidz"];
$invdetidz = $_POST["invdetidz"];
$refqty =  $_POST["refqty"];
$var_voidnameidz =  $_POST["var_voidnameidz"];
$var_voiditemidz =  $_POST["var_voiditemidz"];
$var_voiditemcode =  $_POST["var_voiditemcode"];

$formidz = 1;
$cashieridz = $_SESSION['login_user'];

$updatesalesvoid = "DELETE FROM sales_mbd$lstIpall.invdet WHERE invdetidxx = $invdetidz";
mysqli_query($dbonlineserver, $updatesalesvoid);

$updatesalesvoid = "DELETE FROM mobilejaba.tmp_prsalesdetlink WHERE invdetidxx = $invdetidz";
mysqli_query($dbonlineserver, $updatesalesvoid);

mysqli_close($dbonlineserver);

?>