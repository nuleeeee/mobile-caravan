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

$formidz = 1;
$cashieridz = $_SESSION['login_user'];

$var_invidz = $_POST["var_invidz"];
$dbcridz = $_POST["dbcridz"];
$dbcr = $_POST["dbcr"];
$amt = $_POST["amt"];
$var_invno = $_POST["var_invno"];
$var_payable = $_POST["var_payable"];
$var_chkdate = $_POST["var_chkdate"];
$var_soldtoidz = $_POST["var_soldtoidz"];
$var_delinfonameidxx = $_POST["var_delinfonameidxx"];
$cnt = 0;
$sqlcmd = "SELECT * FROM sales_mbd$lstIpall.payt";
$resultx = mysqli_query($dbonlineserver, $sqlcmd);
$cnt =mysqli_num_rows($resultx);
$srpt ="";
$paytidxx = getId($dbonlineserver,"sales_mbd" . $lstIpall,"payt","paytidxx",$formidz);
$var_payable = $var_payable - $amt;


$insert = "INSERT INTO sales_mbd$lstIpall.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz) VALUES($paytidxx,$var_invidz,$var_soldtoidz,$dbcridz,'$dbcr','$var_chkdate',0,$amt,'$var_invno',0,0,$formidz,$lstIpall,$cashieridz,now());";
mysqli_query($dbonlineserver, $insert);

$updatesalesinv = "UPDATE sales_mbd$lstIpall.inv SET nameidz = $var_soldtoidz WHERE invidxx = $var_invidz";
mysqli_query($dbonlineserver, $updatesalesinv);

if($dbcridz == 3)
{
	$var_bankname = $_POST["var_bankname"];
	$var_bankid = $_POST["var_bankid"];
	$var_bankreference = $_POST["var_bankreference"];
	$insert = "INSERT INTO sales_mbd$lstIpall.ccdetails (creditidxx,invidz,bankname,bankid,reference,formidz,ipadrs,cashieridz,tsz) VALUES($paytidxx,$var_invidz,'$var_bankname',$var_bankid,'$var_bankreference',$formidz,$lstIpall,$cashieridz,now());";
	mysqli_query($dbonlineserver, $insert);
}

if($dbcridz == 4)
{
	$var_codnameidz = $_POST["var_codnameidz"];
	$approvid = getId($dbonlineserver,"sales_mbd","codapprove","approveidxx",$formidz);
	$insert = "INSERT INTO sales_mbd$lstIpall.codapprove (approveidxx,nameidz,invidz,cashieridz,tsz) VALUES($approvid,$var_codnameidz,$var_invidz,$cashieridz,now());";
	mysqli_query($dbonlineserver, $insert);
}

if($dbcridz == 1)
{
	if($var_payable < 0)
	{
		$cashchange = $var_payable * -1;
		$paytidxx = getId($dbonlineserver,"sales_mbd" . $lstIpall,"payt","paytidxx",$formidz);
		$insert = "INSERT INTO sales_mbd$lstIpall.payt (paytidxx,invidz,nameidz,dbcridz,dbcr,chkdate,debit,credit,sino,soaba,paidba,formidz,ipadrs,cashieridz,tsz) VALUES($paytidxx,$var_invidz,$var_soldtoidz,$dbcridz,'change','$var_chkdate',0,$var_payable,'$var_invno',0,0,$formidz,$lstIpall,$cashieridz,now());";
		mysqli_query($dbonlineserver, $insert);

		$srpt ="$('#txt_cashchange').val('$cashchange');
				$('#btn_printcash').prop('disabled', false);";
	}
	else if($var_payable==0)
	{
		$srpt ="$('#btn_printcash').prop('disabled', false);";
	}
	else
	{
		$srpt ="$('#endtrans').modal('show');
				$('#modal_cashpayt').modal('hide');
				$('#btn_printcash').prop('disabled', true);";
	}
}
else if($dbcridz == 2)
{
	if($var_payable > 0)
	{
		$srpt ="$('#endtrans').modal('show');
				$('#modal_chequepayt').modal('hide');
				$('#print_cheque').prop('disabled', true);";
	}
}
else if($dbcridz == 3)
{

	if($var_payable > 0)
	{
		$srpt ="$('#endtrans').modal('show');
				$('#modal_creditcardpayt').modal('hide');
				$('#btn_printcreditcard').prop('disabled', true);";
	}
}
else if($dbcridz == 4)
{
	if($var_payable > 0)
	{
		$srpt ="$('#endtrans').modal('show');
				$('#modal_codpayt').modal('hide');
				$('#btn_printcod').prop('disabled', true);";
	}
}
else if($dbcridz == 5)
{
	if($var_payable > 0)
	{
		$srpt ="$('#endtrans').modal('show');
				$('#modal_arpayt').modal('hide');
				$('#btn_printar').prop('disabled', true);";
	}
}
else if($dbcridz == 34)
{
	if($var_payable > 0)
	{
		$srpt ="$('#endtrans').modal('show');
				$('#modal_banktranspayt').modal('hide');
				$('#btn_printbanktrans').prop('disabled', true);";
	}
}
else if($dbcridz == 125)
{
	if($var_payable > 0)
	{
		$srpt ="$('#endtrans').modal('show');
				$('#modal_couponpayt').modal('hide');
				$('#btn_printbanktrans').prop('disabled', true);";
	}
}
if($var_delinfonameidxx >0)
{
	$delinfoidxx = getId($dbonlineserver,"sales_mbd","invdelinfo","delinfoidxx",$formidz);
	$insertdelinfo = "INSERT INTO sales_mbd$lstIpall.invdelinfo (delinfoidxx,invidxx,nameidz,ipadrs,cashieridz,tsz) VALUES($delinfoidxx,$var_invidz,$var_delinfonameidxx,$lstIpall,$cashieridz,now());";
	mysqli_query($dbonlineserver, $insertdelinfo);
}
$display = "<script>
$srpt
</script>";
echo $display;
mysqli_close($dbonlineserver);

?>