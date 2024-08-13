<?php
	include "../../php/allfunction.php";
	
	$nameiforcrlimit = $_POST["nameiforcrlimit"];

	$sqlcmd = "SELECT vlookup_mcore.vnamelimit.limit as creditlimit FROM vlookup_mcore.vname
INNER JOIN vlookup_mcore.vnamelimit ON vlookup_mcore.vnamelimit.nameidz = vlookup_mcore.vname.nameidxx
WHERE nameidxx = $nameiforcrlimit";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		echo $row["creditlimit"];
	} else {
		echo 0;
	}

?>