<?php

include "allfunction.php";

// $sql = optionlst($db, "SELECT * FROM vlookup_mcore.vbranch WHERE branchidxx IN (7,8)", "brname", "branchidxx");
// echo $sql;

if ($_SESSION['branch'] != 0) {
	echo "d-none";
} else {
	echo "";
}

?>