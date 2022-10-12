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
                    MATÉRIELS
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
                    <div class="card-heading">LISTE DES MATÉRIELS</div>
                    <div class="card-body">
                        <p id="delete_messagec"></p>
                        <?php
                        if (($_SESSION['Role']) == "responsable") {
                        ?>
                        <button class="btn btn-success" type="button" 
                            data-toggle="modal" data-target="#Registration-Materiel"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>

                        <a href="ExportMateriel.php" role="button"
                            style="background-color: DodgerBlue;border: none;color: white;padding: 10px 5px;cursor: pointer;font-size: 20px;">
                            <i class="fa fa-download"
                                style="background-color: DodgerBlue;border: none;color: white;padding: 10px 5px;cursor: pointer;font-size: 20px;">
                            </i>Export</a>
                        <a href="ImportMateriel.php" role="button"
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
                                <input type="input" placeholder="Que recherchez-vous?" id="searchMaterielAgence"
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
                                    <div class="table-responsive" id="Materiel-list"></div>
                                    <!-- delete materiel model -->
                                    <div class="modal fade" id="deleteMateriel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Matériel
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Voulez-vous supprimer le Matériel ?</p>
                                                    <button class="btn btn-success"
                                                        id="btn_delete_materiel_agence">Supprimer
                                                        Matériel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  delete modal -->

                                    <!-- delete composant model -->
                                    <div class="modal fade" id="deleteComposant" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Voulez-vous supprimer cet composant ?</p>
                                                    <button class="btn btn-success"
                                                        id="btn-delete-composant">Supprimer
                                                        le composant</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- end  delete modal -->


                                    <!-- update materiel model -->
                                    <div class="modal fade" id="updateMaterielAgence" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Matériel
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="MaterielForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idmateriel">
                                                        </div>



                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> N° serie matériel</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_materielNserie"
                                                                    placeholder="fournisseur de materiel"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Matériel État</label>
                                                            <div class="col-md-12 border-bottom p-0">

                                                                <select id="up_materielEtat" name="up_materielEtat"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="HS"> Hors Service </option>
                                                                    <option value="T"> Activer</option>
                                                                </select>
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
                                                            <label class="col-md-12 p-0">Agence*</label>
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-md-10 border-bottom p-0">
                                                                            <select id="up_materielagence" name="up_materielagence"
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
                                                    <button class="btn btn-success"
                                                        id="btn_updated_materiel_agence">Modifier
                                                        matériel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->


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

                                     <!-- Modal add materiel -->
                                     <div class="modal fade" id="Registration-Composant-Materiel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Composant Matériel</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="messagecomp"></p>
                                                    <form id="add-ComposantMaterielForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="idmateriel">
                                                        </div>

                                                        <div class="form-group mb-2" id="composant_materiel">
                                                            <label class="col-md-12 p-0">Composant Matériel </label>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dynamic_field_composant">
                                                                    <tr>
                                                                        <td style="width:40%;">
                                                                            <input type="text" name="skill[]"
                                                                                id="materiel_composant_1"
                                                                                placeholder="Composant"
                                                                                class="form-control list-composant-materiel">
                                                                        </td>
                                                                        <td style="width:40%;"> <input type="text"
                                                                                id="num_serie_composant_1"
                                                                                placeholder="Num serie"
                                                                                class="form-control p-0 list-numserie-composant-materiel"
                                                                                required>
                                                                        </td>
                                                                        <td><button type="button" name="addcomposant" id="addcomposant"
                                                                                class="btn btn-success">+</button></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-composant-Materiel">Ajouter
                                                        Composant Matériel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-add-composant-materiel">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add modal -->

                                    <div class="modal fade" id="Registration-Materiel-Comp" tabindex="-1" role="dialog"
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
                                                    <form id="add-MaterielCompForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn-register-Materiel-comp">Ajouter
                                                        Materiel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-add-materiel">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="Registration-Materiel-stock" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Stock</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="messagest"></p>
                                                    <form id="add-MaterielStockForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idMaterielstock">
                                                        </div>

                                                        <div class="form-group mb-2">
                                                            <label class="col-md-12 p-0">Stock Matériel <span class="text-danger"></span></label>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="">
                                                                    <tr>
                                                                        <td style="width:40%;">
                                                                            <select id="stockSigne" name="stockSigne"
                                                                                placeholder="agence"
                                                                                class="form-control p-0 border-0"
                                                                                required>
                                                                                <option value="add"> + </option>
                                                                                <option value="moins"> - </option>
                                                                            </select>
                                                                        </td>
                                                                        <td style="width:40%;"> <input type="text"
                                                                                id="value" value="0"
                                                                                placeholder="quantite"
                                                                                class="form-control p-0 " required>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>

                                                            <div class="form-group mb-4">
                                                                <label class="col-md-12 p-0"> État Matériel</label>
                                                                <div class="col-md-12 border-bottom p-0">
                                                                    <select id="up_EtatMaterielstock"
                                                                        name="up_EtatMaterielstock"
                                                                        class="form-control p-0 border-0" required>
                                                                        <option value="HS"> Hors Service </option>
                                                                        <option value="T"> Activer</option>
                                                                    </select>
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
                                                            <label class="col-md-12 p-0">Agence*</label>
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-md-10 border-bottom p-0">
                                                                            <select id="up_materielstockagence" name="up_materielstockagence"
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
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-Materiel-stock">
                                                        Modifier stock</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-add-materiel">Fermer</button>
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
<script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i +
                '"> <td><input type="text" name="skill[]" id="fetch-materiel_comp' + i +
                '" placeholder="Composant" class="form-control materiel-list-comp"> </td> <td style="width:100px;"> <input type="text" id="num_serie_comp_' +
                i +
                '" placeholder="Num serie"class="form-control p-0 materiel-list-num_comp"  required> </td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });

    $(document).ready(function() {
        var i = 1;
        $('#addcomposant').click(function() {
            i++;
            $('#dynamic_field_composant').append('<tr id="row' + i +
                '"> <td><input type="text" name="skill[]" id="materiel_composant_' + i +
                '" placeholder="Composant" class="form-control list-composant-materiel"> </td> <td style="width:100px;"> <input type="text" id="num_serie_composant_' +
                i +
                '" placeholder="Num serie"class="form-control p-0 list-numserie-composant-materiel"  required> </td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
</script>
</body>
</html>