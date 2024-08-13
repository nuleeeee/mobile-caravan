<?php
	include "../../php/allfunction.php";

	$x = 3;//want number of digits for the random number
	$sum = 0;
	for($i=0;$i<$x;$i++)
	{
		$sum = $sum + rand(0,9)*pow(10,$i);

	}
	$sum = $sum + rand(1,9)*pow(10,3);
	echo $sum;
?>