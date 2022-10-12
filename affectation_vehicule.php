<?php
session_start();
if (($_SESSION['Role']) == "superadmin" || ($_SESSION['Role']) == "admin" || ($_SESSION['Role']) == "responsable") {
    // echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
    include('Gestion_location/inc/header_sidebar.php');
} else {
    header("Location:login.php");
    // si elle est bien connecté alors c'est bon
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
                    Historique Vehicule

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
                    <div class="card-heading"> Historique Vehicule</div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        <!-- #Registration-affectation   Exportaffectation5 -->
                        <?php
                        if (($_SESSION['Role']) != "superadmin") {
                        ?>
                            <button class="btn btn-success " type="button" data-toggle="modal"
                            data-target="#Registration-affectation"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
                        <?php
                        }
                        ?>
                        <!-- <a href=""><button type="button" class="btn btn-primary"
                                style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 150px;width: 50px;height:50px"><i
                                    class="far fa-file-excel"></i></button></a> -->
                        <!-- search box -->

                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchaffectation"
                                    class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row" id="searchvoiture">
                            <div class="col-sm">
                                <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM k2_vehicule where etat!='S' ";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>

                                <div class="col-md-12 border-bottom p-0">
                                    <select id="affectationK2_vehicule_search" name="affectationK2_vehicule"
                                        onchange="affictation_dispo()" class="form-control p-0 border-0" required>
                                        <option value="0">Choisissez un véhicule</option>

                                        <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_vehicule'] . '">' . $row['immatriculation'] . ' - ' . $row['marque'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm">

                            </div>
                            <div class="col-sm">

                            </div>
                        </div>

                        <hr>
                        <!-- end search box -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <div class="table-responsive" id="affectation-list"></div>
                                    <!-- show file modal -->
                                    <div class="modal fade bd-example-modal-sm" id="file-modal" tabindex="-1"
                                        role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-img-content">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end file modal -->

                                    <!-- deleteaffectation model -->
                                    <div class="modal fade" id="deleteaffectation" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer affectation
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Voulez-vous supprimer l'affectation ?</p>
                                                    <button class="btn btn-success"
                                                        id="btn_delete_affectation">Supprimer
                                                        affectation</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  delete modal -->
                                    <!-- update affectation model -->
                                    <div class="modal fade" id="updateaffectation" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier affectation
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="up-affectationForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_affectationName"
                                                                    placeholder="Johnathan Doe"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idaffectation">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Login<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_affectationLogin"
                                                                    placeholder="affectation adresse"
                                                                    class="form-control p-0 border-0">
                                                            </div>

                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Password<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_affectationPassword"
                                                                    placeholder="" class="form-control p-0 border-0">
                                                            </div>

                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Etat <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="duree" id="updateaffectationetat"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="T">Active</option>
                                                                    <option value="F">désactiver</option>

                                                                </select>
                                                            </div>
                                                        </div>


                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_update_affectation">Modifier
                                                        affectation</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->

                                    <!-- Modal add affectation -->
                                    <div class="modal fade" id="Registration-affectation" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Affectation
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        id="btn-close" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="messageaffectation"></p>
                                                    <form id="affectationForm" autocomplete="off"
                                                        class="form-horizontal form-material">


                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM k2_vehicule where etat!='S' ";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> véhicule *</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="affectationK2_vehicule"
                                                                    name="affectationK2_vehicule"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="Choisissez">Choisissez un véhicule
                                                                    </option>

                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_vehicule'] . '">' . $row['immatriculation'] . ' - ' . $row['marque'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM k2_chauffeur where etat !='S'";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Chauffeur*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="affectationChauffeur"
                                                                    name="affectationChauffeur"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="Choisissez">Choisissez un véhicule
                                                                    </option>

                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id'] . '">' . $row['nom_complet'] . ' </option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date debut<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">

                                                                <input type="datetime-local" id="affectationDateDebut"
                                                                    name="affectationDateDebut" min="2018-06-07T00:00">
                                                            </div>
                                                        </div>
                                                        <!-- value ="<?php //echo date('m-d-Y h:i:s ', time()); ?>" -->
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn-register-affectation">Ajouter
                                                        Affectation</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-affectation">Fermer</button>
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
        </div>
        <!-- /.col -->
    </div>
</div>

<?php
include('Gestion_location/inc/footer.php')
?>
</body>

</html>