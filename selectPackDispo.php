<?php
session_start();
include('Gestion_location/inc/connect_db.php');

if ($_POST['DateDebutContrat'] && $_POST['DateFinContrat']) {
    $debut = $_POST['DateDebutContrat'];
    $fin = $_POST['DateFinContrat'];
}
if ($_POST['contratpackagence'] =="") {
    $id_agence = $_SESSION['id_agence'];
}else{
    $id_agence = $_POST['contratpackagence'];
}
if ($id_agence) {
?>
<div class="form-group mb-4" id="materiel">
    <?php
    $query = "SELECT * 
                FROM group_packs  
                WHERE etat_group_pack ='T'  
                ORDER BY designation_pack ASC ";
    $result = mysqli_query($conn, $query);
    ?>
    <label class="col-md-12 p-0">Pack<span class="text-danger">*</span></label>
    <div class="col-md-12 border-bottom p-0">
        <select id="id_pack" name="id_pack"  placeholder="Nom" class="form-control p-0 border-0"
            onchange="List_Materiel_Pack(this.value);">
            <option value="" disabled selected> Pack </option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $dispo_voiture = disponibilite_voiturep($row['type_voiture'],  $id_agence);
                    $dispo_materiel = disponibilite_materielp($row['id_group_packs'], $id_agence); 
                    if ($dispo_materiel == "Non disponible" || $dispo_voiture == "Non disponible") {
                        echo '<option style="background-color:red; color:white;" value="' . $row['id_group_packs'] . '">' . $row['designation_pack'] . ' "Non Disponible"</option>';
                    } else {
                        echo '<option value="' . $row['id_group_packs'] . '">' . $row['designation_pack'] . '</option>';
                    }
                }
            }
            ?>
        </select>
    </div>
</div>
<?php
}
function disponibilite_voiturep($type_voiture, $id_agence)
{
    global $conn;
    $debut = $_POST['DateDebutContrat'];
    $fin = $_POST['DateFinContrat'];
    $resvp = '';
    $var="0";
    if($type_voiture == "sans vehicule"){
        return "disponible";
    }else{
        $query = "SELECT * 
                    FROM voiture,marquemodel 
                    WHERE marquemodel.id_MarqueModel= voiture.id_MarqueModel
                    AND voiture.id_agence = $id_agence 
                    AND voiture.type='$type_voiture' 
                    AND voiture.actions !='S' 
                    AND voiture.etat_voiture='Disponible' ";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0){
            while ($row = $result->fetch_assoc()){
                $disponibilte = disponibilite_Vehiculep($row['id_voiture'], $debut, $fin);
            }
            if (isset($var, $disponibilte)){
                $resvp = "True";
            }else{
                $resvp = "False";
            }

            if ($resvp == "True"){
                return "disponible";
            } else{
                return "Non disponible";
            }
        }else{
            return "Non disponible";
        } 
    }
}
function disponibilite_Vehiculep($id_voiture, $debut, $fin)
{
    global $conn;
    $resv = "False";
    $query = "SELECT * 
                FROM contrat_client 
                WHERE id_voiture ='$id_voiture' 
                AND etat_contrat = 'A' 
                AND ((date_debut <='$debut' AND date_fin >='$debut' )
                OR (date_debut <='$fin' AND date_fin >='$fin' ) 
                OR (date_debut >='$debut' AND date_fin <='$fin' ))";

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


    if ($nb_res != 0 && $nb_res_avenant != 0) {
        return 1;
    }else{
        return 0;
    }
}

function disponibilite_materielp($id_group_pack, $id_agence)
{
    global $conn;
    $debut = $_POST['DateDebutContrat'];
    $fin = $_POST['DateFinContrat'];
    $t = "";
    $res = "";
    $query_m = "SELECT * 
        FROM materiel_group_packs,group_packs,materiels 
        WHERE materiel_group_packs.id_group_packs=group_packs.id_group_packs 
        AND materiel_group_packs.id_materiels=materiels.id_materiels 
        AND materiel_group_packs.id_materiels != '0'
        AND group_packs.id_group_packs=".$id_group_pack;
    $result_m = mysqli_query($conn, $query_m);
    
    while ($row_m = $result_m->fetch_assoc()) {
        $query = "SELECT * 
            FROM materiels,materiels_agence 
            WHERE materiels.id_materiels=materiels_agence.id_materiels 
            AND materiels_agence.id_materiels =".$row_m['id_materiels']."
            AND materiels_agence.etat_materiels = 'T'
            AND materiels_agence.id_agence=" . $id_agence;
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if($row['etat_materiels'] == 'T'){
                    $disponibilte = disponibilite_matp($row['id_materiels_agence'], $debut, $fin, $id_agence);
                    if (strpos($disponibilte, '0') !== false) {
                        $t = "T";
                    }else{
                        $t = "N";
                    }
                }  
            }  
            if (strpos($t, 'T') === false) {
                $res = "False";
            }    
        }else{
            $res = "False";
        } 
    }
    if ($res == "False") {
        return "Non disponible";
    }else {
        return "disponible";
    }   
}


function disponibilite_matp($id_materiels_agence, $debut, $fin, $id_agence)
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
    $row = $result->fetch_assoc();
    if($nb_res > 0){
        $nbrmaterielloue = (int)($row['quantite_materiels']/$row['quantite_contrat']);
        if($row['num_serie_materiels'] == ""){
            if($nb_res == $nbrmaterielloue){
                return 1;
            }else{
                return 0;
            }    
        }else{
            return 1;
        }
    }else{
        return 0;
    }

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
    $rowavenant = $resultavenant->fetch_assoc();

    if($nb_res_avenant > 0){
        $nbrmaterielloueavenant = (int)($rowavenant['quantite_materiels']/$rowavenant['quantite_contrat']);
        if($rowavenant['num_serie_materiels'] == ""){
            if($nb_res_avenant == $nbrmaterielloueavenant){
                return 1;
            }else{
                return 0;
            }    
        }else{
            return 1;
        }
    }else{
        return 0;
    }

}        