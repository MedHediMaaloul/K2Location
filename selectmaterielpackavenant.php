<?php
session_start();
include('Gestion_location/inc/connect_db.php');
if($_POST['type']){

    $id_agence = $_SESSION['id_agence'];
    $id_contrat = $_POST['IDContratAvenant'];

    $query_pack = "SELECT id_group_pack FROM contrat_client
                    where id_contrat = $id_contrat";
    $result_pack = mysqli_query($conn, $query_pack);
    $row_pack = mysqli_fetch_row($result_pack);
    $pack = $row_pack[0];

    $query_agence = "SELECT id_agence FROM contrat_client
                    where id_contrat = $id_contrat";
    $result_agence = mysqli_query($conn, $query_agence);
    $row_agence = mysqli_fetch_row($result_agence);
    $id_agence = $row_agence[0];

    $debut = $_POST['DateDebutContrat'];
    $fin = $_POST['DateFinContrat'];
    $type = $_POST['type'];

    if($type == "vehicule"){
        $query = "SELECT type_voiture FROM group_packs where   id_group_packs=" .  $pack;
        $result = mysqli_query($conn, $query);
        $row = $result->fetch_assoc();
        $type_voiture = $row['type_voiture'];
        if ($type_voiture == 'sans vehicule') {
            echo  '<div>Sans Véhicule</div>
            <input name="vehicule_pack" id="vehicule_pack"  type ="hidden" value ="0">
            ';
        } else {
?>
<div class="form-group mb-4">
    <label class="col-md-12 p-0">Véhicule<span class="text-danger">*</span></label>
    <select name="vehicule_pack" id="vehicule_pack" class="form-control p-0 border-0">
        <?php
            $query1 = "SELECT * FROM voiture,marquemodel where `marquemodel`.`id_MarqueModel`= `voiture`.`id_MarqueModel` and  id_agence = $id_agence and type='$type_voiture'";
            $result1 = mysqli_query($conn, $query1);
            if ($result1->num_rows > 0) {
                while ($row1 = mysqli_fetch_assoc($result1)) {
                    $query2 = "SELECT * FROM contrat_client 
                        where ((date_debut <='$debut' and date_fin >='$debut' )
                         or (date_debut <='$fin' and date_fin >='$fin' ) 
                         or (date_debut >='$debut' and date_fin <='$fin' ))
                         AND etat_contrat != 'S'
                         AND id_voiture =".$row1['id_voiture'];
                    $result2 = mysqli_query($conn, $query2);
                    $nb_res = mysqli_num_rows($result2);

                    $query_avenant = "SELECT * FROM contrat_client_avenant 
                    where ((debut_contrat_avenant <='$debut' and fin_contrat_avenant >='$debut' )
                    or (debut_contrat_avenant <='$fin' and fin_contrat_avenant >='$fin' ) 
                    or (debut_contrat_avenant >='$debut' and fin_contrat_avenant <='$fin' ))
                    AND id_voiture_avenant =".$row1['id_voiture'];
                    $result_avenant = mysqli_query($conn, $query_avenant);
                    $nb_res_avenant = mysqli_num_rows($result_avenant);

                    if ($nb_res == 0 && $nb_res_avenant == 0) {
                        echo '<option value="' . $row1['id_voiture'] . '">' . $row1['pimm'] . '-' . substr($row1['pimm'], 0, 1) . '</option>';
                    } else {
                        echo '<option disabled style="background-color:red; color:white;" value="0">' . $row1['pimm'] . '-' . substr($row1['pimm'], 0, 1) .  ' Non Disponible</option>';
                    }
                }
            } else {
                echo '<option disabled style="background-color:red; color:white;" value="0">Type de voiture '.$type_voiture.' n\'existe pas dans cette agence</option>';

            }
            ?>
    </select>
</div>

<?php
    }
}else if($type == "materiel"){
?>
<div class="form-group mb-4">
    <label class="col-md-12 p-0">Liste des Materiels<span class="text-danger">*</span></label>
    <?php
            $query_m = "SELECT * 
                            FROM materiels,materiels_agence 
                            WHERE materiels.id_materiels=materiels_agence.id_materiels 
                            AND materiels_agence.etat_materiels = 'T'
                            AND materiels.famille_materiel='SOUDEUSE'
                            AND materiels_agence.id_agence=" . $id_agence;
            $result_m = mysqli_query($conn, $query_m);
            ?>
            <table style="width: 100%;">
                <tr>
                    <td>
                        <select name="skill[]" id="fetch-materiel1" class="form-control materiel-list-pack-avenant">
                            <?php
                                
                                if ($result_m->num_rows > 0) {
                                    while ($row_m = $result_m->fetch_assoc()) {
                                        $dispo_materiel = disponibilite_materielp($row_m['id_materiels_agence'],$debut,$fin,$id_agence); 
                                        if ($dispo_materiel == "disponible"){
                                            echo ' <option value="' . $row_m['id_materiels_agence'] . '">' . $row_m['code_materiel'] . '-' . $row_m['designation'] . '-' . $row_m['num_serie_materiels'] . '</option>';
                                        }else{
                                            echo ' <option selected style="background-color:red; color:white;" value="0">' . $row_m['code_materiel'] . '-' . $row_m['designation'] . '-' . $row_m['num_serie_materiels'] . ' "Non Disponible"</option>';
                                        }
                                    } 
                                }
                                else{
                                    echo ' <option selected style="background-color:red; color:white;" value="0">' . $row['designation'] . ' "Non Disponible"</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
</div>
<?php
}
}
function disponibilite_materielp($id_materiels_agence,$debut,$fin,$id_agence)
{
    global $conn;
    $query_m = "SELECT * 
                    FROM materiels,materiels_agence,materiel_contrat_client,contrat_client 
                    WHERE materiels.id_materiels=materiels_agence.id_materiels 
                    AND materiel_contrat_client.id_materiels_agence=materiels_agence.id_materiels_agence 
                    AND contrat_client.id_contrat= materiel_contrat_client.id_contrat 
                    AND contrat_client.etat_contrat = 'A'
                    AND materiels_agence.id_materiels_agence = $id_materiels_agence
                    AND materiels_agence.etat_materiels = 'T'
                    AND ((ContratDateDebut <='$debut' AND ContratDateFin >='$debut' )
                        OR (ContratDateDebut <='$fin' AND ContratDateFin >='$fin' ) 
                        OR (ContratDateDebut >='$debut' AND ContratDateFin <='$fin' ))
                    AND materiels_agence.id_agence=" . $id_agence;
    $result = mysqli_query($conn, $query_m);
    $nb_res = mysqli_num_rows($result);

    $query_m_avenant = "SELECT * 
                    FROM materiels,materiels_agence,materiel_contrat_client
                    WHERE materiels.id_materiels=materiels_agence.id_materiels 
                    AND materiel_contrat_client.id_materiels_agence=materiels_agence.id_materiels_agence 
                    AND materiels_agence.id_materiels_agence = $id_materiels_agence
                    AND materiels_agence.etat_materiels = 'T'
                    AND ((ContratDateDebut <='$debut' AND ContratDateFin >='$debut' )
                        OR (ContratDateDebut <='$fin' AND ContratDateFin >='$fin' ) 
                        OR (ContratDateDebut >='$debut' AND ContratDateFin <='$fin' ))
                    AND materiels_agence.id_agence=" . $id_agence;
    $resultavenant = mysqli_query($conn, $query_m_avenant);
    $nb_res_avenant = mysqli_num_rows($resultavenant);

    if ($nb_res == 0 && $nb_res_avenant == 0) {
        return "disponible";
    } else {
        return "Non disponible";
    }
}        