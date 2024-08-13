<?php
include "../../php/allfunction.php";

$txt_prid = $_POST['txt_prid'];

$brlogin = $_POST['branch'];

$briptosave = check_user_branch($brlogin);

define('DB_SERVERONLINE', $briptosave);
$dbonlineserver = mysqli_connect(DB_SERVERONLINE, DB_USERNAME, DB_PASSWORD);

// Check the connection
if (mysqli_error($dbonlineserver) != "") {
    echo "NO CONNECTION";
    return;
}

$display = "<table id='tbl_fetch' class='table table-bordered table-sm' style='text-align: left; border-collapse: collapse;'>
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

	$get = "SELECT prdetidxx, pridz, itemidz, prqty, itemcode, item, vsprice, cashieridz, tsz
			FROM provijaba_mbd.providet
			WHERE pridz = '$txt_prid'";
	$getresult = mysqli_query($dbonlineserver, $get);

	while ($row = mysqli_fetch_array($getresult))
	{
		$display .= "<tr>
						<td nowrap>".$row["pridz"]."</td>
						<td nowrap>".$row["itemidz"]."</td>
						<td nowrap>".$row["itemcode"]."</td>
						<td nowrap>".$row["item"]."</td>
						<td nowrap>".$row["prqty"]."</td>
						<td nowrap>".$row["vsprice"]."</td>
					</tr>";
	}

	$display .= "</tbody>
			</table>
			<script>
				$(document).ready(function() {
					$('#tbl_fetch').DataTable({
						order: [],
						aLengthMenu: [[-1],['ALL']],
						bPaginate: false,
						bInfo: false,
						scrollX: true
					});
				});
			</script>";

echo $display;