<?php

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
$lstIpall =substr(strrchr($ip,'.'),1);

include "session.php";

$ip =  $_SERVER['REMOTE_ADDR']; 

$client_sub = "_mcore";
$mcore_sub = "_mcore";

// check branch
function check_user_branch($brlogin)
{
	switch ($brlogin) {
	    	case 7:
	        	return "25.4.170.140:3306";
	    	case 8:
	        	return "25.9.150.201:3306";
	    	case 0:
	        	return "192.168.1.129";
	    	default:
	        	return "";
	}
}

//GET BRANCH NAME
function getbrname($bridz)
{
	if($bridz == 1)
	{
		return "Los Banos";
	}
	else if($bridz == 2)
	{
		return "Lipa";
	}
	else if($bridz == 3)
	{
		return "Calamba";
	}
	else if($bridz == 4)
	{
		return "Sto Tomas";
	}
	else if($bridz == 5)
	{
		return "Batangas City";
	}
	else if($bridz == 6)
	{
		return "Rosario";
	}
	else if($bridz == 7)
	{
		return "Lucena";
	}
	else if($bridz == 8)
	{
		return "Pagsanjan";
	}
	else if($bridz == 9)
	{
		return "Dasmarinas";
	}
}

//GET BRANCH FOR SQL
function getbrsql($bridz)
{
	if($bridz == 1)
	{
		return "mli";
	}
	else if($bridz == 2)
	{
		return "lpa";
	}
	else if($bridz == 3)
	{
		return "cal";
	}
	else if($bridz == 4)
	{
		return "sto";
	}
	else if($bridz == 5)
	{
		return "bct";
	}
	else if($bridz == 6)
	{
		return "ros";
	}
	else if($bridz == 7)
	{
		return "luc";
	}
	else if($bridz == 8)
	{
		return "psj";
	}
	else if($bridz == 9)
	{
		return "das";
	}
}

function optionlst($db,$sqlcommand,$flddsplay,$fldvalue)
{
	$display = "";
	
	$resultx = mysqli_query($db, $sqlcommand);
	if(mysqli_error($db)!="")
	{
		return mysqli_error($db);
	}
	$count = mysqli_num_rows($resultx);
	if($count == 0)
	{
		$display .= "<option value=0>NO DATA</option>";
	}
	else
	{
		$display .= "<option value=0 selected>Please Select</option>";
		while($rowx = $resultx->fetch_array())
		{
			$display .= "<option value=".$rowx[$fldvalue].">".$rowx[$flddsplay]."</option>";
		}
	}
	return $display;	
}

function optionlstshortterm($db,$sqlcommand,$flddsplay,$fldvalue)
{
	$display = "";
	
	$resultx = mysqli_query($db, $sqlcommand);
	if(mysqli_error($db)!="")
	{
		return mysqli_error($db);
	}
	$count = mysqli_num_rows($resultx);
	if($count == 0)
	{
		$display .= "<option value=0>NO DATA</option>";
	}
	else
	{
		$display .= "<option value=0 selected>Please Select</option>";
		while($rowx = $resultx->fetch_array())
		{
			if($rowx["pendingstatus"] == 0)
			{
				$display .= "<option value=".$rowx[$fldvalue].">".$rowx[$flddsplay]."</option>";
			}
			else
			{
				$display .= "<option value=".$rowx[$fldvalue]." disabled>".$rowx[$flddsplay]."</option>";
			}
		}
	}
	return $display;	
}

function getId($db,$schema,$table,$field,$formid)
{
	$ip =  $_SERVER['REMOTE_ADDR']; 
	$lstIp =substr(strrchr($ip,'.'),1);
	$lstIp = sprintf('%03d',$lstIp);
	$sql = "SELECT max($field) as maxfld FROM $schema.$table WHERE $field LIKE '%.$lstIp%'";
	$newId = 0;
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
			
	$bridz =$GLOBALS['brnumb'];    
			
	if ($count == 1) {
		$newId = (int)$row["maxfld"] + 1 + sprintf('%0.3f',((int)$lstIp/1000));
		return sprintf('%0.3f',$newId);
	} else {
		$newId = 1 + sprintf('%0.3f',((int)$lstIp/1000));
		return sprintf('%0.3f',$newId) ;

	}
}

function getitemId($db)
{
	$sql = "SELECT max(itemidxx) as maxfld FROM jaba_mbd.jabaitemdet";
	$newId = 0;
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	
	if ($count == 1) {
		$newId = (int)$row["maxfld"] + 1;
		return $newId;
	} else {
		$newId = 1;
		return $newId;

	}
}

function getIdmachine($db,$schema,$table,$field)
{
	$sql = " SELECT max($field) as maxfld FROM $schema.$table";
	$newId = 0;
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result); 
			
	if ($count == 1) {
		$newId = $row["maxfld"] + 1;
		return $newId;
	} else {
		$newId = 1;
		return $newId ;

	}
}

function getmaxsino($db,$ipadrs,$cashieridz)
{
	$init_sino = 100000;
   	$sqlcmd = "SELECT max(sino) + 1 as sino FROM mobilejaba.invdet WHERE invdetidxx IN (SELECT MAX(invdetidxx) FROM mobilejaba.invdet WHERE ipadrs = $ipadrs AND DATE(now()) AND cashieridz = $cashieridz)";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1 && !is_null($row["sino"])) {
		return $row["sino"];
	} else {
		return $init_sino + 1;
	}
}

function getmaxpaymentsino($db,$cashieridz)
{
   $sqlcmd = "SELECT ifnull(max(sino),0) + 1 as sino FROM soa_mbd.soapay WHERE  tsz IN (SELECT MAX(tsz) as tsz FROM soa_mbd.soapay WHERE cashieridz = $cashieridz)";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["sino"];
	} else {
		return 0;
	}
}

function getinvoicenumbsoa($db,$paytidxx)
{
	$sqlcmd = "
	SELECT sino FROM sales_mbd.payt WHERE paytidxx = $paytidxx";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["sino"];
	} else {
		return 0;
	}
}

function getinvoicenumbsales($db,$invidz)
{
	$sqlcmd = "
	SELECT sino FROM sales_mbd.invdet WHERE invidz = $invidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["sino"];
	} else {
		return 0;
	}
}

function getsoldtoid($db,$invidz)
{

	$sqlcmd = "SELECT nameidz FROM sales_mbd.inv WHERE invidxx = $invidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["nameidz"];
	} else {
		return 0;
	}
}

function comboboxsupp($db,$id,$sqlcomm,$displmemvar,$valuememvar)
{
	$sql = mysqli_real_escape_string($db,$sqlcomm);
	$result = mysqli_query($db, $sql);
	
	$display = "<select  class=\"form-control selectpicker\" id=\"".$id."\" data-live-search=\"true\">
	<optgroup>";
		
	while($row = $result->fetch_array())
	{
	   $display .="<option value='".$row[$valuememvar]."'>".$row[$displmemvar]."</option>";
	}
	$display .="</optgroup></select>";
		
	echo $display;
}

