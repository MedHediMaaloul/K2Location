<?php

session_start();
include("Gestion_location/inc/connect_db.php");

global $conn;

$update_query = "UPDATE controletechnique SET controle_status=1 WHERE controle_status=0 AND date_controletechnique = Now()";
$result = mysqli_query($conn, $update_query);
?>
