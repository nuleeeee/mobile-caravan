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

	$var_code = number_format($_POST['var_code'],2,'.','');
	$var_randcode = $_POST['var_randcode'];

	list($integer, $fraction) = explode(".", (string) $var_code);
	$var_code = str_pad($integer, STR_PAD_LEFT);
	$decimal = "";
	if ($fraction > 0)
    {
		for ($i = 0; $i < strlen($fraction); $i++)
		{
			$decimal .= $fraction{$i};
		}
	}
	else
	{
		$decimal = 0;
	}

	$codex = ($var_code * 8)/ $var_randcode;
	$codexxtmp = round($codex,0);
	$codexx = substr($codexxtmp, 0, 6);
	$suppamt = substr($codexxtmp, 6);



	$sqlcommand = "SELECT * FROM vlookup_mcore.vnamenew WHERE pin = '" . $codexx . "' AND hide = 0";
	$result = mysqli_query($dbonlineserver, $sqlcommand);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	$count = mysqli_num_rows($result);
	if($count<=0)
	{
		echo -1;
		return;
	}
	$nameid = $row['nameidxx'];
	$positionid = $row["positionidz"];
	if($positionid >= 66 && $positionid <= 70)
	{
		echo $suppamt.'.'.$decimal;
	}
	else
	{
		echo -2;
	}
?>