function checkautodisc($db,$itemidz,$invprice,$ismbd)
{
	$sqlcmd = "
	SELECT itemidz,mlidisc,suppdisc,mliamt,suppamt FROM vproduct_mbd.mbdsales WHERE mbdsalesidxx =
	(SELECT max(mbdsalesidxx) as mbdsalesidxx FROM vproduct_mbd.mbdsales 
	WHERE itemidz = $itemidz and startdate<=date(now()) and enddate>=date(now())
	AND starttime<=time(now()) and endtime>=time(now()))";
	
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	

		$mbd = $row["mlidisc"]/100;
		$sup = $row["suppdisc"]/100;
		
		if($ismbd==1)
		{
			if($mbd>0)
			{
				return round($mbd * $invprice,2);
			}
			else
			{
				return round($row["mliamt"],2);
			}
		}
		else 
		{
		
			if($sup>0)
			{
				
				return round($sup * $invprice,2);
			}
			else
			{
				return round($row["suppamt"],2);
			}
		}


		return 0;
	}
	return 0;
}

function checkjabaprmanualdisc($db,$itemidz,$prdetidz,$ismbd)
{
	$sqlcmd = "SELECT prmlidiscamt,prsuppdiscamt FROM provijaba_mbd.providisc WHERE prdetidxx = $prdetidz";
	
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {		
		if($ismbd==1)
		{
			return round($row["prmlidiscamt"],2);
		}
		else 
		{
		
			return round($row["prsuppdiscamt"],2);
		}
	}
	return 0;
}

function checkprmanualdisc($db,$itemidz,$prdetidz,$ismbd)
{
	$sqlcmd = "SELECT prmlidiscamt,prsuppdiscamt FROM provi_mbd.providisc WHERE prdetidxx = $prdetidz";
	
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {		
		if($ismbd==1)
		{
			return round($row["prmlidiscamt"],2);
		}
		else 
		{
		
			return round($row["prsuppdiscamt"],2);
		}
	}
	return 0;
}

//COUPON REFUND
function getremcoupon($db,$invpaytid,$creditamt)
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	$lstIpall =substr(strrchr($ip,'.'),1);
	
	$sqlcmd = "SELECT $creditamt - SUM(amt) as amt FROM
	(
		SELECT couponpaytidxx,IF(ISNULL(SUM(amt)),0,SUM(amt)) as amt FROM sales_mbd.couponpayt WHERE paytidz = $invpaytid
		UNION 
		SELECT couponpaytidxx,IF(ISNULL(SUM(amt)),0,SUM(amt)) as amt FROM sales_mbd$lstIpall.couponpayt WHERE paytidz = $invpaytid
	)as tbl";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["amt"];
	} else {
		return 0;
	}
}

function getifpoints($db,$transid)
{
	$sqlcmd = "SELECT * FROM sales_mbd.ptsearned WHERE invidxx = $transid";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {
		return 1;
	} else {
	    return 0;
	}
}

function getdiser($db,$invidz)
{
	$sqlcmd = "SELECT dizername FROM sales_mbd.dzpts WHERE invidz = $invidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["dizername"];
	} else {
		return "N/A";
	}
}

function getdiserprovi($db,$pridz)
{
	$sqlcmd = "SELECT dizername FROM provi_mbd.providzpts WHERE pridz = $pridz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["dizername"];
	} else {
		return "N/A";
	}
}

function getdiserpr($db,$pridz)
{
	$sqlcmd = "SELECT dizername FROM provi_mbd.providzpts WHERE pridz = $pridz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["dizername"];
	} else {
		return "N/A";
	}
}

function getreprintinvno($db,$invidz)
{
	$sqlcmd = "SELECT sino FROM sales_mbd.invdet WHERE invidz = $invidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["sino"];
	} else {
		return "N/A";
	}
}

function getreprintinvnoprovi($db,$pridz)
{
	$sqlcmd = "SELECT sino FROM provi_mbd.providet WHERE pridz = $pridz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["sino"];
	} else {
		return "N/A";
	}
}

function getsoldtoname($db,$invidz)
{
	$sqlcmd = "SELECT IF(ISNULL(sales_mbd.vnamebr.name),vlookup_mcore.vname.vname,sales_mbd.vnamebr.name) as vname FROM sales_mbd.inv
	LEFT OUTER JOIN sales_mbd.vnamebr ON sales_mbd.vnamebr.nameidxx = sales_mbd.inv.nameidz
	LEFT OUTER JOIN vlookup_mcore.vname ON vlookup_mcore.vname.nameidxx = sales_mbd.inv.nameidz
	WHERE invidxx = $invidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["vname"];
	} else {
		return "N/A";
	}
}
function getcashiername($db,$nameidxx)
{
	$sqlcmd = "SELECT vname FROM vlookup_mcore.vname";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["vname"];
	} else {
		return "N/A";
	}
}

function getsoldtonameprovi($db,$pridz)
{
	$sqlcmd = "SELECT vlookup_mcore.vname.vname FROM provi_mbd.provi
	INNER JOIN vlookup_mcore.vname ON vlookup_mcore.vname.nameidxx = provi_mbd.provi.nameidz
	WHERE pridxx = $pridz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["vname"];
	} else {
		return "N/A";
	}
}

function getdelinfo($db,$invidz)
{
	$sqlcmd = "SELECT IFNULL(vlookup_mcore.vname.vname,sales_mbd.vnamebr.name) as customername FROM sales_mbd.invdelinfo
	LEFT OUTER JOIN vlookup_mcore.vname ON vlookup_mcore.vname.nameidxx = sales_mbd.invdelinfo.nameidz
	LEFT OUTER JOIN sales_mbd.vnamebr ON sales_mbd.vnamebr.nameidxx = sales_mbd.invdelinfo.nameidz
	WHERE invidxx = $invidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["customername"];
	} else {
		return "N/A";
	}
}

function getdelinfono($db,$invidz)
{
	$sqlcmd = "SELECT telno FROM sales_mbd.invdelinfo
	LEFT OUTER JOIN sales_mbd.vtelnobr ON sales_mbd.vtelnobr.nameidz = sales_mbd.invdelinfo.nameidz
	WHERE invidxx = $invidz;";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["telno"];
	} else {
		return "N/A";
	}
}

function getdelinfoadrs($db,$invidz)
{
	$sqlcmd = "SELECT CONCAT(street,' ',barangay,' ',city,' ',province) as adrs FROM sales_mbd.invdelinfo
	LEFT OUTER JOIN sales_mbd.vnamedeladrsbr ON sales_mbd.vnamedeladrsbr.nameidz = 	sales_mbd.invdelinfo.nameidz
	WHERE invidxx = 1685.1360;";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["adrs"];
	} else {
		return "N/A";
	}
}
//scanaudit
function checkifuploaded($db,$todoby,$forpicdz)
{
	$sql = "SELECT count(*) as count FROM scan_mbd.forpicscan".$todoby." where forpicidz=".$forpicdz;
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if ($row["count"] >= 1) {
		return "UPLOAD:".$row["count"]."(s)";
	} else {

		return "NO UPLOAD YET";

	}
}


function get_soldto_si($db,$invidz,$getinfo)
{
	if($getinfo==1)
	{
		$sql =
		"
		SELECT vname,sino FROM sales_mbd.payt
		LEFT OUTER JOIN vlookup_mcore.vname ON vlookup_mcore.vname.nameidxx = sales_mbd.payt.nameidz
		LEFT OUTER JOIN sales_mbd.vnamebr ON sales_mbd.vnamebr.nameidxx = sales_mbd.payt.nameidz
		WHERE invidz = $invidz AND debit > 0
		";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$count = mysqli_num_rows($result);
		if ($count == 1) {
			return "&!Customer Name:!&".$row["vname"].
				"&!Sales Invoice Number:!&".$row["sino"];
		} else {

			return "";

		}
	}
	else
	{
		return "";
	}
}

