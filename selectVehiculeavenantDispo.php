<?php
session_start();
include('Gestion_location/inc/connect_db.php');
$id_agence = $_SESSION['id_agence'];

if ($_POST['DateDebutContratAvenant'] && $_POST['DateFinContratAvenant'] && $_POST['IDContrat']) {
    $debut = $_POST['DateDebutContratAvenant'];
    $fin = $_POST['DateFinContratAvenant'];
    $id_contrat = $_POST['IDContrat'];
    $type = $_POST['type'];

if($type == "updatecontratavenant"){
    $querycontrat = "SELECT id_contrat_client FROM contrat_client_avenant
                where id_contrat_avenant = $id_contrat";
    $resultcontrat = mysqli_query($conn, $querycontrat);
    $rowcontrat= mysqli_fetch_row($resultcontrat);
    $id_contrat = $rowcontrat[0];
}
$query_agence = "SELECT id_agence FROM contrat_client
                where id_contrat = $id_contrat";
$result_agence = mysqli_query($conn, $query_agence);
$row_agence = mysqli_fetch_row($result_agence);
$id_agence = $row_agence[0];

$query = "SELECT * FROM voiture WHERE
id_agence = '$id_agence' and etat_voiture = 'Disponible' AND actions='T' ";

$result = mysqli_query($conn, $query);

?>
<label class="col-md-12 p-0"> Vehicule<span class="text-danger">*</span></label>
<div class="col-md-12 border-bottom p-0">
    <select id="list_materiel_avenant" name="list_materiel_avenant" placeholder="Nom" class="form-control p-0 border-0" required>
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
                    echo '<option disabled style="background-color:red; color:white;" value="' . $row['id_voiture'] . '">' . $row['pimm'] . '-' . substr($row['pimm'], 0, 1) .  ' Non Disponible</option>';
                }
            }
        }
        ?>
    </select>
</div>

<script type="text/javascript">
    $(function() {
        $('#list_materiel_avenant').select2({
            dropdownParent: $('#list_materiel_avenant').parent()
        });
    })
</script>

<?php
}
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