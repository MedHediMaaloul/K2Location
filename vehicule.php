<?php

session_start();
// verification si la personn est bien passé par la page pour se connecter
if (!isset($_SESSION['User'])) {
    // echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
    header("Location:login.php");
} else {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
}

?>
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title text-uppercase font-medium font-14">
                    VÉHICULES
                </h4>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- .col -->
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-heading">LISTE DES VOITURES</div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        <?php
                        if (($_SESSION['Role']) != "superadmin") {
                        ?>
                            <button class="btn btn-success " alt="ajouter" type="button" data-toggle="modal"
                                data-target="#Registration-Voiture"
                                style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
                            <button class="btn btn-secondary " type="button" data-toggle="modal"
                                data-target="#Setting-Voiture"
                                style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px"><i
                                class="fas fa-cogs"></i></button>
                        <?php
                        }
                        ?>
                        <button class="btn btn-success " type="button" data-toggle="modal"
                            data-target="#Hist-Transf-Voiture"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px"><i
                                class="fas fa-history"></i></button>
                        <?php
                        if (($_SESSION['Role']) != "superadmin") {
                        ?>
                        <a href="ExportVoiture.php" role="button"
                            style="background-color: DodgerBlue;border: none;color: white;padding: 10px 5px;cursor: pointer;font-size: 20px;">
                            <i class="fa fa-download"
                                style="background-color: DodgerBlue;border: none;color: white;padding: 10px 5px;cursor: pointer;font-size: 20px;">
                            </i>Export</a>
                        <a href="ImportVoiture.php" role="button"
                            style="background-color: #EF3E42;border: none;color: white;padding: 10px 5px;cursor: pointer;font-size: 20px;">
                            <i class="fa fa-download fa-rotate-270"
                                style="background-color: #EF3E42;border: none;color: white;padding: 5px 5px;cursor: pointer;font-size: 20px;">
                            </i>Import</a>
                        <?php
                        }
                        ?>
                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchVoiture"
                                    class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- end search box -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <div class="table-responsive" id="voiture-list"></div>
                                    <!-- setting Voiture -->
                                    <div class="modal fade" id="Setting-Voiture" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Marque &
                                                        Modéle Véhicule</h5>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message-setting"></p>
                                                    <form id="setting-voitureForm" class="form-horizontal form-material"
                                                        autocomplete="off">
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Marque<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" name="type"
                                                                    id="Setting_voitureMarque"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Modèle<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" name="type"
                                                                    id="Setting_voitureModele"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                    </form>
                                                    <hr>
                                                    <div id="tableSetting"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-Setting-Voiture">Ajouter
                                                        Marque/Modèle</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-voiture_setting">Fermer</button>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <!-- end setting Voiture -->
                                    <!-- setting Voiture -->
                                    <div class="modal fade" id="Hist-Transf-Voiture" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Historique Transfert
                                                        Voiture</h5>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="tableSettingTransf"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-voiture_setting">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end setting Voiture -->
                                    <!-- update Voiture model -->
                                    <div class="modal fade" id="updateVoiture" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier véhicule
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="up-voitureForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="Up_Voitureid">
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Type<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="up_voitureType" id="up_voitureType"
                                                                    class="form-control p-0 border-0">
                                                                    <option value="FOURGON UTILITAIRE">FOURGON
                                                                        UTILITAIRE</option>
                                                                    <option value="VOITURE DE SOCIÉTÉ">VOITURE DE
                                                                        SOCIÉTÉ</option>
                                                                    <option value="CAMION NACELLE">CAMION NACELLE
                                                                    </option>
                                                                    <option value="FOURGON NACELLE">FOURGON NACELLE
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">PIMM<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                    <input type="text" id="up_voiturePimm"
                                                                data-inputmask="'mask': 'AA-999-AA'"
                                                                    placeholder="CC-XXX-CC"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <!-- select marque model -->
                                                        <?php
                                                        include_once('Gestion_location/inc/connect_db.php');
                                                        $query = "SELECT * FROM marquemodel  WHERE  etat_marque!='S'  ORDER BY Marque ASC";
                                                        $result = mysqli_query($conn, $query);
                                                        ?>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Marque/Modèle<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="type" id="up_voitureMarqueModel"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="0" disabled selected>Selectionner
                                                                        Marque & Modèle </option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_MarqueModel'] . '">' . $row['Marque'] .  '  ' . $row['Model'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Fournisseur</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_voiturefournisseur"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Km<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="up_voiturekm" placeholder="Km"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Achat</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_voituredate_achat"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date 1er
                                                                immatriculation<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_date_immatriculation"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> DPC VGP</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_date_DPC_VGP"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> DPC VT</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_date_DPC_VT"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> DPT Pollution</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_date_DPT_Pollution"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div id="up_inputvgp" class="form-group mb-4"
                                                            style="display: none">
                                                            <label class="col-md-12 p-0">VGP<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_vgp"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> Carte grise</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_carte_grise"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> Carte verte</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_carte_verte"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>


                                                        <div hidden class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Disponibilité<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="type" id="up_etat_voiture"
                                                                    list="etat_voiture"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="Disponible">Disponible</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_update_voiture">Modifier
                                                        véhicule </button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->

                                    <!-- delete voiture model -->
                                    <div class="modal fade" id="deleteVoiture" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer véhicule
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Voulez-vous supprimer le véhicule ?</p>
                                                    <button class="btn btn-success" id="btn_delete">Supprimer
                                                        véhicule </button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  delete modal -->

                                    <!-- Modal add voiture -->
                                    <div class="modal fade" id="Registration-Voiture" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter véhicule
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="addvoitureForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Type<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select type="text" name="type" id="Voituretype"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        type de véhicule </option>
                                                                    <option value="FOURGON UTILITAIRE">FOURGON
                                                                        UTILITAIRE</option>
                                                                    <option value="VOITURE DE SOCIÉTÉ">VOITURE DE
                                                                        SOCIÉTÉ</option>
                                                                    <option value="CAMION NACELLE">CAMION NACELLE
                                                                    </option>
                                                                    <option value="FOURGON NACELLE">FOURGON NACELLE
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">PIMM<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="Voiturepimm"
                                                                data-inputmask="'mask': 'AA-999-AA'"
                                                                    placeholder="CC-XXX-CC"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <!-- select marque model -->
                                                        <?php
                                                        include_once('Gestion_location/inc/connect_db.php');
                                                        $query = "SELECT * FROM marquemodel  WHERE  etat_marque!='S'  ORDER BY Marque ASC";
                                                        $result = mysqli_query($conn, $query);
                                                        ?>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Marque/Modèle<span
                                                                    class="text-danger">* </span></label>
                                                            <label class="col-md-12 p-0">
                                                                <div class="col-md-12 border-bottom p-0">
                                                                    <span class="text-danger"></span>
                                                                    <select name="type" id="voitureMarqueModel"
                                                                        class="form-control p-0 border-0" required>
                                                                        <option value="" disabled selected>Selectionner
                                                                            Marque & Modèle </option>
                                                                        <?php
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo '<option value="' . $row['id_MarqueModel'] . '">' . $row['Marque'] .  '  ' . $row['Model'] . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Boite de vitesse<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select type="text" name="type" id="Voitureboitevitesse"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        la boite de vitesse</option>
                                                                    <option value="Manuelle">Manuelle</option>
                                                                    <option value="Automatique">Automatique</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Type de carburant<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select type="text" name="type"
                                                                    id="Voituretypecarburant"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        le type de carburant</option>
                                                                    <option value="Essence">Essence</option>
                                                                    <option value="Diesel">Diesel</option>
                                                                    <option value="Electrique">Electrique</option>
                                                                    <option value="Hybride">Hybride</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Fournisseur</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="Voiturefournisseur"
                                                                    placeholder="Fournisseur"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Km<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="Voiturekm" placeholder="Km"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Achat</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="Voituredate_achat"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date 1er
                                                                immatriculation<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="date_immatriculation"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> DPC VGP</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="date_DPC_VGP"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> DPC VT</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="date_DPC_VT"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> DPT Pollution</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="date_DPT_Pollution"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div id="inputvgp" class="form-group mb-4"
                                                            style="display: none">
                                                            <label class="col-md-12 p-0">VGP<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="vgp"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Carte grise<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="carte_grise"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Carte verte<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="carte_verte"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <?php
                                                        if ($_SESSION['Role'] == "responsable") {
                                                        ?>
                                                            <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM agence where id_agence!='0' ";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0">Agence<span
                                                                    class="text-danger">*</span></label>
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-md-10 border-bottom p-0">
                                                                            <select id="vehiculeagence" name="vehiculeagence"
                                                                                placeholder="agence"
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

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-voiture">Ajouter
                                                        véhicule</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add modal -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
    </div>
<?php
include('Gestion_location/inc/footer.php')
?>

<script type="text/javascript">
$(document).ready(function(){
$("#Voiturepimm").inputmask();
});
$(document).ready(function(){
$("#up_voiturePimm").inputmask();
});
</script>

</body>

</html>