function get_name($db,$nameidz)
{

		$sql =
		"
		select vname FROM vlookup_mcore.vname
		WHERE nameidxx='".$nameidz."'
		";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$count = mysqli_num_rows($result);
		if ($count == 1) {
			return $row["vname"];
		} else {

			return "Officer";

		}

}
function showerrorBool($db,$sql)
{
	if(mysqli_error($db)!="")
	{
		return 1;
	}
	return 0;
}

function showerrorx($db,$sql)
{
	if(mysqli_error($db)!="")
	{
		return mysqli_error($db)."<br>Error SQL:<br>".$sql;
	}
}


function comboboxdrivertrips($db,$typequery)
{
	$bridz = $GLOBALS['brnumb'];
	
	if($typequery == 1)
	{
		$sql = "SELECT nameidxx,vname FROM vlookup_mcore.vname WHERE nameidxx = 1
		UNION ALL
		SELECT nameidxx,CONCAT(lastname,',',firstname) as vname FROM vlookup_mcore.vnamenew WHERE positionidz IN (20,23) AND bridz = $bridz AND hide = 0";
		
	}
	else
	{
		$sql = "SELECT nameidxx,vname FROM vlookup_mcore.vname WHERE nameidxx = 1
		UNION ALL
		SELECT nameidxx,CONCAT(lastname,',',firstname) as vname FROM vlookup_mcore.vnamenew WHERE positionidz IN (18,21) AND bridz = $bridz AND hide = 0";
	}
	$result = mysqli_query($db, $sql);
		
	$display = "";
	
	if(mysqli_error($db)!="")
	{
		return mysqli_error($db);
	}
	$count = mysqli_num_rows($result);
	if($count == 0)
	{
		$display .= "<option value=0>NO DATA</option>";
	}
	else
	{
		while($rowx = $result->fetch_array())
		{
			$display .= "<option value=".$rowx["nameidxx"].">".$rowx["vname"]."</option>";
		}
	}
	return $display;	
}	

function comboboxdriver($db,$typequery,$trucknumber)
{
	$bridz = $GLOBALS['brnumb'];
	
	if($typequery == 1)
	{
		$sql = "SELECT nameidxx,vname FROM vlookup_mcore.vname WHERE nameidxx = 1
		UNION ALL
		SELECT nameidxx,vname FROM vlookup_mcore.vtruckaccounted
		INNER JOIN
		(
				SELECT nameidxx,CONCAT(lastname,',',firstname) as vname FROM vlookup_mcore.vnamenew WHERE positionidz IN (20,23) AND bridz = $bridz AND hide = 0
		)as tbl_driver ON tbl_driver.nameidxx = vlookup_mcore.vtruckaccounted.nameidz
		WHERE bridz = $bridz AND truckaccidxx = $trucknumber";
		
	}
	else
	{
			$sql = "SELECT nameidxx,vname FROM vlookup_mcore.vname WHERE nameidxx = 1
			UNION
			SELECT nameidxx,CONCAT(lastname,',',firstname) as vname FROM vlookup_mcore.vnamenew WHERE positionidz IN (18,21) AND bridz = $bridz AND hide = 0";
	}
	$result = mysqli_query($db, $sql);
		
	$display = "";
	
	if(mysqli_error($db)!="")
	{
		return mysqli_error($db);
	}
	$count = mysqli_num_rows($result);
	if($count == 0)
	{
		$display .= "<option value=0>NO DATA</option>";
	}
	else
	{
		while($rowx = $result->fetch_array())
		{
			$display .= "<option value=".$rowx["nameidxx"].">".$rowx["vname"]."</option>";
		}
	}
	return $display;	
}	

function getcodamt($db,$invidz)
{
	$sqlcmd = "SELECT credit FROM sales_mbd.payt WHERE invidz = $invidz AND dbcridz = 4";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["credit"];
	} else {
		return 0;
	}
}

function getdelamt($db,$invidz,$tripid)
{

	$sqlcmd = "SELECT SUM(amount) as amount FROM
	(
		SELECT tripqty * sprice as amount FROM deliv_mbd.tripticketdet WHERE invidz = $invidz AND tripticketidz = $tripid
	)as alltripdet";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["amount"];
	} else {
		return 0;
	}
}

//COMMISION
function checkifcod($db,$invidz)
{
	$sqlcmd = "SELECT dbcridz from sales_mbd.payt where invidz=$invidz and credit >0 AND dbcridz IN (1,2,3,4,5,34)";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$dbcrid = $row["dbcridz"];
	$count = mysqli_num_rows($result);
	if ($count >= 1) {
		return $dbcrid;
	}
	return $dbcrid;
}

//SOA MANAGER
function getmanagername($db,$bridz)
{
	$sql = "SELECT CONCAT(lastname,',',firstname) as vname FROM vlookup_mcore.vnamenew WHERE bridz = $bridz AND positionidz = 1";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1){
		 return $row["vname"];
	} else {
		return "N/A";
	}
}


function cashierpos($db,$nameidz)
{
	$sql = "SELECT vlookup_mcore.vemployeeposition.position as empposition FROM vlookup_mcore.vnamenew
	INNER JOIN vlookup_mcore.vemployeeposition ON vlookup_mcore.vemployeeposition.positionidxx = vlookup_mcore.vnamenew.positionidz
	WHERE nameidxx = $nameidz";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1){
		 return $row["empposition"];
	} else {
		return "N/A";
	}
}
//PROVI
function getinvoicenumbsalespr($db,$pridz)
{
	$sqlcmd = "SELECT sino FROM provi_mbd.providet WHERE pridz = $pridz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["sino"];
	} else {
		return 0;
	}
}

function getsoldtoidpr($db,$pridz)
{

	$sqlcmd = "SELECT IF(ISNULL(vnamenameidxx),IF(ISNULL(vnamearnameidxx),CONCAT(vnamestnameidxx,'-3'),CONCAT(vnamearnameidxx,'-2')),CONCAT(vnamenameidxx,'-1')) as nameidxx FROM provi_mbd.provi
LEFT OUTER JOIN
(
	SELECT nameidxx as vnamenameidxx FROM vlookup_mcore.vname WHERE nameidxx = 1
)as tbl_vname ON tbl_vname.vnamenameidxx = provi_mbd.provi.nameidz
LEFT OUTER JOIN
(
	SELECT nameidxx as vnamearnameidxx FROM vlookup_mcore.vnamenewar
)as tbl_vnamear ON tbl_vnamear.vnamearnameidxx = provi_mbd.provi.nameidz
LEFT OUTER JOIN
(
	SELECT appidxx as vnamestnameidxx FROM vlookup_mcore.vname_shortterm 
)as tbl_vnamest ON tbl_vnamest.vnamestnameidxx = provi_mbd.provi.nameidz 
WHERE pridxx = $pridz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["nameidxx"];
	} else {
		return 0;
	}
}

function getmaxsinopr($db,$ipadrs,$cashieridz)
{
   $sqlcmd = "SELECT IFNULL(max(sino),0) + 1 as sino FROM provi_mbd.providet WHERE cashieridz = $cashieridz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["sino"];
	} else {
		return 0;
	}
}

