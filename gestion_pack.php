<?php

session_start();
// verification si la personn est bien passé par la page pour se connecter
if (isset($_SESSION['User'])) {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
} else {
    // echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
    header("Location:login.php");
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
                    PACK
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
                    <div class="card-heading">LISTE DES PACKS</div>
                    <div class="card-body">
                    <?php
                        if (($_SESSION['Role']) != "superadmin") {
                        ?>
                        <button class="btn btn-success " type="button" data-toggle="modal"
                            data-target="#Registration-Pack"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
                        <?php
                        }
                        ?>
                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchGestionPack"
                                    class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- end search box -->
                        <p id="delete_message_pack"></p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <!-- PDF model  -->

                                    <!-- modal delet contrat -->

                                    <div class="modal fade" id="deletePack" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Pack
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Voulez-vous supprimer le Pack ?</p>
                                                    <button class="btn btn-success" id="btn_delete_pack">Supprimer
                                                        Pack </button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal delet contrat -->

                                     <!-- delete materiel model -->
                                     <div class="modal fade" id="deleteMateriel" tabindex="-1" role="dialog"
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
                                                    <p>Voulez-vous supprimer cet matériel ?</p>
                                                    <button class="btn btn-success"
                                                        id="btn-delete-materiel">Supprimer
                                                        le matériel</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  delete modal -->
                                    <!--  modal view contrat -->
                                    <div class="table-responsive" id="group-pack-list"> </div>
                                    <div class="modal fade" id="Setting-Materiel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"> Matériel </h5>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="tableSettingmateriel"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  modal view contrat -->
                                    <!-- update Contrat Modal -->
                                    <div class="modal fade" id="update-Pack" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Pack</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message_pack"></p>
                                                    <form id="updatePackForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idPack">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Désignation</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_DesignationPack"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT distinct(type) FROM voiture  ORDER BY type ASC ";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Type Véhicule<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="up_TypeVoiturePack"
                                                                    name="up_TypeVoiturePack"
                                                                    class="form-control p-0 border-0">
                                                                    <option value="sans vehicule">SANS
                                                                        VEHICULE
                                                                    </option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['type'] . '">' . $row['type'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT distinct(type) FROM voiture ORDER BY type ASC ";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Etat<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="up_EtatPack" name="up_EtatPack"
                                                                    class="form-control p-0 border-0">
                                                                    <option value="T">
                                                                        Activer
                                                                    </option>
                                                                    <option value="F">
                                                                        Désactiver
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_updated_Group_Pack">Modifier
                                                        Pack</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal add materiel -->
                                    <div class="modal fade" id="Registration-Materiel-Pack" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Matériel Pack</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="messagemat"></p>
                                                    <form id="add-MaterielPackForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="idpack">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $querym = "SELECT * FROM materiels where etat_materiels_categorie!= 'S' ORDER BY code_materiel  ASC";
                                                            $resultm = mysqli_query($conn, $querym);
                                                            ?>
                                                            <script>
                                                            var materielPackData = '<?php
                                                                                    if ($resultm->num_rows > 0) {
                                                                                        while ($row = $resultm->fetch_assoc()) {
                                                                                            echo '<option value="' . $row['id_materiels'] . '">' . $row['designation'] . '-' . substr($row['designation'], 0, 1) . '</option>';
                                                                                        }
                                                                                    }
                                                                                    ?>';
                                                            </script>
                                                            <label class="col-md-12 p-0">Matériel <span
                                                                class="text-danger">*</span></label>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dynamic_field_pack">
                                                                    <tr>
                                                                        <td>
                                                                            <select name="skillpack[]" id="fetch-materiel-pack1"
                                                                                placeholder="Enter your Skill"
                                                                                class="form-control materiel-list-pack-mat"
                                                                                onchange="changeTypeMatrielPack(this.value,1)">
                                                                                <option value="" selected disabled>
                                                                                    Nom Matériel 
                                                                                    <span class="text-danger"></span>
                                                                                </option>
                                                                                <script>
                                                                                    document.write(materielPackData)
                                                                                </script>
                                                                            </select>
                                                                        </td>
                                                                        <td style="width:100px;"> 
                                                                            <input type="number" id="quantitepack_1" placeholder="Quantite" class="form-control p-0  materiel-list-quantite-pack border-0"
                                                                                min="1" step="1" required style="display:none">
                                                                        </td>
                                                                        <td><button type="button" name="addpack" id="addpack"
                                                                                class="btn btn-success">+</button>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-Materiel-Pack">Ajouter
                                                        Matériel Pack</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-add-materiel-pack">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add modal -->

                                    <!-- Modal add contrat -->
                                    <div class="modal fade" id="Registration-Pack" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter pack</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="grouppackForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="Up_Packid">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Désignation<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="DesignationPack"
                                                                    placeholder="Désignation de pack"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT distinct(type) FROM voiture ORDER BY type ASC ";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Type Véhicule<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="VoitureType" name="VoitureType"
                                                                    class="form-control p-0 border-0">
                                                                    <option value="sans vehicule" selected>SANS
                                                                        VEHICULE
                                                                    </option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['type'] . '">' . $row['type'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <?php
                                                           
                                                            $query = "SELECT * FROM materiels where etat_materiels_categorie!= 'S' ORDER BY designation  ASC
                                                             ";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <script>
                                                            var materielData = '<?php
                                                                                    if ($result->num_rows > 0) {
                                                                                        while ($row = $result->fetch_assoc()) {
                                                                                            echo '<option value="' . $row['id_materiels'] . '">' . $row['designation'] . '-' . substr($row['designation'], 0, 1) . '</option>';
                                                                                        }
                                                                                    }
                                                                                    ?>';
                                                            </script>
                                                            <label class="col-md-12 p-0">Matériel <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dynamic_field">
                                                                    <tr>
                                                                        <td>
                                                                            <select name="skill[]" id="fetch-materiel1"
                                                                                placeholder="Enter your Skill"
                                                                                class="form-control materiel-list-pack"
                                                                                onchange="changeTypeMatrielePack(this.value,1)">
                                                                                <option value="" selected
                                                                                    disabled>Nom
                                                                                    Matériel<span
                                                                                        class="text-danger"></span>
                                                                                </option>
                                                                                <script>
                                                                                document.write(materielData)
                                                                                </script>
                                                                            </select>
                                                                        </td>
                                                                        <td style="width:100px;"> <input type="number"
                                                                                id="quantite_1" placeholder="Quantite"
                                                                                class="form-control p-0  materiel-list-quantite border-0"
                                                                                min="1" step="1" required
                                                                                style="display:none">
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
                                                    <button class="btn btn-success" id="btn-register-pack">Ajouter
                                                        Pack</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="js/GeneratePDF.js"></script>
    <script>
    <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id_group_materiel'] . '">' . $row['code'] . '--' . $row['type_materiel'] . '</option>';
            }
        }
    ?>
    </script>
    <script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i +
                '"><td><select name="skill[]"  id="fetch-materiel' + i +
                '" placeholder="Enter your Skill" class="form-control materiel-list-pack" onchange="changeTypeMatrielePack(this.value,' +
                i + ')" ><option value="Nom Materiel"> Nom Materiel </option>' +
                materielData +
                '</select></td> <td> <input type="number" id="quantite_' + i +
                '"placeholder="Quantite"class="form-control materiel-list-quantite p-0 border-0"min="1" step="1" required style="display:none""></td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

        var j = 1;
        $('#addpack').click(function() {
            j++;
            $('#dynamic_field_pack').append('<tr id="row1' + j +
                '"><td><select name="skillpack[]"  id="fetch-materiel-pack' + j +
                '" placeholder="Enter your Skill" class="form-control materiel-list-pack-mat" onchange="changeTypeMatrielPack(this.value,' +
                j + ')" ><option value="Nom Materiel"> Nom Materiel </option>' +
                materielPackData +
                '</select></td> <td> <input type="number" id="quantitepack_' + j +
                '"placeholder="Quantite"class="form-control materiel-list-quantite-pack p-0 border-0"min="1" step="1" required style="display:none""></td><td><button type="button" name="remove" id="' +
                j + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row1' + button_id + '').remove();
        });
    });
    </script>
</body>
</html>