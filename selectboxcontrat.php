<?php
include('Gestion_location/inc/connect_db.php');
if ($_POST['Model_id']) {
    $query = "SELECT * FROM voiture as V LEFT join marquemodel as MM on V.id_MarqueModel = MM.id_MarqueModel
     where  V.etat_voiture = 'Disponible'
     AND V.id_MarqueModel=" . $_POST['Model_id'];
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        echo '<option value="" disabled selected>Select PIMM</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value=' . $row['id_voiture'] . '>' . $row['pimm'] . '</option>';
        }
    } else {

        echo '<option>No pimm Found!</option>';
    }
}
// if($_POST['ClientContrat']){
//     $query = "SELECT * FROM client where id_client=".$_POST['ClientContrat'];
//     $result = mysqli_query($conn, $query);
//     if ($result->num_rows > 0 ){
//         echo '<option value="" disabled selected>Select CIN</option>';
//         while ($row = $result->fetch_assoc()) {
//             echo '<option value='.$row['id_client'].'>'.$row['cin'].'</option>';
//         }
//     }else{
    
//        echo '<option>No cin Found!</option>';
    
//     }
// }