// ADDED 03-04-2024
function getmaxsinojabapr($db,$ipadrs,$cashieridz)
{
   $sqlcmd = "SELECT IFNULL(max(sino),0) + 1 as sino FROM provijaba_mbd.providet WHERE cashieridz = $cashieridz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {
		return $row["sino"];
	} else {
		return 0;
	}
}

function getprovidownbal($db,$pridz)
{
	$sqlcmd = "
	SELECT SUM(made)-SUM(used) as available FROM
	(
		SELECT SUM(made) as made, 0 as used FROM
		(
			SELECT SUM(ifnull(credit,0)) as made,0 as used FROM
			(
				SELECT credit,prpaytidxx FROM provi_mbd.provipayt where pridz = $pridz and dbcridz in (1,2,3,34) and credit!=0
			) as madeall 
			GROUP BY prpaytidxx
		) as finall
		UNION 
		SELECT 0 as made,SUM(ifnull(credit,0)) as used FROM
		(
			SELECT paytidxx,credit FROM sales_mbd.payt where invidz IN 
			(
					SELECT invidz FROM provi_mbd.prsalesdetlink WHERE pridz= $pridz
			) and dbcridz in (101) and credit!=0
		) as madeall
	) as overall";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		if($row["available"]>0)
		{
			return $row["available"];
		}
	}

	return 0;
}

//FOR DBMEMO
function getifdbmemo($db,$transid)
{
	$sqlcmd = "SELECT * FROM dbmemo_mbd.dbmemo WHERE invidz = $transid";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {
		return 1;
	} else {
	    return 0;
	}

}

function gettransidfromsoa($db,$soaidz)
{
	$sqlcmd = "SELECT * FROM soa_mbd.soamadedet  WHERE soaidz = $soaidz";
	$resultx = mysqli_query($db, $sqlcmd);
	while($rowx = $resultx->fetch_array())
	{
		$cntstats = getifdbmemo($db,$rowx["invidz"]);
		if($cntstats == 0)
		{
			return 0;
		}
	}
	return 1;
}

//PRINT DR
function getsoldtonamedr($db,$invidz)
{
	$sqlcmd = "SELECT IF(ISNULL(sales_mbd.vnamebr.name),vlookup_mcore.vname.vname,sales_mbd.vnamebr.name) as customername FROM sales_mbd.payt
	LEFT OUTER JOIN vlookup_mcore.vname ON vlookup_mcore.vname.nameidxx = sales_mbd.payt.nameidz
    LEFT OUTER JOIN sales_mbd.vnamebr ON sales_mbd.vnamebr.nameidxx = sales_mbd.payt.nameidz
	WHERE dbcridz IN (4,5) AND invidz = $invidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["customername"];
	} else {
		return "NOT FOUND";
	}
}

function getdbcridzifcod($db,$invidz)
{
	$sqlcmd = "SELECT * FROM sales_mbd.payt WHERE invidz = $invidz AND dbcridz IN (4,5)";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["dbcridz"];
	} else {
		return 1;
	}
}

//WRHSE RECOUNT
function getstk($db,$itemidz,$condition)
{
	$sqlcmd = "SELECT IFNULL(SUM(wrhsestkqty),0) as wrhsestkqty,itemidz FROM
        (
			SELECT IFNULL(SUM(qtyin),0) - IFNULL(SUM(qtyout),0) as wrhsestkqty,itemidz FROM wrhse_mbd.wrhsedet WHERE itemidz = $itemidz GROUP BY itemidz
			UNION ALL
			SELECT IFNULL(SUM(qtyin),0) - IFNULL(SUM(qtyout),0) as wrhsestkqty,itemidz FROM wrhse_mbd$condition.wrhsedet WHERE itemidz = $itemidz GROUP BY itemidz
		)as tmpdet
        GROUP BY itemidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["wrhsestkqty"];
	} else {
		return 0;
	}
}

//SI CHECKER
function getdelstatus($db,$invdetidx)
{
	$sqlcmd = "SELECT IF(confirmqty = 0,'UNDELIVERED',IF(confirmqty > 0 AND confirmqty < qty, 'PARTIAL', IF(confirmqty > 0 AND confirmqty > qty, 'DELIVERED THEN REFUND','DELIVERED'))) as status FROM
	(
		SELECT qty - IFNULL(refqty,0) as qty,IFNULL(confirmqty,0) as confirmqty  FROM sales_mbd.invdet
		LEFT OUTER JOIN
		(
			SELECT SUM(confirmqty) as confirmqty,invdetidz FROM deliv_mbd.backloaddet WHERE invdetidz = $invdetidx GROUP BY invdetidz
		)as tbl_confirm ON tbl_confirm.invdetidz = sales_mbd.invdet.invdetidxx
		LEFT OUTER JOIN
		(
			SELECT SUM(refqty) as refqty,invdetidz FROM sales_mbd.refund WHERE invdetidz = $invdetidx GROUP BY invdetidz
		)as tbl_refund ON tbl_refund.invdetidz = sales_mbd.invdet.invdetidxx
		WHERE invdetidxx = $invdetidx
	)as tbl_all";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["status"];
	} else {
		return "N/A";
	}
}

function getpickupstatus($db,$invdetidx)
{
	$sqlcmd = "SELECT IF(prepqty = 0,'UNPICKUP',IF(prepqty > 0 AND prepqty < qty, 'PARTIAL', IF(prepqty > 0 AND prepqty > qty, 'PICKUP THEN REFUND','PICK UP'))) as status FROM
	(
		SELECT qty - IFNULL(refqty,0) as qty,IFNULL(prepqty,0) as prepqty  FROM sales_mbd.invdet
		LEFT OUTER JOIN
		(
			SELECT SUM(prepqty) as prepqty,invdetidz FROM deliv_mbd.preparationdet WHERE invdetidz = $invdetidx GROUP BY invdetidz
		)as tbl_prep ON tbl_prep.invdetidz = sales_mbd.invdet.invdetidxx
		LEFT OUTER JOIN
		(
			SELECT SUM(refqty) as refqty,invdetidz FROM sales_mbd.refund WHERE invdetidz = $invdetidx GROUP BY invdetidz
		)as tbl_refund ON tbl_refund.invdetidz = sales_mbd.invdet.invdetidxx
		WHERE invdetidxx = $invdetidx
	)as tbl_all";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["status"];
	} else {
		return "N/A";
	}
}

