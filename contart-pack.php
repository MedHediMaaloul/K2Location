<?php
session_start();
if (isset($_SESSION['User'])) {
    include('Gestion_location/inc/header_sidebar.php');
} else {
    header("Location:login.php");
}
?>
<div class="page-wrapper">
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title text-uppercase font-medium font-14">
                    CONTRATS
                </h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-heading">LISTE DES CONTRATS PACKS</div>
                    <div class="card-body">
                        <?php
                        if (($_SESSION['Role']) != "superadmin") {
                        ?>
                        <button class="btn btn-success " type="button" data-toggle="modal" data-target="#Registration-Contrat-mixte"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
                        <?php
                        }
                        ?>
                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchContratPack" class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr> 
                        <!-- end search box -->
                        <p id="delete_message"></p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <!-- modal delet contrat -->
                                    <div class="modal fade" id="deleteContratPack" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Contrat</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>voulez-vous supprimer le contrat ?</p>
                                                    <button class="btn btn-success" id="btn_delete_pack">Supprimer Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload()" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal delet contrat -->
                                    <div class="table-responsive" id="contrat-list-pack"> </div>
                                    <!-- update Contrat modal -->
                                    <div class="modal fade" id="update-Contrat-Pack" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Contrat</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message_pack"></p>
                                                    <form id="updateContratForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idcontrat">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Début Contrat<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateDebutContrat" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Fin Contrat<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateFinContrat" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Durée Contrat<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="duree" id="up_dureeContrat" class="form-control p-0 border-0" required>
                                                                    <option value="Standard">Standard</option>
                                                                    <option value="Par Jour">Par Jour</option>
                                                                    <option value="Par Semaine">Par Semaine</option>
                                                                    <option value="Par Mois">Par Mois</option>
                                                                    <option value="LLD">LLD</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Prix<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_PrixContrat" placeholder="1000€" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nombre de kilomètres inclus<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_NbreKilometreContrat" placeholder="1000" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Moyen De Caution<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="duree" id="up_moyenCaution" class="form-control p-0 border-0" required>
                                                                    <option value="" selected disabled>Selectionnez Moyen De Caution</option>    
                                                                    <option value="Carte bancaire">Par Carte Bancaire</option>
                                                                    <option value="Cheque">Par Chèque</option>
                                                                    <option value="ChequeCB">Par Carte Bancaire et Chèque</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div id="up_inputNumCB" class="form-group mb-4" style="display: none">
                                                            <label class="col-md-12 p-0">N° Carte Bancaire de caution</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_numCautionCBMateriel" name="card-num" size="18"  minlength="19" maxlength="19" 
                                                                    placeholder="XXXX XXXX XXXX XXXX" class="form-control p-0 border-0" required>
                                                            </div>
                                                            <label class="col-md-12 p-0">Montant de Caution (par carte bancaire)</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_Caution" placeholder="1000€" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div id="up_inputNumChequeCaution" class="form-group mb-4" style="display: none">
                                                            <label class="col-md-12 p-0">N° Chèque de caution</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_numCautionMateriel" data-inputmask="'mask': '9999999'" 
                                                                    placeholder="XXXXXXX" class="form-control p-0 border-0" required>
                                                            </div>
                                                            <label class="col-md-12 p-0">Montant de Caution (par cheque)</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_Cautioncheque" placeholder="1000€" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Mode Paiement<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="up_ModePaiementContrat" class="form-control p-0 border-0" required>
                                                                    <option value="" selected disabled>Selectionnez Mode Paiement</option>
                                                                    <option value="Carte bancaire">Carte bancaire</option>
                                                                    <option value="Virements bancaires">Virements bancaires</option>
                                                                    <option value="Prélèvements automatiques">Prélèvement automatique</option>
                                                                    <option value="Espèces">Espèces</option>
                                                                    <option value="Chèque">Chèque</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div id="up_inputDatePrelevementContrat" class="form-group mb-4" style="display: none">
                                                            <label class="col-md-12 p-0">Date Prélèvement<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DatePrelevementContrat"
                                                                    placeholder="Date prélèvement de chaque mois" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_updated_Contrat_Pack">Modifier Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end update Contrat modal -->
                                    <!-- update Contrat Avenant modal -->
                                    <div class="modal fade" id="update-ContratAvenant" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Contrat Avenant</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_messageavenant_pack"></p>
                                                    <form id="updateContratAvenantForm" autocomplete="off" class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idcontratavenant">
                                                        </div>
        
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Début<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateContratAvenantDebut" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Fin<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateContratAvenantFin" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_updated_ContratAvenant_Pack">Modifier Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal add contrat -->
                                    <div class="modal fade" id="Registration-Contrat-mixte" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter contrat</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="contratpackForm" autocomplete="off" class="form-horizontal form-material">

                                                        <div class="col-md-12 border-bottom p-0">
                                                            <select id="Contrattype" name="Contrattype" onchange="selectcontratpack(this.value)"
                                                                placeholder="Contrattype" class="form-control p-0 border-0" required="">
                                                                <option value="Selectionner" disabled selected>Selectionner type de contrat</option>
                                                                <option value="CONTRAT">CONTRAT</option>
                                                                <option value="CONTRAT CADRE"> CONTRAT CADRE</option>
                                                                <option value="CONTRAT AVENANT">CONTRAT AVENANT</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_DateDebutContrat" style="display:none">
                                                            <label class="col-md-12 p-0">Date Début<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateDebutContrat" placeholder="01/01/2020"
                                                                    onchange="affichier_pack_dispo()" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_DateFinContrat" style="display:none">
                                                            <label class="col-md-12 p-0">Date Fin<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateFinContrat" onchange="affichier_pack_dispo()" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_dureeContrat" style="display:none">
                                                            <label class="col-md-12 p-0">Durée Contrat<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="duree" id="dureeContratMixte" class="form-control p-0 border-0">
                                                                    <option value="" selected disabled>Selectionnez Durée Contrat</option>
                                                                    <option value="Standard">Standard</option>
                                                                    <option value="Par Jour">Par Jour</option>
                                                                    <option value="Par Semaine">Par Semaine</option>
                                                                    <option value="Par Mois">Par Mois</option>
                                                                    <option value="LLD">LLD</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div id="inputDatePrelevementContrat" class="form-group mb-4" style="display: none">
                                                            <label class="col-md-12 p-0">Date Prélèvement<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" data-date-format="DD MMMM YYYY" id="DatePrelevementContratMixte" class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_ClientContrat" style="display:none">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM client  where etat_client !='S' ORDER BY nom ASC";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0">Nom Complet Client<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ClientContratMixte" name="ContratClient" style="width:250px;"
                                                                    placeholder="Nom Client" class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner Un Client</option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            if ($row['nom_entreprise'] == ""){
                                                                                echo '<option value="' . $row['id_client'] . '">' . "Conducteur : " . $row['nom'] . '</option>';
                                                                            }else if ($row['nom'] == ""){
                                                                                echo '<option value="' . $row['id_client'] . '">' . $row['nom_entreprise'] . '</option>';
                                                                            }else{
                                                                                echo '<option value="' . $row['id_client'] . '">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</option>';
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_ClientAgenceRet" style="display:none">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $id_agence = $_SESSION['id_agence'];
                                                            $query = "SELECT * FROM agence where id_agence != $id_agence AND id_agence != '0'";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0">Agence retour</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ClientAgenceRet" name="ClientAgenceRet"
                                                                    placeholder="Agence de retour" class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner Une Agence</option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_agence'] . '">' . $row['lieu_agence'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_PrixContrat" style="display:none">
                                                            <label class="col-md-12 p-0">Prix<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="PrixContratMixte" placeholder="1000€" class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_ChocheKilometreillimite" style="display:none">
                                                            <label for="klillimite"><input type="checkbox" id="klillimite" value="1"/> Kilométrage illimité</label>
                                                            <div class="form-group mb-4" id="cont_NbreKilometreNotOblig" style="display:none">
                                                                <label class="col-md-12 p-0">Nombre de kilomètres inclus</label>
                                                                <div class="col-md-12 border-bottom p-0">
                                                                    <input type="number" id="NbreKilometreObligContrat" placeholder="1000" class="form-control p-0 border-0" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-4" id="cont_NbreKilometreOblig">
                                                                <label class="col-md-12 p-0">Nombre de kilomètres inclus<span class="text-danger">*</span></label>
                                                                <div class="col-md-12 border-bottom p-0">
                                                                    <input type="number" id="NbreKilometreContratCadre" placeholder="1000" class="form-control p-0 border-0" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_moyenCaution" style="display:none">
                                                            <label class="col-md-12 p-0">Moyen De Caution<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="duree" id="moyenCaution" class="form-control p-0 border-0" required>
                                                                    <option value="" selected disabled>Selectionnez Moyen De Caution</option>    
                                                                    <option value="Carte bancaire">Par Carte Bancaire</option>
                                                                    <option value="Cheque">Par Chèque</option>
                                                                    <option value="ChequeCB">Par Carte Bancaire et Chèque</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div id="inputNumCB" class="form-group mb-4" style="display: none">
                                                            <label class="col-md-12 p-0">N° Carte Bancaire de caution</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="numCautionCBMixte" name="card-num" size="18"  minlength="19" maxlength="19"
                                                                    placeholder="XXXX XXXX XXXX XXXX" class="form-control p-0 border-0" required>
                                                            </div>
                                                            <label class="col-md-12 p-0">Montant de Caution (par carte bancaire)</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="CautionContratMixte" placeholder="1000€" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                            
                                                        <div id="inputNumChequeCaution" class="form-group mb-4" style="display: none">
                                                            <label class="col-md-12 p-0">N° Chèque de caution</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="numCautionMixte" data-inputmask="'mask': '9999999'" placeholder="XXXXXXX"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                            <label class="col-md-12 p-0">Montant de Caution (par chèque)</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="CautionContratMixtecheque" placeholder="1000€" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_ModePaiementContrat" style="display:none">
                                                            <label class="col-md-12 p-0">Mode Paiement<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ModePaiementContratMixte" class="form-control p-0 border-0">
                                                                    <option value="" selected disabled>Selectionnez Mode Paiement</option>
                                                                    <option value="Carte bancaire">Carte bancaire</option>
                                                                    <option value="Virements bancaires">Virements bancaires</option>
                                                                    <option value="Prélèvements automatiques">Prélèvement automatique</option>
                                                                    <option value="Espèces">Espèces</option>
                                                                    <option value="Chèque">Chèque</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <?php if ($_SESSION['Role'] == "responsable") { ?>
                                                            <div class="form-group mb-4" id="cont_contratmaterielagence"style="display:none">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM agence where id_agence!='0' ";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                                <label class="col-md-12 p-0">Agence<span class="text-danger">*</span></label>
                                                                <table>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="col-md-10 border-bottom p-0">
                                                                                <select id="contratpackagence" name="contratpackagence" placeholder="agence" 
                                                                                    onchange="affichier_pack_dispo()" class="form-control p-0 border-0" required>
                                                                                    <option value="" disabled selected>Selectionner Agence</option>
                                                                                    <?php if ($result->num_rows > 0) {
                                                                                        while ($row = $result->fetch_assoc()) {
                                                                                            echo '<option value="' . $row['id_agence'] . '">' . $row['lieu_agence'] .'</option>';
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>

                                                        <div class="form-group mb-4" id="materielPack"></div>
                                                        <div class="form-group mb-4" id="list_materiel_pack"></div>

                                                        <div class="form-group mb-4" id="cont_listecontrat" style="display:none">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $id_agence = $_SESSION['id_agence'];
                                                            if ($_SESSION['Role'] == "admin") {
                                                                $query = "SELECT * FROM contrat_client
                                                                WHERE etat_contrat = 'A'
                                                                AND (date_fin_validation >= DATE(NOW()) OR date_fin_validation = '0000-00-00')
                                                                AND type_location = 'Pack'
                                                                AND id_agence = $id_agence";
                                                            }else{
                                                                $query = "SELECT * FROM contrat_client
                                                                WHERE etat_contrat = 'A'
                                                                AND (date_fin_validation >= DATE(NOW()) OR date_fin_validation = '0000-00-00')
                                                                AND type_location = 'Pack'"; 
                                                            }
                                                            $result = mysqli_query($conn, $query); 
                                                            ?>
                                                            <label class="col-md-12 p-0">Contrat Client<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ContratClient" name="ContratClient" class="form-control p-0 border-0">
                                                                    <option value=" " selected>Selectionnez Un Contrat</option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_contrat'] . '">' . "Contrat " .$row['id_contrat'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_DateDebutContratAvenant" style="display:none">
                                                            <label class="col-md-12 p-0">Date Début<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateDebutContratAvenant" onchange="List_Materiel_Pack_Avenant()" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_DateFinContratAvenant" style="display:none">
                                                            <label class="col-md-12 p-0">Date Fin<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateFinContratAvenant" onchange="List_Materiel_Pack_Avenant()" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_Cochevehiculemateriel" style="display:none">
                                                            <div class="input-group mb-3" onchange="List_Materiel_Pack_Avenant()">
                                                                <div>
                                                                    <input type="checkbox" id="vehicule" name="vehicule" value="0">
                                                                    <label for="coding">Véhicule</label>
                                                                </div>
                                                                <div>
                                                                    <input type="checkbox" id="materiel" name="materiel" value="1">
                                                                    <label for="music">Matériel</label>
                                                                </div>
                                                            </div>  
                                                        </div>

                                                        <div class="form-group mb-4" id="list_materiel_pack_ContratAvenant"></div>
                                                    </form>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-contrat-mixte">Ajouter Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload()" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add modal -->
                                    <!--modal contrat signe -->
                                    <div class="modal fade" id="Contrat-pack-Signe" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter le Contrat Signé</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message_contrat_signe_pack"></p>
                                                    <form id="updateContratPackFormSigne" autocomplete="off" class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idcontratsignepack">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class=" col-md-12 p-0">Contrat Signé<span class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="contratsigne_pack" placeholder="contrat signe" class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_updated_Contrat_Pack_Sigen">Modifier le Contrat Signé</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal contrat signe -->
                                    <!-- modal valide sortie contrat -->
                                    <div class="modal fade" id="ValideSortieContratPack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Valide Sortie Pack</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Confirmez vous le départ du pack ?</p>
                                                    <button class="btn btn-success" id="btn_valide_sortie_pack">Valide Sortie Pack</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal valide sortie contrat -->
                                    <!-- modal valide retour contrat -->
                                    <div class="modal fade" id="ValideRetourContratPack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Valide Retour Pack</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Confirmez vous le retour du pack ?</p>
                                                    <button class="btn btn-success" id="btn_valide_retour_pack">Valide Retour Pack</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal valide retour contrat -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('Gestion_location/inc/footer.php')
?>

<script type="text/javascript">

$(document).ready(function(){

$("#up_numCautionMateriel").inputmask();
$("#numCautionMixte").inputmask();

//For Card Number formatted input
var cardNum1 = document.getElementById('numCautionCBMixte');
cardNum1.onkeyup = function (e) {
    if (this.value == this.lastValue) return;
    var caretPosition = this.selectionStart;
    var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
    var parts = [];
    
    for (var i = 0, len = sanitizedValue.length; i < len; i += 4) {
        parts.push(sanitizedValue.substring(i, i + 4));
    }
    
    for (var i = caretPosition - 1; i >= 0; i--) {
        var c = this.value[i];
        if (c < '0' || c > '9') {
            caretPosition--;
        }
    }
    caretPosition += Math.floor(caretPosition / 4);
    
    this.value = this.lastValue = parts.join(' ');
    this.selectionStart = this.selectionEnd = caretPosition;
}
///////// update card number
var cardNum1 = document.getElementById('up_numCautionCBMateriel');
cardNum1.onkeyup = function (e) {
    if (this.value == this.lastValue) return;
    var caretPosition = this.selectionStart;
    var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
    var parts = [];
    
    for (var i = 0, len = sanitizedValue.length; i < len; i += 4) {
        parts.push(sanitizedValue.substring(i, i + 4));
    }
    
    for (var i = caretPosition - 1; i >= 0; i--) {
        var c = this.value[i];
        if (c < '0' || c > '9') {
            caretPosition--;
        }
    }
    caretPosition += Math.floor(caretPosition / 4);
    
    this.value = this.lastValue = parts.join(' ');
    this.selectionStart = this.selectionEnd = caretPosition;
}

});
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="js/GeneratePDF.js"></script>
    <script type="text/javascript">
    $(function() {
        $('#ClientContratMixte').select2({
            dropdownParent: $('#ClientContratMixte').parent()
        });
    });
</script>
    <script>
    <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id_materiel'] . '">' . $row['nom_materiel'] . ' _' . $row['num_serie'] . '</option>';
            }
        }
        ?>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i +
                '"><td><select name="skill[]"  id="fetch-materiel' + i +
                '" placeholder="Enter your Skill" class="form-control materiel-list-contrat-mixte" >' +
                materielData + '</select></td><td><button type="button" name="remove" id="' + i +
                '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
    </script>
    
</body>
</html>