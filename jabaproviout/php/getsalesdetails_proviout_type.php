<?php
include "../../php/allfunction.php";
$formidz = 1;

$var_invidz = $_POST["var_invidz"];

$sqlcmd = "SELECT nano,sales_mbd$lstIpall.invdet.invidz,sales_mbd$lstIpall.invdet.invdetidxx,itemidz,sprice,item,itemcode,qty - IFNULL(refqty,0) as qty FROM sales_mbd$lstIpall.invdet
INNER JOIN vlookup_mcore.vnano ON vlookup_mcore.vnano.idxx = sales_mbd$lstIpall.invdet.nanoidz
LEFT OUTER JOIN
(
	SELECT SUM(refqty) as refqty,invdetidz FROM sales_mbd.refund WHERE invidz = $var_invidz GROUP BY invdetidz
)as salesref ON salesref.invdetidz = sales_mbd$lstIpall.invdet.invdetidxx
WHERE sales_mbd$lstIpall.invdet.invidz = $var_invidz
ORDER BY sales_mbd$lstIpall.invdet.tsz DESC";

$display = "<table class='table table-bordered table-sm' style='font-size: 12px;text-align: left; border-collapse: collapse;width:100%'>
				<thead style='background-color: black; color: white;'>
				        <tr>
							<td nowrap>ITEM</td>
							<td nowrap>QTY</td>
							<td nowrap>TYPE</td>
							<td nowrap>
								<div class='form-group row'>
									<div class='col-sm-10'>
										<div class='form-check form-check-inline'>
											<input class='form-check-input' type='radio' name='radio_allnano' onclick='setallnanodetails(2)' id='radioheader1'>
											<label class='form-check-label' for='radioheader1'>Fordel All</label>
										</div>
									</div>
								</div>
							</td>
							<td nowrap>
								<div class='form-group row'>
									<div class='col-sm-10'>
										<div class='form-check form-check-inline'>
											<input class='form-check-input' type='radio' name='radio_allnano' onclick='setallnanodetails(8)' id='radioheader2'>
											<label class='form-check-label' for='radioheader2'>Pickup All</label>
										</div>
									</div>
								</div>
							</td>
							<td nowrap>
								<div class='form-group row'>
									<div class='col-sm-10'>
										<div class='form-check form-check-inline'>
											<input class='form-check-input' type='radio' name='radio_allnano' onclick='setallnanodetails(3)' id='radioheader3'>
											<label class='form-check-label' for='radioheader3'>Divert All</label>
										</div>
									</div>
								</div>
							</td>
							<td nowrap>
								<div class='form-group row'>
									<div class='col-sm-10'>
										<div class='form-check form-check-inline'>
											<input class='form-check-input' type='radio' name='radio_allnano' onclick='setallnanodetails(6)' id='radioheader4'>
											<label class='form-check-label' for='radioheader4'>Pullout All</label>
										</div>
									</div>
								</div>
							</td>
						</tr>
				</thead>
		   ";
$result = mysqli_query($db, $sqlcmd);
$counter = mysqli_num_rows($result);
$cnt = 0;				
while($row = $result->fetch_array())
{
	if($row["qty"] > 0)
	{
	$radiooptions = 'inlineRadioOptions_' . $cnt;
	$radio1 = 'inlineRadio1_' . $cnt;
	$radio2 = 'inlineRadio2_' . $cnt;
	$radio3 = 'inlineRadio3_' . $cnt;
	$radio4 = 'inlineRadio4_' . $cnt;
	$typetxt = 'slt_type_' . $cnt;
	
	$display .= "<tr>
					<td nowrap>".$row['item']."</td>
					<td nowrap>".number_format($row['qty'],2)."</td>
					<td nowrap><label>".$row['nano']."</label></td>
					<td nowrap>
						<div class='form-group row'>
							<div class='col-sm-10'>
								<div class='form-check form-check-inline'>
									<input class='form-check-input' type='radio' name='$radiooptions' id='$radio1' value='option1' onchange=\"setnanodetails(".$row["invidz"].",".$row["invdetidxx"].",2)\">
									<label class='form-check-label' for='$radio1'>Fordel</label>
								</div>
							</div>
						</div>
					</td>
					<td nowrap>
						<div class='form-group row'>
							<div class='col-sm-10'>
								<div class='form-check form-check-inline'>
									<input class='form-check-input' type='radio' name='$radiooptions' id='$radio2' value='option2' onchange=\"setnanodetails(".$row["invidz"].",".$row["invdetidxx"].",8)\">
									<label class='form-check-label' for='$radio2'>Pickup</label>
								</div>
							</div>
						</div>
					</td>
					<td nowrap>
						<div class='form-group row'>
							<div class='col-sm-10'>
								<div class='form-check form-check-inline'>
									<input class='form-check-input' type='radio' name='$radiooptions' id='$radio3' value='option2' onchange=\"setnanodetails(".$row["invidz"].",".$row["invdetidxx"].",3)\">
									<label class='form-check-label' for='$radio3'>Divert</label>
								</div>
							</div>
						</div>
					</td>
					<td nowrap>
						<div class='form-group row'>
							<div class='col-sm-10'>
								<div class='form-check form-check-inline'>
									<input class='form-check-input' type='radio' name='$radiooptions' id='$radio4' value='option2' onchange=\"setnanodetails(".$row["invidz"].",".$row["invdetidxx"].",6)\">
									<label class='form-check-label' for='$radio4'>Pullout</label>
								</div>
							</div>
						</div>
					</td>
				</tr>";
	$cnt = $cnt + 1;
		}
}

$display .= "</tbody></table>";
$display .= "<script>

</script>";



echo $display;
?>