//INQUIRY STK
function getstkinq($db,$itemidz)
{
	$sqlcmd = "SELECT incomingqty - (salesqty+boqty+adjqty) as stkqty FROM
	(
	SELECT itemidxx,item,itemcode,SUM(salesqty) as salesqty,SUM(incomingqty) as incomingqty,SUM(boqty) as boqty,SUM(adjqty) as adjqty FROM
		(
			SELECT itemidxx,tbl_sales.item,tbl_sales.itemcode,salesqty,incomingqty,boqty,adjqty FROM
			(
				SELECT itemidz,item,itemcode,qty as salesqty,0 as incomingqty,0 as boqty,0 as adjqty FROM sales_mbd.invdet WHERE itemidz = $itemidz
				UNION ALL
				SELECT itemidz,item,itemcode,refqty * -1 as salesqty,0 as incomingqty,0 as boqty,0 as adjqty FROM sales_mbd.refund
				INNER JOIN sales_mbd.invdet ON sales_mbd.invdet.invdetidxx = sales_mbd.refund.invdetidz
				WHERE itemidz = $itemidz
				UNION ALL
				SELECT itemidz,item,itemcode,0 as saleqty,dispatchqty as incomingqty,0 as boqty,0 as adjqty FROM dispatch_mbd.dispatchindet WHERE itemidz = $itemidz
				UNION ALL
				SELECT itemidz,item,itemcode,0 as salesqty,0 as dispatchqty,qty as boqty,0 as adjqty FROM bo_mbd.bodet WHERE itemidz = $itemidz
				UNION ALL
				SELECT itemidxx as itemidz,'' as item,'' as itemcode,0 as salesqty,0 as dispatchqty,0 as boqty,adj as adjqty FROM vproduct_mbd.storeorder WHERE itemidxx = $itemidz
			)as tbl_sales
			INNER JOIN vproduct_mbd.vitem ON vproduct_mbd.vitem.itemidxx = tbl_sales.itemidz
			WHERE itemidxx = $itemidz
		)as tbl_sales2
		GROUP BY itemidxx
		)as final";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["stkqty"];
	} else {
		return 0;
	}
}
//SELLING AREA
function getsalesincsa($db,$sellingstk,$itemidz,$datestart)
{
	$sqlcmd = "SELECT itemidz,item,itemcode,IFNULL(SUM(salesqty),0) as salesqty,IFNULL(SUM(incomingqty),0) as incomingqty FROM
	(
		SELECT itemidz,item,itemcode,qty as salesqty,0 as incomingqty FROM sales_mbd.invdet WHERE itemidz = $itemidz AND tsz > '$datestart'
		UNION ALL
		SELECT itemidz,item,itemcode,refqty * -1 as salesqty,0 as incomingqty FROM sales_mbd.refund
		INNER JOIN sales_mbd.invdet ON sales_mbd.invdet.invdetidxx = sales_mbd.refund.invdetidz
		WHERE itemidz = $itemidz AND sales_mbd.refund.tsz > '$datestart'
		UNION ALL
		SELECT itemidz,item,itemcode,0 as saleqty,dispatchqty as incomingqty FROM dispatch_mbd.dispatchindet WHERE itemidz = $itemidz AND tsz > '$datestart'
	)as tbl_sales
	GROUP BY itemidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		//return number_format(($sellingstk + $row["incomingqty"]) - $row["salesqty"], 2, '.', ' ');
		return ($sellingstk + $row["incomingqty"]) - $row["salesqty"];
	} else {
		//return number_format($sellingstk, 2, '.', ' ');
		return $sellingstk;
	}
}

function getmaxseldate($db,$itemidz)
{
	$sqlcmd = "SELECT MIN(tsz) as seldate,now() as datenow FROM sellingarea_mbd.sellingareadet WHERE itemidz = $itemidz GROUP BY itemidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["seldate"];
	} else {
		return $row["datenow"];
	}
}

//PROFIT
function profit_delcharge($db,$txt_startdate,$txt_enddate,$brsql)
{
	$sqlcmd = "SELECT  SUM(gross) AS gross FROM
(
	SELECT *,qty * (sprice - vbprice) AS profits,qty * sprice AS gross FROM
	(
		SELECT sales_mbd.invdet.invdetidxx,qty,sprice,vproduct_mbd.vitem_$brsql.vbprice,sales_mbd.disc.mlidiscamt AS mli,sales_mbd.discpromo.mlidiscpromoamt AS mlipromo,0 AS mlicomm FROM sales_mbd.invdet
		LEFT OUTER JOIN sales_mbd.disc ON sales_mbd.disc.invdetidxx = sales_mbd.invdet.invdetidxx
		LEFT OUTER JOIN sales_mbd.discpromo ON sales_mbd.discpromo.invdetidxx = sales_mbd.invdet.invdetidxx
        INNER JOIN vproduct_mbd.vitem_$brsql ON vproduct_mbd.vitem_$brsql.itemidxx = sales_mbd.invdet.itemidz
		WHERE DATE(sales_mbd.invdet.tsz) >= '$txt_startdate' AND DATE(sales_mbd.invdet.tsz) <= '$txt_enddate' AND sales_mbd.invdet.formidz = 1 AND sales_mbd.invdet.itemidz IN (221975)
		GROUP BY sales_mbd.invdet.invdetidxx
        UNION ALL 
        SELECT sales_mbd.invdet.invdetidxx,refqty * - 1 AS qty,sprice,vproduct_mbd.vitem_$brsql.vbprice,sales_mbd.disc.mlidiscamt AS mli,sales_mbd.discpromo.mlidiscpromoamt AS mlipromo,0 AS mlicomm FROM sales_mbd.refund
		INNER JOIN sales_mbd.invdet ON sales_mbd.invdet.invdetidxx = sales_mbd.refund.invdetidz
		LEFT OUTER JOIN sales_mbd.disc ON sales_mbd.disc.invdetidxx = sales_mbd.invdet.invdetidxx
		LEFT OUTER JOIN sales_mbd.discpromo ON sales_mbd.discpromo.invdetidxx = sales_mbd.invdet.invdetidxx
        INNER JOIN vproduct_mbd.vitem_$brsql ON vproduct_mbd.vitem_$brsql.itemidxx = sales_mbd.invdet.itemidz
		WHERE DATE(sales_mbd.refund.tsz) >= '$txt_startdate' AND DATE(sales_mbd.refund.tsz) <= '$txt_enddate' AND sales_mbd.invdet.itemidz IN (221975) AND sales_mbd.refund.formidz = 1
		GROUP BY sales_mbd.refund.refidxx
	)AS tmp1
) AS finals";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["gross"];
		
	}
	else
		
	{
		return 0;
	}
}

function profit_getsalary($db,$startdate,$enddate)
{
	$sqlcmd = "SELECT ROUND(sum(perday),2) as perday FROM 
(
	SELECT dtr_mcore.dtr.nameidz,date(dtr_mcore.dtr.tsz) as dates,rate,type,if(type=0,rate/26,rate) + (ifnull(amount,0))/26 as perday FROM dtr_mcore.dtr 
	INNER JOIN
    (
		SELECT nameidz,rate,type FROM vlookup_mcore.vnameratedet WHERE vnrateidxx IN (SELECT max(vnrateidxx) as idxx FROM vlookup_mcore.vnameratedet GROUP BY nameidz)
	) as salaryrate ON salaryrate.nameidz = dtr_mcore.dtr.nameidz
	LEFT OUTER JOIN 
	(
		SELECT nameidz,amount FROM vlookup_mcore.allowance 
		WHERE allowidxx IN (SELECT max(allowidxx) as idxx FROM vlookup_mcore.allowance GROUP BY nameidz)
	) as salaryallowance ON salaryallowance.nameidz = dtr_mcore.dtr.nameidz
	where date(dtr_mcore.dtr.tsz)>='$startdate' and date(dtr_mcore.dtr.tsz)<='$enddate' AND dtr_mcore.dtr.nameidz <> 3972
	GROUP BY nameidz,date(tsz)
) as overall ";

	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["perday"];
		
	}
	else
		
	{
		return 0;
	}
}

