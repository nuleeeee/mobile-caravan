<?php
session_start();
include "connect.php";

$pin = $_POST['login_pin'];

$pin = validate($_POST['login_pin']);

$sql = "SELECT  COALESCE(vlookup_mcore.vemployeeposition.position, 
                        IF(vproduct_mcore.category.catz IS NOT NULL, 
                        vproduct_mcore.category.catz, oldpos.position)) as position, 
                nameidxx as nameidz, CONCAT(firstname,' ',lastname) as vname, pin, bridz, vnamenew.hide 
        FROM vlookup_mcore.vnamenew
        LEFT OUTER JOIN
        (
            SELECT GROUP_CONCAT(catz SEPARATOR ', ') as position,nameidz 
            FROM
            (
                SELECT dtr_mcore.brpos.*,catz FROM dtr_mcore.brpos
                INNER JOIN
                (
                    SELECT MAX(posidxx) as posidxx FROM dtr_mcore.brpos 
                    GROUP BY nameidz,catidz
                )as tbl ON tbl.posidxx = dtr_mcore.brpos.posidxx
                INNER JOIN vproduct_mcore.category ON vproduct_mcore.category.catidxx = dtr_mcore.brpos.catidz
                WHERE status = 0 AND trstatus = 0
            )as tbsub1
            GROUP BY nameidz
        )as oldpos ON oldpos.nameidz = vlookup_mcore.vnamenew.nameidxx
        LEFT OUTER JOIN vlookup_mcore.vemployeeposition ON vlookup_mcore.vemployeeposition.positionidxx = vlookup_mcore.vnamenew.positionidz
        LEFT OUTER JOIN vproduct_mcore.category ON vproduct_mcore.category.catidxx = vlookup_mcore.vnamenew.positionidz
        WHERE pin = '$pin' AND vnamenew.hide = 0";

$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if ($row['pin'] === $pin) {
        $_SESSION['login_user'] = $row["nameidz"];
        $_SESSION['user_position'] = $row["position"];
        $_SESSION['user_nameidzs'] = $row["nameidz"];
        $_SESSION['branch'] = $row["bridz"];
        // echo $row["vname"];
        echo json_encode(array("vname" => $row["vname"], "branch" => $row["bridz"]));
    } else {
        echo 1;
    }
} else {
    echo 1;
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>