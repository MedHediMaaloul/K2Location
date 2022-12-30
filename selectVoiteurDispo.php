<?php
session_start();
include('Gestion_location/inc/connect_db.php');
$id_agence = $_SESSION['id_agence'];

if ($_POST['DateDebutContrat'] && $_POST['DateFinContrat']) {
    $debut = $_POST['DateDebutContrat'];
    $fin = $_POST['DateFinContrat'];
}
if ($id_agence != "0") {
    $query = "SELECT * FROM voiture WHERE
    id_agence = '$id_agence' and etat_voiture = 'Disponible' AND actions='T' ";
} else {
    $agencecontratvoiture = $_POST['contratvehiculeagence'];
    $query = "SELECT * FROM voiture WHERE
    id_agence = '$agencecontratvoiture' and etat_voiture = 'Disponible' AND actions='T' ";
}


$result = mysqli_query($conn, $query);

?>
<label class="col-md-12 p-0"> Vehicule<span class="text-danger">*</span></label>
<div class="col-md-12 border-bottom p-0">
    <select id="list_materiel" name="list_materiel" placeholder="Nom " class="form-control p-0 border-0" required>
        <option value="" disabled selected> Vehicule
        </option>
        <?php
        if ($result->num_rows > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                //  $disponibilte = 'disponibile';
                $disponibilte = disponibilite_Vehicule($row['id_voiture'], $debut, $fin);
                if ($disponibilte == 'disponibile') {
                    echo '<option value="' . $row['id_voiture'] . '">' . $row['pimm'] . '-' . substr($row['pimm'], 0, 1) . '</option>';
                } else {
                    echo '<option disabled value="' . $row['id_voiture'] . '">' . $row['pimm'] . '-' . substr($row['pimm'], 0, 1) .  ' Non Disponible</option>';
                }
            }
        }
        ?>
    </select>
</div>

<script type="text/javascript">
    $(function() {
        $('#list_materiel').select2({
            dropdownParent: $('#list_materiel').parent()
        });
    })
</script>

<?php



function disponibilite_Vehicule($id_voiture, $debut, $fin)
{
    global $conn;

    $query = "SELECT * FROM contrat_client 
    where  
    id_voiture ='$id_voiture' and 
    ((date_debut <='$debut' and date_fin >='$debut' )
     or (date_debut <='$fin' and date_fin >='$fin' ) 
     or (date_debut >='$debut' and date_fin <='$fin' ))
     AND etat_contrat != 'S'
    ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);

    $query_avenant = "SELECT * FROM contrat_client_avenant 
    where  
    id_voiture_avenant ='$id_voiture' and 
    ((debut_contrat_avenant <='$debut' and fin_contrat_avenant >='$debut' )
     or (debut_contrat_avenant <='$fin' and fin_contrat_avenant >='$fin' ) 
     or (debut_contrat_avenant >='$debut' and fin_contrat_avenant <='$fin' ))";
    $result_avenant = mysqli_query($conn, $query_avenant);
    $nb_res_avenant = mysqli_num_rows($result_avenant);

    if ($nb_res == 0 && $nb_res_avenant == 0) {
        return "disponibile";
    } else {
        return " non disponibile";
    }
}
?>