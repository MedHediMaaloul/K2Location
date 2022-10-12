<?php 
// include("db_connect.php");
include_once("Gestion_location/inc/connect_db.php");
session_start();
if (($_SESSION['Role']) == "superadmin" || ($_SESSION['Role']) == "admin" || ($_SESSION['Role']) == "responsable") {
	include('Gestion_location/inc/header_sidebar.php');
} else {
	header("Location:login.php");
}
?>
<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="plugins/bower_components/popper.js/dist/umd/popper.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/app-style-switcher.js"></script>
<script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>

<!--Wave Effects -->
<script src="js/waves.js"></script>
<!--Menu sidebar -->
<script src="js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="js/custom.js"></script>
<script src="js/entretien.js"></script>
<script src="js/myjs.js"></script>
<!--This page JavaScript -->
<!--chartis chart-->
<script src="plugins/bower_components/chartist/dist/chartist.min.js"></script>
<script src="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<script src="js/pages/dashboards/dashboard1.js"></script>


<link rel="stylesheet" href="planning/css/calendar.css">
<div class="page-wrapper">
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title text-uppercase font-medium font-14">
                    PLANNING LOCATION
                </h4>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- .col -->
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-heading">Liste de planning</div>
                    <div class="card-body">
						<div class="page-header">
							<div class="btn-toolbar">
								<div class="btn-group" style="margin: 10px 50px 8px 30px;">
									<button class="btn btn-success" style="color: #ffffff;" data-calendar-nav="prev"><< Précédent</button>
									<button class="btn btn-secondary" data-calendar-nav="today">Aujourd'hui</button>
									<button class="btn btn-success" style="color: #ffffff;" data-calendar-nav="next">Suivant >></button>
								</div>
								<div class="btn-group" style="margin: 10px 0px 8px 30px;">
									<button class="btn btn-danger" data-calendar-view="day">Jour</button>
									<button class="btn btn-danger" data-calendar-view="week">Semaine</button>
									<button class="btn btn-danger active" data-calendar-view="month">Mois</button>
									<button class="btn btn-danger" data-calendar-view="year">Année</button>
								</div>
							</div>
							<div class="card-body">
								<div class="page-header">
									<h3></h3>
									<div class="row">
										<div class="col-md-12">
											<div id="showEventCalendar"></div>
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
<!-- calendar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="planning/js/calendar.js"></script>
<script src="planning/js/events.js"></script>	
