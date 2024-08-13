<?php
date_default_timezone_set('Asia/Manila');
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

$pridz = $_POST["prid"];
$prid = 0;
$tsz = 0;
$total_amt = 0;

$display = "<table id='tbl_providet' class='table table-bordered table-sm' style='text-align: left; width:100%'>
				<thead class='thead-dark'>
					<tr>
						<th nowrap>PR ID</th>
						<th nowrap>ITEM ID</th>
						<th nowrap>ITEM CODE</th>
						<th nowrap>ITEM DESCRIPTION</th>
						<th nowrap>PR QTY</th>
						<th nowrap>SRP</th>
					</tr>
				</thead>
				<tbody>";

$print = "<div style='padding: 10px; font-weight: bold;'>PR ID: <span id='pr_id'></span></div>
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

$sql = "SELECT idxx, providetidz, pridz, itemidz, itemcode, itemdesc, prqty, sprice, cashieridz, tsz
			FROM mobilejaba.mobilevproduct
			WHERE pridz = '$pridz'";
$result = mysqli_query($dbonlineserver, $sql);

while($row = mysqli_fetch_array($result))
{
	$display .="<tr>
					<td nowrap>".$row["pridz"]."</td>
					<td nowrap>".$row["itemidz"]."</td>
					<td nowrap>".$row["itemcode"]."</td>
					<td nowrap>".$row["itemdesc"]."</td>
					<td nowrap>".$row["prqty"]."</td>
					<td nowrap>".$row["sprice"]."</td>
				</tr>";

	$prid = $row["pridz"];
	$tsz = date('Y-m-d', strtotime($row["tsz"]));
	$amount = $row["prqty"] * $row["sprice"];
	$total_amt += $amount;
	$print .="<tr>
				<td nowrap>".$row["itemdesc"]."</td>
				<td nowrap>".intval($row["prqty"])."</td>
				<td nowrap>".$row["sprice"]."</td>
				<td nowrap>".number_format($amount,2)."</td>
			</tr>";
}

$display .="</tbody></table>
<script>
	$(document).ready(function() {
		$('#tbl_providet').DataTable().destroy();
		$('#tbl_providet').DataTable({
			'order': [],
			aLengthMenu: [[-1],['ALL']],
			bInfo: false,
			bPaginate: false,
			scrollX: true,
			scrollY: 450,
			scrollCollapse: true
		});
    	});
</script>";

$print .="</tbody></table>
<script>
$('#pr_id').html('".$prid."');
$('#dated').html('".$tsz."');
$('#total_amt').html('".number_format($total_amt,2)."');
</script>";


// echo $display;
echo json_encode(array("tbl" => $display, "print" => $print));

mysqli_close($dbonlineserver);