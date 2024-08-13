<?php
include "../../php/allfunction.php";
date_default_timezone_set('Asia/Manila');

$brlogin = $_POST['branch'];

$briptosave = check_user_branch($brlogin);

define('DB_SERVERONLINE', $briptosave);
$dbonlineserver = mysqli_connect(DB_SERVERONLINE, DB_USERNAME, DB_PASSWORD);

// Check the connection
if (mysqli_error($dbonlineserver) != "") {
    echo "NO CONNECTION";
    return;
}

$cashieridz = $_SESSION['login_user'];
$formidz = 1;

$var_pridz = $_POST["var_pridz"];
$var_invidz = $_POST["var_invidz"];

$var_couponidxx = $_POST["var_couponidxx"];

$sqlcommand = "SELECT invidxx,ptsnameidxx,ROUND(credit/amountdiv,2) as ptsprovi,provipts FROM sales_mbd$lstIpall.payt
INNER JOIN
(
	SELECT invidz,pridz FROM mobilejaba.tmp_prsalesdetlink WHERE pridz = $var_pridz AND invidz = $var_invidz GROUP BY invidz
)as tblsales ON tblsales.invidz = sales_mbd$lstIpall.payt.invidz
INNER JOIN sales_mbd.ptsearned ON sales_mbd.ptsearned.invidxx = tblsales.pridz
INNER JOIN vlookup_mbd.loyalty_member ON vlookup_mbd.loyalty_member.nameidxx = sales_mbd.ptsearned.ptsnameidxx
WHERE dbcridz = 101 AND provistatus = 0 AND provipts > 0 AND sales_mbd$lstIpall.payt.invidz = $var_invidz";
$result = mysqli_query($dbonlineserver, $sqlcommand);
while($row = $result->fetch_array())
{
	$paytdetinvidz = $row["invidxx"];
	$paytdetnameidxx = $row["ptsnameidxx"];
	$provipts = $row["ptsprovi"];
	$ptsprovi = $row["provipts"];
	if($provipts == $ptsprovi)
	{
		$sql = "UPDATE mobilejaba.ptsearned SET provistatus = 1,provipts = provipts - $provipts WHERE invidxx = $paytdetinvidz;";
		mysqli_query($dbonlineserver, $sql);
	}
	else
	{
		$sql = "UPDATE mobilejaba.ptsearned SET provipts = provipts - $provipts WHERE invidxx = $paytdetinvidz;";
		mysqli_query($dbonlineserver, $sql);
	}


	$sql ="UPDATE vlookup_mbd.loyalty_member SET points_earned = points_earned + $provipts,last_modified= now() WHERE nameidxx = $paytdetnameidxx";
	mysqli_query($dbonlineserver, $sql);

	$provimaxidxx = getId($dbonlineserver,"sales_mbd","ptsprovi","ptspridxx",$formidz);

	$insertcommand = "INSERT IGNORE INTO mobilejaba.ptsprovi (ptspridxx,pridxx,invidz,provipts,ptsnameidxx,cashieridz,tsz) VALUES ($provimaxidxx,$var_pridz,$var_invidz,$provipts,$paytdetnameidxx,$cashieridz,now())";
	mysqli_query($dbonlineserver,$insertcommand);
}


