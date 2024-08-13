<?php
include "../../php/allfunction.php";

$pridz = $_POST["var_pridz"];

$brlogin = $_POST['branch'];

$briptosave = check_user_branch($brlogin);

define('DB_SERVERONLINE', $briptosave);
$dbonlineserver = mysqli_connect(DB_SERVERONLINE, DB_USERNAME, DB_PASSWORD);

// Check the connection
if (mysqli_error($dbonlineserver) != "") {
    echo "NO CONNECTION";
    return;
}

$sqlcmd = "SELECT SUM(chqcnt) as chqcnt, pridz FROM
(
	SELECT pridz, IF(ISNULL(clearstatus),0,IF(clearstatus = 1,0,1)) as chqcnt FROM mobilejaba.mobilevproduct
	LEFT OUTER JOIN sales_mbd.chequecleared ON sales_mbd.chequecleared.soapayidz = mobilejaba.mobilevproduct.pridz
	WHERE pridz = '$pridz'
)as tbl_tbl";

$result = mysqli_query($dbonlineserver, $sqlcmd);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);
if($count>=1)
{
	if (is_null($row["chqcnt"]) && is_null($row["pridz"])) {
		echo "Provissionary ID is not identified or not yet saved";
	} else {
		if($row["chqcnt"] >= 1)
		{
			echo -1;
		}
		else
		{
			echo $row["pridz"];
		}
	}
}
else
{
  echo "Provissionary ID is not identified or not yet saved";
}

?>