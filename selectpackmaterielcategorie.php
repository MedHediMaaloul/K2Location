<?php
include('Gestion_location/inc/connect_db.php');
if ($_POST['id_materiel']) {
    $query = "SELECT num_serie_obg FROM materiels where id_materiels=" . $_POST['id_materiel'];
    $result = mysqli_query($conn, $query);
    $row = $result->fetch_assoc();
    echo  $row['num_serie_obg'];
}