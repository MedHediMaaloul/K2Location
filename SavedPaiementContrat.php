<?php
session_start();
// verification si la personn est bien passé par la page pour se connecter
if (isset($_SESSION['User'])) {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
} else {
    //  echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
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
                    CONTRATS
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
                    <div class="card-heading">ARCHIVES DE PAIEMENT</div>
                    <div class="card-body">
                        <!-- end search box -->
                        <!-- <p id="delete_message"></p> -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <?php
                                    include('Gestion_location/inc/connect_db.php');
                                    $query = "SELECT C.id_contrat,C.type_location,AP.id,AP.contrat_id,AP.date_validation 
                                    FROM contrat AS C 
                                    INNER JOIN archive_paiement AS AP 
                                    on C.id_contrat = AP.contrat_id LIMIT 5";
                                    $result = mysqli_query($conn, $query);
                                    $paiement_Id = '';
                                    ?>
                                    <div class="table-responsive" id="table-archive-paiement">
                                        <table class="table table-bordered" id="load_data_table">
                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                                $date_today = strtotime($row["date_validation"]);
                                                $date_format_fr = date("d-m-Y", $date_today);
                                            ?>
                                            <tr class="text-center font-weight-bold">
                                                <td><?php echo (' <i class="font-20 far fa-credit-card" style="font-size:15px;"></i>  Le paiement du contrat num ' . '' . $row["id_contrat"] . ' de ' . $row["type_location"] . ' est validé le ' . $date_format_fr . '.'); ?>
                                                </td>

                                            </tr>
                                            <?php
                                                $paiement_Id = $row["id"];
                                            }
                                            ?>
                                            <tr id="remove_row">
                                                <td><button type="button" name="btn_more"
                                                        data-vid="<?php echo $paiement_Id; ?>" id="btn_more"
                                                        class="btn btn-secondary form-control">Voir plus</button></td>
                                            </tr>
                                        </table>
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
    <script>
    $(document).ready(function() {
        $(document).on('click', '#btn_more', function() {
            var paiement_id = $(this).data("vid");
            $('#btn_more').html("Loading...");
            $.ajax({
                url: "LoadPaiementData.php",
                method: "POST",
                data: {
                    paiement_id: paiement_id
                },
                dataType: "text",
                success: function(data) {
                    if (data != '') {
                        $('#remove_row').remove();
                        $('#load_data_table').append(data);
                    } else {
                        $('#btn_more').html("Pas de données");
                    }
                }
            });
        });
    });
    </script>
    </body>

    </html>