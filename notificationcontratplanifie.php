<?php

session_start();
include("Gestion_location/inc/connect_db.php");

global $conn;

$update_query = "UPDATE contrat_client SET contrat_status=1 WHERE contrat_status=0 and date_fin = Now()";

$result = mysqli_query($conn, $update_query);
?>