<?php
session_start();
include("Gestion_location/inc/connect_db.php");

global $conn;
if (isset($_GET["clicked_id"])) {
    $query30 = "UPDATE notification SET status = 1 WHERE id_user=".$_SESSION['id_user']."  AND   id_contrat = ".$_GET['clicked_id'];
    if (mysqli_query($conn, $query30)) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
    
    $query_get_type_contrat = "SELECT type_location FROM contrat_client WHERE id_contrat = ".$_GET['clicked_id'];
    $result_get_type_contrat = mysqli_query($conn, $query_get_type_contrat);
    $row = mysqli_fetch_row($result_get_type_contrat);
    if($row[0] == "Vehicule"){
        header('Location: fpdf/contratvehicule1.php?id='.$_GET['clicked_id']); 
    }elseif($row[0] == "Materiel"){
        header('Location: fpdf/ContratMateriel.php?id='.$_GET['clicked_id']); 
    }elseif($row[0] == "Pack"){
        header('Location: fpdf/ContratPack.php?id='.$_GET['clicked_id']); 
    }
}
?>