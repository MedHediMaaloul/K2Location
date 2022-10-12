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
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <?php if(isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Félicitation!</strong> <?php echo $_SESSION['success']; ?>
                        </div>
                    <?php } unset($_SESSION['success']); ?>
                    <?php if(isset($_SESSION['echec'])) { ?>
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Attention!</strong> <?php echo $_SESSION['echec']; ?>
                        </div>
                    <?php } unset($_SESSION['echec']); ?>
                    <div class="card-heading">IMPORTER LA LISTE DES VOITURES</div>
                        <div class="col-sm-12">
							<div class="container">
								<form method="POST" action="UploadVehicule.php" enctype="multipart/form-data">
									<div class="form-group">
										<h8>Importer un fichier excel</h8>
										<input type="file" name="file" class="form-control">
									</div>
									<div class="form-group">
										<button type="submit" name="Submit" class="btn btn-success">Importer</button>
									</div>
								</form>
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