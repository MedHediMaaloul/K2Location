<?php
$servername = 'Localhost';
$username = 'root';
$password = 'K2Location';
$dbname = 'db_k2loc';

$conn = mysqli_connect($servername, $username, $password, $dbname);

$update_query = "UPDATE contrat_client SET contrat_status=1 WHERE contrat_status=0 and date_fin = CURDATE()";
$result = mysqli_query($conn, $update_query);
?>