//PAYMENT ALL
$sqlcommand = "SELECT ptsnameidxx,SUM(ptscod) as ptscod,SUM(ptsearned) as ptsearned FROM
(
	SELECT ptsnameidxx,ROUND(credit/amountdiv,2) as ptscod,0 as ptsearned FROM sales_mbd$lstIpall.payt
	INNER JOIN
	(
		SELECT invidz,pridz FROM mobilejaba.tmp_prsalesdetlink WHERE pridz = $var_pridz AND invidz = $var_invidz GROUP BY invidz
	)as tblsales ON tblsales.invidz = sales_mbd$lstIpall.payt.invidz
	INNER JOIN sales_mbd.ptsearned ON sales_mbd.ptsearned.invidxx = tblsales.pridz
	INNER JOIN vlookup_mbd.loyalty_member ON vlookup_mbd.loyalty_member.nameidxx = sales_mbd.ptsearned.ptsnameidxx
	WHERE dbcridz = 4 AND sales_mbd$lstIpall.payt.invidz = $var_invidz
	UNION ALL
	SELECT ptsnameidxx,ptscod,ROUND(IFNULL(SUM(ptsearned),0)/amountdiv,2) as ptsearned FROM
	(
		SELECT ptsnameidxx,0 as ptscod,credit as ptsearned,amountdiv FROM sales_mbd$lstIpall.payt
		INNER JOIN
		(
			SELECT invidz,pridz FROM mobilejaba.tmp_prsalesdetlink WHERE pridz = $var_pridz AND invidz = $var_invidz GROUP BY invidz
		)as tblsales ON tblsales.invidz = sales_mbd$lstIpall.payt.invidz
		INNER JOIN sales_mbd.ptsearned ON sales_mbd.ptsearned.invidxx = tblsales.pridz
		INNER JOIN vlookup_mbd.loyalty_member ON vlookup_mbd.loyalty_member.nameidxx = sales_mbd.ptsearned.ptsnameidxx
		WHERE dbcridz IN (1,2,3,34) AND sales_mbd$lstIpall.payt.invidz = $var_invidz
	)as ptsall
)as ptsallfnal";
$result = mysqli_query($dbonlineserver, $sqlcommand);
while($row = $result->fetch_array())
{
	$paytdetnameidxx = $row["ptsnameidxx"];
	$ptscod = $row["ptscod"];
	$ptsearned = $row["ptsearned"];

	if (empty($paytdetnameidxx)) {
		// code...
	} else {

	$insertcommand = "INSERT IGNORE INTO mobilejaba.ptsearned (invidxx,codpts,codstatus,provipts,provistatus,earnpts,ptsnameidxx,nameidz,cashieridz,tsz) VALUES ($var_invidz,$ptscod,0,0,0,$ptsearned,$paytdetnameidxx,1,$cashieridz,now())";
	mysqli_query($dbonlineserver,$insertcommand);

	$sql ="UPDATE vlookup_mbd.loyalty_member SET points_earned = points_earned + $ptsearned,last_modified= now() WHERE nameidxx = $paytdetnameidxx";
	mysqli_query($dbonlineserver, $sql);

	}
}

$sqlcommand = "INSERT IGNORE INTO mobilejaba.inv (invidxx,nameidz,ipadrs,cashieridz,tsz)
SELECT invidxx,nameidz,ipadrs,cashieridz,tsz FROM sales_mbd$lstIpall.inv";
mysqli_query($dbonlineserver,$sqlcommand);

$sqlcommand = "INSERT IGNORE INTO mobilejaba.invdet (invdetidxx,invidz,itemidz,qty,sprice,itemcode,item,bxstatus,vbprice,vsprice,sino,nanoidz,formidz,ipadrs,cashieridz,tsz)
SELECT invdetidxx,invidz,itemidz,qty,sprice,itemcode,item,bxstatus,vbprice,vsprice,sino,nanoidz,formidz,ipadrs,cashieridz,tsz FROM sales_mbd$lstIpall.invdet";
mysqli_query($dbonlineserver,$sqlcommand);

$sqlcommand = "INSERT IGNORE INTO mobilejaba.discpromo (discpromoidxx,invidz,invdetidxx,mlidiscpromoamt,suppdiscpromoamt,formidz,ipadrs,cashieridz,tsz)
SELECT discpromoidxx,invidz,invdetidxx,mlidiscpromoamt,suppdiscpromoamt,formidz,ipadrs,cashieridz,tsz FROM sales_mbd$lstIpall.discpromo";
mysqli_query($dbonlineserver,$sqlcommand);

$sqlcommand = "INSERT IGNORE INTO mobilejaba.prsalesdetlink (invdetidxx,invidz,pridz,prdetidz,item,itemcode,salesqty,formidz,ipadrs,cashieridz,tsz)
SELECT invdetidxx,invidz,pridz,prdetidz,item,itemcode,salesqty,formidz,ipadrs,cashieridz,tsz FROM mobilejaba.tmp_prsalesdetlink";
mysqli_query($dbonlineserver,$sqlcommand);

$sqlcommand = "INSERT IGNORE INTO mobilejaba.ccdetails (creditidxx,invidz,bankname,bankid,reference,formidz,ipadrs,cashieridz,tsz)
SELECT creditidxx,invidz,bankname,bankid,reference,formidz,ipadrs,cashieridz,tsz FROM sales_mbd$lstIpall.ccdetails";
mysqli_query($dbonlineserver,$sqlcommand);

$countererror = 0;
$cnttmp = 0;
$cntmcore= 0;

$sqlcommand = "INSERT IGNORE INTO mobilejaba.discpin (discidxx,invdetidxx,officeridz,cashieridz,tsz)
SELECT discidxx,invdetidxx,officeridz,cashieridz,tsz FROM sales_mbd$lstIpall.discpin";
mysqli_query($dbonlineserver,$sqlcommand);

$sqlcommand = "SELECT * FROM sales_mbd$lstIpall.discpin";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cnttmp = mysqli_num_rows($result);

$sqlcommand = "SELECT * FROM sales_mbd.discpin WHERE discidxx IN (SELECT discidxx FROM sales_mbd$lstIpall.discpin)";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cntmcore = mysqli_num_rows($result);

