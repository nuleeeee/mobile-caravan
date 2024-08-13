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

$type = trim($_POST["type"]);
$barcode = trim($_POST["brcode"]);

$clck = "";
$boxqty = 0;
$boxdisc = 0;

$display = "<table id='grd_result_item' class='table table-bordered table-sm' style='font-size: 12px; text-align: left; width:100%;'>
				<thead class='thead-dark'>
				      <tr>
						<td nowrap>BTN</td>
						<td nowrap>ITEM</td>
						<td nowrap>ITEMCODE</td>
						<td nowrap>SRP</td>
					</tr>
				</thead>
				<tbody>";

$sqlcmd = "SELECT idxx, providetidz, pridz, itemidz, itemcode, itemdesc, prqty, sprice, cashieridz, tsz FROM mobilejaba.mobilevproduct WHERE itemcode LIKE '%".$barcode."%' OR itemdesc LIKE '%".$barcode."%'";

$result = mysqli_query($dbonlineserver, $sqlcmd);
$counter = mysqli_num_rows($result);
while($row = $result->fetch_array())
{
	if($type==0)
	{
		$clck = "setitem('".str_replace("'", "`", $row["itemdesc"])."','".str_replace("'", "`",$row["itemcode"])."',".$row["sprice"].",$counter,$boxqty,$boxdisc,$type);";
	}

	$display .= "<tr>
					<td nowrap>
						<button class='btn btn-primary' data-bs-dismiss=\"modal\" onclick='setitem(\"".str_replace("'", "`", $row["itemdesc"])."\", \"".str_replace("'", "`", $row["itemcode"])."\", ".$row["sprice"].",".$row["itemidz"].",$counter,$boxqty,$boxdisc,$type)'>
							Select
						</button>
					</td>
					<td nowrap>".$row["itemdesc"]."</td>
					<td nowrap>".$row["itemcode"]."</td>
					<td nowrap>".$row["sprice"]."</td>
				</tr>";
}


	$display .= "</tbody>
			</table>";

if($type == 0)
{
	if($counter>1)
	{
		$clck = "$('#modal_searchitem').modal('show');";
	}
	else if($counter < 1)
	{
		$clck = "$('#modal_searchitem').modal('show');";
	}
}

$display .= "<script>
	$clck
</script>";


echo $display;