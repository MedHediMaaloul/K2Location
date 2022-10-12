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
                    FACTURES
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
                    <div class="card-heading">LISTE DES FACTURES MATÉRIELS</div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        <?php
                        if (($_SESSION['Role']) != "superadmin") {
                        ?>
                            <button class="btn btn-success " type="button" data-toggle="modal"
                            data-target="#Registration-Facture"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
                        <?php
                        }
                        ?>
                        <!-- search box -->

                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchFactureMateriel"
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
                                    <div class="table-responsive" id="facture-list-contrat-materiel"></div>
                                    <!-- Modal add Facture -->
                                    <div class="modal fade" id="Registration-Facture" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Facture</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="messagefacture"></p>
                                                    <form id="FactureForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="Factureid">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <?php
                                                                include('Gestion_location/inc/connect_db.php');
                                                                $id_agence = $_SESSION['id_agence'];
                                                                if ($_SESSION['Role'] == "admin") {
                                                                    $query = "SELECT * FROM contrat_client 
                                                                    where DATEDIFF(date_fin,date_debut) >= 180
                                                                    and etat_contrat = 'A'
                                                                    and type_location = 'Materiel'
                                                                    AND id_agence = $id_agence";
                                                                }else{
                                                                    $query = "SELECT * FROM contrat_client 
                                                                    where DATEDIFF(date_fin,date_debut) >= 180
                                                                    and etat_contrat = 'A'
                                                                    and type_location = 'Materiel'";
                                                                }
                                                                $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Contrat Client<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="ContratFacture" name="ContratFacture"
                                                                    class="form-control p-0 border-0">
                                                                    <option value=" " selected>Selectionnez Un Contrat
                                                                    </option>
                                                                    <?php
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo '<option value="' . $row['id_contrat'] . '">' . $row['id_contrat'] . " : " . $row['date_debut'] . " - " . $row['date_fin'] .'</option>';                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Arrêt<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="DateArret"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-facture">Ajouter
                                                        Facture</button>
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

    </body>

    </html>