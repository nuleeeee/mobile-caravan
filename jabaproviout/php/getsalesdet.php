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
$scrpt= "";
$display = "
	<table id='salesdetgrd' class='table table-bordered table-sm' style='font-size: 12px;text-align: left; border-collapse: collapse;width:100%'>
		<thead class='thead-dark'>
			<tr>
				<th nowrap>ITEM STATUS</th>
				<th nowrap>ITEM DESCRIPTION</th>
				<th nowrap>ITEM CODE</th>
				<th nowrap>QTY</th>
				<th nowrap>PRICE</th>
				<th nowrap>GROSS</th>
				<th nowrap>NET</th>
				<th nowrap>VOID</th>
			</tr>
		</thead>
		<tbody>";

$sqlcmd = "SELECT sales_mbd$lstIpall.invdet.nanoidz,nano,sales_mbd$lstIpall.invdet.invidz,sales_mbd$lstIpall.invdet.invdetidxx,
itemidz,sprice,item,itemcode,qty,IF(ISNULL(mlidiscamt),0,mlidiscamt) + IF(ISNULL(suppdiscamt),0,suppdiscamt) as discamt,
IF(ISNULL(mlidiscpromoamt),0,mlidiscpromoamt) + IF(ISNULL(suppdiscpromoamt),0,suppdiscpromoamt) as discamtpromo,ROUND(qty * sprice,2) as grossamt,
ROUND((qty * sprice) - ((qty * IFNULL(mlidiscamt,0)) + (qty * IFNULL(suppdiscamt,0)) + (qty * IFNULL(mlidiscpromoamt,0)) + (qty * IFNULL(suppdiscpromoamt,0))),2) as netamt,
qty * IFNULL(mlidiscamt,0) as mlidisc,qty * IFNULL(suppdiscamt,0) as supdisc,qty * IFNULL(mlidiscpromoamt,0) as mlidiscpromo,qty * IFNULL(suppdiscpromoamt,0) as supdiscpromo FROM sales_mbd$lstIpall.invdet
INNER JOIN vlookup_mcore.vnano ON vlookup_mcore.vnano.idxx = sales_mbd$lstIpall.invdet.nanoidz
LEFT OUTER JOIN
(
	SELECT invdetidxx,mlidiscamt,suppdiscamt FROM sales_mbd$lstIpall.disc WHERE invidz = $var_invidz
)as salesdisc ON salesdisc.invdetidxx = sales_mbd$lstIpall.invdet.invdetidxx
LEFT OUTER JOIN sales_mbd$lstIpall.discpromo ON sales_mbd$lstIpall.discpromo.invdetidxx = sales_mbd$lstIpall.invdet.invdetidxx
LEFT OUTER JOIN sales_mbd$lstIpall.seniordisc ON sales_mbd$lstIpall.seniordisc.invdetidxx = sales_mbd$lstIpall.invdet.invdetidxx
WHERE sales_mbd$lstIpall.invdet.invidz = $var_invidz
ORDER BY sales_mbd$lstIpall.invdet.tsz DESC";
$resultx = mysqli_query($dbonlineserver, $sqlcmd);
$counter = 0;
$totalsales =0;
$totalnet = 0;
$totalmli = 0;
$totalsup = 0;
$totalmlipromo = 0;
$totasuppromo = 0;
$fordelstatus = 0;
while($rowx = $resultx->fetch_array())
{
	$totalmli = $totalmli + $rowx["mlidisc"];
	$totalsup = $totalsup + $rowx["supdisc"];
	$totalsales = $totalsales + $rowx["grossamt"];
	$totalnet = $totalnet + $rowx["netamt"];
	$totalmlipromo = $totalmlipromo + $rowx["mlidiscpromo"];
	$totasuppromo = $totasuppromo + $rowx["supdiscpromo"];
	$classheader = "";
	if($rowx["nanoidz"] == 2)
	{
		$fordelstatus = 1;
	}
	
	if($counter ==0)
	{
		$classheader = "table-active";
	}
	if($rowx["qty"] > 0 )
	{
		$display .="<tr class='$classheader'>
					<td nowrap>".$rowx["nano"]."</td>
					<td nowrap>".$rowx["item"]."</td>
					<td nowrap>".$rowx["itemcode"]."</td>
					<td nowrap>".$rowx["qty"]."</td>
					<td nowrap>".$rowx["sprice"]."</td>
					<td style='font-size:15px;' nowrap><b>".$rowx["grossamt"]."</b></td>
					<td style='font-size:15px;' nowrap><b>".$rowx["netamt"]."</b></td>
					<td style='text-align: center;' nowrap>
						<btn class='btn btn-danger btn-sm' name='radiosalesdet' onclick='setvoid(".$rowx["invidz"].",".$rowx["invdetidxx"].",".$rowx["qty"].",".$rowx["itemidz"].",\"".mysqli_real_escape_string($dbonlineserver,str_replace("'",
					"",$rowx["itemcode"]) )."\")'>
							Remove
						</button>
					</td>
					</tr>";
	}
	if($rowx["qty"] > 0)
	{
		$counter = $counter + 1;
	}
}
$totalnetformat = number_format($totalnet,2,'.',',');
$scrpt = "var_itemcount = $counter;
$('#lbl_item_cnt').html('$counter');
$('#txt_net').html('$totalnetformat');
var_payable = $totalnet;
var_grosspayable =$totalsales;
var_totalmlidisc = $totalmli;
var_totalsupdisc = $totalsup;
var_totalmlidiscpromo = $totalmlipromo;
var_totalsupdiscpromo = $totasuppromo;
var_fordelstatus = $fordelstatus;";
$display .="</tbody></table>
<script>
$scrpt
</script>";


echo $display;

mysqli_close($dbonlineserver);
?>
