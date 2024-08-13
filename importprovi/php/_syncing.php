<?php
include "../../php/allfunction.php";

$get = "SELECT prdetidxx, pridz, itemidz, prqty, itemcode, item, vsprice, cashieridz, tsz
            FROM provijaba_mbd.providet
            /*WHERE DATE(tsz) = DATE(NOW())*/";
$getresult = mysqli_query($db, $get);

while ($row = mysqli_fetch_array($getresult))
{
      // Check if prdetidxx already exists in mobilevproduct
      $checkQuery = "SELECT COUNT(*) AS count FROM vproduct_mcore.mobilevproduct WHERE providetidz = ".$row["prdetidxx"];
      $checkResult = mysqli_query($db, $checkQuery);
      $checkRow = mysqli_fetch_assoc($checkResult);
      $count = $checkRow['count'];

      // If prdetidxx does not exist, insert into mobilevproduct
      if ($count == 0) {
            $sql = "INSERT INTO vproduct_mcore.mobilevproduct (providetidz, pridz, itemidz, itemcode, itemdesc, prqty, sprice, cashieridz, tsz) VALUES (".$row["prdetidxx"].", ".$row["pridz"].", ".$row["itemidz"].", '".$row["itemcode"]."', '".str_replace("'","`",$row["item"])."', ".$row["prqty"].", ".$row["vsprice"].", ".$row["cashieridz"].", '".$row["tsz"]."')";
            $sqlresult = mysqli_query($db, $sql);

            if ($sqlresult) {
                  echo "";
            } else {
                  echo "Syncing error: " . mysqli_error($db);
            }
      } else {
            // If prdetidxx already exists, skip insertion
            echo "Record already exists for providetidz: ".$row["prdetidxx"]."<br>";
      }
}