function profit_getsalarydriver($db,$startdate,$enddate)
{
	$sqlcmd = "SELECT (tripqty * ifnull(driverrate,0)) + (tripqty * ifnull(helper1rate,0)) + (tripqty * ifnull(helper2rate,0)) as amt FROM 
(
	SELECT trips2.*,rate as helper2rate FROM
    (
		SELECT trips1.*,rate as helper1rate FROM 
        (
			SELECT trips.*,rate as driverrate FROM
            (
				SELECT  trips as tripqty,tripticketidz,driver,helper1,helper2 FROM deliv_mbd.backload
				INNER JOIN vlookup_mcore.vname ON vlookup_mcore.vname.nameidxx = deliv_mbd.backload.driver
				WHERE DATE(deliv_mbd.backload.tsz) >= '$startdate' AND DATE(deliv_mbd.backload.tsz) <= '$enddate'
			)as trips 
            LEFT OUTER JOIN 
			(
				SELECT nameidz,rate FROM vlookup_mcore.vnameratetrip WHERE vnmetrpidx IN (SELECT max(vnmetrpidx) FROM vlookup_mcore.vnameratetrip GROUP BY nameidz)
			) as ratedriver ON ratedriver.nameidz = trips.driver
		)as trips1
        LEFT OUTER JOIN 
        (
			SELECT nameidz,rate FROM vlookup_mcore.vnameratetrip WHERE vnmetrpidx IN (SELECT max(vnmetrpidx) FROM vlookup_mcore.vnameratetrip GROUP BY nameidz)
        ) as ratehelper1 ON ratehelper1.nameidz = trips1.helper1
	)as trips2
    LEFT OUTER JOIN 
	(
		SELECT nameidz,rate FROM vlookup_mcore.vnameratetrip WHERE vnmetrpidx IN (SELECT max(vnmetrpidx) FROM vlookup_mcore.vnameratetrip GROUP BY nameidz)
	) as ratehelper2 ON ratehelper2.nameidz = trips2.helper2
) as final";

	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["amt"];
		
	}
	else
		
	{
		return 0;
	}
}

function profit_gas($db,$startdate,$enddate)
{
	$sqlcmd = "SELECT SUM(amount) as amount FROM
(
	SELECT dispatchqty * dispatchsprice as amount  FROM dispatch_mbd.dispatchindet
	WHERE dispatch_mbd.dispatchindet.itemidz in (230011,230017,54537687,54537689,54537690,54540785) AND date(dispatch_mbd.dispatchindet.tsz) >= '$startdate' AND date(dispatch_mbd.dispatchindet.tsz) <= '$enddate'
) as overall";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["amount"];
	}
	else
	{
		return 0;
	}
}

function profit_outside($db,$startdate,$enddate)
{
	$sqlcmd = "SELECT SUM(amt) * -1 as amt FROM
(
	SELECT sum(qty*sprice) as amt FROM sales_mbd.invdet where itemidz in (54532727,5449860) and formidz =5 and date(tsz)>='$startdate' and date(tsz)<='$enddate'
	UNION ALL
	SELECT sum(refqty*sprice)*-1 as amt FROM sales_mbd.refund
	INNER JOIN sales_mbd.invdet ON sales_mbd.invdet.invdetidxx = sales_mbd.refund.invdetidz AND sales_mbd.invdet.invidz = sales_mbd.refund.invidz
	where sales_mbd.invdet.itemidz in (54532727,5449860) and date(sales_mbd.refund.tsz)>='$startdate' and date(sales_mbd.refund.tsz)<='$enddate' and sales_mbd.invdet.formidz= 5
) as summall";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["amt"];
		
	}
	else
		
	{
		return 0;
	}
}

function profit_petty($db,$startdate,$enddate)
{
	$sqlcmd = "SELECT ABS(SUM(amt)) as amt FROM
(
	SELECT sum(qty*sprice) as amt FROM sales_mbd.invdet WHERE formidz =5 and date(tsz)>='$startdate' and date(tsz)<='$enddate'  AND sales_mbd.invdet.itemidz NOT in (54532727,5449860)
	UNION ALL
	SELECT SUM(refqty*sprice) *-1 as amt FROM sales_mbd.refund
	INNER JOIN sales_mbd.invdet ON sales_mbd.invdet.invdetidxx = sales_mbd.refund.invdetidz  AND sales_mbd.invdet.invidz = sales_mbd.refund.invidz
	where date(sales_mbd.refund.tsz)>='$startdate' and date(sales_mbd.refund.tsz)<='$enddate' AND sales_mbd.invdet.itemidz NOT in (54532727,5449860) and sales_mbd.invdet.formidz = 5 GROUP BY invdetidxx
) as summall";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["amt"];
		
	}
	else
		
	{
		return 0;
	}
}

function profit_gainloss($db,$startdate,$enddate)
{
	$sqlcmd = "SELECT SUM(gainlossamt) * -1 as amt FROM
(
	SELECT reportidxx,DATE(remit_mbd.remitreport.tsz) as transdate,systemamt,oldsystemamt,zankamt,remitamt,(systemamt + oldsystemamt + zankamt)  - remitamt as gainlossamt,nameidz  FROM remit_mbd.remitreport
	WHERE DATE(remit_mbd.remitreport.tsz) >= '$startdate' AND DATE(remit_mbd.remitreport.tsz) <= '$enddate' AND dbcridz= 1
)as tblgainloss";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["amt"];
		
	}
	else
		
	{
		return 0;
	}
}

function profit_rent($db,$bridz,$tartdate,$enddate)
{
	$sqlcmd = "SELECT amount/30 as amt FROM  vlookup_mcore.vrent where month= month(DATE_SUB('$tartdate', INTERVAL 4 MONTH)) and year = year(DATE_SUB('$tartdate', INTERVAL 4 MONTH)) and bridz=$bridz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["amt"];
		
	}
	else
		
	{
		return 0;
	}
}

function profit_getcccharge($db,$start,$end)
{
	$sqlcmd = "select sum(credit)*.035 as amt from sales_mbd.payt where dbcridz = 3 AND date(tsz)>='$start' and date(tsz)<='$end'";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["amt"];
		
	}
	else
		
	{
		return 0;
	}
}

function profit_getbreakage($db,$stdate,$enddate,$type)
{
	if($type == 1)
	{
		$sqlcmd = "SELECT ROUND(SUM(amount),2) as breakageamt FROM
(
	SELECT item,qty,vbprice,qty * vbprice as  amount FROM
	(
		SELECT item,qty,itemidz FROM wrhse_mbd.breakagedet WHERE DATE(wrhse_mbd.breakagedet.tsz) >= '$stdate' AND DATE(wrhse_mbd.breakagedet.tsz) <= '$enddate'
	)as overbad
	INNER JOIN vproduct_mbd.vitem_psj ON vproduct_mbd.vitem_psj.itemidxx = overbad.itemidz
	INNER JOIN vproduct_mbd.vitem ON vproduct_mbd.vitem.itemidxx = overbad.itemidz
	INNER JOIN vproduct_mcore.category ON vproduct_mcore.category.catidxx = vproduct_mbd.vitem.suppidz
	WHERE npaydes <> 2
)as fbreakage";
	}
	else
	{
		$sqlcmd = "SELECT ROUND(SUM(amount),2) as breakageamt FROM
(
	SELECT item,qty,vbprice,qty * vbprice as  amount FROM
	(
		SELECT item,qty,itemidz FROM wrhse_mbd.breakagedet WHERE DATE(wrhse_mbd.breakagedet.tsz) >= '$stdate' AND DATE(wrhse_mbd.breakagedet.tsz) <= '$enddate'
	)as overbad
	INNER JOIN vproduct_mbd.vitem_psj ON vproduct_mbd.vitem_psj.itemidxx = overbad.itemidz
	INNER JOIN vproduct_mbd.vitem ON vproduct_mbd.vitem.itemidxx = overbad.itemidz
	INNER JOIN vproduct_mcore.category ON vproduct_mcore.category.catidxx = vproduct_mbd.vitem.suppidz
	WHERE npaydes = 2
)as fbreakage";
	}
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	$breakageamt = $row['breakageamt'];
	if ($count >= 1) {	
		return $breakageamt;
	} else {

		return 0;

	}
}

