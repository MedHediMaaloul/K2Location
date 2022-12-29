<?php
$servername = 'Localhost';
$username = 'root';
$password = 'K2Location';
$dbname = 'db_k2loc';

$conn = mysqli_connect($servername, $username, $password, $dbname);

$sqlQuery = "INSERT INTO facture_client (id_client,id_contrat,id_agence) 
            SELECT id_client, id_contrat, id_agence 
            FROM contrat_client AS C 
            WHERE ( C.date_fin > Now() AND C.date_debut < Now() AND DAY(C.date_debut) = DAY(NOW()) )
            OR ( C.date_fin = date(NOW()) )";
$result = mysqli_query($conn, $sqlQuery);
?>