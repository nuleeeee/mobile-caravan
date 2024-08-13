<?php
include "../../php/allfunction.php";
$pin = $_POST["void_enterpin"];
$sqlcmd = "SELECT * FROM vlookup_mcore.vnamenew WHERE pin = '$pin' AND hide = 0;";
$result = mysqli_query($db, $sqlcmd);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);
if ($count >= 1) {
	$nameid = $row['nameidxx'];
	$positionid = $row["positionidz"];
	if($positionid == 1 || $positionid == 2 || $positionid == 3 || $positionid == 4 || $positionid == 90 || $positionid == 75)
	{
		echo $nameid;
	}
	else
	{
		echo 0;
	}
} else {
	echo 0;
}
?>