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

$formidz = 1;

$sql = "TRUNCATE sales_mbd$lstIpall.payt";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.invdelinfo";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.ccdetails";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.creditcardapprov";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.ccdetails";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.codapprove";
mysqli_query($dbonlineserver, $sql);

$var_pridz = $_POST["var_pridz"];
$var_invidz = $_POST["var_invidz"];
$var_grosspayable = $_POST["var_grosspayable"];
$var_totalmlidisc = $_POST["var_totalmlidisc"];
$var_totalsupdisc = $_POST["var_totalsupdisc"];
$var_invno =  $_POST["var_invno"];
$var_soldtoidz =  $_POST["var_soldtoidz"];
$var_totalmlidiscpromo =  $_POST["var_totalmlidiscpromo"];
$var_totalsupdiscpromo =  $_POST["var_totalsupdiscpromo"];
//VAT
//$var_status = $_POST["var_status"];

$var_nonvat = $_POST["var_nonvat"];
$var_2307 = $_POST["var_2307"];
$var_2306 = $_POST["var_2306"];

$paytidx = getId($dbonlineserver,"mobilejaba","payt","paytidxx",$formidz);

$insert  = "INSERT INTO sales_mbd$lstIpall.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz)
VALUES ($paytidx,$var_invidz,$var_soldtoidz,14,'CofGSo',date(now()),$var_grosspayable,0,'$var_invno',0,0,$formidz,$lstIpall,$cashieridz,now());";
mysqli_query($dbonlineserver, $insert);

/*if($var_totalmlidisc>0)
{
	$paytidx = getId($dbonlineserver,"sales_mbd$lstIpall","payt","paytidxx",$formidz);
	$insert  = "INSERT INTO sales_mbd$lstIpall.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz)
	VALUES ($paytidx,$var_invidz,$var_soldtoidz,9,'mlidsc',date(now()),0,$var_totalmlidisc,'$var_invno',0,0,$formidz,$lstIpall,$cashieridz,now());";
	mysqli_query($dbonlineserver, $insert);
}
if($var_totalsupdisc>0)
{
	$paytidx = getId($dbonlineserver,"sales_mbd$lstIpall","payt","paytidxx",$formidz);
	$insert  = "INSERT INTO sales_mbd$lstIpall.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz)
	VALUES
	($paytidx,$var_invidz,$var_soldtoidz,10,'supdsc',date(now()),0,$var_totalsupdisc,'$var_invno',0,0,$formidz,$lstIpall,$cashieridz,now());";
	mysqli_query($dbonlineserver, $insert);
}

if($var_totalmlidiscpromo > 0)
{
	$paytidx = getId($dbonlineserver,"sales_mbd$lstIpall","payt","paytidxx",$formidz);
	$insert  = "INSERT INTO sales_mbd$lstIpall.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz)
	VALUES
	($paytidx,$var_invidz,$var_soldtoidz,11,'spdismil',date(now()),0,$var_totalmlidiscpromo,'$var_invno',0,0,$formidz,$lstIpall,$cashieridz,now());";
	mysqli_query($dbonlineserver, $insert);
}

if($var_totalsupdiscpromo > 0)
{
	$paytidx = getId($dbonlineserver,"sales_mbd$lstIpall","payt","paytidxx",$formidz);
	$insert  = "INSERT INTO sales_mbd$lstIpall.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz)
	VALUES
	($paytidx,$var_invidz,$var_soldtoidz,12,'spdissupp',date(now()),0,$var_totalsupdiscpromo,'$var_invno',0,0,$formidz,$lstIpall,$cashieridz,now());";
	mysqli_query($dbonlineserver, $insert);
}*/

$vatpayable = $var_grosspayable - ($var_totalmlidisc + $var_totalsupdisc + $var_totalmlidiscpromo + $var_totalsupdiscpromo);

$grosstax = 0;
$taxdbcrid = 0;
$taxdbcr = "";

$grosstax2306=0;
$grosstax2307=0;
$grossvat = 0;

if($var_2307 == 1)
{
	$grosstax = ($vatpayable/1.12)*(0.01);
	$grosstax2307 = $grosstax;
	$taxdbcrid = 115;
	$taxdbcr = "TX2307";

	$paytidx = getId($dbonlineserver,"sales_mbd$lstIpall","payt","paytidxx",$formidz);

	$insert  = "INSERT INTO sales_mbd$lstIpall.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz)
		VALUES($paytidx,$var_invidz,$var_soldtoidz,$taxdbcrid,'$taxdbcr',date(now()),0,$grosstax,'$var_invno',0,0,$formidz,$lstIpall,$cashieridz,now());";
		mysqli_query($dbonlineserver, $insert);
}

if ($var_2306 == 1)
{
	$grosstax = ($vatpayable/1.12)*(0.05);
	$grosstax2306 = $grosstax;
	$taxdbcrid = 114;
	$taxdbcr = "TX2306";

	$paytidx = getId($dbonlineserver,"sales_mbd$lstIpall","payt","paytidxx",$formidz);

	$insert  = "INSERT INTO sales_mbd$lstIpall.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz)
		VALUES($paytidx,$var_invidz,$var_soldtoidz,$taxdbcrid,'$taxdbcr',date(now()),0,$grosstax,'$var_invno',0,0,$formidz,$lstIpall,$cashieridz,now());";
		mysqli_query($dbonlineserver, $insert);
}

if ($var_nonvat == 1)
{
	$grosstax = ($var_grosspayable/1.12)*(0.12);
	$grossvat = $grosstax;
	$taxdbcrid = 89;
	$taxdbcr = "nonvat";

	$paytidx = getId($dbonlineserver,"sales_mbd$lstIpall","payt","paytidxx",$formidz);

	$insert  = "INSERT INTO sales_mbd$lstIpall.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz)
		VALUES($paytidx,$var_invidz,$var_soldtoidz,$taxdbcrid,'$taxdbcr',date(now()),0,$grosstax,'$var_invno',0,0,$formidz,$lstIpall,$cashieridz,now());";
		mysqli_query($dbonlineserver, $insert);
}

mysqli_close($dbonlineserver);
?>