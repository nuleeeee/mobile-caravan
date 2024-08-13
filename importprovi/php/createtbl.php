<?php
include "../../php/allfunction.php";

$sql = "USE `mobilejaba`;";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `mobilejaba`.`mobilevproduct` (
      `idxx` int(11) NOT NULL AUTO_INCREMENT,
      `providetidz` decimal(20,4) DEFAULT NULL,
      `pridz` decimal(20,4) DEFAULT NULL,
      `itemidz` int(11) DEFAULT NULL,
      `itemcode` char(25) DEFAULT NULL,
      `itemdesc` char(30) DEFAULT NULL,
      `prqty` decimal(9,3) DEFAULT NULL,
      `sprice` decimal(9,2) DEFAULT NULL,
      `cashieridz` int(11) DEFAULT NULL,
      `tsz` datetime DEFAULT NULL,
      PRIMARY KEY (`idxx`),
      UNIQUE KEY `idxx_UNIQUE` (`idxx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
mysqli_query($db, $sql);

echo $sql;