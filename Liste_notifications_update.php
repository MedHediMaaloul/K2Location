<?php

include("Gestion_location/inc/connect_db.php");

global $conn;
        if (isset($_GET["clicked_id"])) {
		    $query30 = "UPDATE contrat_client SET view = 1 WHERE id_contrat = ".$_GET['clicked_id'];
		    if (mysqli_query($conn, $query30)) {
		      echo "Record updated successfully";
		    } else {
		      echo "Error updating record: " . mysqli_error($conn);
		    }

			$query_get_type_contrat = "SELECT type_location FROM contrat_client WHERE id_contrat = ".$_GET['clicked_id'];
            $result_get_type_contrat = mysqli_query($conn, $query_get_type_contrat);
            $row = mysqli_fetch_row($result_get_type_contrat);
    		if($row[0] == "Vehicule"){
    		    header('Location: fpdf/contratlocationvehicule.php?id='.$_GET['clicked_id']); 
    		}elseif($row[0] == "Materiel"){
    		    header('Location: fpdf/contratlocationmateriel.php?id='.$_GET['clicked_id']); 
    		}elseif($row[0] == "Pack"){
				header('Location: fpdf/contratlocationpack.php?id='.$_GET['clicked_id']); 
			}
		}else{
		        // echo "dhfjdshfshlk";
		}
  		// header('Location: fpdf/ContratPack.php?id='.$_GET['clicked_id']);   
?>