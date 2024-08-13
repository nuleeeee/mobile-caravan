<?php
include "../../php/allfunction.php";

$cashieridz = $_SESSION['login_user'];

$brlogin = $_POST['branch'];

$briptosave = check_user_branch($brlogin);

define('DB_SERVERONLINE', $briptosave);
$dbonlineserver = mysqli_connect(DB_SERVERONLINE, DB_USERNAME, DB_PASSWORD);

// Check the connection
if (mysqli_error($dbonlineserver) != "") {
    echo "NO CONNECTION";
    return;
}

$var_clearnameidz = $_POST["var_clearnameidz"];
$var_pridz = $_POST["var_pridz"];

$sql = "CREATE SCHEMA IF NOT EXISTS sales_mbd$lstIpall";
mysqli_query($dbonlineserver, $sql);

$sql = "USE sales_mbd$lstIpall";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`cashout` (
  `invidxx` decimal(21,4) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `amount` decimal(9,2) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `machine_id` varchar(50) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`invidxx`),
  UNIQUE KEY `invidxx_UNIQUE` (`invidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`ccdetails` (
  `creditidxx` decimal(20,3) NOT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `bankname` varchar(20) DEFAULT NULL,
  `bankid` int(2) DEFAULT NULL,
  `reference` varchar(15) DEFAULT NULL,
  `formidz` int(2) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`creditidxx`),
  UNIQUE KEY `creditidxx_UNIQUE` (`creditidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`chequeapprove` (
  `chqapproveidxx` decimal(20,3) NOT NULL,
  `nameidz` int(11) DEFAULT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`chqapproveidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`chequecleared` (
  `clearidxx` decimal(20,3) NOT NULL,
  `soapayidz` decimal(21,4) DEFAULT NULL,
  `chknumber` char(8) DEFAULT NULL,
  `chkdate` date DEFAULT NULL,
  `chkamt` decimal(9,2) DEFAULT NULL,
  `clearstatus` int(1) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`clearidxx`),
  UNIQUE KEY `clearidxx_UNIQUE` (`clearidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`codapprove` (
  `approveidxx` decimal(20,3) NOT NULL,
  `nameidz` int(11) DEFAULT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`approveidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`codarpaymentdet` (
  `codaridxx` decimal(20,3) NOT NULL,
  `codarinvidxx` decimal(21,4) DEFAULT NULL,
  `soapayidz` decimal(21,4) DEFAULT NULL,
  `coaramt` decimal(9,2) DEFAULT NULL,
  `formidz` int(2) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`codaridxx`),
  UNIQUE KEY `codaridxx_UNIQUE` (`codaridxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`commission` (
  `commidxx` decimal(21,4) NOT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `invdetidxx` decimal(20,4) DEFAULT NULL,
  `mlicomm` decimal(9,2) DEFAULT NULL,
  `suppcomm` decimal(9,2) DEFAULT NULL,
  `promomlicomm` decimal(9,2) DEFAULT NULL,
  `promosuppcomm` decimal(9,2) DEFAULT NULL,
  `formidz` int(2) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`commidxx`),
  UNIQUE KEY `commidxx_UNIQUE` (`commidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`commissionpin` (
  `commidxx` decimal(21,4) NOT NULL,
  `invdetidxx` decimal(20,4) DEFAULT NULL,
  `officeridz` int(11) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`commidxx`),
  UNIQUE KEY `commidxx_UNIQUE` (`commidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`couponpayt` (
  `couponpaytidxx` decimal(20,3) NOT NULL,
  `paytidxx` decimal(21,4) DEFAULT NULL,
  `paytidz` decimal(21,4) DEFAULT NULL,
  `amt` decimal(9,2) DEFAULT NULL,
  `formidz` int(2) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`couponpaytidxx`),
  UNIQUE KEY `couponpaytidxx_UNIQUE` (`couponpaytidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`creditcardapprov` (
  `apprvidxx` decimal(20,3) NOT NULL,
  `nameidz` int(11) DEFAULT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `paytidxx` decimal(21,4) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`apprvidxx`),
  UNIQUE KEY `apprvidxx_UNIQUE` (`apprvidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`disc` (
  `discidxx` decimal(20,4) NOT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `invdetidxx` decimal(20,4) DEFAULT NULL,
  `mlidiscamt` decimal(9,2) DEFAULT NULL,
  `suppdiscamt` decimal(9,2) DEFAULT NULL,
  `discstats` int(1) DEFAULT NULL,
  `formidz` int(2) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`discidxx`),
  UNIQUE KEY `discidxx_UNIQUE` (`discidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`discpin` (
  `discidxx` decimal(20,4) NOT NULL,
  `invdetidxx` decimal(20,4) DEFAULT NULL,
  `officeridz` int(11) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`discidxx`),
  UNIQUE KEY `discidxx_UNIQUE` (`discidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`discpromo` (
  `discpromoidxx` decimal(20,4) NOT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `invdetidxx` decimal(20,4) DEFAULT NULL,
  `mlidiscpromoamt` decimal(9,2) DEFAULT NULL,
  `suppdiscpromoamt` decimal(9,2) DEFAULT NULL,
  `formidz` int(2) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`discpromoidxx`),
  UNIQUE KEY `discpromoidxx_UNIQUE` (`discpromoidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`gcapprove` (
  `approveidxx` decimal(20,3) NOT NULL,
  `nameidz` int(11) DEFAULT NULL,
  `customername` varchar(100) DEFAULT NULL,
  `refrerencenumber` varchar(45) DEFAULT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `paytidxx` decimal(21,4) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`approveidxx`),
  UNIQUE KEY `approveidxx_UNIQUE` (`approveidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`inv` (
  `invidxx` decimal(21,4) NOT NULL,
  `nameidz` decimal(20,3) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`invidxx`),
  UNIQUE KEY `invidxx_UNIQUE` (`invidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`invdelinfo` (
  `delinfoidxx` decimal(20,3) NOT NULL,
  `invidxx` decimal(21,4) DEFAULT NULL,
  `nameidz` decimal(20,3) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`delinfoidxx`),
  UNIQUE KEY `delinfoidxx_UNIQUE` (`delinfoidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`invdelinfonew` (
  `delinfoidxx` decimal(20,3) NOT NULL,
  `invidxx` decimal(21,4) DEFAULT NULL,
  `nameidz` decimal(20,3) DEFAULT NULL,
  `dbcridz` int(11) DEFAULT NULL,
  `customername` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `contactnum` varchar(15) DEFAULT NULL,
  `ipadrs` int(11) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`delinfoidxx`),
  UNIQUE KEY `delinfoidxx_UNIQUE` (`delinfoidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`invdet` (
  `invdetidxx` decimal(20,4) NOT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `itemidz` int(11) DEFAULT NULL,
  `qty` decimal(9,3) DEFAULT NULL,
  `sprice` decimal(9,2) DEFAULT NULL,
  `itemcode` char(25) DEFAULT NULL,
  `item` char(100) DEFAULT NULL,
  `bxstatus` int(2) DEFAULT NULL,
  `vbprice` decimal(9,2) DEFAULT NULL,
  `vsprice` decimal(9,2) DEFAULT NULL,
  `sino` char(30) DEFAULT NULL,
  `nanoidz` int(2) DEFAULT NULL,
  `formidz` int(2) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`invdetidxx`),
  UNIQUE KEY `invdetidxx_UNIQUE` (`invdetidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`loyaltyapprove` (
  `loyaltyapprveidxx` decimal(20,3) NOT NULL,
  `nameidz` int(11) DEFAULT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `formidz` int(1) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`loyaltyapprveidxx`),
  UNIQUE KEY `loyaltyapprveidxx_UNIQUE` (`loyaltyapprveidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`oraccounted` (
  `oracctidxx` decimal(20,3) NOT NULL,
  `seriesdetidz` decimal(20,3) DEFAULT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `ornumber` int(11) DEFAULT NULL,
  `nameidz` decimal(20,3) DEFAULT NULL,
  `dbcridz` int(3) DEFAULT NULL,
  `dbcr` char(8) DEFAULT NULL,
  `chkdate` date DEFAULT NULL,
  `amount` decimal(9,2) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`oracctidxx`),
  UNIQUE KEY `oracctidxx_UNIQUE` (`oracctidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`payt` (
  `paytidxx` decimal(21,4) NOT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `nameidz` decimal(20,3) DEFAULT NULL,
  `dbcridz` int(3) DEFAULT NULL,
  `dbcr` char(8) DEFAULT NULL,
  `chkdate` date DEFAULT NULL,
  `debit` decimal(9,2) DEFAULT NULL,
  `credit` decimal(9,2) DEFAULT NULL,
  `sino` char(15) DEFAULT NULL,
  `soaba` int(1) DEFAULT NULL,
  `paidba` int(1) DEFAULT NULL,
  `formidz` int(2) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`paytidxx`),
  UNIQUE KEY `paytidxx_UNIQUE` (`paytidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`ptsredeemed` (
  `invidxx` decimal(21,4) NOT NULL,
  `redeempts` decimal(9,2) DEFAULT NULL,
  `ptsnameidxx` decimal(20,5) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`invidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`refund` (
  `refidxx` decimal(20,3) NOT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `sino` char(10) DEFAULT NULL,
  `invdetidz` decimal(20,4) DEFAULT NULL,
  `refqty` decimal(9,3) DEFAULT NULL,
  `formidz` int(2) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`refidxx`),
  UNIQUE KEY `refidxx_UNIQUE` (`refidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`seniordet` (
  `invidxx` decimal(21,4) NOT NULL,
  `seniorname` varchar(45) DEFAULT NULL,
  `seniorid` int(15) DEFAULT NULL,
  `nameidz` int(11) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`invidxx`),
  UNIQUE KEY `invidxx_UNIQUE` (`invidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`seniordisc` (
  `seniordiscidxx` decimal(20,3) NOT NULL,
  `invidz` decimal(21,4) DEFAULT NULL,
  `invdetidxx` decimal(20,4) DEFAULT NULL,
  `seniordiscamt` decimal(9,2) DEFAULT NULL,
  `formidz` int(2) DEFAULT NULL,
  `ipadrs` int(3) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`seniordiscidxx`),
  UNIQUE KEY `seniordiscidxx_UNIQUE` (`seniordiscidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sales_mbd$lstIpall`.`sukidet` (
  `invidxx` decimal(21,4) NOT NULL,
  `nameidz` int(11) DEFAULT NULL,
  `cashieridz` int(11) DEFAULT NULL,
  `tsz` datetime DEFAULT NULL,
  PRIMARY KEY (`invidxx`),
  UNIQUE KEY `invidxx_UNIQUE` (`invidxx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.inv";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.invdet";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.disc";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.discpromo";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.discpin";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.payt";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.invdelinfo";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.creditcardapprov";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE sales_mbd$lstIpall.codapprove";
mysqli_query($dbonlineserver, $sql);

$sql = "TRUNCATE mobilejaba.tmp_prsalesdetlink";
mysqli_query($dbonlineserver, $sql);

mysqli_close($db);
?>