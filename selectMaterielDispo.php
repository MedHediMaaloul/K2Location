<?php
session_start();
include('Gestion_location/inc/connect_db.php');
$id_agence = $_SESSION['id_agence'];


if ($_POST['DateDebutContrat'] && $_POST['DateFinContrat']) {
    $debut = $_POST['DateDebutContrat'];
    $fin = $_POST['DateFinContrat'];
}

if ($id_agence != "0") {
    $query = "SELECT * FROM materiels_agence,materiels where materiels_agence.id_materiels = materiels.id_materiels
            and  type_location = 'Individuel' 
            and id_agence = '$id_agence'
            and etat_materiels = 'T'
            ORDER BY designation ASC ";
} else {
    $agencecontratmateriel = $_POST['contratmaterielagence'];
    $query = "SELECT * FROM materiels_agence,materiels where materiels_agence.id_materiels = materiels.id_materiels
            and  type_location = 'Individuel' 
            and id_agence = '$agencecontratmateriel'
            and etat_materiels = 'T'
            ORDER BY designation ASC ";
}
$result = mysqli_query($conn, $query);

?>
<label class="col-md-12 p-0"> Materiel<span class="text-danger">*</span></label>
<div class="col-md-12 border-bottom p-0">
    <select id="list_materiel" name="list_materiel" placeholder="Nom " class="form-control p-0 border-0"
        onchange="List_Comp_Materiel(this.value)" required>
        <option value="" disabled selected>Nom Materiel &
            Num</option>
        <?php
        if ($result->num_rows > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                $disponibilte = disponibilite_materiel_num_serie($row['id_materiels_agence'], $debut, $fin);
                if ($disponibilte == 'disponibile') {
                    echo '<option value="' . $row['id_materiels_agence'] . '">' . $row['code_materiel'] . '-' . $row['designation'] . '-' . $row['num_serie_materiels'] . '</option>';
                } else {
                    echo '<option disabled value="' . $row['id_materiels_agence'] . '">' . $row['code_materiel'] . '-' . $row['designation'] . '-' . $row['num_serie_materiels'] . ' Non Disponible</option>';
                }
            }
        }
        ?>
    </select>
</div>


<?php



function disponibilite_materiel_num_serie($id_materiels_agence, $debut, $fin)
{
    global $conn;

    $query = "SELECT * FROM contrat_client, materiel_contrat_client
    where  contrat_client.id_contrat= materiel_contrat_client.id_contrat and 
    id_materiels_agence ='$id_materiels_agence' and 
    ((date_debut <='$debut' and date_fin >='$debut' )
     or (date_debut <='$fin' and date_fin >='$fin' ) 
     or (date_debut >='$debut' and date_fin <='$fin' ))
     
    ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        return "disponibile";
    } else {
        return " non disponibile";
    }
}
?>