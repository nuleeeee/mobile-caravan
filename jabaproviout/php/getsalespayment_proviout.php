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

$display = "
	<table id='salesdetgrd' class='table table-bordered table-md' style='font-size: 12px;text-align: left; border-collapse: collapse;width:100%'>
		<thead class='thead-dark'>
			<tr>
				<th nowrap>MODE OF PAYMENT</th>
				<th nowrap>DEBIT</th>
				<th nowrap>CREDIT</th>
			</tr>
		</thead>
		<tbody>";

$sqlcmd = "SELECT * FROM sales_mbd$lstIpall.payt WHERE invidz = $var_invidz ORDER BY tsz ASC";
$resultx = mysqli_query($dbonlineserver, $sqlcmd);
while($rowx = $resultx->fetch_array())
{
	$display .="<tr>
					<td nowrap>".$rowx["dbcr"]."</td>
					<td nowrap>".$rowx["debit"]."</td>
					<td nowrap>".$rowx["credit"]."</td>
				</tr>";
	$counter = $counter + 1;
}
$rempayable = 0;
$sqlcmd = "SELECT sum(credit) as credit,sum(debit) as debit,sum(debit) - sum(credit) as rempayabale FROM sales_mbd$lstIpall.payt WHERE invidz = $var_invidz";
$result = mysqli_query($dbonlineserver, $sqlcmd);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);
if ($count >= 1)
{
	$rempayable = $row["rempayabale"];
}
$display .="</tbody></table>
<script>
var_payable = $rempayable;
$('#txt_rempayable').val('$rempayable');
$('#txt_cash').val('$rempayable');
$('#txt_cheque').val('$rempayable');
$('#txt_creditcard').val('$rempayable');
$('#txt_cod').val('$rempayable');
$('#txt_ar').val('$rempayable');
$('#txt_banktrans').val('$rempayable');
</script>";

echo $display;

mysqli_close($dbonlineserver);
?>
