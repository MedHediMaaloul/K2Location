<?php
include('Gestion_location/inc/connect_db.php');
$sysdate = date("Y-m-d");
 $query = "SELECT * FROM entretien where date_fin_entretien='$sysdate'";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
  $id_voiture = $row['id_voiture'];


  $qt= " UPDATE voiture set etat_voiture= 'Disponible' where  id_voiture=$id_voiture  ";
  $res = mysqli_query($conn, $qt);

}