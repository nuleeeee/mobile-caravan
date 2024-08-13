<?php
include "../../php/allfunction.php";
$var_pridz = $_POST["var_pridz"];

$brlogin = $_POST['branch'];

$briptosave = check_user_branch($brlogin);

define('DB_SERVERONLINE', $briptosave);
$dbonlineserver = mysqli_connect(DB_SERVERONLINE, DB_USERNAME, DB_PASSWORD);

// Check the connection
if (mysqli_error($dbonlineserver) != "") {
    echo "NO CONNECTION";
    return;
}

$sqlcmd = "SELECT name, nameidxx, IF(creditlimit > 1,1,0) as arstatus FROM vlookup_mbd.vname WHERE nameidxx = 1";
$result = mysqli_query($dbonlineserver, $sqlcmd);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$soldtoname = $row["name"];
$soldtoid = $row["nameidxx"];
$arstatus = $row["arstatus"];
$display = "
<script>
var_arstatus = $arstatus;
var_soldtoname = '$soldtoname';
var_soldtoidz = $soldtoid;
$('#txt_salessoldto').val('$soldtoname');
</script>";

echo $display;