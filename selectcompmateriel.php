<?php
include('Gestion_location/inc/connect_db.php');
if ($_POST['id_materiels_agence']) {
    $query = "SELECT * FROM composant_materiels where id_materiels_agence=" . $_POST['id_materiels_agence'];
    $result = mysqli_query($conn, $query);
    while ($row = $result->fetch_assoc()) {
        echo  '<div>' . $row['designation_composant'] . ' - ' . $row['num_serie_composant'] . '</div>';
    }
}