function gettripamt($db,$tripid)
{

	$sqlcmd = "SELECT SUM(amount) as amount FROM
	(
		SELECT tripqty * sprice as amount FROM deliv_mbd.tripticketdet WHERE tripticketidz = $tripid
	)as alltripdet";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["amount"];
	} else {
		return 0;
	}
}

function getdisercount($db,$month,$year)
{

	$sqlcmd = "SELECT COUNT(*) as cntdiser FROM report_mbd.dizercount WHERE month = $month AND year = $year;";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["cntdiser"];
	} else {
		return 0;
	}
}

function getsalesquota($db,$month,$year,$bridz)
{
	$monthname = "";
	if($month == 1)
	{
		$monthname = "janquota";
	}
	else if($month == 2)
	{
		$monthname = "febquota";
	}
	else if($month == 3)
	{
		$monthname = "marchquota";
	}
	else if($month == 4)
	{
		$monthname = "aprilquota";
	}
	else if($month == 5)
	{
		$monthname = "mayquota";
	}
	else if($month == 6)
	{
		$monthname = "junequota";
	}
	else if($month == 7)
	{
		$monthname = "julyquota";
	}
	else if($month == 8)
	{
		$monthname = "augquota";
	}
	else if($month == 9)
	{
		$monthname = "sepquota";
	}
	else if($month == 10)
	{
		$monthname = "octquota";
	}
	else if($month == 11)
	{
		$monthname = "novquota";
	}
	else if($month == 12)
	{
		$monthname = "decquota";
	}
	$sqlcmd = "SELECT $monthname as fld FROM vlookup_mcore.vbrquota WHERE bridz = $bridz AND year = $year";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["fld"];
	} else {
		return 0;
	}
}

//OR
function getifhavedetails($db,$seriesdetid)
{

	$sqlcmd = "SELECT * FROM sales_mbd.oraccounted WHERE seriesdetidz = $seriesdetid";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1)
	{
		if($row["invidz"] > 0)
		{
			return 1;   
		}
		else
		{
			return 2;   
		}
		
	} else {

		return 0;
	}
}

function clean($string)
{
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

	$string = str_replace('-', ' ', $string);
	return $string;
}

//JABA TRANSCOUNT
function getjabatranscount($db,$start,$end)
{

	$sqlcmd = "SELECT COUNT(*) as cnttrans FROM
(
	SELECT * FROM
	(
		SELECT qty,invidz FROM sales_mbd.invdet
		INNER JOIN sales_mbd.inv ON sales_mbd.inv.invidxx = sales_mbd.invdet.invidz
		INNER JOIN jaba_mbd.jabaitemdet ON jaba_mbd.jabaitemdet.itemidxx = sales_mbd.invdet.itemidz
		WHERE DATE(sales_mbd.invdet.tsz) >= '$start' AND DATE(sales_mbd.invdet.tsz) <= '$end' AND formidz IN (1,4) AND itemidz <> 54593422 AND sales_mbd.inv.nameidz NOT IN (1806,38273903,123,343,344,395,992,1112,1837,2459,2585,2639,2669,3241,3777,3787)
        UNION ALL
        SELECT qty,invidz FROM sales_mbd.invdet
		INNER JOIN sales_mbd.inv ON sales_mbd.inv.invidxx = sales_mbd.invdet.invidz
		INNER JOIN vproduct_mbd.vitem ON vproduct_mbd.vitem.itemidxx = sales_mbd.invdet.itemidz
        INNER JOIN vproduct_mcore.category ON vproduct_mcore.category.catidxx  =  vproduct_mbd.vitem.suppidz
        INNER JOIN vproduct_mcore.category_type ON vproduct_mcore.category_type.catidxx  =  vproduct_mcore.category.catidxx
		WHERE DATE(sales_mbd.invdet.tsz) >= '$start' AND DATE(sales_mbd.invdet.tsz) <= '$end' AND typeidz IN (1,3) AND formidz IN (1,4) AND itemidz <> 54593422 AND sales_mbd.inv.nameidz NOT IN (1806,38273903,123,343,344,395,992,1112,1837,2459,2585,2639,2669,3241,3777,3787)
	)as tbl_l
	GROUP BY invidz
)as tbl_2";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	return $row["cnttrans"];
}

//MBD TRANSCOUNT
function getmbdtranscount($db,$start,$end)
{

	$sqlcmd = "SELECT COUNT(*) as cnttrans FROM
(
	SELECT * FROM
	(
		SELECT qty,invidz FROM sales_mbd.invdet
		INNER JOIN sales_mbd.inv ON sales_mbd.inv.invidxx = sales_mbd.invdet.invidz
		INNER JOIN vproduct_mbd.vitem ON vproduct_mbd.vitem.itemidxx = sales_mbd.invdet.itemidz
        INNER JOIN vproduct_mcore.category ON vproduct_mcore.category.catidxx = vproduct_mbd.vitem.suppidz
        INNER JOIN vproduct_mcore.category_type ON vproduct_mcore.category_type.catidxx = vproduct_mbd.vitem.suppidz
		WHERE DATE(sales_mbd.invdet.tsz) >= '$start' AND DATE(sales_mbd.invdet.tsz) <= '$end' AND typeidz NOT IN (1,3) AND formidz IN (1,4) AND itemidz <> 54593422 AND sales_mbd.inv.nameidz NOT IN (1806,38273903,123,343,344,395,992,1112,1837,2459,2585,2639,2669,3241,3777,3787)
	)as tbl_l
	GROUP BY invidz
)as tbl_2";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	return $row["cnttrans"];
}


//GET MBD RATIO
function getmbdrationstatus($db,$sqlcommand,$flddsplay,$fldvalue)
{
	$display = "";
	
	$resultx = mysqli_query($db, $sqlcommand);
	if(mysqli_error($db)!="")
	{
		return mysqli_error($db);
	}
	$count = mysqli_num_rows($resultx);
	if($count == 0)
	{
		$display .= "<option value=0>NO DATA</option>";
	}
	else
	{
		$display .= "<option value=0 selected>SELECT ALL</option>";
		while($rowx = $resultx->fetch_array())
		{
			$display .= "<option value=".$rowx[$fldvalue].">".$rowx[$flddsplay]."</option>";
		}
	}
	return $display;	
}

function getmbdratioremarks($db,$sqlcommand,$flddsplay,$fldvalue)
{
	$display = "";
	
	$resultx = mysqli_query($db, $sqlcommand);
	if(mysqli_error($db)!="")
	{
		return mysqli_error($db);
	}
	$count = mysqli_num_rows($resultx);
	if($count == 0)
	{
		$display .= "<option value=0>NO DATA</option>";
	}
	else
	{
		while($rowx = $resultx->fetch_array())
		{
			$display .= "<option value=".$rowx[$fldvalue].">".$rowx[$flddsplay]."</option>";
		}
	}
	return $display;	
}

