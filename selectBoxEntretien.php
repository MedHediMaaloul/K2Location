<?php
include('Gestion_location/inc/connect_db.php');
if($_POST['Model_id']){
    $query = "SELECT * FROM voiture as V LEFT join marquemodel as MM on V.id_MarqueModel = MM.id_MarqueModel where V.id_MarqueModel=".$_POST['Model_id'];
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0 ){
        echo '<option value="" disabled selected>Select PIMM</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value='.$row['id_voiture'].'>'.$row['pimm'].'</option>';
        }
    }else{
    
       echo '<option>No pimm Found!</option>';
    
    }

}elseif($_POST['Pimm_id']){

    $query = "SELECT * FROM voiture where id_voiture=".$_POST['Pimm_id'];
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0 ){
        echo '<option value="" disabled selected>Select date achat voiture</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value='.$row['date_achat'].'>'.$row['date_achat'].'</option>';
        }
    }else{
    
       echo '<option>No date Found!</option>';
    
    }
}
if($_POST['Materiel_id']){
    $query = "SELECT * FROM materiel where id_materiel=".$_POST['Materiel_id'];
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0 ){
        echo '<option value="" disabled selected>Select Num Serie</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option  value='.$row['id_materiel'].'>'.$row['num_serie'].'</option>';
        }
    }else{
    
       echo '<option>No Num Serie Found!</option>';
    
    }

}elseif($_POST['NumSerieMateriel']){

    $query = "SELECT * FROM materiel where id_materiel=".$_POST['NumSerieMateriel'];
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0 ){
        echo '<option value="" disabled selected>Select date achat materiel</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value='.$row['date_achat'].'>'.$row['date_achat'].'</option>';
        }
    }else{
    
       echo '<option>No date Found!</option>';
    
    }
}
















?>