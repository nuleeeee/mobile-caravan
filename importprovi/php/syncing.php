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

$get = "SELECT prdetidxx, pridz, itemidz, prqty, itemcode, item, vsprice, cashieridz, tsz
            FROM provijaba_mbd.providet
            WHERE pridz = '$txt_prid'";
$getresult = mysqli_query($dbonlineserver, $get);

while ($row = mysqli_fetch_array($getresult))
{
      // Check if prdetidxx already exists in mobilevproduct
      $checkQuery = "SELECT COUNT(*) AS count FROM mobilejaba.mobilevproduct WHERE providetidz = ".$row["prdetidxx"];
      $checkResult = mysqli_query($dbonlineserver, $checkQuery);
      $checkRow = mysqli_fetch_assoc($checkResult);
      $count = $checkRow['count'];

      if ($count > 0) {
            // If prdetidxx already exists, skip insertion
      } else {
            // If prdetidxx does not exist, insert into mobilevproduct
            $sql = "INSERT INTO mobilejaba.mobilevproduct (providetidz, pridz, itemidz, itemcode, itemdesc, prqty, sprice, cashieridz, tsz) VALUES (".$row["prdetidxx"].", ".$row["pridz"].", ".$row["itemidz"].", '".$row["itemcode"]."', '".str_replace("'","`",$row["item"])."', ".$row["prqty"].", ".$row["vsprice"].", ".$row["cashieridz"].", '".$row["tsz"]."')";
            $sqlresult = mysqli_query($dbonlineserver, $sql);

            if ($sqlresult) {
                  echo "";
            } else {
                  echo "Syncing error: " . mysqli_error($dbonlineserver);
            }
      }
}