<?php
session_start();
include('Gestion_location/inc/connect_db.php');
global $conn;
$id_agence = $_SESSION['id_agence'];
$value = '
<div class="table-responsive">
<table  class="table customize-table mb-0 v-middle">
<thead class="table-light">
        <tr>
            <th class="border-top-1">ID A</th>
            <th class="border-top-1">Pimm</th>
            <th class="border-top-1">Type</th>
            <th class="border-top-1">Date Achat</th>
            <th class="border-top-1">Agence</th>
            <th class="border-top-1">Disponibilité</th>
            <th class="border-top-1">Transfert </th>
            
        </tr>
</thead>';

if ($id_agence != "0") {
    $query = "SELECT * FROM voiture,agence
    WHERE voiture.id_agence = agence.id_agence 
    AND voiture.id_agence = '$id_agence'
    AND voiture.actions !='S'
    ORDER BY `etat_voiture` ASC";
} else {
    $query = " SELECT * FROM `voiture`,agence
     WHERE voiture.id_agence = agence.id_agence 
     AND  voiture.actions !='S'
     ORDER BY `etat_voiture` ASC";
}

$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {

    if ($row['etat_voiture'] == "Loue") {
        $color = "badge bg-light-warning text-warning fw-normal";
        $color1 = "background-color: #ffedd4!important";
        $row['etat_voiture'] = "LOUER";
    } elseif ($row['etat_voiture'] == "Entretien") {
        $color = "badge bg-light-info text-white fw-normal";
        $color1 = "background-color: #ffc36d!important";
        $row['etat_voiture'] = "ENTRETIEN";
    } elseif ($row['etat_voiture'] == "Vendue") {
        $color = "badge bg-light-info text-white fw-normal";
        $color1 = "background-color: #ff5050!important";
        $row['etat_voiture'] = "VENDU";
    } elseif ($row['etat_voiture'] == "HS") {
        $color = "badge bg-light-info text-white fw-normal";
        $color1 = "background-color: #343a40!important";
        $row['etat_voiture'] = "HORS SERVICE";
    } elseif ($row['etat_voiture'] == "Disponible") {
        $disponibilte = disponibilite_Vehicule1($row['id_voiture']);
        if ($disponibilte == 'disponibile') {
            $color = "badge bg-light-success text-white fw-normal";
            $color1 = "background-color: #2cd07e!important";
            $row['etat_voiture'] = "DISPONIBLE";
        } else {

            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ff5050!important";
            $row['etat_voiture'] = "NON DISPONIBLE";
        }
    }
    $value .= '
    <tbody>
            <tr>
                <td class="border-top-1  ">' . $row['id_voiture'] . '</td>
                <td class="border-top-1">' . $row['pimm'] . '</td>
                <td class="border-top-1">' . $row['type'] . '</td>
                <td class="border-top-1">' . $row['date_achat'] . '</td>
                <td class="border-top-1">' . $row['lieu_agence'] . '</td>
                <td><span class="' . $color . '" style ="' . $color1 . '">' . $row['etat_voiture'] . '</span></td>';

    if ($row['etat_voiture'] != "VENDU") {

        $value .= '         <td><button class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert" data-id=' . $row['id_voiture'] . '><i class="fas fa-exchange-alt"></i></button></td>';
    }

    $value .= '        </tr>
    </tbody>';
}

$value .= '</table>
</div>';
//header('Content-type:application/json;charset=utf-8');
//  <button class="btn btn-primary" id="btn-edit-user" data-id=' . $row['id_user'] . '><i class="fas fa-edit"></i></button> <button class="btn btn-danger" id="btn-delete-user" data-id1=' . $row['id_user'] . '><i class="fas fa-trash-alt"></i></button>

echo json_encode(['status' => 'success', 'html' => $value]);





function disponibilite_Vehicule1($id_voiture)
{
    global $conn;

    /*
    $sqlqtidispo = "SELECT quantite_materiels_dispo from   materiels_agence where  id_materiels_agence ='$id_materiels_agence' ";
    $resultqtidispo = mysqli_query($conn, $sqlqtidispo);
    $row = mysqli_fetch_assoc($resultqtidispo);
    $row['quantite_materiels_dispo'];
*/

    $query = "SELECT * FROM contrat_client 
    where  
    id_voiture ='$id_voiture' and 
    ((date_debut <= DATE(NOW()) and date_fin >=DATE(NOW()) ))
     
    ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        return "disponibile";
    } else {
        return "non disponibile";
    }
}