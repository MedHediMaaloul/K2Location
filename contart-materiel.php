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
                    <div class="card-heading">LISTE DES CONTRATS MATÉRIELS</div>
                    <div class="card-body">
                    <?php if (($_SESSION['Role']) != "superadmin") { ?>
                    <button class="btn btn-success " type="button" data-toggle="modal" data-target="#Registration-Contrat-materiel"
                        style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
                    <?php } ?>
                    <!-- search box -->
                    <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                        <div class="input-group">
                            <input type="input" placeholder="Que recherchez-vous?" id="searchContratMateriel"
                                class="form-control border-0  bg-light">
                            <div class="input-group-append">
                                <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                        class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- end search box -->
                    <p id="delete_message_materiel"></p>
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
                                    
                                <div class="table-responsive" id="contrat-list-materiel"> </div>
                                    
                                <!-- update Contrat modal -->
                                <div class="modal fade" id="update-Contrat-Materiel" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modifier Contrat</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <p id="up_message_materiel"></p>
                                                <form id="updateContratForm" autocomplete="off" class="form-horizontal form-material">
                                                    <div class="form-group mb-4">
                                                        <input type="hidden" id="up_idcontrat">
                                                    </div>

                                                    <div class="form-group mb-4">
                                                        <label class="col-md-12 p-0">Date Début Contrat<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="date" id="up_DateContratDebut" class="form-control p-0 border-0" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-4">
                                                        <label class="col-md-12 p-0">Date Fin Contrat<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="date" id="up_DateContratFin" class="form-control p-0 border-0" required>
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

                                                    <div id="up_inputDatePrelevementContrat" class="form-group mb-4" style="display: none">
                                                        <label class="col-md-12 p-0">Date Prélèvement<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="date" id="up_DatePrelevementContrat" placeholder="Date prélèvement de chaque mois" class="form-control p-0 border-0" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-4">
                                                        <label class="col-md-12 p-0">Prix<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="number" id="up_PrixContrat" placeholder="1000€" class="form-control p-0 border-0" required>
                                                        </div>
                                                    </div>
                                                      
                                                    <div class="form-group mb-4">
                                                        <label class="col-md-12 p-0">Moyen De Caution<span class="text-danger">*</span></label>
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
                                                            <input type="tel" id="up_numCautionCB" name="card-num" size="18"  minlength="19" maxlength="19"
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
                                                </form>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-success" id="btn_updated_Contrat_Materiel">Modifier Contrat</button>
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
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p id="up_messageavenant_materiel"></p>
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
                                                <button class="btn btn-success" id="btn_updated_ContratAvenant_Materiel">Modifier Contrat</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal add contrat -->
                                <div class="modal fade" id="Registration-Contrat-materiel" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Ajouter contrat Matériel</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p id="message"></p>
                                                <form id="contratForm" autocomplete="off" class="form-horizontal form-material">
                                                        
                                                    <div class="col-md-12 border-bottom p-0">
                                                        <select id="Contrattype" name="Contrattype" onchange="selectcontratmateriel(this.value)"
                                                            placeholder="Contrattype" class="form-control p-0 border-0" required="">
                                                            <option value="Selectionner" disabled selected>Selectionner type de contrat</option>
                                                            <option value="CONTRAT">CONTRAT</option>
                                                            <option value="CONTRAT CADRE"> CONTRAT CADRE</option>
                                                            <option value="CONTRAT AVENANT"> CONTRAT AVENANT</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group mb-4">
                                                        <input type="hidden" id="Up_Contratid">
                                                    </div>

                                                    <div class="form-group mb-4" id="cont_DateDebutContrat" style="display:none">
                                                        <label class="col-md-12 p-0">Date Début<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="date" id="DateDebutContrat" placeholder="01/01/2020" onchange="affichier_materiel_dispo()" class="form-control p-0 border-0" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-4" id="cont_DateFinContrat" style="display:none">
                                                        <label class="col-md-12 p-0">Date Fin<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="date" id="DateFinContrat" placeholder="01/01/2020" onchange="affichier_materiel_dispo()" class="form-control p-0 border-0" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-4" id="cont_dureeContrat" style="display:none">
                                                        <label class="col-md-12 p-0">Durée Contrat<span class="text-danger">*</span></label>
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
                                                        <label class="col-md-12 p-0">Date Prélèvement<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="date" id="DatePrelevementContrat" placeholder="Date prélèvement de chaque mois" class="form-control p-0 border-0" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-4" id="cont_ClientContrat" style="display:none">
                                                        <?php
                                                        include('Gestion_location/inc/connect_db.php');
                                                        $query = "SELECT * FROM client WHERE etat_client !='S' ORDER BY nom ASC ";
                                                        $result = mysqli_query($conn, $query);
                                                        ?>
                                                        <label class="col-md-12 p-0">Nom Complet Client<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <select id="ClientContrat" name="ClientContrat" style="width:250px;" placeholder="Nom Client" class="form-control p-0 border-0" required>
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

                                                    <div class="form-group mb-4" id="cont_ClientAgenceRet" style="display:none">
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
                                                        <label class="col-md-12 p-0">Prix<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="number" id="PrixContrat" placeholder="1000€" class="form-control p-0 border-0" required>
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
                                                        
                                                    <div id="inputNumCB" class="form-group mb-4" style="display:none">
                                                        <label class="col-md-12 p-0">N° Carte Bancaire de caution</label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="text" id="numCautionCBMateriel" name="card-num" size="18"  minlength="19" maxlength="19"
                                                                placeholder="XXXX XXXX XXXX XXXX" class="form-control p-0 border-0 cc-number" required>
                                                        </div>
                                                        <label class="col-md-12 p-0">Montant de Caution (par carte bancaire)</label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="number" id="CautionContrat" placeholder="1000€" class="form-control p-0 border-0" required>
                                                        </div>
                                                    </div>
                                                            
                                                    <div id="inputNumChequeCaution" class="form-group mb-4" style="display: none">
                                                        <label class="col-md-12 p-0">N° Chèque de caution</label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="text" id="numCautionMateriel" data-inputmask="'mask': '9999999'" placeholder="XXXXXXX"
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
                                                        
                                                    <div class="form-group mb-4" id="cont_ModePaiementContrat" style="display:none">
                                                        <label class="col-md-12 p-0">Mode Paiement<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <select id="ModePaiementContrat" class="form-control p-0 border-0" required>
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
                                                        <div class="form-group mb-4" id="cont_contratmaterielagence" style="display:none">
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
                                                                            <select id="contratmaterielagence" name="contratmaterielagence" placeholder="agence"
                                                                                onchange="affichier_materiel_dispo()" class="form-control p-0 border-0" required>
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

                                                    <div class="form-group mb-4" id="materiel"></div>

                                                    <div class="form-group mb-4" id="cont_listecontrat" style="display:none">
                                                        <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $id_agence = $_SESSION['id_agence'];
                                                            if ($_SESSION['Role'] == "admin") {
                                                                $query = "SELECT * FROM contrat_client
                                                                WHERE etat_contrat = 'A'
                                                                AND (date_fin_validation >= DATE(NOW()) OR date_fin_validation = '0000-00-00')
                                                                AND type_location = 'Materiel'
                                                                AND id_agence = $id_agence";
                                                            }else{
                                                                $query = "SELECT * FROM contrat_client
                                                                WHERE etat_contrat = 'A'
                                                                AND (date_fin_validation >= DATE(NOW()) OR date_fin_validation = '0000-00-00')
                                                                AND type_location = 'Materiel'"; 
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
                                                            <input type="date" id="DateDebutContratAvenant" onchange="afficher_materiel_avenant_dispo()" class="form-control p-0 border-0" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-4" id="cont_DateFinContratAvenant" style="display:none">
                                                        <label class="col-md-12 p-0">Date Fin<span class="text-danger">*</span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="date" id="DateFinContratAvenant" onchange="afficher_materiel_avenant_dispo()" class="form-control p-0 border-0" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-4" id="materielContratAvenant"></div>

                                                </form>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-success" id="btn-register-contrat-materiel">Ajouter Contrat</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload()" id="btn-close">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--modal contrat signe -->
                                <div class="modal fade" id="Contrat-Materiel-Signe" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Ajouter le Contrat Signé</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p id="message_contratmateriel_signe"></p>
                                                <form id="updateContratMaterielFormSigne" autocomplete="off" class="form-horizontal form-material">
                                                    <div class="form-group mb-4">
                                                        <input type="hidden" id="idcontratsignemateriel">
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class=" col-md-12 p-0">Contrat Signé<span class="text-danger"></span></label>
                                                        <div class="col-md-12 border-bottom p-0">
                                                            <input type="file" id="contratsignemateriel" placeholder="contrat signe" class="form-control p-0 border-0">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-success" id="btn_updated_Contrat_Materiel_Signe">Modifier Contrat</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal valide sortie contrat -->
                                <div class="modal fade" id="ValideSortieContratMateriel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Valide Sortie Materiel</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Confirmez vous le départ du matériel ?</p>
                                                <button class="btn btn-success" id="btn_valide_sortie_materiel">Valide Sortie Materiel</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal valide retour contrat -->
                                <div class="modal fade" id="ValideRetourContratMateriel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Valide Retour Materiel</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Confirmez vous le retour du matériel ?</p>
                                                <button class="btn btn-success" id="btn_valide_retour_materiel">Valide Retour Materiel</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    
<script src="js/GeneratePDF.js"></script>
<script type="text/javascript">
    $(function() {
        $('#ClientContrat').select2({
            dropdownParent: $('#ClientContrat').parent()
        });
    })
</script>

<script type="text/javascript">
$(document).ready(function(){

$("#numCautionMateriel").inputmask();
$("#up_numCaution").inputmask();
  //For Card Number formatted input
var cardNum = document.getElementById('numCautionCBMateriel');
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
  /////////////////////////// update numero carte bancaire material
  $(document).ready(function(){
    //For Card Number formatted input
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