//BRANCH PO
function getlastinc($db,$itemidz,$retfld)
{
	$sqlcmd = "SELECT $retfld as returnFld FROM dispatch_mbd.dispatchindet
	INNER JOIN
	(
		SELECT MAX(tsz) as maxtsz FROM dispatch_mbd.dispatchindet WHERE itemidz = $itemidz GROUP BY itemidz
	)as tbl_lastinc ON tbl_lastinc.maxtsz = dispatch_mbd.dispatchindet.tsz
	WHERE itemidz = $itemidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		//return number_format(($sellingstk + $row["incomingqty"]) - $row["salesqty"], 2, '.', ' ');
		return $row["returnFld"];
	} else {
		//return number_format($sellingstk, 2, '.', ' ');
		return 0;
	}
}


//OTR ATD
function getotrtype($db,$invidz)
{

	$sqlcmd = "SELECT atdtypeidz FROM sales_mbd.invotratd WHERE invidxx = $invidz";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["atdtypeidz"];
	} else {
		return 0;
	}
}

//CREDIT CARD TAGGING
function getcreditcardtagopts($db, $sqlcommand, $flddsplay, $fldvalue)
{
	$display = "";

	$resultx = mysqli_query($db, $sqlcommand);
	if (mysqli_error($db) != "") {
		return mysqli_error($db);
	}
	$count = mysqli_num_rows($resultx);
	if ($count == 0) {
		$display .= "<option value=0>NO DATA</option>";
	} else {
		$display .= "<option value=0 selected>SELECT ALL</option>";
		while ($rowx = $resultx->fetch_array()) {
			$display .= "<option value=" . $rowx[$fldvalue] . ">" . $rowx[$flddsplay] . "</option>";
		}
	}
	return $display;
}

//GET SHORT TERM LIMIT
function getstlimit($db)
{

	$sqlcmd = "SELECT * FROM sales_mbd.shorttermlimit";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["stlimitamount"];
	} else {
		return 0;
	}
}

function getstbalance($db)
{

	$sqlcmd = "SELECT SUM(stlimitamount) as availablebalance FROM
	(
		SELECT stlimitamount FROM sales_mbd.shorttermlimit
		UNION ALL
		SELECT credit * -1 as stlimitamount FROM sales_mbd.payt WHERE dbcridz = 137 AND paidba = 0
	)as tbl_tbl";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["availablebalance"];
	} else {
		return 0;
	}
}

function getstbalancejaba($db)
{

	$sqlcmd = "SELECT COUNT(*) as cntperson FROM sales_mbd.payt where dbcridz = 143 AND paidba = 0";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {	
		return $row["cntperson"];
	} else {
		return 0;
	}
}

//TAGGING REASON
function getjabareason($db, $sqlcommand, $flddsplay, $fldvalue)
{
	$display = "";

	$resultx = mysqli_query($db, $sqlcommand);
	if (mysqli_error($db) != "") {
		return mysqli_error($db);
	}
	$count = mysqli_num_rows($resultx);
	if ($count == 0) {
		$display .= "<option value=0>NO DATA</option>";
	} else {
		$display .= "<option value=0 selected>SELECT ALL</option>";
		while ($rowx = $resultx->fetch_array()) {
			$display .= "<option value=" . $rowx[$fldvalue] . ">" . $rowx[$flddsplay] . "</option>";
		}
	}
	return $display;
}

//AGING
function getsalestotal($db,$itemidz,$startdate)
{
	$sqlcmd = "SELECT SUM(salesqty) as salesqty FROM
(
	SELECT IF(ISNULL(SUM(salesqty)),0.00,SUM(salesqty)) as salesqty FROM
	(
		SELECT qty - IFNULL(refqty,0) as salesqty FROM sales_mbd.invdet
		LEFT OUTER JOIN
		(
			SELECT SUM(refqty) as refqty,invdetidz FROM sales_mbd.refund WHERE DATE(tsz) > '$startdate' GROUP BY invdetidz
		)as tblnew_refund ON tblnew_refund.invdetidz = sales_mbd.invdet.invdetidxx
		WHERE DATE(tsz) > '$startdate' AND itemidz = $itemidz
	)as salesall
	UNION ALL
	SELECT IF(ISNULL(SUM(salesqty)),0.00,SUM(salesqty)) as salesqty FROM
	(
		SELECT invqty as salesqty FROM sales_mcore.salesdet
		LEFT OUTER JOIN
		(
			SELECT SUM(refqty) as refqty,invdetidz FROM sales_mcore.salesref WHERE DATE(tsz) > '$startdate' GROUP BY invdetidz
		)as tblold_refund ON tblold_refund.invdetidz = sales_mcore.salesdet.invdetidxx
		WHERE DATE(tsz) > '$startdate' AND itemidz = $itemidz
	)as salesall_old
)as sales_all";
	$resultx = mysqli_query($db, $sqlcmd);
	$rowx = mysqli_fetch_array($resultx, MYSQLI_ASSOC);
	$count = mysqli_num_rows($resultx);
	if ($count >= 1) {	
		return $rowx["salesqty"];
	}
	return 0;
}

//COD LIMIT PER EMPLOYEE
function getcodlimit($db,$nameidz,$newcod)
{

	$sqlcmd = "SELECT IFNULL(SUM(credit),0) as unpaidcod,codlimit FROM
(
	SELECT credit,rate * 12 as codlimit FROM sales_mbd.codapprove
	INNER JOIN sales_mbd.payt ON sales_mbd.payt.invidz = sales_mbd.codapprove.invidz AND dbcridz = 4
	INNER JOIN vlookup_mcore.vnamenew ON vlookup_mcore.vnamenew.nameidxx = sales_mbd.codapprove.nameidz
	WHERE sales_mbd.codapprove.nameidz = $nameidz AND paidba = 0
)as tbl_cod";
	$result = mysqli_query($db, $sqlcmd);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
	if ($count >= 1) {
		$unpaidcod = $row["unpaidcod"];
		$codlimit = $row["codlimit"];
		
		if($unpaidcod + $newcod > $codlimit)
		{
			return 0;
		}
		else
		{
			return 1;
		}
	} else {
		return 0;
	}
}

//NEW AR
function optionlstpr($db,$sqlcommand,$flddsplay,$fldvalue)
{
	$display = "";
	
	$resultx = mysqli_query($db, $sqlcommand);
	if(mysqli_error($db)!="")
	{
		return mysqli_error($db);
	}
	$count = mysqli_num_rows($resultx);
	if($count == 0)
	{
		$display .= "<option value=0>NO DATA</option>";
	}
	else
	{
		$display .= "<option value=0 selected>Please Select</option>";
		while($rowx = $resultx->fetch_array())
		{
			if($rowx["pendingstatus"] == 0)
			{
				$display .= "<option value=".$rowx[$fldvalue].">".$rowx[$flddsplay]."</option>";
			}
			else
			{
				$display .= "<option value=".$rowx[$fldvalue]." disabled>".$rowx[$flddsplay]."</option>";
			}
		}
	}
	return $display;	
}
?>