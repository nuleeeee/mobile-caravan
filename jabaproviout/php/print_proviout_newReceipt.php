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

$var_invidz = $_POST['var_invidz'];
$prtransid = 0;
$tsz = 0;
$total_amt = 0;
$total_cash = 0;
$total_change = 0;

$print = "<div style='padding: 10px; font-weight: bold;'>DR ID: <span id='dr_id'></span></div>
		  <div style='padding: 10px; font-weight: bold;'>DATE: <span id='dated'></span></div>
		  <table id='tbl_providet_print' class='table-sm' style='text-align: left; width:100%'>
			<thead>
				<tr>
					<th nowrap>ITEM DESC</th>
					<th nowrap>QTY</th>
					<th nowrap>PRICE</th>
					<th nowrap>AMOUNT</th>
				</tr>
			</thead>
			<hr>
		  	<tbody>";

	$sql = "SELECT invdetidxx, invidz, itemidz, qty, sprice, itemcode, item, cashieridz, tsz 
			FROM mobilejaba.invdet
			LEFT OUTER JOIN
			(
				SELECT invidz as tmpinvidz, pridz, prdetidz, salesqty FROM mobilejaba.prsalesdetlink
			) as tmp1 ON tmp1.tmpinvidz = mobilejaba.invdet.invidz
			WHERE invidz = '$var_invidz'
			GROUP BY invdetidxx";
		
	$result = mysqli_query($dbonlineserver, $sql);
	while($row = $result->fetch_array())
	{
		$prtransid = $row["invidz"];
		$tsz = date('Y-m-d', strtotime($row["tsz"]));
		$amount = $row["qty"] * $row["sprice"];
		$total_amt += $amount;
		$print .="<tr>
					<td nowrap>".$row["item"]."</td>
					<td nowrap>".intval($row["qty"])."</td>
					<td nowrap>".$row["sprice"]."</td>
					<td nowrap>".number_format($amount,2)."</td>
				</tr>";
	}

	$get = "SELECT invidz, SUM(CASE WHEN dbcr = 'Cash' THEN credit ELSE 0 END) AS cash,
					 SUM(CASE WHEN dbcr = 'change' THEN credit ELSE 0 END) AS chnge 
			FROM mobilejaba.payt 
			WHERE invidz = '$var_invidz'
			GROUP BY invidz;";
	$getres = mysqli_query($dbonlineserver, $get);
	while ($rowx = $getres->fetch_array())
	{
		$total_cash = $rowx["cash"];
		$total_change = str_replace("-","",$rowx["chnge"]);
	}

$print .="</tbody></table>
<script>
$('#dr_id').html('".$prtransid."');
$('#dated').html('".$tsz."');
$('#total_amt').html('".number_format($total_amt,2)."');
$('#total_cash').html('".number_format($total_cash,2)."');
$('#total_change').html('".number_format($total_change,2)."');
</script>";

echo $print;