if($cnttmp <> $cntmcore)
{
	$countererror = 1;
}

$sqlcommand = "INSERT IGNORE INTO mobilejaba.disc (discidxx,invidz,invdetidxx,mlidiscamt,suppdiscamt,discstats,formidz,ipadrs,cashieridz,tsz)
SELECT discidxx,invidz,invdetidxx,mlidiscamt,suppdiscamt,discstats,formidz,ipadrs,cashieridz,tsz FROM sales_mbd$lstIpall.disc";
mysqli_query($dbonlineserver,$sqlcommand);

$sqlcommand = "SELECT * FROM sales_mbd$lstIpall.disc";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cnttmp = mysqli_num_rows($result);

$sqlcommand = "SELECT * FROM sales_mbd.disc WHERE discidxx IN (SELECT discidxx FROM sales_mbd$lstIpall.disc)";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cntmcore = mysqli_num_rows($result);

if($cnttmp <> $cntmcore)
{
	$countererror = 1;
}

$sqlcommand = "INSERT IGNORE INTO mobilejaba.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz)
SELECT paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz FROM sales_mbd$lstIpall.payt";
mysqli_query($dbonlineserver,$sqlcommand);

$sqlcommand = "SELECT * FROM sales_mbd$lstIpall.payt WHERE dbcridz = 3";
$result = mysqli_query($dbonlineserver, $sqlcommand);
while($row = $result->fetch_array())
{
	$sql = "UPDATE mobilejaba.creditcarddet SET paytidxx = ".$row["paytidxx"].",status = 1 WHERE ccdetidxx = $var_ccdetidxx";
	mysqli_query($dbonlineserver, $sql);
}

$sqlcommand = "SELECT * FROM sales_mbd$lstIpall.payt WHERE dbcridz = 125";
$result = mysqli_query($dbonlineserver, $sqlcommand);
while($row = $result->fetch_array())
{
	$sql = "UPDATE mobilejaba.payt SET soaba = 1,paidba = 1 WHERE paytidxx = $var_couponidxx";
	mysqli_query($dbonlineserver, $sql);

	$couidxx = getId($dbonlineserver,"sales_mbd","used_coupon","couponidxx",$formidz);
	$insertusedcoupon = "INSERT INTO mobilejaba.used_coupon (couponidxx,transid,couponid,tsz) VALUES ($couidxx,$var_invidz,$var_couponidxx,now());";
	mysqli_query($dbonlineserver, $insertusedcoupon);
}


$sqlcommand = "SELECT * FROM sales_mbd$lstIpall.payt";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cnttmp = mysqli_num_rows($result);

$sqlcommand = "SELECT * FROM sales_mbd.payt WHERE paytidxx IN (SELECT paytidxx FROM sales_mbd$lstIpall.payt)";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cntmcore = mysqli_num_rows($result);

if($cnttmp <> $cntmcore)
{
	$countererror = 1;
}

$sqlcommand = "INSERT IGNORE INTO mobilejaba.invdelinfo (delinfoidxx,invidxx,nameidz,ipadrs,cashieridz,tsz)
SELECT delinfoidxx,invidxx,nameidz,ipadrs,cashieridz,tsz FROM sales_mbd$lstIpall.invdelinfo";
mysqli_query($dbonlineserver,$sqlcommand);

$sqlcommand = "SELECT * FROM sales_mbd$lstIpall.invdelinfo";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cnttmp = mysqli_num_rows($result);

$sqlcommand = "SELECT * FROM sales_mbd.invdelinfo WHERE delinfoidxx IN (SELECT delinfoidxx FROM sales_mbd$lstIpall.invdelinfo)";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cntmcore = mysqli_num_rows($result);

if($cnttmp <> $cntmcore)
{
	$countererror = 1;
}

//COD APPROVE
$sqlcommand = "INSERT IGNORE INTO mobilejaba.codapprove (approveidxx,nameidz,invidz,cashieridz,tsz)
SELECT approveidxx,nameidz,invidz,cashieridz,tsz FROM sales_mbd$lstIpall.codapprove";
mysqli_query($dbonlineserver,$sqlcommand);

$sqlcommand = "SELECT * FROM sales_mbd$lstIpall.codapprove";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cnttmp = mysqli_num_rows($result);

$sqlcommand = "SELECT * FROM sales_mbd.codapprove WHERE approveidxx IN (SELECT approveidxx FROM sales_mbd$lstIpall.codapprove)";
$result = mysqli_query($dbonlineserver, $sqlcommand);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cntmcore = mysqli_num_rows($result);

if($cnttmp <> $cntmcore)
{
	$countererror = 1;
}

echo $countererror;
mysqli_close($dbonlineserver);

?>