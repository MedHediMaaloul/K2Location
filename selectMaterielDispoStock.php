<?php
session_start();
include('Gestion_location/inc/connect_db.php');
$id_agence = $_SESSION['id_agence'];

$value = '<div class="table-responsive">
<table  class="table customize-table mb-0 v-middle">
<thead class="table-light">
            <th class="border-top-0">ID</th>
            <th class="border-top-0">N° série de matériel </th>
            <th class="border-top-0">Quantité disponible</th>
            <th class="border-top-0">Disponibilité</th>
            
        </tr>
        </thead>';

// disponibilite_materiel_num_serie(1, $debut, $fin);
if ($id_agence != "0") {
    $query = "SELECT * FROM materiels_agence,materiels where materiels_agence.id_materiels = materiels.id_materiels
 and  materiels_agence.etat_materiels !='F'
and id_agence = '$id_agence'
ORDER BY etat_materiels ASC

";
} else {
    $query = "SELECT * FROM materiels_agence,materiels where materiels_agence.id_materiels = materiels.id_materiels
    and  materiels_agence.etat_materiels !='F'
    ORDER BY etat_materiels ASC
    
    ";
}

$result = mysqli_query($conn, $query);


while ($row = mysqli_fetch_assoc($result)) {

    if ($row['etat_materiels'] == "HS") {
        $color = "badge bg-light-info text-white fw-normal";
        $color1 = "background-color: #ffc36d!important";
        $etat = "HORS SERVICE";
    } elseif ($row['etat_materiels'] == "T") {
        $disponibilte =  $row['quantite_materiels_dispo'];

        //  $disponibilte = disponibilite_materiel_num_serie($row['id_materiels_agence']);
        if ($disponibilte > 0) {
            $color = "badge bg-light-success text-white fw-normal";
            $color1 = "background-color: #2cd07e!important";
            $etat = "DISPONIBLE";
        } else {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ff5050!important";
            $etat = "NON DISPONIBLE";
        }
    } else {
        $color = "badge bg-light-info text-white fw-normal";
        $color1 = "background-color: #ff5050!important";
        $etat = "NON DISPONIBLE";
    }

    $value .= '
    <tbody>
           
                <tr>
                <td class="border-top-0">' . $row['id_materiels'] . '</td>
                <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                <td class="border-top-0">' . $row['quantite_materiels_dispo'] . '</td>
                              
                <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                <td class="border-top-0">
                </td>
                </tr>
                </tbody>';
}



$value .= '</table>
</div>';



echo json_encode(['status' => 'success', 'html' => $value]);



// function disponibilite_materiel_num_serie($id_materiels_agence)
// {
//     global $conn;

//     /*
//     $sqlqtidispo = "SELECT quantite_materiels_dispo from   materiels_agence where  id_materiels_agence ='$id_materiels_agence' ";
//     $resultqtidispo = mysqli_query($conn, $sqlqtidispo);
//     $row = mysqli_fetch_assoc($resultqtidispo);
//     $row['quantite_materiels_dispo'];
// */

//     $query1 = "SELECT * FROM contrat_client, materiel_contrat_client
//     where  contrat_client.id_contrat= materiel_contrat_client.id_contrat and 
//     id_materiels_agence ='$id_materiels_agence' and 
//     ((date_debut <=DATE(NOW())) and (date_fin >=DATE(NOW()) )) ";
//     $result1 = mysqli_query($conn, $query1);
//     while ($row = mysqli_fetch_assoc($result1)) {
//         if ($row['quantite_materiels_dispo'] > 0) {

//             return "disponibile";
//         } else {
//             return " non disponibile";
//         }
//     }
// }