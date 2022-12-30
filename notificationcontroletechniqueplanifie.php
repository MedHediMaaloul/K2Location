<?php
$servername = 'Localhost';
$username = 'root';
$password = 'K2Location';
$dbname = 'db_k2loc';

$conn = mysqli_connect($servername, $username, $password, $dbname);

$update_query = "UPDATE controletechnique SET controle_status=1 WHERE controle_status=0 AND date_controletechnique = CURDATE()";
$result = mysqli_query($conn, $update_query);
?>
