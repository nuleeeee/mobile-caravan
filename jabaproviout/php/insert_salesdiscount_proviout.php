<?php
include "../../php/allfunction.php";
$cashieridz = $_SESSION['login_user'];
$formidz = 1;

$invidz = $_POST["invidz"];
$invdetid = $_POST["invdetid"];
$tmp_mli = $_POST["tmp_mli"];
$tmp_sup = $_POST["tmp_sup"];
$var_discountpinidz = $_POST["var_discountpinidz"];

$cnt = 0;
$sqlcmd = "SELECT * FROM sales_mbd$lstIpall.disc";
$resultx = mysqli_query($db, $sqlcmd);
$cnt =mysqli_num_rows($resultx);

$discidxx = 0;
if($cnt > 0)
{
	$discidxx = getId($db,"sales_mbd" . $lstIpall,"disc","discidxx",$formidz); 
}
else
{
	$discidxx = getId($db,"sales_mbd","disc","discidxx",$formidz); 
}

$insertsalesdisc = "INSERT INTO sales_mbd$lstIpall.disc (discidxx,invidz,invdetidxx,mlidiscamt,suppdiscamt,discstats,formidz,ipadrs,cashieridz,tsz) VALUES ($discidxx,$invidz,$invdetid,$tmp_mli,$tmp_sup,0,$formidz,$lstIpall,$cashieridz,now())";
mysqli_query($db, $insertsalesdisc);

$insertsalesdisc = "INSERT INTO sales_mbd$lstIpall.discpin (discidxx,invdetidxx,officeridz,cashieridz,tsz) VALUES ($discidxx,$invdetid,$var_discountpinidz,$cashieridz,now())";
mysqli_query($db, $insertsalesdisc);

mysqli_close($db);

?>