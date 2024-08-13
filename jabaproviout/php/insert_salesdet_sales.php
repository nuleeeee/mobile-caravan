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

$var_invidz = $_POST["var_invidz"];
$var_soldtoidz = $_POST["var_soldtoidz"];
$var_invno =  $_POST["var_invno"];
$var_itemidz =  $_POST["var_itemidz"];
$var_bpitem = $_POST["var_bpitem"];
$var_srpitem = $_POST["var_srpitem"];
$var_invprice = $_POST["var_invprice"];
$var_qty =  $_POST["var_qty"];
$var_nanoidz =  $_POST["var_nanoidz"];
$var_item = $_POST["var_item"];
$var_item = str_replace("'","\'",$var_item);
$var_itemcode = $_POST["var_itemcode"];
$var_bxdisc = $_POST["var_bxdisc"];
$var_autodisc = $_POST["var_autodisc"];
$var_pridz = $_POST["var_pridz"];

$formidz = 1;
$cashieridz = $_SESSION['login_user'];

$sqlcommand = "SELECT * FROM sales_mbd$lstIpall.inv WHERE invidxx = $var_invidz";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);
if($count<=0)
{
	$insertinvoice = "INSERT INTO sales_mbd$lstIpall.inv (invidxx,nameidz,ipadrs,cashieridz,tsz) VALUES ($var_invidz,$var_soldtoidz,$lstIpall,$cashieridz,now());";
	mysqli_query($dbonlineserver, $insertinvoice);
}

$sqlcommand = "SELECT * FROM sales_mbd$lstIpall.invdet";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cnt = mysqli_num_rows($result);

$invdetidxx = getId($dbonlineserver,"mobilejaba","invdet","invdetidxx",$formidz) + $cnt;

$insertsalesdet = "INSERT INTO sales_mbd$lstIpall.invdet (invdetidxx,invidz,itemidz,qty,sprice,itemcode,item,bxstatus,vbprice,vsprice,sino,nanoidz,formidz,ipadrs,cashieridz,tsz) VALUES ($invdetidxx,$var_invidz,$var_itemidz,$var_qty,$var_invprice,'$var_itemcode','$var_item',0,$var_bpitem,$var_srpitem,'$var_invno',$var_nanoidz,$formidz,$lstIpall,$cashieridz,now())";
mysqli_query($dbonlineserver, $insertsalesdet);

$insertlink = "INSERT INTO mobilejaba.tmp_prsalesdetlink (invdetidxx,invidz,pridz,prdetidz,item,itemcode,salesqty,formidz,ipadrs,cashieridz,tsz) VALUES ($invdetidxx,$var_invidz,$var_pridz,0,'$var_item','$var_itemcode',$var_qty,$formidz,$lstIpall,$cashieridz,now())";
mysqli_query($dbonlineserver, $insertlink);

if($var_autodisc == 1)
{
	// $var_mlidiscpromo = checkautodisc($dbonlineserver,$var_itemidz,$var_invprice,1);
	// $var_supdiscpromo = checkautodisc($dbonlineserver,$var_itemidz,$var_invprice,0);

	$var_mlidiscpromo = 0;
	$var_supdiscpromo = 0;

	if($var_mlidiscpromo<=0)
	{
		$var_mlidiscpromo =  0;
	}
	if($var_supdiscpromo<=0)
	{
		$var_supdiscpromo =  0;
	}

	if($var_mlidiscpromo > 0 ||  $var_supdiscpromo >0)
	{
		$sqlcommand = "SELECT * FROM sales_mbd$lstIpall.discpromo";
		$result = mysqli_query($dbonlineserver, $sqlcommand);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$cntpromo = mysqli_num_rows($result);

		$discpromoidxx = getId($dbonlineserver,"sales_mbd","discpromo","discpromoidxx",$formidz) + $cntpromo;
		$insertpromo  = "INSERT INTO sales_mbd$lstIpall.discpromo (discpromoidxx,invidz,invdetidxx,mlidiscpromoamt,suppdiscpromoamt,formidz,ipadrs,cashieridz,tsz) VALUES
	($discpromoidxx,$var_invidz,$invdetidxx,$var_mlidiscpromo,$var_supdiscpromo,$formidz,$lstIpall,$cashieridz,now());";
		mysqli_query($dbonlineserver, $insertpromo);
	}
}


mysqli_close($dbonlineserver);

?>