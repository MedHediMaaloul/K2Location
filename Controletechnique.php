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
                Contrôle périodique véhicule
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
                    <div class="card-heading text-uppercase">Liste des Contrôle périodique véhicules</div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        <?php
                        // if (($_SESSION['Role']) != "superadmin") {
                        ?>
                        <!-- <button class="btn btn-success " type="button" data-toggle="modal"
                            data-target="#Registration-Controle-technique"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button> -->
                        <?php
                        // }
                        ?>
                            <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2" >
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchControleTechnique"
                                    class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row" id="searchTypeControleTechnique">
                            <div class="col-sm">
                                <div class="col-md-12 border-bottom p-0">
                                    <select id="Type_Controle_Technique_search" name="Type_Controle_Technique_search" onchange="Type_Controle_dispo()"
                                            class="form-control p-0 border-0" required>
                                        <option value="0">Choisissez le type</option>
                                        <option value="1">Contrôle Technique</option>
                                        <option value="2">Contrôle Anti pollution</option>
                                        <option value="3">Contrôle VGP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm"></div>
                            <div class="col-sm"></div>
                        </div>
                        <hr>
                        <!-- end search box -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <div class="table-responsive" id="Controle-technique-list"></div>
                                    <!-- realisation Controle-technique model -->
                                    <div class="modal fade" id="realisationControleTechnique" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Réaliser le contrôle</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Confirmez vous la réalisation de contrôle ?</p>
                                                    <button class="btn btn-success"
                                                        id="btn_realisation_Controletechnique">Réaliser le contrôle</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  realisation Controle-technique modal -->
                                    <!-- update Controle-technique model -->
                                    <div class="modal fade" id="updateControleTechnique" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier
                                                    Contrôle périodique
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_messageCT"></p>
                                                    <form id="updateControle-techniqueForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idcontroletechnique">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire Déclarant<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <textarea class="form-control p-0 border-0"
                                                                    placeholder="Votre commentaire"
                                                                    id="up_Controle_technique_Commentaire" rows="3"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Contrôle périodique<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_controledate"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_updated_controle_technique">Modifier
                                                    Contrôle périodique</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->

                                    <!-- update Controle-technique-mecanicien model -->
                                    <div class="modal fade" id="updateControleTechniqueMecanicien" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier
                                                    Contrôle périodique
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_messageCTmeca"></p>
                                                    <form id="updateControle-techniqueForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idcontroletechniquemec">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire Intervenant</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <textarea class="form-control p-0 border-0"
                                                                    placeholder="Votre commentaire"
                                                                    id="up_Controle_techniquemec_Commentaire_interv" rows="3"></textarea>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_updated_controle_technique_mecanicien">Modifier
                                                    Contrôle périodique</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->



                                    <!-- Modal add Registration-Controle-technique -->
                                    <div class="modal fade" id="Registration-Controle-technique" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Contrôle Périodique Véhicule
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message-Controle-technique"></p>
                                                    <form id="EntretienForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Type
                                                            de Contrôle Véhicule
                                                                    *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="Controlevehiculetype" name="Controlevehiculetype"
                                                                    placeholder="Controlevehiculetype"
                                                                    class="form-control p-0 border-0" required="">
                                                                    <option value="Selectionner" disabled selected>
                                                                        Selectionner type de Contrôle Véhicule</option>
                                                                    <option value="Controle Technique">Contrôle périodique</option>
                                                                    <option value="VGP">VGP</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Type
                                                                d'intervention
                                                                *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="ObjetControletechnique"
                                                                    placeholder="Type d'intervention"
                                                                    class="form-control p-0 border-0"
                                                                    name="ObjetControletechnique">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0"> Lieu
                                                            Contrôle périodique
                                                                *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="LieuControletechnique"
                                                                    placeholder="Paris"
                                                                    class="form-control p-0 border-0"
                                                                    name="Entretiendate">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0"> Cout
                                                            Contrôle périodique *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="CoutControletechnique"
                                                                    placeholder="1000 £"
                                                                    class="form-control p-0 border-0"
                                                                    name="CoutControletechnique">
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Date début
                                                            Contrôle périodique *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="Controletechniquedate"
                                                                    class="form-control p-0 border-0"
                                                                    name="Controletechniquedate">
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Date fin
                                                            Contrôle périodique *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="ControletechniqueFindate"
                                                                    class="form-control p-0 border-0"
                                                                    name="ControletechniqueFindate">
                                                            </div>
                                                        </div>





                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Maintenance récurrente*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <!-- <input type="text" id="Entretienname" placeholder="nom de Entretien" class="form-control p-0 border-0" required> </div> -->
                                                                <select class="form-control form-control p-0 border-0"
                                                                    id="EntretienTypeM">
                                                                    <option value="" disabled selected>Selectionner
                                                                    </option>
                                                                    <option>oui</option>
                                                                    <option>non</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="ProchaineEntretien"
                                                            style="display: none">
                                                            <label for="example-email" class="col-md-12 p-0">Prochaine
                                                                date Contrôle périodique *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="ProchaineControletechniquedate"
                                                                    class="form-control p-0 border-0"
                                                                    name="Controletechniquedate">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <!-- <input type="text" id="Entretienfournisseur" placeholder="fournisseur de Entretien" class="form-control p-0 border-0"> -->
                                                                <textarea class="form-control p-0 border-0"
                                                                    placeholder="Votre commentaire .."
                                                                    id="ControletechniqueCommentaire"
                                                                    rows="3"></textarea>
                                                            </div>
                                                        </div>

                                                        <div id="voiture">
                                                            <div class="form-group mb-4">
                                                                <label class="col-md-12 p-0"> Véhicule</label>
                                                                <div class="col-md-12 border-bottom p-0">
                                                                    <?php
                                                                    include('Gestion_location/inc/connect_db.php');
                                                                    $id_agence = $_SESSION['id_agence'];
                                                                    if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                                                        $query = "SELECT * FROM `voiture` where (etat_voiture != 'Vendue' and etat_voiture != 'Entretien') 
                                                                        and actions !='S'
                                                                        ORDER BY `id_voiture` ASC";
                                                                    } else {
                                                                        $query = "SELECT * FROM `voiture` where (etat_voiture != 'Vendue' and etat_voiture != 'Entretien') 
                                                                        and id_agence ='$id_agence'
                                                                        and actions !='S'
                                                                        ORDER BY `id_voiture` ASC";
                                                                    }
                                                                    $result = mysqli_query($conn, $query);
                                                                    ?>
                                                                    <select id="ControletechniqueVoiture"
                                                                        name="ControletechniqueVoiture"
                                                                        class="form-control p-0 border-0">
                                                                        <option value="" disabled selected>Selectionner
                                                                            véhicule</option>
                                                                        <?php
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo '<option value="' . $row['id_voiture'] . '">' .  $row['type'] . ' - ' . $row['pimm'] . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn-register-Controle-technique">Ajouter
                                                        Contrôle périodique</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END ADD Registration-Controletechnique -->
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

    </body>

    </html>