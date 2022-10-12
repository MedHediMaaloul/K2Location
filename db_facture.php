<?php

session_start();
include("Gestion_location/inc/connect_db.php");

global $conn;

$sqlQuery = "INSERT INTO facture_client (id_client,id_contrat,id_agence) 
            SELECT id_client, id_contrat, id_agence 
            FROM contrat_client AS C 
            WHERE ( C.date_fin > Now() AND C.date_debut < Now() AND DAY(C.date_debut) = DAY(NOW()) )
            OR ( C.date_fin = date(NOW()) )";

$result = mysqli_query($conn, $sqlQuery);