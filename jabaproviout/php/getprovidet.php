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

$var_pridz = $_POST["var_pridz"];

$display = "
	<table id='providetgrd' class='table table-bordered table-sm' style='font-size: 12px;text-align: left; border-collapse: collapse;width:100%'>
		<thead class='thead-dark'>
			<tr>
				<th nowrap>ITEM DESCRIPTION</th>
				<th nowrap>TYPE</th>
				<th nowrap>PR QTY</th>
				<th nowrap>SALES</th>
				<th nowrap>REMAINING</th>
				<th nowrap>PRICE</th>
				<th nowrap>MBD DSCNT</th>
				<th nowrap>SUP DSCNT</th>
				<th nowrap>PROMO MBD</th>
				<th nowrap>PROMO SUP</th>
				<th nowrap>OUT</th>
				<th nowrap>FNX</th>
			</tr>
		</thead>
		<tbody>";

$sqlcmd = "SELECT  itemdesc,  itemcode,  sprice, providetidz, itemidz, pridz, prqty, prqty*sprice as amount,
mobilejaba.mobilevproduct.tsz, ifnull(salesqty, 0) as salesqty, prqty - ifnull(salesqty, 0) as remainingqty, returnedqty
FROM mobilejaba.mobilevproduct
LEFT OUTER JOIN
(
	SELECT IFNULL(SUM(salesqty), 0) as salesqty, prdetidz FROM mobilejaba.tmp_prsalesdetlink WHERE pridz = '$var_pridz'
	GROUP BY prdetidz
)as salesout ON salesout.prdetidz = mobilejaba.mobilevproduct.providetidz
LEFT OUTER JOIN
(
	SELECT SUM(returnedqty) as returnedqty, prdetidzz FROM provijaba_mbd.provi_qtyreturned WHERE prtransid = '$var_pridz' GROUP BY prdetidzz
)as qtyreturned ON qtyreturned.prdetidzz = mobilejaba.mobilevproduct.providetidz
where pridz = '$var_pridz'";
$resultx = mysqli_query($dbonlineserver, $sqlcmd);
$counter = 0;
while($rowx = $resultx->fetch_array())
{
		$providetidz = $rowx["providetidz"];
		$var_mlidisc = 0;
		$var_supdisc = 0;
		$var_mlidiscpromo = 0;
		$var_supdiscpromo = 0;
		if($rowx["remainingqty"] <= 0)
		{
			$display .="<tr style='background-color: red;'>";
		}
		else
		{
			$display .="<tr>";
		}
		$display .="<td nowrap>".$rowx["itemdesc"]."</td>
					<td nowrap>taken</td>
					<td nowrap>".$rowx["prqty"]."</td>
					<td nowrap>".$rowx["salesqty"]."</td>
					<td nowrap>".$rowx["remainingqty"]."</td>
					<td nowrap>".$rowx["sprice"]."</td>
					<td nowrap>".$var_mlidisc."</td>
					<td nowrap><b>".$var_supdisc."</b></td>
					<td nowrap><b>".$var_mlidiscpromo."</b></td>
					<td nowrap><b>".$var_supdiscpromo."</b></td>";
		if($rowx["remainingqty"] <= 0)
		{
			$display .="<td>TRANSACTED</td>
			<td>TRANSACTED</td>";
		}
		else
		{
			$display .="<td style='white-space: nowrap;min-width:100px;padding:5px;'><input class='form-control' id='txt_qty_".floor($providetidz)."' value='0.00'></td>
			<td style='white-space: nowrap;min-width:100px;padding:5px;'><button class='btn btn-primary w-100' id='btn_".floor($providetidz)."' onclick='addqty(\"".mysqli_real_escape_string($dbonlineserver,str_replace("'","",$rowx["itemdesc"]))."\",\"".mysqli_real_escape_string($dbonlineserver,str_replace("'","",$rowx["itemcode"]))."\",$providetidz,".$rowx["itemidz"].",".$rowx["sprice"].",".$rowx["sprice"].",".$rowx["sprice"].",\"".$rowx["returnedqty"]."\", ".$rowx["remainingqty"].")'>Add</Button></td>";
		}


		$display .="</tr>";
}

$display .="</tbody></table>
<script>

</script>";


echo $display;

mysqli_close($dbonlineserver);
?>
