<?php

include("Gestion_location/inc/connect_db.php");

global $conn;

if (isset($_GET["clicked_id"])) {
        $queryupdatestatutCT = "UPDATE controletechnique SET controle_status = 1 WHERE id_controletechnique = ".$_GET['clicked_id'];
        if (mysqli_query($conn, $queryupdatestatutCT)) {
          echo "Record updated successfully";
        } else {
          echo "Error updating record: " . mysqli_error($conn);
        }
}

header('Location: ListeNotifcationEntretien.php?id='.$_GET['clicked_id']);   

?>