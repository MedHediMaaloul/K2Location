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
                    MATERIELS
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
                    <div class="card-heading">LISTE DES MATERIELS</div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        <button class="btn btn-success " type="button" data-toggle="modal"
                            data-target="#Registration-Materiel"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
                        <!-- <button class="rounded-pill border border-dark" type="button" data-toggle="modal" data-target="#Registration-Materiel" style="height: 50px;;width: 120px" >AJOUTER<span style="border-radius:50% ; width: 50px;width: 50px;width: 50px;border:1px" >+</span></button> -->
                        <a href="ExportMateriel.php"><button type="button" class="btn btn-primary"
                                style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 150px;width: 50px;height:50px"><i
                                    class="far fa-file-excel"></i></button></a>


                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchMateriel"
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Materiel
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>voulez-vous supprimer le Materiel ?</p>
                                                    <button class="btn btn-success" id="btn_delete_materiel">Supprimer
                                                        Materiel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  delete modal -->


                                    <!-- update materiel model -->
                                    <div class="modal fade" id="updateMateriel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Materiel
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
                                                            <label class="col-md-12 p-0">Nom Materiel<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_materielname"
                                                                    placeholder="nom de materiel"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idmateriel">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="example-email"
                                                                class="col-md-12 p-0">Catègorie<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_materielcategorie"
                                                                    placeholder="catégorie de materiel"
                                                                    class="form-control p-0 border-0"
                                                                    name="example-email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Fournisseur</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_materielfournisseur"
                                                                    placeholder="fournisseur de materiel"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Achat</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_materieldateachat"
                                                                    placeholder="date d'achat de materiel"
                                                                    class="form-control p-0 border-0">
                                                            </div>

                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Num Serie<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_materielnumserie"
                                                                    placeholder="num serie de materiel"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Designation</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_materieldesignation"
                                                                    placeholder="designation de materiel"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Disponibilité<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" name="type" id="up_materieldespo"
                                                                    list="despodispo1" class="form-control p-0 border-0"
                                                                    required>
                                                                <datalist id="despodispo1">
                                                                    <option value="OUI">
                                                                    <option value="NON">
                                                                </datalist>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_updated_materiel">Modifier
                                                        Materiel</button>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Materiel</h5>
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
                                                            $query = "SELECT * FROM group_materiels ORDER BY code,type_materiel ASC";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Catègorie*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="MaterielCategorie" name="MaterielCategorie"
                                                                    onchange="MaterielCategorieGroup(this.value)"
                                                                    placeholder="agence"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        Catègorie</option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_group_materiel'] . '">' . $row['code'] . ' -- ' . $row['type_materiel'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Designation</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="materieldesignation"
                                                                    placeholder="designation de materiel"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_num_serie"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Num Serie<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="materielnumserie"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4" id="cont_quitite"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">quitite<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="quitite" placeholder="l"
                                                                    class="form-control p-0 border-0" min="1" step="1"
                                                                    required>
                                                            </div>
                                                        </div>



                                                        <div class="form-group mb-2" id="cont_composant"
                                                            style="display:none">


                                                            <label class="col-md-12 p-0">Composant Materiel <span
                                                                    class="text-danger">*</span></label>

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


                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-Materiel">Ajouter
                                                        Materiel</button>
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
            <!-- /.col -->
        </div>
    </div>
    <?php
    include('Gestion_location/inc/footer.php')
    ?>

    <script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            // alert('cvbcvb');
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
    </script>
    </body>

    </html>