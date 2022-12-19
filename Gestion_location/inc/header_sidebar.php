<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf8mb3" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 4 admin, bootstrap 4, css3 dashboard, bootstrap 4 dashboard, Ample lite admin bootstrap 4 dashboard, frontend, responsive bootstrap 4 admin template, Ample admin lite dashboard bootstrap 4 dashboard template" />
    <meta name="description"
        content="Ample Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework" />
    <meta name="robots" content="noindex,nofollow" />
    <title>K2 Gestion De Location</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="20x20" href="plugins/images/K2.png" />
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet" />
    <link href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- calendar -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <?php
                        if($_SESSION['Role'] == "mecanicien"){
                    ?>
                    <a class="navbar-brand" href="Controletechnique.php">
                        <b class="logo-icon">                       
                            <img width="50px" src="plugins/k2-pdf.jpg"/>           
                        </b>
                    </a>
                    <?php
                        }else{
                    ?>
                    <a class="navbar-brand" href="dashboard.php">
                        <b class="logo-icon">                   
                            <img width="50px" src="plugins/k2-pdf.jpg" alt="homepage" />
                        </b>
                    </a>
                    <?php     
                        }
                    ?>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- <ul class="navbar-nav d-none d-md-block d-lg-none">
                        <li class="nav-item">
                            <a class="nav-toggler nav-link waves-effect waves-light text-white"
                                href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                        </li>
                    </ul> -->
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ml-auto d-flex align-items-center">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" id="toggle-contrat" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="label label-pill label-danger" id="count-contrat"
                                    style="border-radius:10px;"></span>
                                <span class="text-white font-20 fas fa-calendar" style="font-size:18px;"></span>
                                <div class="notify">
                                    <span class="heartbit"></span>
                                    <span class="point"></span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left dropdown-menu-lg-left"
                                id="dropdown-menu-contrat"></ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" id="toggle-contratdebut" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="label label-pill label-danger" id="count-contratdebut"
                                    style="border-radius:10px;"></span>
                                <span class="text-white font-20 fa fa-bell" style="font-size:18px;"></span>
                                <div class="notify">
                                    <span class="heartbit"></span>
                                    <span class="point"></span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left dropdown-menu-lg-left"
                                id="dropdown-menu-contratDebut"></ul>
                        </li>
                        <li class="dropdown ">
                            <a href="#" class="dropdown-toggle" id="toggle-entretien" data-toggle="dropdown">
                                <span class="label label-pill label-danger" id="count-entretien"
                                    style="border-radius:10px;"></span>
                                <span class="text-white font-20 fas fa-wrench" style="font-size:15px;"></span>
                                <div class="notify">
                                    <span class="heartbit"></span>
                                    <span class="point"></span>
                                </div>
                            </a>
                            <ul class="dropdown-menu" id="dropdown-menu-entretien"></ul>
                        </li>
                        <style>
                        a.dropdown-toggle {
                            position: relative;
                            height: 50px;
                            width: 50px;
                            background-size: contain;
                            text-decoration: none;
                        }

                        .navbar-expand-md .navbar-nav .dropdown-menu {
                            position: absolute;
                            margin-left: -400px;
                        }

                        .dropdown {
                            margin-right: 50px;
                        }

                        .label-danger {
                            position: absolute;
                            width: 15px;
                            height: 15px;
                            right: 12px;
                            top: -5px;
                            color: #fff;
                        }

                        .dropdown-menu {
                            width: 500px !important;
                            margin-right: 500px;
                            left: -130%;
                        }
                        </style>
                        </li>
                        <li class="dropdown">
                            <?php
                            if (isset($_SESSION['User'])) {
                                if($_SESSION['Role'] == "superadmin"){
                                    echo '<span class="text-white font-medium">' . ($_SESSION['User']) .
                                            '</span>';
                                    echo '<a class="profile-pic" href="logout.php?logout"><span class="text-white font-medium">
                                            <i class="font-20 fas fa-sign-out-alt"></i></span></a>';
                                    
                                }else{
                                    $roles ='';
                                        
                                        if ($_SESSION['Role'] == 'responsable'){
                                            $roles = "Admin";
                                        }else if ($_SESSION['Role'] =='admin'){
                                            $roles ="Agent";
                                        }else if ($_SESSION['Role'] =='mecanicien'){
                                            $roles ="Mécanicien";
                                        }
                                    echo '<span class="text-white font-medium">' . $roles." : ".($_SESSION['User']) .
                                        '</span>';
                                    echo '<a class="profile-pic" href="logout.php?logout"><span class="text-white font-medium">
                                        <i class="font-20 fas fa-sign-out-alt"></i></span></a>';
                                }       
                            } else {
                                header("location:login.php");
                            }
                            ?>

                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <?php
                        if ($_SESSION['Role'] != "mecanicien") {
                        ?> 
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard.php"
                                aria-expanded="false">
                                <i class="far fa-clock" aria-hidden="true"></i>
                                <span class="hide-menu">Tableau de bord</span>
                            </a>
                        </li>

                        <?php
                        if ($_SESSION['Role'] == "superadmin") {
                            echo ' <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="agence.php"
                                    aria-expanded="false">
                                    <i class="fa fa-building" aria-hidden="true"></i>
                                    <span class="hide-menu">Agence</span>
                                </a>
                            </li>';
                        }
                        ?>
                        <?php
                        if ($_SESSION['Role'] == "superadmin") {
                            echo ' <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="utilisateur.php"
                                    aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Utilisateur  </span>
                                </a>
                            </li>';
                        }
                        ?> 

                        <li class="sidebar-item selected">
                            <a class="sidebar-link waves-effect waves-dark " href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <span class="hide-menu">Client</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item active">
                                    <a href="client.php" class="sidebar-link">
                                        <i class="mdi mdi-account-box"></i>
                                        <span class="hide-menu"> Client Actif </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="Client_inactif.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu"> Client Inactif</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="categorie.php"
                                aria-expanded="false">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                                <span class="hide-menu">Catégorie de Matériel</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="materiel-agence.php"
                                aria-expanded="false">
                                <i class="fas fa-box-open" aria-hidden="true"></i>
                                <span class="hide-menu">Matériel</span>
                            </a>
                        </li>

                        
                        <li class="sidebar-item selected">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fa fa-car" aria-hidden="true"></i>
                                <span class="hide-menu">Véhicule</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item active">
                                    <a href="vehicule.php" class="sidebar-link">
                                        <i class="mdi mdi-account-box"></i>
                                        <span class="hide-menu">Liste des véhicules</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="vehicule-Vendue.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Véhicule Vendu</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="vehicule-HS.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu"> Véhicule hors service</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="gestion_pack.php"
                                aria-expanded="false">
                                <i class="fa fa-cube" aria-hidden="true"></i>
                                <span class="hide-menu">Pack</span>
                            </a>
                        </li>
                        <li class="sidebar-item selected">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fas fa-calendar"></i>
                                <span class="hide-menu">Contrat </span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item active">
                                    <a href="contart-voiture.php" class="sidebar-link">
                                        <i class="mdi mdi-account-box"></i>
                                        <span class="hide-menu"> Contrat Véhicule </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="contart-materiel.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Contrat Matériel</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="contart-pack.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Contrat Pack</span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="archivage-contart-voiture.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Archivage Contrat Voiture</span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="archivage-contart-materiel.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Archivage Contrat Materiel</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="archivage-contart-pack.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Archivage Contrat Pack</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="historique-contart.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Historique Contrat</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="planning.php"
                                aria-expanded="false">
                                <i class="fas fa-tasks" aria-hidden="true"></i>
                                <span class="hide-menu">Planning</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="devis.php"
                                aria-expanded="false">
                                <i class="fas fa-calculator" aria-hidden="true"></i>
                                <span class="hide-menu">Devis</span>
                            </a>
                        </li>

                        <li class="sidebar-item selected">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fas fa-list-alt"></i>
                                <span class="hide-menu">Facture</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item active">
                                    <a href="facture-contart-voiture.php" class="sidebar-link">
                                        <i class="mdi mdi-account-box"></i>
                                        <span class="hide-menu">Facture Contrat Véhicule </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="facture-contart-materiel.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Facture Contrat Matériel</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="facture-contart-pack.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Facture Contrat Pack</span>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="sidebar-item selected">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fas fa-cubes"></i>
                                <span class="hide-menu">Stock</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item active">
                                    <a href="stock.php" class="sidebar-link">
                                        <i class="mdi mdi-account-box"></i>
                                        <span class="hide-menu"> Stock Véhicule </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="stock_matreiel.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu"> Stock Matériel</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    <?php
                    }
                    ?>
                        <li class="sidebar-item selected">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fas fa-wrench"></i>
                                <span class="hide-menu">Entretien</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">

                                <li class="sidebar-item">
                                    <a href="Controletechnique.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Contrôle Périodique</span>
                                    </a>
                                </li>

                                <li class="sidebar-item active">
                                    <a href="historique-controle.php" class="sidebar-link">
                                        <i class="mdi mdi-account-box"></i>
                                        <span class="hide-menu">Historique Contrôle Périodique</span>
                                    </a>
                                </li>

                                <li class="sidebar-item active">
                                    <a href="entretien.php" class="sidebar-link">
                                        <i class="mdi mdi-account-box"></i>
                                        <span class="hide-menu">Entretiens</span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="entretien-voiture.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Archivage Entretien Vehicule</span>
                                    </a>
                                </li>
                                
                                <li class="sidebar-item">
                                    <a href="entretien-materiel.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Archivage Entretien Matériel</span>
                                    </a>
                                </li>
                                
                                <li class="sidebar-item active">
                                    <a href="historique-entretien.php" class="sidebar-link">
                                        <i class="mdi mdi-account-box"></i>
                                        <span class="hide-menu">Historique Entretiens</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <?php
                            if ($_SESSION['Role'] != "mecanicien") {
                        ?>
                        <li class="sidebar-item selected">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fas fa-arrow-right"></i>
                                <span class="hide-menu">Affectation Véhicule</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="k2voiture.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Véhicule </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="chauffeur.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu">Chauffeur </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="affectation_vehicule.php" class="sidebar-link">
                                        <i class="mdi mdi-account-network"></i>
                                        <span class="hide-menu"> Affectation</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                            }
                        ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation  entretien -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="modal fade" id="validatePaiementContrat" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Valider le paiement Contrat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form style="display: none;">
                            <input type="text" id='validate-contrat-id'>
                        </form>
                        <p>voulez-vous valider le paiement de contrat ?</p>
                        <button class="btn btn-success" id="btn_validatePaiement">Valider</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                    </div>
                </div>
            </div>
        </div>