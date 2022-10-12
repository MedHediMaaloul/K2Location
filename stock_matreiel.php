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
                    STOCK MATÉRIEL

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
                    <div class="card-heading">LISTE DES STOCKS MATÉRIELS</div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        <?php
                        if (($_SESSION['Role']) != "superadmin") {
                        ?>
                        <button class="btn btn-success" type="button" 
                            data-toggle="modal" data-target="#Registration-Materiel"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>

                        <?php
                        }
                        ?>
                       <!-- search box -->
                       <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchStockMateriels"
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
                                    <div class="table-responsive" id="stock-list-materiel"></div>
                                    <!-- show file modal -->
                                    <div class="modal fade bd-example-modal-sm" id="file-modal" tabindex="-1"
                                        role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-img-content">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add modal -->
                                    <!-- update Transfert  model -->
                                    <div class="modal fade" id="updatematerialestock" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Material</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="up-materialForm" autocomplete="off"
                                                        class="form-horizontal form-material">


                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idmaterial">
                                                        </div>



                                                        <?php
                                                        include_once('Gestion_location/inc/connect_db.php');
                                                        $id_agence = $_SESSION['id_agence'];
                                                        $query = "SELECT * FROM agence  where etat_agence !='S' AND id_agence != $id_agence AND id_agence != '0' ";
                                                        $result = mysqli_query($conn, $query);
                                                        ?>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Agence<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="type" id="up_materialagence"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        Agence </option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_agence'] . '">' . $row['lieu_agence'] .   '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn_update_materiel_stock">Modifier
                                                        Agence</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal update materiel -->
                                    <div class="modal fade" id="updatematerialestockquantite" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Material</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_messagequantite"></p>
                                                    <form id="up-materialForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idmaterialquantite">
                                                        </div>

                                                        <?php
                                                        include_once('Gestion_location/inc/connect_db.php');
                                                        $id_agence = $_SESSION['id_agence'];
                                                        $query = "SELECT * FROM agence  where etat_agence !='S' AND id_agence != $id_agence AND id_agence != '0' ";
                                                        $result = mysqli_query($conn, $query);
                                                        ?>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Agence<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="type" id="up_materialquantiteagence"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        Agence </option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_agence'] . '">' . $row['lieu_agence'] .   '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Quantité<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="quititematerialquantite" placeholder="l"
                                                                    class="form-control p-0 border-0" min="1" step="1"
                                                                    required>
                                                            </div>
                                                        </div>  
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn_update_materiel_stock_quantite">Modifier
                                                        Agence</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal update materiel -->
                                    <!-- Modal add materiel -->
                                    <div class="modal fade" id="Registration-Materiel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Matériel
                                                        Agence</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="add-MaterielForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM materiels where etat_materiels_categorie!='S'  ORDER BY code_materiel,designation ASC";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0">Materiel<span class="text-danger">*</span></label>
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-md-10 border-bottom p-0">
                                                                            <select id="IdMateriel" name="IdMateriel"
                                                                                onchange="MaterielCategorie(this.value)"
                                                                                placeholder="agence"
                                                                                class="form-control p-0 border-0"
                                                                                required>
                                                                                <option value="" disabled selected>Selectionner Materiel</option>
                                                                                <?php
                                                                                if ($result->num_rows > 0) {
                                                                                    while ($row = $result->fetch_assoc()) {
                                                                                        echo '<option value="' . $row['id_materiels'] . '">' . $row['code_materiel'] . ' -- ' . $row['designation'] . '</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_num_serie"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">N° Serie<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" placeholder="Ns° A3452 "
                                                                    id="materielnumserie"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group mb-2" id="cont_composant"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Composant Matériel </label>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dynamic_field">
                                                                    <tr>
                                                                        <td style="width:40%;">
                                                                            <input type="text" name="skill[]"
                                                                                id="fetch-materiel_comp1"
                                                                                placeholder="Composant"
                                                                                class="form-control materiel-list-comp">
                                                                        </td>
                                                                        <td style="width:40%;"> <input type="text"
                                                                                id="num_serie_comp_1"
                                                                                placeholder="Num serie"
                                                                                class="form-control p-0  materiel-list-num_comp"
                                                                                required>
                                                                        </td>
                                                                        <td><button type="button" name="add" id="add"
                                                                                class="btn btn-success">+</button></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_quitite"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Quantité<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="quitite" placeholder="l"
                                                                    class="form-control p-0 border-0" min="1" step="1"
                                                                    required>
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
                                                                            <select id="materielagence" name="materielagence"
                                                                                placeholder="agence"
                                                                                class="form-control p-0 border-0"
                                                                                required>
                                                                                <option value="0" disabled selected>Selectionner Agence</option>
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
                                                    <button class="btn btn-success" id="btn-register-Materiel">Ajouter
                                                        Matériel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-add-materiel">Fermer</button>
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