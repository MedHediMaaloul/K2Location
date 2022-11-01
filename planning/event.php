<?php
session_start();
if (($_SESSION['Role']) == "superadmin" || ($_SESSION['Role']) == "admin" || ($_SESSION['Role']) == "responsable") {
	include_once("../Gestion_location/inc/connect_db.php");
} else {
	header("Location:login.php");
}
$id_agence = $_SESSION['id_agence'];
if (($_SESSION['Role']) == "admin") {
	$req = "SELECT id_contrat,type_location
				FROM contrat_client 
				where id_agence = '$id_agence'
				AND etat_contrat = 'A' ";
	$result = mysqli_query($conn, $req);
} else {
	$req = "SELECT id_contrat,type_location
				FROM contrat_client 
				WHERE etat_contrat = 'A'";
	$result = mysqli_query($conn, $req);
}
$calendar = array();
while ($rowcontrat = mysqli_fetch_row($result)) {
	$id_contrat = $rowcontrat[0];
	$type_contrat = $rowcontrat[1];
	if ($type_contrat == "Vehicule") {
		$sql = "SELECT c.id_contrat AS id, v.pimm AS title, c.date_debut AS start_date, c.date_fin AS end_date
		FROM contrat_client as c 
		JOIN voiture as v ON c.id_voiture = v.id_voiture
		WHERE etat_contrat = 'A'
		AND id_contrat = '$id_contrat'";
	} elseif ($type_contrat == "Materiel") {
		$sql = "SELECT c.id_contrat AS id, m.designation AS title, c.date_debut AS start_date, c.date_fin AS end_date
		FROM contrat_client as c 
		JOIN materiels_agence as ma ON c.id_materiels_contrat = ma.id_materiels_agence
		JOIN materiels as m ON ma.id_materiels = m.id_materiels
		WHERE etat_contrat = 'A'
		AND id_contrat = '$id_contrat'";
	} elseif ($type_contrat == "Pack") {
		$sql = "SELECT c.id_contrat AS id, GP.designation_pack AS title, c.date_debut AS start_date, c.date_fin AS end_date
		FROM contrat_client as c 
		JOIN group_packs as GP ON GP.id_group_packs = c.id_group_pack
		WHERE etat_contrat = 'A'
		AND id_contrat = '$id_contrat'";					
	}
	$resultset = mysqli_query($conn, $sql);
	
	while($rows = mysqli_fetch_assoc($resultset)) {	
		$start = strtotime($rows['start_date']. "+1 days") * 1000;
		$end = strtotime($rows['end_date']. "+1 days") * 1000;  
		if ($type_contrat == "Vehicule") {
			$calendar[] = array(
				'id' =>$rows['id'],
				'title' => "CONTRAT DE LOCATION VEHICULE N° ".$rows['id']." - ".$rows['title'],
				'url' => "fpdf/contratvehicule.php?id=".$rows['id'],
				"class" => 'event-important',
				'start' => "$start",
				'end' => "$end"
			);
		} elseif ($type_contrat == "Materiel") {
			$calendar[] = array(
				'id' =>$rows['id'],
				'title' => "CONTRAT DE LOCATION MATERIEL N° ".$rows['id']." - ".$rows['title'],
				'url' => "fpdf/ContratMateriel.php?id=".$rows['id'],
				"class" => 'event-important',
				'start' => "$start",
				'end' => "$end"
			);
		} elseif ($type_contrat == "Pack") {
			$calendar[] = array(
				'id' =>$rows['id'],
				'title' => "CONTRAT DE LOCATION PACK N° ".$rows['id']." - ".$rows['title'],
				'url' => "fpdf/ContratPack.php?id=".$rows['id'],
				"class" => 'event-important',
				'start' => "$start",
				'end' => "$end"
			);
		}
	}
}
$calendarData = array(
	"success" => 1,	
	"result"=>$calendar);
echo json_encode($calendarData);	
exit;	



?>