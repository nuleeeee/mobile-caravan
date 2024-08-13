<?php
	include "../../php/allfunction.php";
	$cashieridz = $_SESSION['login_user'];

	$brlogin = $_POST['branch'];

	$briptosave = check_user_branch($brlogin);

	define('DB_SERVERONLINE', $briptosave);
	$dbonlineserver = mysqli_connect(DB_SERVERONLINE, DB_USERNAME, DB_PASSWORD);

	// Check the connection
	if (mysqli_error($dbonlineserver) != "") {
	    echo "NO CONNECTION";
	    return;
	}

	$getnewtransid = getmaxsino($dbonlineserver,$lstIpall,$cashieridz);
 	echo $getnewtransid;
?>