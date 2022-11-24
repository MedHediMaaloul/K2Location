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
                    <div class="card-heading">LISTE DES CONTRATS VÉHICULES</div>
                    <div class="card-body">
                        <?php
                        if (($_SESSION['Role']) != "superadmin") {
                        ?>
                        <button class="btn btn-success " type="button" data-toggle="modal" data-target="#Registration-Contrat-Voiture"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
                        <?php
                        }
                        ?>
                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchContratVoiture" class="form-control border-0  bg-light">
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
                                    <div class="modal fade" id="deleteContrat" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Contrat
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>voulez-vous supprimer le contrat ?</p>
                                                    <button class="btn btn-success" id="btn_delete">Supprimer
                                                        Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload()"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal delet contrat -->
                                    <div class="table-responsive" id="contrat-list-voiture"> </div>
                                    <!-- update Contrat modal -->
                                    <div class="modal fade" id="update-Contrat-Voiture" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Contrat</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message_voiture"></p>
                                                    <form id="updateContratForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idcontrat">
                                                        </div>
        
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Début Contrat<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateContratDebut"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Fin Contrat<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateContratFin"
                                        
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" id="up_ContratType">
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Durée Contrat<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="duree" id="up_dureeContrat"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="Standard">Standard</option>
                                                                    <option value="Par Jour">Par Jour</option>
                                                                    <option value="Par Semaine">Par Semaine</option>
                                                                    <option value="Par Mois">Par Mois</option>
                                                                    <option value="LLD">LLD</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div id="up_inputDatePrelevementContrat" class="form-group mb-4"
                                                            style="display: none">
                                                            <label class="col-md-12 p-0">Date Prélèvement<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" data-date-format="DD MMMM YYYY"
                                                                    id="up_DatePrelevementContrat"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Prix (Montant hors taxe)<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_PrixContrat"
                                                                    placeholder="1000€"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nombre de kilomètres inclus<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_NbreKilometreContrat" placeholder="1000"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Moyen De Caution<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="duree" id="up_moyenCaution"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" selected disabled>Selectionnez
                                                                    Moyen De Caution</option>    
                                                                    <option value="Carte bancaire">Par Carte Bancaire</option>
                                                                    <option value="Cheque">Par Chèque</option>
                                                                    <option value="ChequeCB">Par Carte Bancaire et Chèque</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div id="up_inputNumCB" class="form-group mb-4" style="display: none">
                                                            <label class="col-md-12 p-0">N° Carte Bancaire de caution</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_numCautionCB" name="card-num" size="18"  minlength="19" maxlength="19"
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
                                                                <input type="text" id="up_numCaution" data-inputmask="'mask': '9999999'" placeholder="XXXXXXX"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                            <label class="col-md-12 p-0">Montant de Caution (par cheque)</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_Cautioncheque" placeholder="1000€" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Mode Paiement<span
                                                                    class="text-danger">*</span></label>
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
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_updated_Contrat_Voiture">Modifier Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- update Contrat Avenant modal -->
                                    <div class="modal fade" id="update-ContratAvenant" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Contrat Avenant</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_messageavenant_voiture"></p>
                                                    <form id="updateContratAvenantForm" autocomplete="off" class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idcontratavenant">
                                                        </div>

                                                        <input type="hidden" id="type" value="updatecontratavenant">
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Début<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateContratAvenantDebut"
                                                                    onchange="affichier_update_voiture_dispo_contratavenant()"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Fin<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_DateContratAvenantFin"
                                                                    onchange="affichier_update_voiture_dispo_contratavenant()"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="materielupdateVoiteurContratAvenant"></div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn_updated_ContratAvenant_Voiture">Modifier
                                                        Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal add contrat -->
                                    <div class="modal fade" id="Registration-Contrat-Voiture" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter contrat Véhicule</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="messagevoiture"></p>
                                                    <form id="contratvoitureForm" autocomplete="off" class="form-horizontal form-material">
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <select id="Contrattype" name="Contrattype"
                                                                onchange="selectcontratvoiture(this.value)" 
                                                                placeholder="Contrattype" class="form-control p-0 border-0" required="">
                                                                <option value="Selectionner" disabled selected>Selectionner type de contrat</option>
                                                                <option value="CONTRAT">CONTRAT</option>
                                                                <option value="CONTRAT CADRE"> CONTRAT CADRE</option>
                                                                <option value="CONTRAT AVENANT"> CONTRAT AVENANT</option>
                                                            </select>
                                                        </div>
                                                        <br>
                                                        <div class="form-group mb-4" id="cont_DateDebutContrat" style="display:none">
                                                            <label class="col-md-12 p-0">Date Début<span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateDebutContrat"
                                                                    onchange="affichier_voiture_dispo()"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_DateFinContrat" style="display:none">
                                                            <label class="col-md-12 p-0">Date Fin<span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateFinContrat"
                                                                    onchange="affichier_voiture_dispo()"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="TypeContrat" value="Vehicule">
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_dureeContrat" style="display:none">
                                                            <label class="col-md-12 p-0">Durée Contrat<span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="duree" id="dureeContrat" class="form-control p-0 border-0" required>
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
                                                            <label class="col-md-12 p-0">Date Prélèvement<span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" data-date-format="DD MMMM YYYY" id="DatePrelevementContrat" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_ClientContrat" style="display:none">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM client WHERE etat_client !='S' ORDER BY nom ASC ";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Nom Complet Client<span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ClientContrat" name="ClientContrat" style="width: 450px;" placeholder="Nom Client" class="form-control p-0 border-0" required>
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

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="ClientAgenceDep">
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_ClientAgenceRet"
                                                            style="display:none">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $id_agence = $_SESSION['id_agence'];
                                                            $query = "SELECT * FROM agence where id_agence != $id_agence AND id_agence != '0'";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Agence retour</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ClientAgenceRet" name="ClientAgenceRet" placeholder="Agence de retour" class="form-control p-0 border-0" required>
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
                                                            <label class="col-md-12 p-0">Prix (Montant hors taxe)<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="PrixContrat" placeholder="1000€" class="form-control p-0 border-0" required>
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

                                                        <div class="form-group mb-4" id="cont_NbreKilometreContrat" style="display:none">
                                                            <label class="col-md-12 p-0">Nombre de kilomètres inclus<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="NbreKilometreContrat" placeholder="1000" class="form-control p-0 border-0" required>
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
                                                        <div id="inputNumCB" class="form-group mb-4"
                                                            style="display: none">
                                                            <label class="col-md-12 p-0">N° Carte Bancaire de caution</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="numCautionCB" name="card-num" size="18"  
                                                                    minlength="19" maxlength="19" placeholder="XXXX XXXX XXXX XXXX" class="form-control p-0 border-0" required>
                                                            </div>
                                                            <label class="col-md-12 p-0">Montant de Caution (par carte bancaire)</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="CautionContrat" placeholder="1000€" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                            
                                                        <div id="inputNumChequeCaution" class="form-group mb-4"
                                                            style="display: none">
                                                            <label class="col-md-12 p-0">N° Chèque de caution</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="numCaution" data-inputmask="'mask': '9999999'" placeholder="XXXXXXX"
                                                                class="form-control p-0 border-0" required>
                                                            </div>
                                                            <label class="col-md-12 p-0">Montant de Caution (par chèque)</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="CautionContratcheque" placeholder="1000€" class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="AssuranceContrat">
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_ModePaiementContrat"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Mode Paiement<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ModePaiementContrat"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" selected disabled>Selectionnez Mode Paiement</option>
                                                                    <option value="Carte bancaire">Carte bancaire</option>
                                                                    <option value="Virements bancaires">Virements bancaires</option>
                                                                    <option value="Prélèvements automatiques">Prélèvement automatique</option>
                                                                    <option value="Espèces">Espèces</option>
                                                                    <option value="Chèque">Chèque</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <?php
                                                        if ($_SESSION['Role'] == "responsable") {
                                                        ?>
                                                            <div class="form-group mb-4" id="cont_contratvehiculeagence"
                                                                style="display:none">
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
                                                                                <select id="contratvehiculeagence" name="contratvehiculeagence"
                                                                                    placeholder="agence"
                                                                                    onchange="affichier_voiture_dispo()"
                                                                                    class="form-control p-0 border-0"
                                                                                    required>
                                                                                    <option value="" disabled selected>Selectionner Agence</option>
                                                                                    <?php
                                                                                    if ($result->num_rows > 0) {
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

                                                        <div class="form-group mb-4" id="materielVoiteur"></div>

                                                        <div class="form-group mb-4" id="cont_listecontrat" style="display:none">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $id_agence = $_SESSION['id_agence'];
                                                            if ($_SESSION['Role'] == "admin") {
                                                                $query = "SELECT * FROM contrat_client
                                                                WHERE etat_contrat = 'A'
                                                                AND (date_fin_validation >= DATE(NOW()) OR date_fin_validation = '0000-00-00')
                                                                AND type_location = 'Vehicule'
                                                                AND id_agence = $id_agence";
                                                            }else{
                                                                $query = "SELECT * FROM contrat_client
                                                                WHERE etat_contrat = 'A'
                                                                AND (date_fin_validation >= DATE(NOW()) OR date_fin_validation = '0000-00-00')
                                                                AND type_location = 'Vehicule'"; 
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
                                                                <input type="date" id="DateDebutContratAvenant"
                                                                    onchange="affichier_voiture_dispo_contratavenant()"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_DateFinContratAvenant" style="display:none">
                                                            <label class="col-md-12 p-0">Date Fin<span class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateFinContratAvenant"
                                                                    onchange="affichier_voiture_dispo_contratavenant()"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" id="type1" name="type1" value="addcontratavenant">

                                                        <div class="form-group mb-4" id="materielVoiteurContratAvenant"></div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn-register-contrat-voiture">Ajouter
                                                        Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload()"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add modal -->
                                    <!--modal contrat signe -->
                                    <div class="modal fade" id="Contrat-Voiture-Signe" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter le Contrat Signé</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message_contrat_signe"></p>
                                                    <form id="updateContratFormSigne" autocomplete="off" class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idcontratsigne">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class=" col-md-12 p-0">Contrat Signé<span class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="contratsigne_voiture" placeholder="contrat signe" class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_updated_Contrat_Voiture_Sigen">Modifier Contrat Signé</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal contrat signe -->
                                    <!-- modal valide sortie contrat -->
                                    <div class="modal fade" id="ValideSortieContrat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Valide Sortie Voiture</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Confirmez vous le départ du véhicule ?</p>
                                                    <button class="btn btn-success" id="btn_valide_sortie_voiture">Valide Sortie Voiture</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal valide sortie contrat -->
                                    <!-- modal valide retour contrat -->
                                    <div class="modal fade" id="ValideRetourContrat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Valide Sortie Voiture</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Confirmez vous le retour du véhicule ?</p>
                                                    <button class="btn btn-success" id="btn_valide_retour_voiture">Valide Retour Voiture</button>
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

$("#numCaution").inputmask();
$("#up_numCaution").inputmask();

//For Card Number formatted input
var cardNum = document.getElementById('numCautionCB');
cardNum.onkeyup = function (e) {
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

var cardNum = document.getElementById('up_numCautionCB');
cardNum.onkeyup = function (e) {
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
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<script src="js/GeneratePDF.js"></script>




