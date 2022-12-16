<?php

use PhpMyAdmin\Console;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once('connect_db.php');

// helpers
function is_image($file)
{
    $ALLOWED_EXTENSIONS = ["jpg", "jpeg", "png", "pdf"];
    return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $ALLOWED_EXTENSIONS);
}
//compress image 
function compressImage($source, $destination, $quality)
{
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    }

    imagejpeg($image, $destination, $quality);
}
//insert Clients Records function

function InsertClient()
{
    global $conn;
    $errors = [];
    if (!empty($errors)) {
        echo json_encode(["error" => "Requête invalide", "data" => $errors]);
        return;
    }
    $nom_entreprise = $_POST['nom_entreprise'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $adresse = $_POST['adresse'];
    $raisonsocial = $_POST['raison_social'];
    $num_permis = $_POST['num_permis'];
    $num_siret = $_POST['siret'];
    $code_naf = $_POST['naf'];
    $code_tva = $_POST['codetva'];
    $date_creation_entreprise = $_POST['date_creation_entreprise'];
    $comment = $_POST['comment'];
    $type = $_POST['type'];
    $cin = isset($_FILES['cin']) ? $_FILES['cin'] : "";
    $permis = isset($_FILES['permis']) ? $_FILES['permis'] : "";
    $kbis = isset($_FILES['kbis']) ? $_FILES['kbis'] : "";
    $rib = isset($_FILES['rib']) ? $_FILES['rib'] : "";
    $attestation_civile = isset($_FILES['attestation_civile']) ? $_FILES['attestation_civile'] : "";
    $unique_id = hash("sha256", strval(rand(1000, 9999999)) + strval(time()));

    if ($type == 'CLIENT PRO') {
        if (!is_image($kbis["name"])) {
            array_push($errors, ["error" => "Type d'image non pris en charge pour kbis", "data" => $kbis["name"]]);
        }
        if (!is_image($attestation_civile["name"])) {
            array_push($errors, ["error" => "Type d'image non pris en charge pour attestation civile", "data" => $attestation_civile["name"]]);
        }

        $kbis_filename = $unique_id . "_kbis." . strtolower(pathinfo($kbis["name"], PATHINFO_EXTENSION));
        $attestation_civile_filename = $unique_id . "_attestation_civile." . strtolower(pathinfo($attestation_civile["name"], PATHINFO_EXTENSION));

        // move_uploaded_file($kbis["tmp_name"], "./uploads/${kbis_filename}");
        $size = $kbis["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp');
        $location = "./uploads/${kbis_filename}";
        $file_extension = is_image($location);
        $source_image = $kbis["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($kbis["tmp_name"], "./uploads/${kbis_filename}");
            }
        }
        // move_uploaded_file($attestation_civile["tmp_name"], "./uploads/${attestation_civile_filename}");
        $size = $attestation_civile["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${attestation_civile_filename}";
        $file_extension = is_image($location);
        $source_image = $attestation_civile["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($attestation_civile["tmp_name"], "./uploads/${attestation_civile_filename}");
            }
        }
    } else {
        $kbis_filename = "";
        $attestation_civile_filename = "";
    }
    if (!is_image($cin["name"])) {
        array_push($errors, ["error" => "Type d'image non pris en charge pour CNI", "data" => $cin["name"]]);
    }
    if (!is_image($permis["name"])) {
        array_push($errors, ["error" => "Type d'image non pris en charge pour Permis", "data" => $permis["name"]]);
    }
    if (!is_image($rib["name"])) {
        array_push($errors, ["error" => "Type d'image non pris en charge pour RIB", "data" => $rib["name"]]);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, ["error" => "Email incorrect", "data" => $email]);
    }

    $cin_filename = $unique_id . "_cin." . strtolower(pathinfo($cin["name"], PATHINFO_EXTENSION));
    $permis_filename = $unique_id . "_permis." . strtolower(pathinfo($permis["name"], PATHINFO_EXTENSION));
    $rib_filename = $unique_id . "_rib." . strtolower(pathinfo($rib["name"], PATHINFO_EXTENSION));

    $size = $cin["size"] / 1024;
    $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
    $location = "./uploads/${cin_filename}";
    $file_extension = is_image($location);
    $source_image = $cin["tmp_name"];
    if (in_array($file_extension, $valid_ext)) {
        if ($size >= 2000) {
            compressImage($source_image, $location, 60);
        } else {
            move_uploaded_file($cin["tmp_name"], "./uploads/${cin_filename}");
        }
    }
    // move_uploaded_file($permis["tmp_name"], "./uploads/${permis_filename}");
    $size = $permis["size"] / 1024;
    $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
    $location = "./uploads/.${permis_filename}";
    $file_extension = is_image($location);
    $source_image = $permis["tmp_name"];
    if (in_array($file_extension, $valid_ext)) {
        if ($size >= 2000) {
            compressImage($source_image, $location, 60);
        } else {
            move_uploaded_file($permis["tmp_name"], "./uploads/${permis_filename}");
        }
    }
    // move_uploaded_file($rib["tmp_name"], "./uploads/${rib_filename}");
    $size = $rib["size"] / 1024;
    $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
    $location = "./uploads/${rib_filename}";
    $file_extension = is_image($location);
    $source_image = $rib["tmp_name"];
    if (in_array($file_extension, $valid_ext)) {
        if ($size >= 2000) {
            compressImage($source_image, $location, 60);
        } else {
            move_uploaded_file($rib["tmp_name"], "./uploads/${rib_filename}");
        }
    }

    $sql_e = "SELECT * FROM client WHERE email='$email' AND etat_client !='S'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... Email est déjà pris!</div>';
    } else {
        $date_jour = date("Y-m-d");
        $query = "INSERT INTO 
            client(nom_entreprise,nom,email,tel,adresse,cin ,raison_social,num_permis,siret,naf,codetva,date_creation_entreprise,permis,kbis,rib,attestation_civile,comment,type,date_update_doc) 
            VALUES ('$nom_entreprise','$nom','$email','$tel','$adresse' , '$cin_filename' ,'$raisonsocial','$num_permis','$num_siret','$code_naf','$code_tva','$date_creation_entreprise','$permis_filename','$kbis_filename','$rib_filename','$attestation_civile_filename','$comment','$type','$date_jour') ";

        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'>Un client est ajouté avec succès</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors de l'ajout du client</div>";
        }
    }
}

// dispaly client data function
function display_client_record()
{
    global $conn;
    $value = '<table class="table table-striped">
    <thead class="thead-light">
        <tr style="height:10px;">
            <th class="border-top-0">Nom de l\'entreprise</th>
            <th class="border-top-0">Nom Conducteur</th>
            <th class="border-top-0">E-mail</th>
            <th class="border-top-0" style="min-width:110px;">Téléphone</th>
            <th class="border-top-0">Adresse</th>
            <th class="border-top-0">Actions</th>   
        </tr>
    </thead>';
    $query = "SELECT * FROM client where etat_client ='A'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['nom_entreprise'] . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . wordwrap($row['tel'], 2, " ", 1) . '</td>
                <td class="border-top-0">' . $row['adresse'] . '</td>
                <style>
                .cin:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
              </style>';
        if (($_SESSION['Role']) != "superadmin") {
            if ($row['type'] == "CLIENT PRO") {
                $value .= '   <td class="border-top-0">';
                $ddate = $row['date_update_doc'];
                $cdate = date("Y-m-d");

                if (strtotime("+3 months", strtotime($ddate)) < strtotime($cdate)) {
                    $value .= '    <button type="button" title="Modifier les documents du client" class="btn waves-effect waves-light btn-outline-danger" style="width:55px; height:45px;" id="btn-edit-doc" data-id3=' . $row['id_client'] . '><i class="fas fa-clock"></i></button> ';
                }
                $value .= '    <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> ';
                $value .= '    <button type="button" title="Modifier le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-client" data-id=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
            } else {
                $value .= '   <td class="border-top-0">';
                $ddate = $row['date_update_doc'];
                $cdate = date("Y-m-d");
                if (strtotime("+3 months", strtotime($ddate)) < strtotime($cdate)) {
                    $value .= '    <button type="button" title="Modifier les documents du client" class="btn waves-effect waves-light btn-outline-danger" style="width:55px; height:45px;" id="btn-edit-doc" data-id3=' . $row['id_client'] . '><i class="fas fa-clock"></i></button> ';
                }
                $value .= '   <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client-part" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> ';
                $value .= '   <button type="button" title="Modifier le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-client-part" data-id2=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
            }
            $value .= '       <button type="button" title="Supprimer le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-client" data-id1=' . $row['id_client'] . '><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>';
        } else {
            if ($row['type'] == "CLIENT PRO") {
                $value .= '   <td class="border-top-0">';
                $value .= '  <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> 
                </td></tr>';
            } else {
                $value .= '   <td class="border-top-0">';
                $value .= '  <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client-part" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> 
                </td></tr>';
            }
        }
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function update_client_doc_value()
{
    global $conn;
    if (!array_key_exists("_id", $_POST)) {
        echo json_encode(["error" => "ID client manquant ", "data" => "ID client manquant"]);
        return;
    }
    $client_id = $_POST["_id"];
    $client_query = "SELECT * FROM  client where id_client = ${client_id}";
    $client_result = mysqli_query($conn, $client_query);
    $client = mysqli_fetch_assoc($client_result);
    if (!$client) {
        echo json_encode(["error" => "Client introuvable ", "data" => "Client $client_id not found."]);
        return;
    }
    $unique_id = hash("sha256", strval(rand(1000, 9999999)) + strval(time()));
    $client_updated_cin = $client["cin"];
    if (array_key_exists("cin", $_FILES)) {
        // update cin
        $client_cin_file = $_FILES["cin"];
        $client_cin_new = $unique_id . "_cin." . strtolower(pathinfo($client_cin_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_cin_file["tmp_name"], "./uploads/" . $client_cin_new);
        $size = $client_cin_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${client_cin_new}";
        $file_extension = is_image($location);
        $source_image = $client_cin_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_cin_file["tmp_name"], "./uploads/" . $client_cin_new);
            }
        }
        if ($client["cin"] && file_exists($client["cin"])) {
            unlink("./uploads/" . $client["cin"]);
        }
        $client_updated_cin = $client_cin_new;
    }
    $client_updated_kbis = $client["kbis"];
    if (array_key_exists("kbis", $_FILES)) {
        // update kbis
        $client_kbis_file = $_FILES["kbis"];
        $client_kbis_new = $unique_id . "_kbis." . strtolower(pathinfo($client_kbis_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_kbis_file["tmp_name"], "./uploads/" . $client_kbis_new);
        $size = $client_kbis_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp');
        $location = "./uploads/${client_kbis_new}";
        $file_extension = is_image($location);
        $source_image = $client_kbis_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_kbis_file["tmp_name"], "./uploads/${client_kbis_new}");
            }
        }
        if ($client["kbis"] && file_exists($client["kbis"])) {
            unlink("./uploads/" . $client["kbis"]);
        }
        $client_updated_kbis = $client_kbis_new;
    }
    $client_updated_permis = $client["permis"];
    if (array_key_exists("permis", $_FILES)) {
        // update permis
        $client_permis_file = $_FILES["permis"];
        $client_permis_new = $unique_id . "_permis." . strtolower(pathinfo($client_permis_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_permis_file["tmp_name"], "./uploads/" . $client_permis_new);
        $size = $client_permis_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${client_permis_new}";
        $file_extension = is_image($location);
        $source_image = $client_permis_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_permis_file["tmp_name"], "./uploads/${client_permis_new}");
            }
        }
        if ($client["permis"] && file_exists($client["permis"])) {
            unlink("./uploads/" . $client["permis"]);
        }
        $client_updated_permis = $client_permis_new;
    }
    $client_updated_rib = $client["rib"];
    if (array_key_exists("rib", $_FILES)) {
        // update cin
        $client_rib_file = $_FILES["rib"];
        $client_rib_new = $unique_id . "_rib." . strtolower(pathinfo($client_rib_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_rib_file["tmp_name"], "./uploads/" . $client_rib_new);
        $size = $client_rib_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${client_rib_new}";
        $file_extension = is_image($location);
        $source_image = $client_rib_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_rib_file["tmp_name"], "./uploads/${client_rib_new}");
            }
        }
        if ($client["rib"] && file_exists($client["rib"])) {
            unlink("./uploads/" . $client["rib"]);
        }
        $client_updated_rib = $client_rib_new;
    }
    $client_updated_attestation_civile = $client["attestation_civile"];
    if (array_key_exists("attestation_civile", $_FILES)) {
        // update cin
        $client_attestation_civile_file = $_FILES["attestation_civile"];
        $client_attestation_civile_new = $unique_id . "_attestation_civile." . strtolower(pathinfo($client_attestation_civile_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_attestation_civile_file["tmp_name"], "./uploads/" . $client_attestation_civile_new);
        $size = $client_attestation_civile_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${client_attestation_civile_new}";
        $file_extension = is_image($location);
        $source_image = $client_attestation_civile_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_attestation_civile_file["tmp_name"], "./uploads/${client_attestation_civile_new}");
            }
        }
        if ($client["attestation_civile"] && file_exists($client["attestation_civile"])) {
            unlink("./uploads/" . $client["attestation_civile"]);
        }
        $client_updated_attestation_civile = $client_attestation_civile_new;
    }

    $sysdate = date("Y-m-d");
    $update_query = "UPDATE client SET 
    cin='$client_updated_cin',
    kbis='$client_updated_kbis',
    permis='$client_updated_permis',
    rib='$client_updated_rib',
    date_update_doc='$sysdate',
    attestation_civile='$client_updated_attestation_civile'
    WHERE id_client = $client_id";
    $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour du client!</div>";
        return;
    } else {

        echo "<div class='text-success'>Client a été mis à jour avec succès! gggg</div>";
        return;
    }
}

function display_client_inactif_record()
{
    global $conn;
    $value = '<table class="table table-striped">
    <thead class="thead-light">
        <tr style="height:10px;">
            <th class="border-top-0">Nom de l\'entreprise</th>
            <th class="border-top-0">Nom Conducteur</th>
            <th class="border-top-0">E-mail</th>
            <th class="border-top-0" style="min-width:110px;">Téléphone</th>
            <th class="border-top-0">Adresse</th>
            <th class="border-top-0">Actions</th>   
        </tr>
    </thead>';
    $query = "SELECT * FROM client where etat_client ='I'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['nom_entreprise'] . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . wordwrap($row['tel'], 2, " ", 1) . '</td>
                <td class="border-top-0">' . $row['adresse'] . '</td>
                <style>
                .cin:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
              </style> ';
        if (($_SESSION['Role']) != "superadmin") {
            if ($row['type'] == "CLIENT PRO") {
                $value .= '   <td class="border-top-0">';
                $ddate = $row['date_update_doc'];
                $cdate = date("Y-m-d");
                if (strtotime("+3 months", strtotime($ddate)) < strtotime($cdate)) {
                    $value .= '    <button type="button" title="Modifier les documents du client" class="btn waves-effect waves-light btn-outline-danger" style="width:55px; height:45px;" id="btn-edit-doc" data-id3=' . $row['id_client'] . '><i class="fas fa-clock"></i></button> ';
                }
                $value .= '    <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> ';
                $value .= '   <button type="button" title="Modifier le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-client" data-id=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
            } else {
                $value .= '   <td class="border-top-0">';
                $ddate = $row['date_update_doc'];
                $cdate = date("Y-m-d");
                if (strtotime("+3 months", strtotime($ddate)) < strtotime($cdate)) {
                    $value .= '    <button type="button" title="Modifier les documents du client" class="btn waves-effect waves-light btn-outline-danger" style="width:55px; height:45px;" id="btn-edit-doc" data-id3=' . $row['id_client'] . '><i class="fas fa-clock"></i></button> ';
                }
                $value .= '   <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client-part" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> ';
                $value .= '   <button type="button" title="Modifier le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-client-part" data-id2=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
            }
            $value .= '       <button type="button" title="Supprimer le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-client" data-id1=' . $row['id_client'] . '><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>';
        } else {
            if ($row['type'] == "CLIENT PRO") {
                $value .= '   <td class="border-top-0">';
                $value .= '  <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> 
                    </td></tr>';
            } else {
                $value .= '   <td class="border-top-0">';
                $value .= '  <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client-part" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> 
                    </td></tr>';
            }
        }
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

//get pro client record
function get_client_record()
{
    global $conn;
    $ClientId = $_POST['ClientID'];
    $query = " SELECT * FROM client WHERE id_client='$ClientId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $client_data = [];
        $client_data[0] = $row['id_client'];
        $client_data[1] = $row['nom'];
        $client_data[2] = $row['email'];
        $client_data[3] = $row['tel'];
        $client_data[4] = $row['adresse'];
        $client_data[5] = $row['num_permis'];
        $client_data[6] = $row['cin'];
        $client_data[7] = $row['comment'];
        $client_data[8] = $row['permis'];
        $client_data[9] = $row['kbis'];
        $client_data[10] = $row['rib'];
        $client_data[11] = $row['raison_social'];
        $client_data[12] = $row['type'];
        $client_data[13] = $row['siret'];
        $client_data[14] = $row['naf'];
        $client_data[15] = $row['codetva'];
        $client_data[16] = $row['nom_entreprise'];
        $client_data[17] = $row['date_creation_entreprise'];
        $client_data[18] = $row['attestation_civile'];
    }
    echo json_encode($client_data);
}



function get_show_client_record()
{
    global $conn;
    $ClientId = $_POST['ClientID'];
    $query = " SELECT * FROM client WHERE id_client='$ClientId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $client_data = [];
        $client_data[0] = $row['id_client'];
        $client_data[1] = $row['nom'];
        $client_data[2] = $row['email'];
        $client_data[3] = $row['tel'];
        $client_data[4] = $row['adresse'];
        $client_data[5] = $row['num_permis'];
        $client_data[6] = $row['cin'];
        $client_data[7] = $row['comment'];
        $client_data[8] = $row['permis'];
        $client_data[9] = $row['kbis'];
        $client_data[10] = $row['rib'];
        $client_data[11] = $row['raison_social'];
        $client_data[12] = $row['type'];
        $client_data[13] = $row['siret'];
        $client_data[14] = $row['naf'];
        $client_data[15] = $row['codetva'];
        $client_data[16] = $row['nom_entreprise'];
        $client_data[17] = $row['date_creation_entreprise'];
        $client_data[18] = $row['attestation_civile'];
    }
    echo json_encode($client_data);
}

//get id client
function get_id_client()
{
    global $conn;
    $ClientId = $_POST['ClientID'];
    $query = " SELECT * FROM client WHERE id_client='$ClientId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $client_data = $row['id_client'];
    }
    echo json_encode($ClientId);
}

// update Client pro
function update_client_value()
{
    global $conn;
    if (!array_key_exists("_id", $_POST)) {
        echo json_encode(["error" => "ID client manquant ", "data" => "ID client manquant"]);
        return;
    }
    $client_id = $_POST["_id"];
    $client_query = "SELECT * FROM  client where id_client = ${client_id}";
    $client_result = mysqli_query($conn, $client_query);
    $client = mysqli_fetch_assoc($client_result);
    if (!$client) {
        echo json_encode(["error" => "Client introuvable ", "data" => "Client $client_id not found."]);
        return;
    }
    $unique_id = hash("sha256", strval(rand(1000, 9999999)) + strval(time()));
    $client_updated_cin = $client["cin"];
    if (array_key_exists("cin", $_FILES)) {
        // update cin
        $client_cin_file = $_FILES["cin"];
        $client_cin_new = $unique_id . "_cin." . strtolower(pathinfo($client_cin_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_cin_file["tmp_name"], "./uploads/" . $client_cin_new);
        $size = $client_cin_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${client_cin_new}";
        $file_extension = is_image($location);
        $source_image = $client_cin_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_cin_file["tmp_name"], "./uploads/" . $client_cin_new);
            }
        }
        if ($client["cin"] && file_exists($client["cin"])) {
            unlink("./uploads/" . $client["cin"]);
        }
        $client_updated_cin = $client_cin_new;
    }
    $client_updated_kbis = $client["kbis"];
    if (array_key_exists("kbis", $_FILES)) {
        // update kbis
        $client_kbis_file = $_FILES["kbis"];
        $client_kbis_new = $unique_id . "_kbis." . strtolower(pathinfo($client_kbis_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_kbis_file["tmp_name"], "./uploads/" . $client_kbis_new);
        $size = $client_kbis_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp');
        $location = "./uploads/${client_kbis_new}";
        $file_extension = is_image($location);
        $source_image = $client_kbis_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_kbis_file["tmp_name"], "./uploads/${client_kbis_new}");
            }
        }
        if ($client["kbis"] && file_exists($client["kbis"])) {
            unlink("./uploads/" . $client["kbis"]);
        }
        $client_updated_kbis = $client_kbis_new;
    }
    $client_updated_permis = $client["permis"];
    if (array_key_exists("permis", $_FILES)) {
        // update permis
        $client_permis_file = $_FILES["permis"];
        $client_permis_new = $unique_id . "_permis." . strtolower(pathinfo($client_permis_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_permis_file["tmp_name"], "./uploads/" . $client_permis_new);
        $size = $client_permis_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${client_permis_new}";
        $file_extension = is_image($location);
        $source_image = $client_permis_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_permis_file["tmp_name"], "./uploads/${client_permis_new}");
            }
        }
        if ($client["permis"] && file_exists($client["permis"])) {
            unlink("./uploads/" . $client["permis"]);
        }
        $client_updated_permis = $client_permis_new;
    }
    $client_updated_rib = $client["rib"];
    if (array_key_exists("rib", $_FILES)) {
        // update cin
        $client_rib_file = $_FILES["rib"];
        $client_rib_new = $unique_id . "_rib." . strtolower(pathinfo($client_rib_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_rib_file["tmp_name"], "./uploads/" . $client_rib_new);
        $size = $client_rib_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${client_rib_new}";
        $file_extension = is_image($location);
        $source_image = $client_rib_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_rib_file["tmp_name"], "./uploads/${client_rib_new}");
            }
        }
        if ($client["rib"] && file_exists($client["rib"])) {
            unlink("./uploads/" . $client["rib"]);
        }
        $client_updated_rib = $client_rib_new;
    }
    $client_updated_attestation_civile = $client["attestation_civile"];
    if (array_key_exists("attestation_civile", $_FILES)) {
        // update cin
        $client_attestation_civile_file = $_FILES["attestation_civile"];
        $client_attestation_civile_new = $unique_id . "_attestation_civile." . strtolower(pathinfo($client_attestation_civile_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_attestation_civile_file["tmp_name"], "./uploads/" . $client_attestation_civile_new);
        $size = $client_attestation_civile_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${client_attestation_civile_new}";
        $file_extension = is_image($location);
        $source_image = $client_attestation_civile_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_attestation_civile_file["tmp_name"], "./uploads/${client_attestation_civile_new}");
            }
        }
        if ($client["attestation_civile"] && file_exists($client["attestation_civile"])) {
            unlink("./uploads/" . $client["attestation_civile"]);
        }
        $client_updated_attestation_civile = $client_attestation_civile_new;
    }
    $client_updated_Nomentreprise = $_POST["nom_entreprise"];
    $client_updated_nom = $_POST["nom"];
    $client_updated_email = $_POST["email"];
    $client_updated_tel = $_POST["tel"];
    $client_updated_adresse = $_POST["adresse"];
    $client_updated_comment = $_POST["comment"];
    $client_updated_raison_social = $_POST["raison_social"];
    $client_updated_num_permis = $_POST["num_permis"];
    $client_updated_siret = $_POST["siret"];
    $client_updated_naf = $_POST["naf"];
    $client_updated_tva = $_POST["codetva"];
    $client_updated_DateEntreprise = $_POST["DateEntreprise"];
    $client_updated_type = $_POST["updateclientType"];

    $sql_e = "SELECT * FROM client WHERE id_client!='$client_id' AND email='$client_updated_email' AND etat_client!='S'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... Email est déjà pris!</div>';
        return;
    } else {
        $update_query = "UPDATE client SET 
    nom_entreprise='$client_updated_Nomentreprise',
    nom='$client_updated_nom',
    email='$client_updated_email',
    tel='$client_updated_tel',
    adresse='$client_updated_adresse',
    comment='$client_updated_comment',
    raison_social='$client_updated_raison_social',
    num_permis='$client_updated_num_permis',
    siret='$client_updated_siret',
    naf='$client_updated_naf',
    codetva='$client_updated_tva',
    date_creation_entreprise='$client_updated_DateEntreprise',
    cin='$client_updated_cin',
    kbis='$client_updated_kbis',
    permis='$client_updated_permis',
    rib='$client_updated_rib',
    attestation_civile='$client_updated_attestation_civile'
    WHERE id_client = $client_id";

        $update_result = mysqli_query($conn, $update_query);
        if (!$update_result) {
            echo "<div class='text-danger'>Erreur lors de la mise à jour du client!</div>";
            return;
        }
        echo "<div class='text-success'>Client a été mis à jour avec succès!</div>";

        return;
    }
}
// update Client
function update_client_part_value()
{
    global $conn;
    if (!array_key_exists("_id", $_POST)) {
        echo json_encode(["error" => "ID client manquant ", "data" => "ID client manquant"]);
        return;
    }
    $client_id = $_POST["_id"];
    $client_query = "SELECT * FROM  client where id_client = ${client_id}";
    $client_result = mysqli_query($conn, $client_query);
    $client = mysqli_fetch_assoc($client_result);
    if (!$client) {
        echo json_encode(["error" => "Client introuvable ", "data" => "Client $client_id not found."]);
        return;
    }
    $unique_id = hash("sha256", strval(rand(1000, 9999999)) + strval(time()));
    $client_updated_cin = $client["cin"];
    if (array_key_exists("cin", $_FILES)) {
        // update cin
        $client_cin_file = $_FILES["cin"];
        $client_cin_new = $unique_id . "_cin." . strtolower(pathinfo($client_cin_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_cin_file["tmp_name"], "./uploads/" . $client_cin_new);
        $size = $client_cin_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${client_cin_new}";
        $file_extension = is_image($location);
        $source_image = $client_cin_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_cin_file["tmp_name"], "./uploads/" . $client_cin_new);
            }
        }
        if ($client["cin"] && file_exists($client["cin"])) {
            unlink("./uploads/" . $client["cin"]);
        }
        $client_updated_cin = $client_cin_new;
    }
    $client_updated_permis = $client["permis"];
    if (array_key_exists("permis", $_FILES)) {
        // update permis
        $client_permis_file = $_FILES["permis"];
        $client_permis_new = $unique_id . "_permis." . strtolower(pathinfo($client_permis_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_permis_file["tmp_name"], "./uploads/" . $client_permis_new);
        $size = $client_permis_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/.${client_permis_new}";
        $file_extension = is_image($location);
        $source_image = $client_permis_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_permis_file["tmp_name"], "./uploads/${client_permis_new}");
            }
        }
        if ($client["permis"] && file_exists($client["permis"])) {
            unlink("./uploads/" . $client["permis"]);
        }
        $client_updated_permis = $client_permis_new;
    }
    $client_updated_rib = $client["rib"];
    if (array_key_exists("rib", $_FILES)) {
        // update rib
        $client_rib_file = $_FILES["rib"];
        $client_rib_new = $unique_id . "_rib." . strtolower(pathinfo($client_rib_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($client_rib_file["tmp_name"], "./uploads/" . $client_rib_new);
        $size = $client_rib_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif');
        $location = "./uploads/${client_rib_new}";
        $file_extension = is_image($location);
        $source_image = $client_rib_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($client_rib_file["tmp_name"], "./uploads/${client_rib_new}");
            }
        }
        if ($client["rib"] && file_exists($client["rib"])) {
            unlink("./uploads/" . $client["rib"]);
        }
        $client_updated_rib = $client_rib_new;
    }


    $client_updated_nom = $_POST["nom"];
    $client_updated_email = $_POST["email"];
    $client_updated_tel = $_POST["tel"];
    $client_updated_adresse = $_POST["adresse"];
    $client_updated_num_permis = $_POST["num_permis"];
    $client_updated_comment = $_POST["comment"];
    $client_updated_type = $_POST["updateclientType"];

    $sql_e = "SELECT * FROM client WHERE id_client!='$client_id' AND email='$client_updated_email' AND etat_client !='S' ";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... Email est déjà pris!</div>';
        return;
    } else {
        $update_query = "UPDATE client SET 
    nom='$client_updated_nom',
    email='$client_updated_email',
    tel='$client_updated_tel',
    adresse='$client_updated_adresse',
    num_permis='$client_updated_num_permis',
    comment='$client_updated_comment',
    type='$client_updated_type',
    cin='$client_updated_cin',
    rib='$client_updated_rib',
    permis='$client_updated_permis'
    WHERE id_client = $client_id";
        $update_result = mysqli_query($conn, $update_query);
        if (!$update_result) {
            echo "<div class='text-danger'>Erreur lors de la mise à jour du client!</div>";
            return;
        }
        echo "<div class='text-success'>Client a été mis à jour avec succès!</div>";
        return;
    }
}


function delete_client_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_ClientID'];

    $query = "UPDATE client SET 
    etat_client='S'
    WHERE id_client = $Del_ID";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Le client est supprimé avec succès';
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

function insert_materiel()
{
    global $conn;
    $ComposantListe = $_POST['ComposantListe'];
    $NumSerieListe = $_POST['NumSerieListe'];
    $count = count($ComposantListe);
    $countNumSerie = count($NumSerieListe);
    $verif = "T";
    $id_materiels = $_POST['id_materiels'];
    $materielnumserie = $_POST['materielnumserie'];
    $quitite = $_POST['quitite'];
    $id_user = $_SESSION['id_user'];
    $materielagence = isset($_POST['materielagence']) ? $_POST['materielagence'] :  "";

    if ($materielagence == "") {
        $id_agence = $_SESSION['id_agence'];;
    } else {
        $id_agence = $materielagence;
    }
    for ($c = 0; $c < $count; $c++) {
        if ($ComposantListe[$c] != null && $NumSerieListe[$c] == null) {
            $verif = "F";
        } else if ($ComposantListe[$c] == null && $NumSerieListe[$c] != null) {
            $verif = "F";
        }
    }
    if ($id_agence != "0") {
        // insert materiel avec quitite
        if ($materielnumserie == "vide") {
            $sql_e = "SELECT * FROM materiels_agence WHERE id_materiels='$id_materiels'  and etat_materiels='F' ";
            $res_e = mysqli_query($conn, $sql_e);
            if (mysqli_num_rows($res_e) > 0) {
                $query = " update materiels_agence set quantite_materiels = '$quitite' , quantite_materiels_dispo ='$quitite' ,etat_materiels='T'
               where id_materiels =$id_materiels  ";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    echo "<div class='text-success'>Le matériel est ajouté avec succés</div>";
                } else {
                    echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
                }
            } else {
                $materielnumserie = "";
                $sql_e = "SELECT id_materiels_agence FROM materiels_agence WHERE id_materiels='$id_materiels' AND id_agence = $id_agence";
                $res_e = mysqli_query($conn, $sql_e);
                if (mysqli_num_rows($res_e) == 0) {
                    $query = "INSERT INTO
                        materiels_agence(id_materiels,num_serie_materiels,quantite_materiels,quantite_materiels_dispo,id_agence,id_user)
                        VALUE('$id_materiels','$materielnumserie','$quitite','$quitite','$id_agence','$id_user')";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        echo "<div class='text-success'>Le Matériel ajouté avec succés</div>";
                    } else {
                        echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
                    }
                } else {
                    $row = mysqli_fetch_row($res_e);
                    $id_materiels_agence = $row[0];

                    $query = " update materiels_agence set quantite_materiels = quantite_materiels +$quitite, quantite_materiels_dispo =quantite_materiels_dispo +$quitite
                   where id_materiels_agence =$id_materiels_agence ";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        echo "<div class='text-success'>Le matériel est ajouté avec succés</div>";
                    } else {
                        echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
                    }
                }
            }
        }
        // insert materiel avec lists des materiels 
        else if ($verif == "T") {
            // validate unique Num Serie"

            $sql_e = "SELECT * FROM materiels_agence WHERE num_serie_materiels='$materielnumserie' 
            AND etat_materiels='T' ";
            $res_e = mysqli_query($conn, $sql_e);
            if (mysqli_num_rows($res_e) > 0) {
                echo '<div class="text-danger">
                Désolé ... Num Serie est déjà existant!</div>';
            } else {
                $query = "INSERT INTO
                    materiels_agence(id_materiels,num_serie_materiels,quantite_materiels,quantite_materiels_dispo,id_agence,id_user)
                    VALUE('$id_materiels','$materielnumserie','$quitite','$quitite','$id_agence','$id_user')";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    $query_get_max_id_materiel = "SELECT max(id_materiels_agence) FROM materiels_agence where id_user='$id_user' ";
                    $result_query_get_max_materie = mysqli_query($conn, $query_get_max_id_materiel);
                    $row = mysqli_fetch_row($result_query_get_max_materie);
                    $id_materiels = $row[0];

                    for ($i = 0; $i < $count; $i++) {
                        if ($ComposantListe[$i] != "") {
                            $query_insert_materiel_list = "INSERT INTO composant_materiels(id_materiels_agence,designation_composant,num_serie_composant)
                             VALUES ('$id_materiels','$ComposantListe[$i]','$NumSerieListe[$i]') ";
                            $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
                        }
                    }
                    echo "<div class='text-success'>Le matériel est ajouté avec succès </div>";
                } else {
                    echo "<div class='text-danger'>Le matériel est ajouté avec succès </div>";
                }
            }
        } else {
            echo "<div class='text-danger'>Veuillez remplir tous les champs obligatoires !</div>";
        }
    } else {
        echo "<div class='text-danger'>SVP! Choisissez l'agence</div>";
    }
}

function InsertComposantMateriel()
{
    global $conn;
    $ComposantListe = $_POST['ComposantListe'];
    $NumSerieListe = $_POST['NumSerieListe'];
    $count = count($ComposantListe);
    $countNumSerie = count($NumSerieListe);
    $id_materiels = $_POST['id_materiels'];
    $id_user = $_SESSION['id_user'];

    for ($i = 0; $i < $count; $i++) {
        if ($ComposantListe[$i] != "") {
            $sql_e = "SELECT * FROM composant_materiels WHERE num_serie_composant='$NumSerieListe[$i]' ";
            $res_e = mysqli_query($conn, $sql_e);
            if (mysqli_num_rows($res_e) > 0) {
                echo '<div class="text-danger" role="alert">
                Désolé ... Num Série Composant est déjà pris!</div>';
                return;
            } else {
                $query_insert_materiel_list = "INSERT INTO composant_materiels(id_materiels_agence,designation_composant,num_serie_composant)
                VALUES ('$id_materiels','$ComposantListe[$i]','$NumSerieListe[$i]') ";
                $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);

                if ($result_query_insert_materiel_list) {
                    echo "<div class='text-success'>Le composant est ajouté avec succès </div> ";
                } else {
                    echo " <div class='text-danger'>Veuillez vérifier votre requête</div> ";
                }
            }
        }
    }
}


function view_materiel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($id_agence != "0") {
        $value = '<div class="table-responsive">
        <table class="table">
        <thead >
            <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0"> Code de matériel</th>
                <th class="border-top-0">N° de série</th>
                <th class="border-top-0">Désignation</th>
                <th class="border-top-0">Type de location</th>
                <th class="border-top-0">Quantité</th>
                <th class="border-top-0">Quantité dispo</th>
                <th class="border-top-0">Composant</th>
                <th class="border-top-0">État</th>
                
            </tr>
            </thead>';
            $query = "SELECT * FROM materiels,materiels_agence
            where materiels.id_materiels = materiels_agence.id_materiels
            AND id_agence ='$id_agence' 
            AND materiels_agence.etat_materiels != 'F'
            ORDER BY id_materiels_agence ASC";
        }else if (($_SESSION['Role']) != "superadmin") {
            $value = '<div class="table-responsive">
        <table class="table">
        <thead >
            <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0"> Code de matériel</th>
                <th class="border-top-0">N° de série</th>
                <th class="border-top-0">Désignation</th>
                <th class="border-top-0">Agence</th>
                <th class="border-top-0">Type de location</th>
                <th class="border-top-0">Quantité</th>
                <th class="border-top-0">Quantité dispo</th>
                <th class="border-top-0">Composant</th>
                <th class="border-top-0">État</th>
                <th class="border-top-0">Actions</th>
            </tr>
            </thead>';
            $query = "SELECT * FROM materiels,materiels_agence,agence  
            where materiels.id_materiels = materiels_agence.id_materiels 
            AND  materiels_agence.id_agence = agence.id_agence
            AND materiels_agence.etat_materiels != 'F'
            ORDER BY id_materiels_agence ASC";
        }else {
            $value = '<div class="table-responsive">
        <table class="table">
        <thead >
            <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0"> Code de matériel</th>
                <th class="border-top-0">N° de série</th>
                <th class="border-top-0">Désignation</th>
                <th class="border-top-0">Agence</th>
                <th class="border-top-0">Type de location</th>
                <th class="border-top-0">Quantité</th>
                <th class="border-top-0">Quantité dispo</th>
                <th class="border-top-0">Composant</th>
                <th class="border-top-0">État</th>
            </tr>
            </thead>';
            $query = "SELECT * FROM materiels,materiels_agence,agence  
            where materiels.id_materiels = materiels_agence.id_materiels 
            AND  materiels_agence.id_agence = agence.id_agence
            AND materiels_agence.etat_materiels != 'F'
            ORDER BY id_materiels_agence ASC";
        }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $comp = $row['id_materiels_agence'];
        if ($row['etat_materiels'] == "T") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #2cd07e!important";
            $etat = "ACTIF ";
        } elseif ($row['etat_materiels'] == "HS") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ffc36d!important";
            $etat = "Hors Service";
        } elseif ($row['etat_materiels'] == "E") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ebe75c!important";
            $etat = "Entretien";
        }

        if ($id_agence != "0") {
            $value .= '
            <tbody>
            <tr ' . $color . ' >
                <td class="border-top-0">' . $row['id_materiels_agence'] . '</td>
                <td class="border-top-0">' . $row['code_materiel'] . '</td>
                <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                <td class="border-top-0">' . $row['designation'] . '</td>
                <td class="border-top-0">' . $row['type_location'] . '</td>
                <td class="border-top-0">' . $row['quantite_materiels'] . '</td>
                <td class="border-top-0">' . $row['quantite_materiels_dispo'] . '</td>';
        } else {
            $value .= '
            <tbody>
            <tr ' . $color . ' >
                <td class="border-top-0">' . $row['id_materiels_agence'] . '</td>
                <td class="border-top-0">' . $row['code_materiel'] . '</td>
                <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                <td class="border-top-0">' . $row['designation'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['type_location'] . '</td>
                <td class="border-top-0">' . $row['quantite_materiels'] . '</td>
                <td class="border-top-0">' . $row['quantite_materiels_dispo'] . '</td>';
        }
        $value .= '<td class="border-top-0">';

        $querycomp = "SELECT * FROM materiels_agence,composant_materiels where materiels_agence.id_materiels_agence = composant_materiels.id_materiels_agence 
                AND materiels_agence.id_materiels_agence = '$comp'";
        $resultcom = mysqli_query($conn, $querycomp);
        while ($row1 = mysqli_fetch_assoc($resultcom)) {
            if (($_SESSION['Role']) == "responsable") {
            $value .= ' <span class=" text-primary">
                <button  type="button" title="Supprimer le composant" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-composant" data-id=' . $row1['id_composant_materiels'] . '>X</button> '
                    . $row1['num_serie_composant'] . ' - ' . $row1['designation_composant'] .
                    '</span> <br> ';
            } else {
                $value .= ' <span class=" text-primary">' . $row1['num_serie_composant'] . ' - ' . $row1['designation_composant'] .
                    '</span> <br> ';
            }
        }
        $value .=   '</td>';

        $value .= ' <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                <td class="border-top-0">';
        if (($_SESSION['Role']) == "responsable") {
            if ($row['num_serie_obg'] == "T") {
                $value .= '
                <button  type="button" title="Modifier le matériel" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-materiel" data-id=' . $row['id_materiels_agence'] . '><i class="fas fa-edit"></i></button>
                <button  type="button" title="Ajouter un composant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-add-composant" data-id=' . $row['id_materiels_agence'] . '><i class="fas fa-plus"></i></button> ';
            } else {
                $value .= '  <button  type="button" title="Modifier le matériel" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-materiel-stock" data-id=' . $row['id_materiels_agence'] . '><i class="fas fa-edit"></i></button> ';
            }
            $value .=    ' 
                   
                    <button  type="button" title="Supprimer le matériel" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-materiel" data-id1=' . $row['id_materiels_agence'] . '><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>';
        }
    }

    $value .= ' </tbody>
    </table>
</div>';
    //header('Content-type:application/json;charset=utf-8');
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function get_materiel_record()
{
    global $conn;
    $MaterielID = $_POST['MaterielID'];
    $query = " SELECT * FROM materiel WHERE id_materiel='$MaterielID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $Materiel_data = [];
        $Materiel_data[0] = $row['id_materiel'];
        $Materiel_data[1] = $row['nom_materiel'];
        $Materiel_data[2] = $row['categorie'];
        $Materiel_data[3] = $row['fournisseur'];
        $Materiel_data[4] = $row['date_achat'];
        $Materiel_data[5] = $row['num_serie'];
        $Materiel_data[6] = $row['designation'];
        $Materiel_data[7] = $row['dispo'];
    }
    echo json_encode($Materiel_data);
}

function get_materiel_agence_record()
{
    global $conn;
    $MaterielID = $_POST['MaterielID'];

    $query = " SELECT * FROM  materiels,materiels_agence
    WHERE materiels.id_materiels=materiels_agence.id_materiels 
    AND materiels_agence.id_materiels_agence='$MaterielID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $Materiel_data = [];
        $Materiel_data[0] = $row['id_materiels_agence'];
        $Materiel_data[1] = $row['num_serie_materiels'];
        $Materiel_data[2] = $row['etat_materiels'];
        $Materiel_data[3] = $row['id_agence'];
        $Materiel_data[4] = $row['quantite_materiels'];
    }
    echo json_encode($Materiel_data);
}
function update_materiels()
{
    global $conn;
    $updateMaterielId = $_POST['updateMaterielId'];
    $updateMaterielNumSerie = $_POST['updateMaterielNumSerie'];
    $up_materielEtat = $_POST['up_materielEtat'];
    $up_materielagence = isset($_POST['up_materielagence']) ? $_POST['up_materielagence'] :  "";
    $id_user = $_SESSION['id_user'];

    if ($up_materielagence == "") {
        $id_agence = $_SESSION['id_agence'];;
    } else {
        $id_agence = $up_materielagence;
    }
    $sql_e = "SELECT * FROM materiels_agence WHERE id_materiels_agence!='$updateMaterielId' AND num_serie_materiels='$updateMaterielNumSerie' AND etat_materiels !='F'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... Num Série est déjà pris!</div>';
        return;
    } else {
        $query = "UPDATE materiels_agence AS MA
        SET MA.id_agence='$id_agence',MA.id_user='$id_user',MA.num_serie_materiels='$updateMaterielNumSerie',MA.etat_materiels='$up_materielEtat',
        where MA.id_materiels_agence='$updateMaterielId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'> Modification a été mis à jour </div> ";
        } else {
            echo " <div class='text-danger'>Veuillez vérifier votre requête</div> ";
        }
    }
}

function delete_materiel_record()
{
    global $conn;
    $Del_Id = $_POST['Del_ID'];
    $query = "UPDATE  materiels_agence SET etat_materiels ='F'  where id_materiels_agence='$Del_Id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<div class='text-success'> Le materiel est supprimé avec succès</div> ";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête </div>";
    }
}

function delete_composant_materiel_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_COMPOSANTID'];
    $query = "DELETE from composant_materiels where id_composant_materiels='$Del_ID' ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Le composant est supprimé avec succès";
    } else {
        echo 'SVP vérifier votre requette !';
    }
}
// Afficher vehicules

// display_voiture__record
function display_voiture_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($id_agence != "0") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        <th class="border-top-0">Actions</th>      
        </tr>';
        $query = "SELECT * 
            FROM voiture as V LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
            WHERE V.etat_voiture = 'Disponible' 
            AND actions='T'
            AND V.id_agence='$id_agence'
            ORDER BY id_voiture ASC";
    } else if (($_SESSION['Role']) != "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        <th class="border-top-0">Actions</th>      
        </tr>';
        $query = "SELECT * 
            FROM voiture as V
            LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
            LEFT JOIN agence AS A on V.id_agence=A.id_agence 
            WHERE V.etat_voiture = 'Disponible' 
            AND actions='T'
            ORDER BY id_voiture ASC";
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>   
        </tr>';
        $query = "SELECT * 
            FROM voiture as V
            LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
            LEFT JOIN agence AS A on V.id_agence=A.id_agence 
            WHERE V.etat_voiture = 'Disponible' 
            AND actions='T'
            ORDER BY id_voiture ASC";
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($id_agence != "0") {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_voiture'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
                <td class="border-top-0">' . $row['type_carburant'] . '</td>
                <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
        } else {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_voiture'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
                <td class="border-top-0">' . $row['type_carburant'] . '</td>
                <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
        }
        $value .= '
                <style>
                .carte_grise:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
                </style>       
                <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_grise"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>
                <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_verte"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>';

        if (($_SESSION['Role']) != "superadmin") {
            $value .= '<td class="border-top-0">
                    <button type="button" title="Modifier la voiture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-voiture" data-id=' . $row['id_voiture'] . '><i class="fas fa-edit"></i></button>
                    <button type="button" title="Supprimer la voiture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-voiture" data-id1=' . $row['id_voiture'] . '><i class="fas fa-trash-alt"></i></button>
                    </td>';
        }
        $value .= '</tr>';
    }

    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function display_voiture_vendue_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($id_agence != "0") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        <th class="border-top-0">Action</th>  
        </tr>';
        $query = "SELECT * 
        FROM voiture AS V
        LEFT JOIN histrique_voiture AS HV on V.id_voiture=HV.id_voiture_HV
        LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE HV.action = 'Vendue' 
        AND V.id_agence='$id_agence'
        ORDER BY id_histrique_voiture ASC";
    } else if (($_SESSION['Role']) != "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        <th class="border-top-0">Action</th>  
        </tr>';
        $query = "SELECT * 
        FROM voiture AS V
        LEFT JOIN histrique_voiture AS HV on V.id_voiture=HV.id_voiture_HV
        LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
        LEFT JOIN agence AS A on V.id_agence=A.id_agence 
        WHERE HV.action = 'Vendue'
        ORDER BY id_histrique_voiture ASC";
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        </tr>';
        $query = "SELECT * 
        FROM voiture AS V
        LEFT JOIN histrique_voiture AS HV on V.id_voiture=HV.id_voiture_HV
        LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
        LEFT JOIN agence AS A on V.id_agence=A.id_agence 
        WHERE HV.action = 'Vendue'
        ORDER BY id_histrique_voiture ASC";
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($id_agence != "0") {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['date_HV'] . '</td>
                <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
                <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
                <td class="border-top-0">' . $row['type_carburant'] . '</td>
                <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
        } else {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['date_HV'] . '</td>
                <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
                <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
                <td class="border-top-0">' . $row['type_carburant'] . '</td>
                <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
        }

        $value .= '
                <style>
                .carte_grise:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
                </style>       
                <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_grise"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>
                <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_verte"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>';
        if (($_SESSION['Role']) != "superadmin") {
            $value .= '<td class="border-top-0">
                    <button type="button" title="Modifier la voiture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-voiture-vendue" data-id=' . $row['id_histrique_voiture'] . '><i class="fas fa-edit"></i></button> 
                    </td>';
        }
        $value .= '</tr>';
    }

    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_voiture_hs_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($id_agence != "0") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date Hors Service</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        <th class="border-top-0">Action</th>  
        </tr>';
        $query = "SELECT * 
        FROM voiture AS V
        LEFT JOIN histrique_voiture AS HV on V.id_voiture=HV.id_voiture_HV
        LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE V.etat_voiture = 'HS'
        AND HV.action = 'HS'
        AND V.id_agence='$id_agence'
        ORDER BY id_histrique_voiture ASC";
    } else if (($_SESSION['Role']) != "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date Hors Service</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        <th class="border-top-0">Action</th>  
        </tr>';
        $query = "SELECT * 
        FROM voiture AS V
        LEFT JOIN histrique_voiture AS HV on V.id_voiture=HV.id_voiture_HV
        LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
        LEFT JOIN agence AS A on V.id_agence=A.id_agence 
        WHERE V.etat_voiture = 'HS'
        AND HV.action = 'HS'
        ORDER BY id_histrique_voiture ASC";
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date Hors Service</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th> 
        </tr>';
        $query = "SELECT * 
        FROM voiture AS V
        LEFT JOIN histrique_voiture AS HV on V.id_voiture=HV.id_voiture_HV
        LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
        LEFT JOIN agence AS A on V.id_agence=A.id_agence 
        WHERE V.etat_voiture = 'HS'
        AND HV.action = 'HS'
        ORDER BY id_histrique_voiture ASC";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($id_agence != "0") {
            $value .= '
            <tr>
            <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
            <td class="border-top-0">' . $row['type'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['date_HV'] . '</td>
            <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
            <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
            <td class="border-top-0">' . $row['type_carburant'] . '</td>
            <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
            <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
            <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
        } else {
            $value .= '
            <tr>
            <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
            <td class="border-top-0">' . $row['type'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['date_HV'] . '</td>
            <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
            <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['lieu_agence'] . '</td>
            <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
            <td class="border-top-0">' . $row['type_carburant'] . '</td>
            <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
            <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
            <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
        }
        $value .= '
        <style>
        .carte_grise:hover {   
            box-shadow: 0px 0px 150px #000000;
            z-index: 2;
            -webkit-transition: all 200ms ease-in;
            -webkit-transform: scale(5);
            -ms-transition: all 200ms ease-in;
            -ms-transform: scale(1.5);   
            -moz-transition: all 200ms ease-in;
            -moz-transform: scale(1.5);
            transition: all 200ms ease-in;
            transform: scale(1.5);}
        </style>       
        <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_grise"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>
        <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_verte"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>';
        if (($_SESSION['Role']) != "superadmin") {
            $value .= '<td class="border-top-0">
            <button type="button" title="Modifier la voiture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-voiture-HS" data-id=' . $row['id_histrique_voiture'] . '><i class="fas fa-edit"></i></button> 
            </td>';
        }
        $value .= '</tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

//Ajouter Voiture Records function
function InsertVoiture()
{
    global $conn;
    $type = $_POST['type'];
    $pimm = $_POST['pimm'];
    $boite_vitesse = $_POST['boite_vitesse'];
    $type_carburant = $_POST['type_carburant'];
    $marqueModele = $_POST['marqueModele'];
    $fournisseur = $_POST['fournisseur'];
    $km = $_POST['km'];
    $date_achat = $_POST['date_achat'];
    $dispo = $_POST['dispo'];
    $date_immatriculation = $_POST['date_immatriculation'];
    $date_DPC_VGP = $_POST['date_DPC_VGP'];
    $date_DPC_VT = $_POST['date_DPC_VT'];
    $date_DPT_Pollution = $_POST['date_DPT_Pollution'];
    $vgp = isset($_FILES['vgp']) ? $_FILES['vgp'] : "";
    $carte_grise = isset($_FILES['carte_grise']) ? $_FILES['carte_grise'] : "";
    $carte_verte = $_FILES['carte_verte'];
    $etat_voiture = $_POST['etat_voiture'];
    $id_user = $_SESSION['id_user'];
    $vehiculeagence = isset($_POST['vehiculeagence']) ? $_POST['vehiculeagence'] : "";

    if ($vehiculeagence == "") {
        $id_agence = $_SESSION['id_agence'];;
    } else {
        $id_agence = $vehiculeagence;
    }
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        return;
    }
    // validate unique pimm"
    $sql_e = "SELECT * FROM voiture WHERE pimm='$pimm' AND actions='T' ";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo "<div class='text-danger'>
            Désolé ... PIMM est déjà existant!</div>";
    } else {
        if ($type == "CAMION NACELLE" || $type == "FOURGON NACELLE") {
            if (!is_image($vgp["name"])) {
                array_push($errors, ["error" => "Type d'image non pris en charge pour VGP", "data" => $vgp["name"]]);
            }
        }
        if (!is_image($carte_grise["name"])) {
            array_push($errors, ["error" => "Type d'image non pris en charge pour carte grise", "data" => $carte_grise["name"]]);
        }
        if (!is_image($carte_verte["name"])) {
            array_push($errors, ["error" => "Type d'image non pris en charge pour carte verte", "data" => $carte_verte["name"]]);
        }
        $unique_id = time();
        if ($type == "CAMION NACELLE" || $type == "FOURGON NACELLE") {
            $vgp_file = $_FILES["vgp"];
            $vgp_filename = $unique_id . "_vgp." . strtolower(pathinfo($vgp["name"], PATHINFO_EXTENSION));
            $size = $vgp_file["size"] / 1024;
            $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp');
            $location = "./uploads/voiture/${vgp_filename}";
            $file_extension = is_image($location);
            $source_image = $vgp_file["tmp_name"];
            if (in_array($file_extension, $valid_ext)) {
                if ($size >= 2000) {
                    compressImage($source_image, $location, 60);
                } else {
                    move_uploaded_file($vgp_file["tmp_name"], "./uploads/voiture/${vgp_filename}");
                }
            }
        }
        $carte_grise_file = $_FILES["carte_grise"];
        $carte_grise_filename = $unique_id . "_cg." . strtolower(pathinfo($carte_grise["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($carte_grise["tmp_name"], "./uploads/voiture/${carte_grise_filename}");
        $size = $carte_grise_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp');
        $location = "./uploads/voiture/${carte_grise_filename}";
        $file_extension = is_image($location);
        $source_image = $carte_grise_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($carte_grise_file["tmp_name"], "./uploads/voiture/${carte_grise_filename}");
            }
        }
        $carte_verte_file = $_FILES["carte_verte"];
        $carte_verte_filename = $unique_id . "_cv." . strtolower(pathinfo($carte_verte["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($carte_verte["tmp_name"], "./uploads/voiture/${carte_verte_filename}");
        $size = $carte_verte_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp');
        $location = "./uploads/voiture/${carte_verte_filename}";
        $file_extension = is_image($location);
        $source_image = $carte_verte_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($carte_verte_file["tmp_name"], "./uploads/voiture/${carte_verte_filename}");
            }
        }
        if ($id_agence != "0") {
            if ($type == "CAMION NACELLE" || $type == "FOURGON NACELLE") {
                $query = "INSERT INTO 
                voiture(type,pimm,id_MarqueModel,fournisseur,km,date_achat,dispo,date_immatriculation,date_DPC_VGP,date_DPC_VT,date_DPT_Pollution,vgp,carte_grise,carte_verte,etat_voiture,boite_vitesse,type_carburant,id_user,id_agence) 
                VALUES ('$type','$pimm','$marqueModele','$fournisseur','$km','$date_achat','$dispo',' $date_immatriculation','$date_DPC_VGP','$date_DPC_VT','$date_DPT_Pollution','$vgp_filename','$carte_grise_filename','$carte_verte_filename','$etat_voiture','$boite_vitesse','$type_carburant',' $id_user','$id_agence')";
            } else {
                $query = "INSERT INTO 
                voiture(type,pimm,id_MarqueModel,fournisseur,km,date_achat,dispo,date_immatriculation,date_DPC_VGP,date_DPC_VT,date_DPT_Pollution,carte_grise,carte_verte,etat_voiture,boite_vitesse,type_carburant,id_user,id_agence) 
                VALUES ('$type','$pimm','$marqueModele','$fournisseur','$km','$date_achat','$dispo',' $date_immatriculation','$date_DPC_VGP','$date_DPC_VT','$date_DPT_Pollution','$carte_grise_filename','$carte_verte_filename','$etat_voiture','$boite_vitesse','$type_carburant',' $id_user','$id_agence')";
            }
            $result = mysqli_query($conn, $query);
            if ($result) {
                $queryVehiculeTid = "SELECT id_voiture FROM `voiture` WHERE `id_voiture`=(SELECT max(id_voiture) from voiture)";
                $resultVehiculeTid = mysqli_query($conn, $queryVehiculeTid);

                while ($row = mysqli_fetch_assoc($resultVehiculeTid)) {
                    $rowid = $row['id_voiture'];
                }
                $queryVehiculeT = "INSERT INTO  
                 histrique_voiture(id_voiture_HV,id_agence_em,id_agence_recv,action,id_user_HV) 
                 VALUES ('$rowid','$id_agence','$id_agence','Ajoute',' $id_user') ";
                $resultVehiculeT = mysqli_query($conn, $queryVehiculeT);

                $dateCAP = date('Y-m-d', strtotime($date_immatriculation. '+ 1459 days'));
                $dateCT = date('Y-m-d', strtotime($date_immatriculation. '+ 1459 days'));
                $dateCVGP = date('Y-m-d', strtotime($date_immatriculation. '+ 180 days'));
                if ($type == "CAMION NACELLE" || $type == "FOURGON NACELLE") {
                    $querycontrole = "INSERT INTO 
                    controletechnique(id_voiture,type_controletechnique,date_controletechnique) 
                    VALUES ('$rowid','1','$dateCT'),
                            ('$rowid','2','$dateCAP'),
                            ('$rowid','3','$dateCVGP')";
                } else {
                    $querycontrole = "INSERT INTO 
                    controletechnique(id_voiture,type_controletechnique,date_controletechnique) 
                    VALUES ('$rowid','1','$dateCT'),
                            ('$rowid','2','$dateCAP')";
                }
                
                $resultcontrole = mysqli_query($conn, $querycontrole);

                if ($resultcontrole) {
                    echo "<div class='text-success'>Le véhicule est Ajouté avec succés</div>";
                }
            } else {
                echo "<div class='text-danger'>Erreur lors d'ajout de voiture</div>";
            }
        } else {
            echo "<div class='text-danger'>SVP! Choisissez l'agence</div>";
        }
    }
    // add voiture
}

function InsertVoitureVendue()
{
    global $conn;
    $id_voiture = $_POST['voitureMarqueModel'];
    $Voituredate_vendue = $_POST['Voituredate_vendue'];
    $VoitureCommentaire = $_POST['VoitureCommentaire'];
    $vehiculevendueagence = isset($_POST['vehiculevendueagence']) ? $_POST['vehiculevendueagence'] :  "";
    $id_user = $_SESSION['id_user'];
    if ($vehiculevendueagence == "") {
        $id_agence = $_SESSION['id_agence'];;
    } else {
        $id_agence = $vehiculevendueagence;
    }
    if ($id_agence != "0") {
        $query = "INSERT INTO 
                histrique_voiture(id_voiture_HV,action,id_agence_em,id_agence_recv,id_user_HV,commentaire_HV,date_HV) 
                VALUES ('$id_voiture','Vendue','$id_agence','$id_agence','$id_user','$VoitureCommentaire','$Voituredate_vendue')";
        $result = mysqli_query($conn, $query);

        $update_query = "UPDATE voiture 
        SET etat_voiture='Vendue',id_agence='$id_agence'
        WHERE id_voiture = $id_voiture";
        $update_result = mysqli_query($conn, $update_query);

        if ($result) {
            echo "<div class='text-success'>La voiture est Ajoutée avec succés</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout de voiture</div>";
        }
    } else {
        echo "<div class='text-danger'>SVP! Choisissez l'agence</div>";
    }
}


function InsertVoitureHS()
{
    global $conn;
    $voitureIDHS = $_POST['voitureIDHS'];
    $Voituredate_HS = $_POST['Voituredate_HS'];
    $VoitureCommentaire = $_POST['VoitureCommentaire'];
    $vehiculehsagence = $_POST['vehiculehsagence'];
    $id_user = $_SESSION['id_user'];
    if ($vehiculehsagence == "") {
        $id_agence = $_SESSION['id_agence'];;
    } else {
        $id_agence = $vehiculehsagence;
    }
    if ($id_agence != "0") {
        $query = "INSERT INTO 
                histrique_voiture(id_voiture_HV,action,id_agence_em,id_agence_recv,id_user_HV,commentaire_HV,date_HV) 
                VALUES ('$voitureIDHS','HS','$id_agence','$id_agence','$id_user','$VoitureCommentaire','$Voituredate_HS')";
        $result = mysqli_query($conn, $query);

        $update_query = "UPDATE voiture 
        SET etat_voiture='HS'
         WHERE id_voiture = $voitureIDHS";
        $update_result = mysqli_query($conn, $update_query);

        if ($result) {
            echo "<div class='text-success'>La voiture est Ajoutée avec succés</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout de voiture</div>";
        }
    } else {
        echo "<div class='text-danger'>SVP! Choisissez l'agence</div>";
    }
}
//supprime   InsertVoitureVendue()
function delete_voiture_record()
{
    global $conn;
    $Del_ID = $_POST['id_voiture'];
    $query = "UPDATE voiture SET actions='S' WHERE id_voiture='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $querycontrole = "DELETE FROM controletechnique WHERE id_voiture='$Del_ID'";
        $resultcontrole = mysqli_query($conn, $querycontrole);
        echo "Le véhicule est supprimé avec succés";
    } else {
        echo "SVP vérifier votre requette !";
    }
}

//get particular voiture record
function get_voiture_record()
{
    global $conn;
    $idvoiture = $_POST['id_voiture'];
    $query = " SELECT *
    FROM voiture AS V LEFT JOIN marquemodel AS MM ON V.id_MarqueModel =MM.id_MarqueModel
     WHERE V.id_voiture='$idvoiture' AND V.id_MarqueModel = MM.id_MarqueModel  ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $voiture_data = [];
        $voiture_data[0] = $row['id_voiture'];
        $voiture_data[1] = $row['type'];
        $voiture_data[2] = $row['pimm'];
        $voiture_data[3] = $row['id_MarqueModel'];
        $voiture_data[4] = $row['fournisseur'];
        $voiture_data[5] = $row['km'];
        $voiture_data[6] = $row['date_achat'];
        $voiture_data[7] = $row['date_immatriculation'];
        $voiture_data[8] = $row['date_DPC_VGP'];
        $voiture_data[9] = $row['date_DPC_VT'];
        $voiture_data[10] = $row['date_DPT_Pollution'];
    }
    echo json_encode($voiture_data);
}


function get_voiture_vendue_record()
{
    global $conn;

    $idvoiture = $_POST['id_voitureH'];
    $query = " SELECT *
    FROM histrique_voiture 
     WHERE id_histrique_voiture='$idvoiture'  ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $voiture_datav = [];
        $voiture_datav[0] = $row['id_histrique_voiture'];
        $voiture_datav[1] = $row['date_HV'];
        $voiture_datav[2] = $row['commentaire_HV'];
    }
    echo json_encode($voiture_datav);
}


//get particular voiture record
function get_voiture_HS_record()
{
    global $conn;

    $id_voitureH = $_POST['id_voitureH'];

    $query = "SELECT * FROM voiture,histrique_voiture WHERE  voiture.id_voiture=histrique_voiture.id_voiture_HV
    AND histrique_voiture.id_histrique_voiture = $id_voitureH ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $voiture_data = [];
        $voiture_data[0] = $row['id_histrique_voiture'];
        $voiture_data[1] = $row['id_voiture_HV'];
        $voiture_data[2] = $row['date_HV'];
        $voiture_data[3] = $row['commentaire_HV'];
        $voiture_data[4] = $row['action'];
    }
    echo json_encode($voiture_data);
}


//modifier voiture
function update_voiture_value()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $id_agenceuser = $_SESSION['id_agence'];
    $idvoiture = $_POST['id_voiture'];
    $Update_Type = $_POST['type'];
    $Update_Pimm = $_POST['pimm'];
    $Update_ModeleMarque = $_POST['marquemodele'];
    $Update_Fournisseur = $_POST['fournisseur'];
    $Update_Km = $_POST['km'];
    $Update_Date_achat = $_POST['date_achat'];
    $Update_Dispo = 'OUI';
    $up_date_immatriculation = $_POST['up_date_immatriculation'];
    $up_date_DPC_VGP = $_POST['up_date_DPC_VGP'];
    $up_date_DPT_Pollution = $_POST['up_date_DPT_Pollution'];
    $up_etat_voiture = $_POST['up_etat_voiture'];
    $up_date_DPC_VT = $_POST['up_date_DPC_VT'];

    if (!array_key_exists("id_voiture", $_POST)) {
        echo json_encode(["error" => "ID voiture manquant ", "data" => "ID voiture manquant"]);
        return;
    }
    $voiture_id = $_POST["id_voiture"];
    $voiture_query = "SELECT * FROM  voiture where id_voiture = ${voiture_id}";
    $voiture_result = mysqli_query($conn, $voiture_query);
    $voiture = mysqli_fetch_assoc($voiture_result);
    if (!$voiture) {
        echo json_encode(["error" => "voiture introuvable ", "data" => "Voiture $voiture_id not found."]);
        return;
    }

    $unique_id = time();
    $voiture_updated_vgp = $voiture["vgp"];
    if (array_key_exists("vgp", $_FILES)) {
        // update vgp
        $voiture_vgp_file = $_FILES["vgp"];
        $voiture_vgp_new = $unique_id . "_vgp." . strtolower(pathinfo($voiture_vgp_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($voiture_cg_file["tmp_name"], "./uploads/voiture/" . $voiture_cg_new);
        $size = $voiture_vgp_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp');
        $location = "./uploads/voiture/${voiture_vgp_new}";
        $file_extension = is_image($location);
        $source_image = $voiture_vgp_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($voiture_vgp_file["tmp_name"], "./uploads/voiture/${voiture_vgp_new}");
            }
        }
        if ($voiture["vgp"] && file_exists($voiture["vgp"])) {
            unlink("./uploads/voiture/" . $voiture["vgp"]);
        }
        $voiture_updated_vgp = $voiture_vgp_new;
    }
    $voiture_updated_carte_grise = $voiture["carte_grise"];
    if (array_key_exists("carte_grise", $_FILES)) {
        // update carte_grise
        $voiture_cg_file = $_FILES["carte_grise"];
        $voiture_cg_new = $unique_id . "_cg." . strtolower(pathinfo($voiture_cg_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($voiture_cg_file["tmp_name"], "./uploads/voiture/" . $voiture_cg_new);
        $size = $voiture_cg_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp');
        $location = "./uploads/voiture/${voiture_cg_new}";
        $file_extension = is_image($location);
        $source_image = $voiture_cg_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($voiture_cg_file["tmp_name"], "./uploads/voiture/${voiture_cg_new}");
            }
        }
        if ($voiture["carte_grise"] && file_exists($voiture["carte_grise"])) {
            unlink("./uploads/voiture/" . $voiture["carte_grise"]);
        }
        $voiture_updated_carte_grise = $voiture_cg_new;
    }
    $voiture_updated_carte_verte = $voiture["carte_verte"];
    if (array_key_exists("carte_verte", $_FILES)) {
        // update carte_verte
        $voiture_cv_file = $_FILES["carte_verte"];
        $voiture_cv_new = $unique_id . "_cv." . strtolower(pathinfo($voiture_cv_file["name"], PATHINFO_EXTENSION));
        // move_uploaded_file($voiture_cv_file["tmp_name"], "./uploads/voiture/" . $voiture_cv_new);
        $size = $voiture_cv_file["size"] / 1024;
        $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp');
        $location = "./uploads/voiture/${voiture_cv_new}";
        $file_extension = is_image($location);
        $source_image = $voiture_cv_file["tmp_name"];
        if (in_array($file_extension, $valid_ext)) {
            if ($size >= 2000) {
                compressImage($source_image, $location, 60);
            } else {
                move_uploaded_file($voiture_cv_file["tmp_name"], "./uploads/voiture/${voiture_cv_new}");
            }
        }
        if ($voiture["carte_verte"] && file_exists($voiture["carte_verte"])) {
            unlink("./uploads/voiture/" . $voiture["carte_verte"]);
        }
        $voiture_updated_carte_verte = $voiture_cv_new;
    }

    $sql_e = "SELECT * FROM voiture 
    WHERE id_voiture!='$idvoiture' 
    AND pimm='$Update_Pimm'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... Immatricule est déjà pris!</div>';
        return;
    } else {
        $update_query = "UPDATE voiture SET 
            type='$Update_Type',
            pimm='$Update_Pimm',
            id_MarqueModel=$Update_ModeleMarque,
            fournisseur='$Update_Fournisseur',
            km='$Update_Km',
            date_achat='$Update_Date_achat',
            dispo='$Update_Dispo',
            date_immatriculation='$up_date_immatriculation',
            etat_voiture='$up_etat_voiture',
            date_DPC_VT='$up_date_DPC_VT',
            date_DPC_VGP='$up_date_DPC_VGP',
            date_DPT_Pollution='$up_date_DPT_Pollution',
            vgp='$voiture_updated_vgp',
            carte_grise='$voiture_updated_carte_grise',
            carte_verte='$voiture_updated_carte_verte'
            WHERE id_voiture = $idvoiture";
        $update_result = mysqli_query($conn, $update_query);
        if (!$update_result) {
            echo "<div class='text-danger'>Erreur lors de la mise à jour du voiture!<br>Impossible de mettre à jour la voiture</div>";
        } else {
            $dateCAP = date('Y-m-d', strtotime($up_date_immatriculation. '+ 1459 days'));
            $dateCT = date('Y-m-d', strtotime($up_date_immatriculation. '+ 1459 days'));
            $dateCVGP = date('Y-m-d', strtotime($up_date_immatriculation. '+ 180 days'));

            $updatedatecontrole = "UPDATE controletechnique SET 
            date_controletechnique='$dateCT'
            WHERE id_voiture = $idvoiture 
            AND type_controletechnique = '1'";
            $resultdatecontrole = mysqli_query($conn, $updatedatecontrole);
            $updatedatecontrole1 = "UPDATE controletechnique SET 
            date_controletechnique='$dateCAP'
            WHERE id_voiture = $idvoiture 
            AND type_controletechnique = '2'";
            $resultdatecontrole1 = mysqli_query($conn, $updatedatecontrole1);
            if ($Update_Type == "CAMION NACELLE" || $Update_Type == "FOURGON NACELLE") {
                $updatedatecontrole2 = "UPDATE controletechnique SET 
                date_controletechnique='$dateCVGP'
                WHERE id_voiture = $idvoiture 
                AND type_controletechnique = '3'";
                $resultdatecontrole2 = mysqli_query($conn, $updatedatecontrole2);
            }
            echo "<div class='text-success'>La voiture est modifiée avec succès </div>";
        }
    }
}
//modifier voiture
function update_voiture_vendue_value()
{
    global $conn;

    $id_voiture_vendue = $_POST['id_voiture_vendue'];

    $Up_Voituredate_vendue = $_POST['Up_Voituredate_vendue'];
    $Up_VoitureCommentaire = $_POST['Up_VoitureCommentaire'];

    $update_query = "UPDATE histrique_voiture 
    SET date_HV='$Up_Voituredate_vendue',commentaire_HV='$Up_VoitureCommentaire'
     WHERE id_histrique_voiture = $id_voiture_vendue";
    $update_result = mysqli_query($conn, $update_query);


    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour de véhicule!<br>Impossible de mettre à jour le véhicule</div>";
        return;
    } else {
        echo "<div class='text-success'>Le véhicule a été mis à jour avec succès</div>";
        return;
    }
}

//modifier voiture
function update_voiture_HS_value()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $id_agence = $_SESSION['id_agence'];
    $id_voiture_HS = $_POST['id_voiture_HS'];
    $Up_Voituredate_HS = $_POST['Up_Voituredate_HS'];
    $Up_VoitureCommentaire = $_POST['Up_VoitureCommentaire'];
    $up_VoitureHS = $_POST['up_VoitureHS'];
    $Up_VHSid = $_POST['Up_VHSid'];
    if ($up_VoitureHS == "HS") {
        echo  $update_query = "UPDATE histrique_voiture 
    SET date_HV='$Up_Voituredate_HS',commentaire_HV='$Up_VoitureCommentaire'
     WHERE id_histrique_voiture = $id_voiture_HS";
        $update_result = mysqli_query($conn, $update_query);
    } else {

        $query = "INSERT INTO 
    histrique_voiture(id_voiture_HV,action,id_agence_em,id_agence_recv,id_user_HV,commentaire_HV,date_HV) 
    VALUES ('$Up_VHSid','Disponible','$id_agence','$id_agence','$id_user','$Up_VoitureCommentaire','$Up_Voituredate_HS')";
        $result = mysqli_query($conn, $query);

        $update_query = "UPDATE voiture 
SET etat_voiture='Disponible'
WHERE id_voiture = $Up_VHSid";
        $update_result = mysqli_query($conn, $update_query);
    }




    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour de véhicule!<br>Impossible de mettre à jour le véhicule</div>";
        return;
    } else {
        echo "<div class='text-success'>Le véhicule a été mis à jour avec succès</div>";
        return;
    }
}



function update_agence_stock()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    // $id_agenceuser = $_SESSION['id_agence'];

    $id_voiture = $_POST['id_voiture'];
    $up_voitureAgence = $_POST['up_voitureAgence'];

    //selection de agence  tab voiture
    $queryag = "SELECT * FROM voiture  WHERE id_voiture = $id_voiture";
    $result_ag = mysqli_query($conn, $queryag);
    while ($row = mysqli_fetch_assoc($result_ag)) {
        $id_agenceuser = $row['id_agence'];
    }
    // end selection de agence  tab voiture

    //update agance  dans tab voiture
    $update_query = "UPDATE voiture 
    SET   id_agence='$up_voitureAgence'
    WHERE id_voiture = $id_voiture";
    $update_result = mysqli_query($conn, $update_query);
    // end update  agance  dans tab voiture

    if (!$update_result) {

        echo "<div class='text-danger'>Erreur lors de la mise à jour de véhicule!<br>Impossible de mettre à jour le véhicule</div>";
        return;
    } else {
        // end update  agance  dans tab histrique_voiture  
        $queryVehiculeT = "INSERT INTO  
    histrique_voiture(id_voiture_HV,id_agence_em,id_agence_recv,action,id_user_HV) 
    VALUES ('$id_voiture','$id_agenceuser','$up_voitureAgence','Transferer','$id_user') ";
        $resultVehiculeT = mysqli_query($conn, $queryVehiculeT);
        // end update  agance  dans tab histrique_voiture
        echo "<div class='text-success'>Le véhicule a été mis à jour avec succès</div>";
        return;
    }
}

function update_agence_material_stock()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    // $id_agenceuser = $_SESSION['id_agence'];

    $id_material = $_POST['id_materiel'];
    $up_materialagence = $_POST['up_materialagence'];

    //selection de agence  tab material agence
    $queryag = "SELECT * FROM materiels_agence  WHERE id_materiels_agence = $id_material";
    $result_ag = mysqli_query($conn, $queryag);
    while ($row = mysqli_fetch_assoc($result_ag)) {
        $id_agenceuser = $row['id_agence'];
    }
    // end selection de agence  tab material agence

    //update agance  dans tab voiture
    $update_query = "UPDATE materiels_agence
    SET   id_agence='$up_materialagence'
    WHERE id_materiels_agence = $id_material";
    $update_result = mysqli_query($conn, $update_query);
    // end update  agance  dans tab material agence
   
}

function update_agence_material_quantite_stock()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $id_materiel_agence = $_POST['id_materiel'];
    $up_materialagence = $_POST['up_materialagence'];
    $up_quantitemateriel = $_POST['up_quantitemateriel'];

    $query = "SELECT id_materiels,quantite_materiels,id_agence
                    FROM materiels_agence  
                    WHERE id_materiels_agence = '$id_materiel_agence'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id_materiels = $row['id_materiels'];
        $quantite_materielsorig = $row['quantite_materiels'];
        $id_agence = $row['id_agence'];
    }

    $query1 = "SELECT *
                    FROM materiels_agence  
                    WHERE id_materiels = '$id_materiels'
                    AND id_agence='$up_materialagence'";
    $result1 = mysqli_query($conn, $query1);
    
    if($result1->num_rows > 0){
        $row1 = mysqli_fetch_assoc($result1);
        $id_materiel_agence1 = $row1['id_materiels_agence'];
        $quantite_materiels = $row1['quantite_materiels'];

        $qtitetotaladd = $quantite_materiels + $up_quantitemateriel;
        $qtitetotalmoins = $quantite_materielsorig - $up_quantitemateriel;

        if($qtitetotalmoins >= 0){
            $update_queryadd = "UPDATE materiels_agence
            SET quantite_materiels='$qtitetotaladd'
            WHERE id_materiels_agence = $id_materiel_agence1";
            $result_updateadd = mysqli_query($conn, $update_queryadd);

            $update_querymoins = "UPDATE materiels_agence
                SET quantite_materiels='$qtitetotalmoins'
                WHERE id_materiels_agence = $id_materiel_agence";
            $result_updatemoins = mysqli_query($conn, $update_querymoins);
            echo "<div class='text-success'>Le matériel est modifié avec succès</div>";
        }else{
            echo "<div class='text-danger'>La quantité est insuffisante dans cet agence</div>";
        }
    }else{
        $qtitetotaladd = $up_quantitemateriel;
        $qtitetotalmoins = $quantite_materielsorig - $up_quantitemateriel;
        $insert_query1 = "INSERT INTO 
        materiels_agence(id_materiels,quantite_materiels,quantite_materiels_dispo,id_agence,id_user) 
        VALUES ('$id_materiels','$qtitetotaladd','$qtitetotaladd','$up_materialagence','$id_user')";
        $result_insert1 = mysqli_query($conn, $insert_query1);

        $update_query1 = "UPDATE materiels_agence
            SET   quantite_materiels='$qtitetotalmoins'
            WHERE id_materiels_agence = $id_materiel_agence";
        $result_update1 = mysqli_query($conn, $update_query1);

        echo "<div class='text-success'>Le matériel est modifié avec succès</div>";
    }  
}
//Ajouter entretien Records function
function InsertEntretien()
{
    global $conn;

    $EntretienType = isset($_POST['EntretienType']) ? $_POST['EntretienType'] : "";
    $EntretienNomMateriel = isset($_POST['EntretienNomMateriel']) ? $_POST['EntretienNomMateriel'] : "";
    $EntretienModelVoiture = isset($_POST['EntretienModelVoiture']) ? $_POST['EntretienModelVoiture'] : "";
    $ObjetEntretien = isset($_POST['ObjetEntretien']) ? $_POST['ObjetEntretien'] : "";
    $LieuEntretien = isset($_POST['LieuEntretien']) ? $_POST['LieuEntretien'] : "";
    $CoutEntretien = isset($_POST['CoutEntretien']) ? $_POST['CoutEntretien'] : "";
    $Entretiendate = isset($_POST['Entretiendate']) ? $_POST['Entretiendate'] : "";
    $EntretienFindate = isset($_POST['EntretienFindate']) ? $_POST['EntretienFindate'] : "";
    $EntretienCommentaire = isset($_POST['EntretienCommentaire']) ? $_POST['EntretienCommentaire'] : "";

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        return;
    }
    if ($EntretienNomMateriel) {
        $query = "INSERT INTO 
        entretien(id_materiel,type,commentaire,date_entretien,objet_entretien,lieu_entretien,cout_entretien,date_fin_entretien) 
        VALUES ('$EntretienNomMateriel','$EntretienType','$EntretienCommentaire','$Entretiendate','$ObjetEntretien','$LieuEntretien','$CoutEntretien','$EntretienFindate')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'>L'entretien est ajouté avec succés</div>";
            $query_update = "UPDATE materiels_agence SET etat_materiels='E' WHERE id_materiels_agence='$EntretienNomMateriel'";
            $result_update = mysqli_query($conn, $query_update);
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout d'entretien</div>";
        }
    } elseif ($EntretienModelVoiture) {
        $query = "INSERT INTO 
        entretien(id_voiture,type,commentaire,date_entretien,objet_entretien,lieu_entretien,cout_entretien,date_fin_entretien) 
        VALUES ('$EntretienModelVoiture','$EntretienType','$EntretienCommentaire','$Entretiendate','$ObjetEntretien','$LieuEntretien','$CoutEntretien','$EntretienFindate')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "L'entretien est ajouté avec succés";
            $query_update = "UPDATE voiture SET etat_voiture='Entretien' WHERE id_voiture='$EntretienModelVoiture'";
            $result_update = mysqli_query($conn, $query_update);
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout d'entretien</div>";
        }
    } else {
        echo 'échoué!';
    }
}


//Ajouter entretien Records function
function InsertControletechnique()
{
    global $conn;

    $typeControletechnique = isset($_POST['typeControletechnique']) ? $_POST['typeControletechnique'] : "";
    $ObjetControletechnique = isset($_POST['ObjetControletechnique']) ? $_POST['ObjetControletechnique'] : "";
    $LieuControletechnique = isset($_POST['LieuControletechnique']) ? $_POST['LieuControletechnique'] : "";
    $CoutControletechnique = isset($_POST['CoutControletechnique']) ? $_POST['CoutControletechnique'] : "";
    $Controletechniquedate = isset($_POST['Controletechniquedate']) ? $_POST['Controletechniquedate'] : "";
    $ControletechniqueFindate = isset($_POST['ControletechniqueFindate']) ? $_POST['ControletechniqueFindate'] : "";
    $ProchaineControletechniquedate = isset($_POST['ProchaineControletechniquedate']) ? $_POST['ProchaineControletechniquedate'] : "";
    $ControletechniqueCommentaire = isset($_POST['ControletechniqueCommentaire']) ? $_POST['ControletechniqueCommentaire'] : "";
    $ControletechniqueVoiture = isset($_POST['ControletechniqueVoiture']) ? $_POST['ControletechniqueVoiture'] : "";

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        return;
    }

    $query = "INSERT INTO 
        entretien(id_voiture,type,commentaire,date_entretien,objet_entretien,lieu_entretien,cout_entretien,date_fin_entretien,prochaine_entretien) 
        VALUES ('$ControletechniqueVoiture','$typeControletechnique','$ControletechniqueCommentaire','$Controletechniquedate','$ObjetControletechnique',
        '$LieuControletechnique','$CoutControletechnique','$ControletechniqueFindate','$ProchaineControletechniquedate')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "L'entretien est ajouté avec succés";
        $query_update = "UPDATE voiture SET etat_voiture='Entretien' WHERE id_voiture='$ControletechniqueVoiture'";
        $result_update = mysqli_query($conn, $query_update);
    } else {
        echo "<div class='text-danger'>Erreur lors d'ajout d'entretien</div>";
    }
}

function get_entretien_record()
{
    global $conn;
    $EntretienId = $_POST['EntretienID'];
    $query = "SELECT E.id_entretien,E.type,E.date_entretien,E.commentaire,E.id_voiture,E.id_materiel,
    E.objet_entretien,E.lieu_entretien,E.cout_entretien,E.date_fin_entretien,E.commentaire_intervenant,
    V.pimm,M.id_materiels_agence
    FROM `entretien`as E 
    LEFT JOIN materiels_agence as M ON E.id_materiel=M.id_materiels_agence 
    LEFT JOIN voiture as V on E.id_voiture=V.id_voiture 
  
    WHERE id_entretien='$EntretienId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $entretien_data = [];
        $entretien_data[0] = $row['id_entretien'];
        $entretien_data[1] = $row['type'];
        $entretien_data[2] = $row['date_entretien'];
        $entretien_data[3] = $row['commentaire'];
        $entretien_data[4] = $row['commentaire_intervenant'];
        $entretien_data[5] = $row['id_voiture'];
        $entretien_data[6] = $row['id_materiel'];
        $entretien_data[7] = $row['objet_entretien'];
        $entretien_data[8] = $row['lieu_entretien'];
        $entretien_data[9] = $row['cout_entretien'];
        $entretien_data[10] = $row['date_fin_entretien'];
    }
    echo json_encode($entretien_data);
}

function update_entretien()
{
    global $conn;
    $Update_Entretien_Id = $_POST['up_dateEntretienId'];
    $Update_Entretien_Date = $_POST['up_dateEntretienDate'];
    $Update_Entretien_Commentaire = $_POST['up_dateEntretienCommentaire'];
    $up_EntretienIdVoiture = $_POST['up_EntretienIdVoiture'];
    $up_ObjetEntretien = $_POST['up_ObjetEntretien'];
    $up_LieuEntretien = $_POST['up_LieuEntretien'];
    $up_CoutEntretien = $_POST['up_CoutEntretien'];

    $up_EntretiendateFin = $_POST['up_EntretiendateFin'];
    $up_VoitureEntretien = $_POST['up_VoitureEntretien'];

    $query = "UPDATE entretien SET  date_entretien='$Update_Entretien_Date',commentaire='$Update_Entretien_Commentaire',
    id_voiture='$up_EntretienIdVoiture',objet_entretien='$up_ObjetEntretien',lieu_entretien='$up_LieuEntretien',cout_entretien='$up_CoutEntretien',date_fin_entretien='$up_EntretiendateFin'
    WHERE id_entretien ='$Update_Entretien_Id'";

    $result = mysqli_query($conn, $query);
    if ($result) {

        if ($up_VoitureEntretien == "Disponible") {
            $queryEnt = "SELECT  id_voiture,id_entretien,id_materiel,type   FROM entretien 
        WHERE  id_entretien =   $Update_Entretien_Id ";

            $resultEnt = mysqli_query($conn, $queryEnt);
            while ($row = mysqli_fetch_assoc($resultEnt)) {
                if ($row['type'] == "Materiel") {

                    $idvoitureEnt = $row['id_materiel'];
                    $update_queryEnt = "UPDATE materiels_agence 
                    SET etat_materiels='T'
                     WHERE id_materiels_agence = $idvoitureEnt";
                    $update_resultEnt = mysqli_query($conn, $update_queryEnt);
                } else {
                    $idvoitureEnt = $row['id_voiture'];

                    $update_queryEnt = "UPDATE voiture 
                SET etat_voiture='Disponible'
                 WHERE id_voiture = $idvoitureEnt";
                    $update_resultEnt = mysqli_query($conn, $update_queryEnt);
                }
            }
        }
        echo "<div class='text-success'>L'entretien a été mis à jour avec succés</div> ";
    } else {
        echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
    }
}

function update_entretien_mecanicien()
{
    global $conn;
    $Update_Entretien_Id = $_POST['up_dateEntretienId'];
    $Update_Entretien_Commentaire_Intervenant = $_POST['updateEntretienCommentaireIntervenant'];


    $query = "UPDATE entretien SET commentaire_intervenant='$Update_Entretien_Commentaire_Intervenant'
    WHERE id_entretien ='$Update_Entretien_Id'";

    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>L'entretien a été mis à jour avec succés</div> ";
    } else {
        echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
    }
}

function delete_entretien()
{
    global $conn;
    $Del_ID = $_POST['id_entretien'];

    $queryidv = "SELECT id_voiture FROM entretien where id_entretien='$Del_ID'";
    $resultidv = mysqli_query($conn, $queryidv);
    $row = mysqli_fetch_row($resultidv);
    $id_voiture = $row[0];

    $query = "DELETE FROM entretien WHERE id_entretien='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {

        $qt = " UPDATE voiture set etat_voiture= 'Disponible' where  id_voiture=$id_voiture  ";
        $res = mysqli_query($conn, $qt);

        echo "<div class='text-danger'>L'entretien est supprimé avec succés</div>";
    } else {
        echo "<div class='text-success'>SVP vérifier votre requette !</div>";
    }
}

function Confirmation_Entretien()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $rowdate = date("Y-m-d h:i:s");
    $RealisationEntretien_ID = $_POST['RealisationEntretien_ID'];

    $qt = "UPDATE entretien set etat_entretien= '1' where id_entretien=$RealisationEntretien_ID";
    $res = mysqli_query($conn, $qt);
    
    $selectmatvehicule = "SELECT id_voiture,id_materiel FROM entretien WHERE id_entretien = $RealisationEntretien_ID";
    $resmatvehicule = mysqli_query($conn, $selectmatvehicule);
    $row = mysqli_fetch_row($resmatvehicule);
    $idvoitureEnt = $row[0];
    $idmatEnt = $row[1];

    if($res){
        if ($idvoitureEnt == 0){
            $updatedispo = "UPDATE materiels_agence set etat_materiels= 'T' where id_materiels_agence=$idmatEnt";
        }else{
            $updatedispo = "UPDATE voiture set etat_voiture= 'Disponible' where id_voiture=$idvoitureEnt";
        }
        $resupdatedispo = mysqli_query($conn, $updatedispo);

        $queryhistorique = "INSERT INTO 
        historique_entretien(id_entretien,id_user_entretien,action_entretien,date_action_entretien) 
        VALUES ('$RealisationEntretien_ID','$id_user','Confirmation','$rowdate')";

        $resulthistorique = mysqli_query($conn, $queryhistorique);
        if($resulthistorique){
            echo "<div class='text-success'>L'entretien est fait avec succés</div>";
        } else {
            echo "<div class='text-danger'>SVP vérifier votre requette !</div>";
        }
    }
}

function get_Controle_technique_data()
{
    global $conn;
    $ControleTechniqueID = $_POST['ControleTechniqueID'];
    $query = "SELECT *
    FROM controletechnique 
    WHERE id_controletechnique='$ControleTechniqueID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $Controle_technique_data = [];
        $Controle_technique_data[0] = $row['id_controletechnique'];
        $Controle_technique_data[1] = $row['comment_declar'];
        $Controle_technique_data[2] = $row['comment_interv'];
        $Controle_technique_data[3] = $row['date_controletechnique'];
    }
    echo json_encode($Controle_technique_data);
}

function update_Controle_technique()
{
    global $conn;
    $up_Id_Controle_technique = $_POST['up_Id_Controle_technique'];
    $up_Commentaire_Controle_technique = $_POST['up_Commentaire_Controle_technique'];
    $up_date_Controle_technique = $_POST['up_date_Controle_technique'];

    $query = "UPDATE controletechnique SET  comment_declar='$up_Commentaire_Controle_technique',date_controletechnique='$up_date_Controle_technique'
    WHERE id_controletechnique ='$up_Id_Controle_technique'";

    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Le controle technique a été mis à jour avec succés</div> ";
    } else {
        echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
    }
}

function update_Controle_technique_mecanicien()
{
    global $conn;
    $up_Id_Controle_technique_mec = $_POST['up_Id_Controle_technique_mec'];
    $up_Commentaire_Controle_technique_mec_interv = $_POST['up_Commentaire_Controle_technique_mec_interv'];

    $query = "UPDATE controletechnique SET comment_interv='$up_Commentaire_Controle_technique_mec_interv'
    WHERE id_controletechnique ='$up_Id_Controle_technique_mec'";

    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Le controle technique a été mis à jour avec succés</div> ";
    } else {
        echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
    }
}

function Confirmation_Controletechnique()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $rowdate = date("Y-m-d h:i:s");
    $Realisation_ID = $_POST['Realisation_ID'];

    $querytype = "SELECT type_controletechnique FROM controletechnique where id_controletechnique='$Realisation_ID'";
    $resulttype = mysqli_query($conn, $querytype);
    $row = mysqli_fetch_row($resulttype);
    $typecontrole = $row[0];

    if($typecontrole == "1"){
        $update_query = "UPDATE controletechnique 
                        SET date_controletechnique = DATE_ADD(date_controletechnique, INTERVAL 730 DAY),
                        controle_status = 0
                        where id_controletechnique='$Realisation_ID'";
    }else if($typecontrole == "2"){
        $update_query = "UPDATE controletechnique 
                        SET date_controletechnique = DATE_ADD(date_controletechnique, INTERVAL 365 DAY),
                        controle_status = 0
                        where id_controletechnique='$Realisation_ID'";
    }else if($typecontrole == "3"){
        $update_query = "UPDATE controletechnique 
                        SET date_controletechnique = DATE_ADD(date_controletechnique, INTERVAL 180 DAY),
                        controle_status = 0
                        where id_controletechnique='$Realisation_ID'";
    }
    
    $result_query = mysqli_query($conn, $update_query);

    if ($result_query) {
        $queryhistorique = "INSERT INTO 
        historique_controle(id_controle,id_user_controle,action_controle,date_action_controle) 
        VALUES ('$Realisation_ID','$id_user','Confirmation','$rowdate')";
        
        $resulthistorique = mysqli_query($conn, $queryhistorique);

        echo "<div class='text-success'>Le contrôle est fait avec succés</div>";
    } else {
        echo "<div class='text-danger'>SVP vérifier votre requette !</div>";
    }
}



// Afficher vehicules <th class="border-top-0">N° de chéque Caution</th>

function display_contrat_record_voiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email du client</th>
        <th class="border-top-0">Modèle de véhicule</th>
        <th class="border-top-0">PIMM de véhicule</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Nombre de kilomètres inclus</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Contrat Signé</th>
        <th class="border-top-0">Actions</th>  
        </tr>';

    if ($id_agence != "0") {
        $query = "SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.contratsigne,C.date_debut,C.date_fin,
        C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.KMPrevu,C.NbrekmInclus,
        CL.id_client,CL.nom,CL.nom_entreprise,CL.email,A.lieu_agence As lieu_dep,
        AD.lieu_agence As lieu_agence_dep,AR.lieu_agence As lieu_agence_ret,
        V.pimm,MM.Model 
        FROM contrat_client AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
        LEFT JOIN agence AS AD ON AD.id_agence =C.id_agencedep 
        LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00'))
        AND  etat_contrat != 'S'
        AND  C.type_location = 'Vehicule'
        AND C.id_client =CL.id_client
        AND C.id_agence = $id_agence ";
    } else {
        $query = "SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.contratsigne,C.date_debut,C.date_fin,
        C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.KMPrevu,C.NbrekmInclus,
        CL.id_client,CL.nom,CL.nom_entreprise,CL.email,A.lieu_agence As lieu_dep,
        AD.lieu_agence As lieu_agence_dep,AR.lieu_agence As lieu_agence_ret,
        V.pimm,MM.Model 
        FROM contrat_client AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
        LEFT JOIN agence AS AD ON AD.id_agence =C.id_agencedep 
        LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00')  OR (C.date_debut_validation = '0000-00-00'))
        AND  etat_contrat != 'S'
        AND  C.type_location = 'Vehicule'
        AND C.id_client =CL.id_client ";
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ((($row["date_fin"] < $date) && ($row["date_fin_validation"] == "0000-00-00")) || (($row["date_fin"] < $date) && ($row["date_debut_validation"] == "0000-00-00"))){
            $style = "#FF8000";
            $value .= '<tr>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['id_contrat'] . '</td>';
            if (($row["date_debut_validation"] == "0000-00-00")){
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                            '.date('d-m-Y', strtotime($row['date_debut'])).'
                            <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-voiture" data-id-sortie-voiture=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                            </td>';
            }else{
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                            '. date('d-m-Y', strtotime($row['date_debut'])).'
                            <img style= "width:55px; height:45px;" src="sortievalide.png">
                        </td>';
            }
            if (($row["date_fin_validation"] == "0000-00-00")){
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                            '. date('d-m-Y', strtotime($row['date_fin'])).'
                            <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-voiture" data-id-retour-voiture=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                            </td>';
            }else{
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                            '. date('d-m-Y', strtotime($row['date_fin'])).' 
                            <img style= "width:55px; height:45px;" src="entreevalide.png">
                        </td>';
            }
            $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_dep'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_agence_ret'] . '</td>'; 
            if ($row['nom_entreprise'] == ""){
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom'] . '</td>';
            }else if ($row['nom'] == ""){
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . '</td>';
            }else{
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
            }
            $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['email'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['Model'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['pimm'] . '</td> 
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['duree'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['prix'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['caution'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['NbrekmInclus'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['mode_de_paiement'] . '</td>';
            if ($row["contratsigne"] == ""){
                $value .= '<td class="border-top-0" bgcolor="'.$style.'"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
            }else{
                $value .= '<td class="border-top-0" bgcolor="'.$style.'"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
            }
            $value .= '<td class="border-top-0" bgcolor="'.$style.'">';
            if ($_SESSION['Role'] != "superadmin") {
                $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-voiture" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                        <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-voiture" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                        <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-voiture-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
            }
            $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td></tr>';
        }else{
            $value .= '<tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>';
            if (($row["date_debut_validation"] == "0000-00-00")){
                $value .= '<td class="border-top-0">
                            '.date('d-m-Y', strtotime($row['date_debut'])).'
                            <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-voiture" data-id-sortie-voiture=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                            </td>';
            }else{
                $value .= '<td class="border-top-0">
                            '. date('d-m-Y', strtotime($row['date_debut'])).'
                            <img style= "width:55px; height:45px;" src="sortievalide.png">
                        </td>';
            }
            if (($row["date_fin_validation"] == "0000-00-00")){
                $value .= '<td class="border-top-0">
                            '. date('d-m-Y', strtotime($row['date_fin'])).'
                            <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-voiture" data-id-retour-voiture=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                            </td>';
            }else {
                $value .= '<td class="border-top-0">
                            '. date('d-m-Y', strtotime($row['date_fin'])).' 
                            <img style= "width:55px; height:45px;" src="entreevalide.png">
                        </td>';
            }
            $value .= '<td class="border-top-0">' . $row['lieu_dep'] . '</td>
            <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
            if ($row['nom_entreprise'] == ""){
                $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
            }else if ($row['nom'] == ""){
                $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
            }else{
                $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
            }
            $value .= '<td class="border-top-0">' . $row['email'] . '</td>
            <td class="border-top-0">' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td> 
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['NbrekmInclus'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
            if ($row["contratsigne"] == ""){
                $value .= '<td class="border-top-0"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
            }else{
                $value .= '<td class="border-top-0"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
            }
            $value .= '<td class="border-top-0">';
            if ($_SESSION['Role'] != "superadmin") {
                $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-voiture" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                        <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-voiture" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                        <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-voiture-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
            }
            $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td></tr>';
        }
        $queryavenant = "SELECT * 
        FROM contrat_client_avenant AS C
        LEFT JOIN voiture AS V on C.id_voiture_avenant = V.id_voiture 
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE C.id_contrat_client = ".$row['id_contrat'];
        $resultavenant = mysqli_query($conn, $queryavenant);
        if (mysqli_num_rows($resultavenant) > 0) {
            while ($rowavenant = mysqli_fetch_assoc($resultavenant)) {
            $value .= '<tr><td class="border-top-0" style="background-color:#F2F2F2;"></td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['debut_contrat_avenant'])) . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['fin_contrat_avenant'])) . '</td> 
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_dep'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_agence_ret'] . '</td>';
            if ($row['nom_entreprise'] == ""){
                $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom'] . '</td>';
            }else if ($row['nom'] == ""){
                $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . '</td>';
            }else{
                $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
            }
            $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['email'] . '</td> 
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $rowavenant['Model'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $rowavenant['pimm'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['duree'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['prix'] . '</td> 
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['caution'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['NbrekmInclus'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['mode_de_paiement'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;"></td>
            <td class="border-top-0" >
                <button type="button" title="Modifier le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-avenant" data-id1=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-edit"></i></i></button>
                <button type="button" title="Télécharger le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-contrat-avenant" data-id=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-download"></i></i></button>
            </td></tr>'; 
            }
        }   
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}



// Afficher vehicules
//TODO : fix display
function display_contrat_archivage_record_voiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email de client</th>
        <th class="border-top-0">Modèle de véhicule</th>
        <th class="border-top-0">PIMM de véhicule</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Nombre de kilomètres inclus</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Actions</th>  
        </tr>';
    if ($id_agence != "0") {
        $query = "SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,C.prix,
        C.mode_de_paiement,C.KMPrevu,C.NbrekmInclus,
        CL.id_client,CL.nom,CL.nom_entreprise,CL.email,A.lieu_agence As lieu_dep,
        AD.lieu_agence As lieu_agence_dep,AR.lieu_agence As lieu_agence_ret,
        V.pimm,MM.Model 
        FROM contrat_client AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
        LEFT JOIN agence AS AD ON AD.id_agence =C.id_agencedep 
        LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE ( (DATE(NOW()) >= C.date_fin_validation) OR (DATE(NOW()) > C.date_fin) )
        AND (C.date_fin_validation != '0000-00-00')
        AND (C.date_debut_validation != '0000-00-00')
        AND C.etat_contrat != 'S' 
        AND  C.type_location = 'Vehicule'
        AND C.id_client =CL.id_client
        AND C.id_agence = $id_agence
        ORDER BY C.id_contrat DESC";
    } else {
        $query = "SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,C.prix,
        C.mode_de_paiement,C.KMPrevu,C.NbrekmInclus,
        CL.id_client,CL.nom,CL.nom_entreprise,CL.email,A.lieu_agence As lieu_dep,
        AD.lieu_agence As lieu_agence_dep,AR.lieu_agence As lieu_agence_ret,
        V.pimm,MM.Model 
        FROM contrat_client AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
        LEFT JOIN agence AS AD ON AD.id_agence =C.id_agencedep 
        LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE ( (DATE(NOW()) >= C.date_fin_validation) OR (DATE(NOW()) > C.date_fin) )
        AND (C.date_fin_validation != '0000-00-00')
        AND (C.date_debut_validation != '0000-00-00')
        AND C.etat_contrat != 'S' 
        AND  C.type_location = 'Vehicule'
        AND C.id_client =CL.id_client 
        ORDER BY C.id_contrat DESC";
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
        <td class="border-top-0">' . $row['id_contrat'] . '</td>
        <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_debut'])).' </td>
        <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_fin'])).' </td>
        <td class="border-top-0">' . $row['lieu_dep'] . '</td>
        <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
        if ($row['nom_entreprise'] == ""){
            $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
        }else if ($row['nom'] == ""){
            $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
        }else{
            $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
        }
        $value .= '<td class="border-top-0">' . $row['email'] . '</td>
        <td class="border-top-0">' . $row['Model'] . '</td>
        <td class="border-top-0">' . $row['pimm'] . '</td> 
        <td class="border-top-0">' . $row['duree'] . '</td>
        <td class="border-top-0">' . $row['prix'] . '</td>
        <td class="border-top-0">' . $row['caution'] . '</td>
        <td class="border-top-0">' . $row['NbrekmInclus'] . '</td>
        <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
    
        $value .= '<td class="border-top-0">
            <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>';
            if ($_SESSION['Role'] != "superadmin") {
                $value .= '<button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-voiture" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>';
            }
        $value .= '</td></tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_contrat_archivage_record_materiel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Date de départ</th>
            <th class="border-top-0">Date de retour</th>
            <th class="border-top-0">Agence de départ</th>
            <th class="border-top-0">Agence de retour</th>
            <th class="border-top-0">Nom du client</th>
            <th class="border-top-0">Email du client</th>
            <th class="border-top-0">Désignation matériel</th>
            <th class="border-top-0">Num Série matériel</th>
            <th class="border-top-0">Durée de location</th>
            <th class="border-top-0">Prix</th>
            <th class="border-top-0">Caution</th>
            <th class="border-top-0">Nombre de kilomètres inclus</th>
            <th class="border-top-0">Mode de paiement</th>
            <th class="border-top-0">Action</th>    
        </tr>';

        if ($id_agence != "0") {
            $query = "SELECT DISTINCT C.id_contrat,C.duree,C.id_agencedep,C.id_agenceret,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,C.prix,
        C.date_debut_validation,C.date_fin_validation,C.mode_de_paiement,C.NbrekmInclus,CL.nom,CL.nom_entreprise,CL.email,CM.designation_contrat,CM.num_serie_contrat,
        A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
        FROM contrat_client AS C 
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
        LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
        LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
        WHERE ( (DATE(NOW()) >= C.date_fin_validation) OR (DATE(NOW()) > C.date_fin) )
        AND (C.date_fin_validation != '0000-00-00')
        AND (C.date_debut_validation != '0000-00-00')
        AND  C.type_location = 'Materiel'
        AND C.etat_contrat != 'S' 
        AND C.id_agence = $id_agence 
        ORDER BY id_contrat DESC";
        } else {
            $query = "SELECT DISTINCT C.id_contrat,C.duree,C.id_agencedep,C.id_agenceret,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,C.prix,
        C.date_debut_validation,C.date_fin_validation,C.mode_de_paiement,C.NbrekmInclus,CL.nom,CL.nom_entreprise,CL.email,CM.designation_contrat,CM.num_serie_contrat,
        A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
        FROM contrat_client AS C 
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
        LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
        LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
        WHERE ( (DATE(NOW()) >= C.date_fin_validation) OR (DATE(NOW()) > C.date_fin) )
        AND (C.date_fin_validation != '0000-00-00')
        AND (C.date_debut_validation != '0000-00-00')
        AND  C.type_location = 'Materiel'
        AND C.etat_contrat != 'S' 
        ORDER BY id_contrat DESC";
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
        <td class="border-top-0">' . $row['id_contrat'] . '</td>
        <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_debut'])).'</td>
        <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_fin'])).'</td>
        <td class="border-top-0">' . $row['lieu_dep'] . '</td>
        <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
        if ($row['nom_entreprise'] == ""){
            $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
        }else if ($row['nom'] == ""){
            $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
        }else{
            $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
        }
        $value .= '<td class="border-top-0">' . $row['email'] . '</td>
        <td class="border-top-0">' . $row['designation_contrat'] . '</td>
        <td class="border-top-0">' . $row['num_serie_contrat'] . '</td> 
        <td class="border-top-0">' . $row['duree'] . '</td>
        <td class="border-top-0">' . $row['prix'] . '</td>
        <td class="border-top-0">' . $row['caution'] . '</td>
        <td class="border-top-0">' . $row['NbrekmInclus'] . '</td>
        <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
        $value .= '<td class="border-top-0">
            <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel" data-id5=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>';
        if ($_SESSION['Role'] != "superadmin") {
            $value .= '<button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>';
        }
        $value .= '</td></tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_contrat_archivage_record_pack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Date de départ</th>
            <th class="border-top-0">Date de retour</th>
            <th class="border-top-0">Agence de départ</th>
            <th class="border-top-0">Agence de retour</th>
            <th class="border-top-0">Nom du client</th>
            <th class="border-top-0">Email du client</th>
            <th class="border-top-0">Désignation Pack</th>
            <th class="border-top-0">Durée de location</th>
            <th class="border-top-0">Prix</th>
            <th class="border-top-0">Caution</th>
            <th class="border-top-0">Nombre de kilomètres inclus</th>
            <th class="border-top-0">Mode de paiement</th>
            <th class="border-top-0">Action</th>     
        </tr>';

        if ($id_agence != "0") {
            $query = " SELECT DISTINCT C.id_contrat,C.duree,C.caution,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,
            P.designation_pack,
            CL.nom,CL.nom_entreprise,CL.email,
            A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
                FROM contrat_client AS C 
                LEFT JOIN group_packs AS P ON P.id_group_packs=C.id_group_pack
                LEFT JOIN client AS CL ON C.id_client=CL.id_client
                LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
                LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret 
            WHERE ( (DATE(NOW()) >= C.date_fin_validation) OR (DATE(NOW()) > C.date_fin) )
            AND (C.date_fin_validation != '0000-00-00')
            AND (C.date_debut_validation != '0000-00-00')
            AND C.type_location = 'Pack' 
            AND  C.etat_contrat != 'S'
            AND C.id_agence = $id_agence
            ORDER BY id_contrat DESC";
        } else {
            $query = " SELECT DISTINCT C.id_contrat,C.duree,C.caution,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,
            P.designation_pack,
            CL.nom,CL.nom_entreprise,CL.email,
            A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
            FROM contrat_client AS C 
            LEFT JOIN group_packs AS P ON P.id_group_packs=C.id_group_pack
            LEFT JOIN client AS CL ON C.id_client=CL.id_client
            LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
            LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
            WHERE ( (DATE(NOW()) >= C.date_fin_validation) OR (DATE(NOW()) > C.date_fin) )
            AND (C.date_fin_validation != '0000-00-00')
            AND (C.date_debut_validation != '0000-00-00')
            AND C.type_location = 'Pack' 
            AND  C.etat_contrat != 'S'
            ORDER BY id_contrat DESC";
        }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
        <td class="border-top-0">' . $row['id_contrat'] . '</td>
        <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_debut'])).'</td>
        <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_fin'])).'</td>
        <td class="border-top-0">' . $row['lieu_dep'] . '</td>
        <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
        if ($row['nom_entreprise'] == ""){
            $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
        }else if ($row['nom'] == ""){
            $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
        }else{
            $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
        }
        $value .= '<td class="border-top-0">' . $row['email'] . '</td>
        <td class="border-top-0">' . $row['designation_pack'] . '</td>
        <td class="border-top-0">' . $row['duree'] . '</td>
        <td class="border-top-0">' . $row['prix'] . '</td>
        <td class="border-top-0">' . $row['caution'] . '</td>
        <td class="border-top-0">' . $row['NbrekmInclus'] . '</td>
        <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
        $value .= '<td class="border-top-0">
        <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>';
        if ($_SESSION['Role'] != "superadmin") {
            $value .= '<button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-pack" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>';
        }
        $value .= '</td></tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// Afficher contrat materiel
function display_contrat_record_materiel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email du client</th>
        <th class="border-top-0">Désignation matériel</th>
        <th class="border-top-0">Num Série matériel</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Contrat Signé</th> 
        <th class="border-top-0">Action</th>    
        </tr>';

    if ($id_agence != "0") {
        $query = "SELECT DISTINCT C.id_contrat,C.duree,C.id_agencedep,C.id_agenceret,C.contratsigne,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,
        C.date_debut_validation,C.date_fin_validation,C.prix,C.NbrekmInclus,C.mode_de_paiement,
        CL.nom,CL.nom_entreprise,CL.email,CM.designation_contrat,CM.num_serie_contrat,
        A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
    FROM contrat_client AS C 
    LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
    LEFT JOIN client AS CL ON C.id_client=CL.id_client
    LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
    LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
    WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00')) 
    AND  etat_contrat != 'S'
    AND C.type_location = 'Materiel'
    AND C.id_agence = $id_agence ";
    } else {
        $query = "SELECT DISTINCT C.id_contrat,C.duree,C.id_agencedep,C.id_agenceret,C.contratsigne,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,
        C.date_debut_validation,C.date_fin_validation,C.prix,C.NbrekmInclus,C.mode_de_paiement,
        CL.nom,CL.nom_entreprise,CL.email,CM.designation_contrat,CM.num_serie_contrat,
        A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
    FROM contrat_client AS C 
    LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
    LEFT JOIN client AS CL ON C.id_client=CL.id_client
    LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
    LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
    WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00') )
    AND  etat_contrat != 'S'
    AND C.type_location = 'Materiel' ";
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ( (($row["date_fin"] < $date) && ($row["date_fin_validation"] == "0000-00-00")) || (($row["date_fin"] < $date) && ($row["date_debut_validation"] == "0000-00-00"))){
            $style = "#FF8000";
            $value .= '
            <tr>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['id_contrat'] . '</td>';
                if (($row["date_debut_validation"] == "0000-00-00")){
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                '. date('d-m-Y', strtotime($row['date_debut'])).'
                                <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-materiel" data-id-sortie-materiel=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                                </td>';
                }else{
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                '. date('d-m-Y', strtotime($row['date_debut'])).'
                                <img style= "width:55px; height:45px;" src="sortievalide.png">
                                </td>';
                }
                if (($row["date_fin_validation"] == "0000-00-00")){
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                '. date('d-m-Y', strtotime($row['date_fin'])).'
                                <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-materiel" data-id-retour-materiel=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                                </td>';
                }else{
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                '. date('d-m-Y', strtotime($row['date_fin'])).'
                                <img style= "width:55px; height:45px;" src="entreevalide.png">
                                </td>';
                }
                $value .= '
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_dep'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_agence_ret'] . '</td>'; 
                if ($row['nom_entreprise'] == ""){
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom'] . '</td>';
                }else if ($row['nom'] == ""){
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . '</td>';
                }else{
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                }
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['email'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['designation_contrat'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['num_serie_contrat'] . '</td> 
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['duree'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['prix'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['caution'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['mode_de_paiement'] . '</td>';
                if ($row["contratsigne"] == ""){
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
                }else{
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
                }
            $value .= '<td class="border-top-0" bgcolor="'.$style.'">';
            if ($_SESSION['Role'] != "superadmin") {
                $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-materiel" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                        <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                        <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
            }
            $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel" data-id5=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td></tr>';
        }else{
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>';
                if (($row["date_debut_validation"] == "0000-00-00")){
                    $value .= '<td class="border-top-0">
                                '. date('d-m-Y', strtotime($row['date_debut'])).'
                                <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-materiel" data-id-sortie-materiel=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                                </td>';
                }else{
                    $value .= '<td class="border-top-0">
                                '. date('d-m-Y', strtotime($row['date_debut'])).'
                                <img style= "width:55px; height:45px;" src="sortievalide.png">
                                </td>';
                }
                if (($row["date_fin_validation"] == "0000-00-00")){
                    $value .= '<td class="border-top-0">
                                '. date('d-m-Y', strtotime($row['date_fin'])).'
                                <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-materiel" data-id-retour-materiel=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                                </td>';
                }else{
                    $value .= '<td class="border-top-0">
                                '. date('d-m-Y', strtotime($row['date_fin'])).'
                                <img style= "width:55px; height:45px;" src="entreevalide.png">
                                </td>';
                }
                $value .= '
                <td class="border-top-0">' . $row['lieu_dep'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
                if ($row['nom_entreprise'] == ""){
                    $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
                }else if ($row['nom'] == ""){
                    $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
                }else{
                    $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                }
                $value .= '<td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . $row['designation_contrat'] . '</td>
                <td class="border-top-0">' . $row['num_serie_contrat'] . '</td> 
                <td class="border-top-0">' . $row['duree'] . '</td>
                <td class="border-top-0">' . $row['prix'] . '</td>
                <td class="border-top-0">' . $row['caution'] . '</td>
                <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
                if ($row["contratsigne"] == ""){
                    $value .= '<td class="border-top-0"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
                }else{
                    $value .= '<td class="border-top-0"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
                }
            $value .= '<td class="border-top-0">';
            if ($_SESSION['Role'] != "superadmin") {
                $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-materiel" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                        <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                        <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
            }
            $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel" data-id5=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td></tr>';
        }
        $queryavenant = "SELECT * 
        FROM contrat_client_avenant AS C
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat_avenant =C.id_contrat_avenant 
        WHERE C.id_contrat_client = ".$row['id_contrat'];
        $resultavenant = mysqli_query($conn, $queryavenant);
        if (mysqli_num_rows($resultavenant) > 0) {
            while ($rowavenant = mysqli_fetch_assoc($resultavenant)) {
            $value .= '<tr><td class="border-top-0" style="background-color:#F2F2F2;"></td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['debut_contrat_avenant'])) . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['fin_contrat_avenant'])) . '</td> 
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_dep'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_agence_ret'] . '</td>';
            if ($row['nom_entreprise'] == ""){
                $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom'] . '</td>';
            }else if ($row['nom'] == ""){
                $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . '</td>';
            }else{
                $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
            }
            $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['email'] . '</td> 
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $rowavenant['designation_contrat'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $rowavenant['num_serie_contrat'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['duree'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['prix'] . '</td> 
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['caution'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['mode_de_paiement'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;"></td>
            <td class="border-top-0" >
                <button type="button" title="Modifier le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-avenant" data-id1=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-edit"></i></i></button>
                <button type="button" title="Télécharger le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-contrat-avenant-materiel" data-id=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-download"></i></i></button>
            </td></tr>'; 
            }
        }
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
// Afficher contrat materiel
function display_contrat_record_pack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");

    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email du client</th>
        <th class="border-top-0">Désignation Pack</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Nombre de kilomètres inclus</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Contrat Signé</th> 
        <th class="border-top-0">Action</th>     
        </tr>';

    if ($id_agence != "0") {
        $query = " SELECT DISTINCT C.id_contrat,C.duree,C.caution,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,C.contratsigne,
        P.designation_pack,
        CL.nom,CL.nom_entreprise,CL.email,
        A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
        FROM contrat_client AS C 
        LEFT JOIN group_packs AS P ON P.id_group_packs=C.id_group_pack
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
        LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
        LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
        WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00'))
         AND  etat_contrat != 'S'
         AND C.type_location = 'Pack'
        AND C.id_agence = $id_agence ";
    } else {
        $query = " SELECT DISTINCT C.id_contrat,C.duree,C.caution,C.date_debut,C.date_debut_validation,C.date_fin_validation,C.date_fin,C.prix,C.mode_de_paiement,C.NbrekmInclus,C.contratsigne,
        P.designation_pack,
        CL.nom,CL.nom_entreprise,CL.email,
        A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
        FROM contrat_client AS C 
        LEFT JOIN group_packs AS P ON P.id_group_packs=C.id_group_pack
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
        LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
        LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
        WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00'))
         AND  etat_contrat != 'S'
         AND C.type_location = 'Pack' ";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ( (($row["date_fin"] < $date) && ($row["date_fin_validation"] == "0000-00-00")) || (($row["date_fin"] < $date) && ($row["date_debut_validation"] == "0000-00-00"))){
            $style = "#FF8000";
            $value .= '<tr>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['id_contrat'] . '</td>';
            if (($row["date_debut_validation"] == "0000-00-00")){
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                            '.date('d-m-Y', strtotime($row['date_debut'])).'
                            <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-pack" data-id-sortie-pack=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                            </td>';
            }else{
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                            '. date('d-m-Y', strtotime($row['date_debut'])).'
                            <img style= "width:55px; height:45px;" src="sortievalide.png">
                        </td>';
            }
            if (($row["date_fin_validation"] == "0000-00-00")){
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                            '. date('d-m-Y', strtotime($row['date_fin'])).'
                            <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-pack" data-id-retour-pack=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                            </td>';
            }else {
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                            '. date('d-m-Y', strtotime($row['date_fin'])).' 
                            <img style= "width:55px; height:45px;" src="entreevalide.png">
                        </td>';
            }
            $value .= '
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_dep'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_agence_ret'] . '</td>'; 
            if ($row['nom_entreprise'] == ""){
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom'] . '</td>';
            }else if ($row['nom'] == ""){
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . '</td>';
            }else{
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
            }
            $value .= '
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['email'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['designation_pack'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['duree'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['prix'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['caution'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['NbrekmInclus'] . '</td>
            <td class="border-top-0" bgcolor="'.$style.'">' . $row['mode_de_paiement'] . '</td>';
            if ($row["contratsigne"] == ""){
                $value .= '<td class="border-top-0" bgcolor="'.$style.'"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
            }else{
                $value .= '<td class="border-top-0" bgcolor="'.$style.'"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
            }
            $value .= '<td class="border-top-0" bgcolor="'.$style.'">';
            if ($_SESSION['Role'] != "superadmin") {
                $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-pack" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                        <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-pack" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                        <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
            }
            $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td></tr>';
        }else{
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>';
                if (($row["date_debut_validation"] == "0000-00-00")){
                    $value .= '<td class="border-top-0">
                                '.date('d-m-Y', strtotime($row['date_debut'])).'
                                <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-pack" data-id-sortie-pack=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                                </td>';
                }else{
                    $value .= '<td class="border-top-0">
                                '. date('d-m-Y', strtotime($row['date_debut'])).'
                                <img style= "width:55px; height:45px;" src="sortievalide.png">
                            </td>';
                }
                if (($row["date_fin_validation"] == "0000-00-00")){
                    $value .= '<td class="border-top-0">
                                '. date('d-m-Y', strtotime($row['date_fin'])).'
                                <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-pack" data-id-retour-pack=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                                </td>';
                }else {
                    $value .= '<td class="border-top-0">
                                '. date('d-m-Y', strtotime($row['date_fin'])).' 
                                <img style= "width:55px; height:45px;" src="entreevalide.png">
                            </td>';
                }
                $value .= '
                <td class="border-top-0">' . $row['lieu_dep'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
                if ($row['nom_entreprise'] == ""){
                    $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
                }else if ($row['nom'] == ""){
                    $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
                }else{
                    $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                }
                $value .= '
                <td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . $row['designation_pack'] . '</td>
                <td class="border-top-0">' . $row['duree'] . '</td>
                <td class="border-top-0">' . $row['prix'] . '</td>
                <td class="border-top-0">' . $row['caution'] . '</td>
                <td class="border-top-0">' . $row['NbrekmInclus'] . '</td>
                <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
                if ($row["contratsigne"] == ""){
                    $value .= '<td class="border-top-0"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
                }else{
                    $value .= '<td class="border-top-0"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
                }
            $value .= '<td class="border-top-0">';
            if ($_SESSION['Role'] != "superadmin") {
                $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-pack" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                        <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-pack" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                        <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
            }
            $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td></tr>';
        }
        $queryavenant = "SELECT * 
        FROM contrat_client_avenant AS C
        LEFT JOIN group_packs AS P ON P.id_group_packs=C.id_pack_avenant
        WHERE C.id_contrat_client = ".$row['id_contrat'];
        $resultavenant = mysqli_query($conn, $queryavenant);
        if (mysqli_num_rows($resultavenant) > 0) {
            while ($rowavenant = mysqli_fetch_assoc($resultavenant)) {
            $value .= '<tr><td class="border-top-0" style="background-color:#F2F2F2;"></td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['debut_contrat_avenant'])) . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['fin_contrat_avenant'])) . '</td> 
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_dep'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_agence_ret'] . '</td>';
            if ($row['nom_entreprise'] == ""){
                $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom'] . '</td>';
            }else if ($row['nom'] == ""){
                $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . '</td>';
            }else{
                $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
            }
            $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['email'] . '</td> 
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $rowavenant['designation_pack'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['duree'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['prix'] . '</td> 
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['caution'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['NbrekmInclus'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['mode_de_paiement'] . '</td>
            <td class="border-top-0" style="background-color:#F2F2F2;"></td>
            <td class="border-top-0" >                
                <button type="button" title="Modifier le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-avenant" data-id1=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-edit"></i></i></button>
                <button type="button" title="Télécharger le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-contrat-avenant-pack" data-id=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-download"></i></i></button>
            </td></tr>'; 
        }
        }
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// Afficher contrat materiel
function display_contrat_archived_pack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de contrat</th>
        <th class="border-top-0">Type de location</th>
        <th class="border-top-0">Véhicule</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">Date début</th>
        <th class="border-top-0">Date fin</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Assurance</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">N° de chéque Caution</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Action</th>   
        </tr>';
    $query = " SELECT DISTINCT CL.nom,V.type,V.pimm,C.id_contrat,C.date_contrat,C.duree,C.caution,C.type_location,C.num_cb_caution,C.etat_contrat,
    C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,CL.nom,CL.cin 
        FROM contrat_client AS C 
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
        LEFT JOIN voiture AS V ON V.id_voiture=C.id_voiture
         WHERE DATE(NOW()) > C.date_fin
          AND  C.type_location = 'Pack'
          AND  C.etat_contrat = 'A'
          AND C.id_agence = $id_agence ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['type'] . '</br>' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['assurance'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['num_cb_caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
            <td class="border-top-0">' . $row['nom'] . '</td>                
            <td class="border-top-0">
                <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-pack" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-pack" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td>   
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_contrat_historique_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">ID Contrat</th>
        <th class="border-top-0">Type Contrat</th>
        <th class="border-top-0">Utilisateur</th>
        <th class="border-top-0">Activité</th>
        <th class="border-top-0">Date d\'activité</th>
        <th class="border-top-0">Les modifications</th>
        <th class="border-top-0">Action</th>
        </tr>';
    if ($id_agence != "0") {
        $query = ("SELECT HC.id_historique_contrat,HC.id_contrat_HC,HC.action,HC.date_action,HC.update_contrat,C.type_location,U.nom_user
        from historique_contrat AS HC
        JOIN contrat_client AS C ON HC.id_contrat_HC = C.id_contrat 
        JOIN user AS U ON HC.id_user_HC = U.id_user
        AND U.id_agence = $id_agence
        ORDER BY HC.id_historique_contrat DESC");
    } else {
        $query = ("SELECT HC.id_historique_contrat,HC.id_contrat_HC,HC.action,HC.date_action,HC.update_contrat,C.type_location,U.nom_user
        from historique_contrat AS HC
        JOIN contrat_client AS C ON HC.id_contrat_HC = C.id_contrat 
        JOIN user AS U ON HC.id_user_HC = U.id_user
        ORDER BY HC.id_historique_contrat DESC");
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['action'] == "Ajout") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #2cd07e!important";
            $rowETAT = "Ajout contrat";
        } elseif ($row['action'] == "Suppression") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ff5050!important";
            $rowETAT = "Suppression contrat";
        } elseif ($row['action'] == "Modification") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ffc36d!important";
            $rowETAT = "Modification contrat";
        } elseif ($row['action'] == "Validation de sortie") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #FFA500!important";
            $rowETAT = "Validation de sortie";
        } elseif ($row['action'] == "Validation de retour") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #FFA500!important";
            $rowETAT = "Validation de retour";
        }
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_historique_contrat'] . '</td>
            <td class="border-top-0">' . $row['id_contrat_HC'] . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['nom_user'] . '</td>
            <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>
            <td class="border-top-0">' . $row['date_action'] . '</td>
            <td class="border-top-0">' . $row['update_contrat'] . '</td>';
        if ($row['action'] != "Suppression") {
            if ($row['type_location'] == "Vehicule") {
                $value .= '<td class="border-top-0">
                    <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client" data-id3=' . $row['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                </td>';
            } else if ($row['type_location'] == "Materiel") {
                $value .= '<td class="border-top-0">
                    <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel" data-id5=' . $row['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                </td>';
            } else {
                $value .= '<td class="border-top-0">
                    <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack" data-id3=' . $row['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                </td>';
            }
        }
        $value .= '</tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function searchHistoriqueContrat()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">ID Contrat</th>
        <th class="border-top-0">Type Contrat</th>
        <th class="border-top-0">Utilisateur</th>
        <th class="border-top-0">Activité</th>
        <th class="border-top-0">Date d\'activité</th>
        <th class="border-top-0">Les modifications</th>
        <th class="border-top-0">Action</th>
        </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != 0) {
            $query = ("SELECT HC.id_historique_contrat,HC.id_contrat_HC,HC.action,HC.date_action,HC.update_contrat,C.type_location,U.nom_user
            from historique_contrat AS HC
            JOIN contrat_client AS C ON HC.id_contrat_HC = C.id_contrat 
            JOIN user AS U ON HC.id_user_HC = U.id_user
            AND U.id_agence = $id_agence
            AND   (id_historique_contrat LIKE ('%" . $search . "%')
                    OR id_contrat_HC LIKE ('%" . $search . "%')
                    OR type_location LIKE ('%" . $search . "%')
                    OR nom_user LIKE ('%" . $search . "%')
                    OR action LIKE ('%" . $search . "%')
                    OR date_action LIKE ('%" . $search . "%')  )
                    ORDER BY id_historique_contrat DESC");
        } else {
            $query = ("SELECT HC.id_historique_contrat,HC.id_contrat_HC,HC.action,HC.date_action,HC.update_contrat,C.type_location,U.nom_user
            from historique_contrat AS HC
            JOIN contrat_client AS C ON HC.id_contrat_HC = C.id_contrat 
            JOIN user AS U ON HC.id_user_HC = U.id_user
            AND   (id_historique_contrat LIKE ('%" . $search . "%')
                    OR id_contrat_HC LIKE ('%" . $search . "%')
                    OR type_location LIKE ('%" . $search . "%')
                    OR nom_user LIKE ('%" . $search . "%')
                    OR action LIKE ('%" . $search . "%')
                    OR date_action LIKE ('%" . $search . "%')  )
                    ORDER BY id_historique_contrat DESC");
        }
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['action'] == "Ajout") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #2cd07e!important";
                    $rowETAT = "Ajout contrat";
                } elseif ($row['action'] == "Suppression") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ff5050!important";
                    $rowETAT = "Suppression contrat";
                } elseif ($row['action'] == "Modification") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ffc36d!important";
                    $rowETAT = "Modification contrat";
                } elseif ($row['action'] == "Validation de sortie") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #FFA500!important";
                    $rowETAT = "Validation de sortie";
                } elseif ($row['action'] == "Validation de retour") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #FFA500!important";
                    $rowETAT = "Validation de retour";
                }
                $value .= '
            <tr>
            <td class="border-top-0">' . $row['id_historique_contrat'] . '</td>
            <td class="border-top-0">' . $row['id_contrat_HC'] . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['nom_user'] . '</td>
            <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>
            <td class="border-top-0">' . $row['date_action'] . '</td>
            <td class="border-top-0">' . $row['update_contrat'] . '</td>';
                if ($row['action'] != "Suppression") {
                    if ($row['type_location'] == "Vehicule") {
                        $value .= '<td class="border-top-0">
                    <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client" data-id3=' . $row['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                </td>';
                    } else if ($row['type_location'] == "Materiel") {
                        $value .= '<td class="border-top-0">
                    <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel" data-id5=' . $row['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                </td>';
                    } else {
                        $value .= '<td class="border-top-0">
                    <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack" data-id3=' . $row['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                </td>';
                    }
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_historique_record();
    }
}

function searchHistoriqueUserContrat()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">ID Contrat</th>
        <th class="border-top-0">Type Contrat</th>
        <th class="border-top-0">Utilisateur</th>
        <th class="border-top-0">Activité</th>
        <th class="border-top-0">Date d\'activité</th>
        <th class="border-top-0">Les modifications</th>
        <th class="border-top-0">Action</th>
        </tr>';
    if ($_POST['queryuser'] != "0") {
        $search = $_POST['queryuser'];
        if ($search == 0) {
            if ($id_agence != 0) {
                $query = ("SELECT HC.id_historique_contrat,HC.id_contrat_HC,HC.action,HC.date_action,HC.update_contrat,C.type_location,U.nom_user
                from historique_contrat AS HC
                JOIN contrat_client AS C ON HC.id_contrat_HC = C.id_contrat 
                JOIN user AS U ON HC.id_user_HC = U.id_user
                AND U.id_agence = $id_agence
                ORDER BY HC.id_historique_contrat DESC");
            } else {
                $query = ("SELECT HC.id_historique_contrat,HC.id_contrat_HC,HC.action,HC.date_action,HC.update_contrat,C.type_location,U.nom_user
                from historique_contrat AS HC
                JOIN contrat_client AS C ON HC.id_contrat_HC = C.id_contrat 
                JOIN user AS U ON HC.id_user_HC = U.id_user
                ORDER BY HC.id_historique_contrat DESC");
            }
        } else {
            if ($id_agence != 0) {
                $query = ("SELECT HC.id_historique_contrat,HC.id_contrat_HC,HC.action,HC.date_action,HC.update_contrat,C.type_location,U.nom_user
                from historique_contrat AS HC
                JOIN contrat_client AS C ON HC.id_contrat_HC = C.id_contrat 
                JOIN user AS U ON HC.id_user_HC = U.id_user
                AND HC.id_user_HC = '$search'
                AND U.id_agence = $id_agence
                ORDER BY HC.id_historique_contrat DESC");
            } else {
                $query = ("SELECT HC.id_historique_contrat,HC.id_contrat_HC,HC.action,HC.date_action,HC.update_contrat,C.type_location,U.nom_user
                from historique_contrat AS HC
                JOIN contrat_client AS C ON HC.id_contrat_HC = C.id_contrat 
                JOIN user AS U ON HC.id_user_HC = U.id_user
                AND HC.id_user_HC = '$search'
                ORDER BY HC.id_historique_contrat DESC");
            }
        }
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['action'] == "Ajout") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #2cd07e!important";
                    $rowETAT = "Ajout contrat";
                } elseif ($row['action'] == "Suppression") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ff5050!important";
                    $rowETAT = "Suppression contrat";
                } elseif ($row['action'] == "Modification") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ffc36d!important";
                    $rowETAT = "Modification contrat";
                } elseif ($row['action'] == "Validation de sortie") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #FFA500!important";
                    $rowETAT = "Validation de sortie";
                } elseif ($row['action'] == "Validation de retour") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #FFA500!important";
                    $rowETAT = "Validation de retour";
                }
                $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_historique_contrat'] . '</td>
                <td class="border-top-0">' . $row['id_contrat_HC'] . '</td>
                <td class="border-top-0">' . $row['type_location'] . '</td>
                <td class="border-top-0">' . $row['nom_user'] . '</td>
                <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>
                <td class="border-top-0">' . $row['date_action'] . '</td>
                <td class="border-top-0">' . $row['update_contrat'] . '</td>';
                if ($row['action'] != "Suppression") {
                    if ($row['type_location'] == "Vehicule") {
                        $value .= '<td class="border-top-0">
                        <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client" data-id3=' . $row['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                    </td>';
                    } else if ($row['type_location'] == "Materiel") {
                        $value .= '<td class="border-top-0">
                        <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel" data-id5=' . $row['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                    </td>';
                    } else {
                        $value .= '<td class="border-top-0">
                        <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack" data-id3=' . $row['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                    </td>';
                    }
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        if ($id_agence != 0) {
            $query1 = ("SELECT HC.id_historique_contrat,HC.id_contrat_HC,HC.action,HC.date_action,HC.update_contrat,C.type_location,U.nom_user
            from historique_contrat AS HC
            JOIN contrat_client AS C ON HC.id_contrat_HC = C.id_contrat 
            JOIN user AS U ON HC.id_user_HC = U.id_user
            AND U.id_agence = $id_agence
            ORDER BY HC.id_historique_contrat DESC");
        } else {
            $query1 = ("SELECT HC.id_historique_contrat,HC.id_contrat_HC,HC.action,HC.date_action,HC.update_contrat,C.type_location,U.nom_user
            from historique_contrat AS HC
            JOIN contrat_client AS C ON HC.id_contrat_HC = C.id_contrat 
            JOIN user AS U ON HC.id_user_HC = U.id_user
            ORDER BY HC.id_historique_contrat DESC");
        }

        $result1 = mysqli_query($conn, $query1);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            if ($row1['action'] == "Ajout") {
                $color = "badge bg-light-info text-white fw-normal";
                $color1 = "background-color: #2cd07e!important";
                $rowETAT = "Ajout contrat";
            } elseif ($row1['action'] == "Suppression") {
                $color = "badge bg-light-info text-white fw-normal";
                $color1 = "background-color: #ff5050!important";
                $rowETAT = "Suppression contrat";
            } elseif ($row1['action'] == "Modification") {
                $color = "badge bg-light-info text-white fw-normal";
                $color1 = "background-color: #ffc36d!important";
                $rowETAT = "Modification contrat";
            } elseif ($row1['action'] == "Validation de sortie") {
                $color = "badge bg-light-info text-white fw-normal";
                $color1 = "background-color: #FFA500!important";
                $rowETAT = "Validation de sortie";
            } elseif ($row1['action'] == "Validation de retour") {
                $color = "badge bg-light-info text-white fw-normal";
                $color1 = "background-color: #FFA500!important";
                $rowETAT = "Validation de retour";
            }
            $value .= '
            <tr>
                <td class="border-top-0">' . $row1['id_historique_contrat'] . '</td>
                <td class="border-top-0">' . $row1['id_contrat_HC'] . '</td>
                <td class="border-top-0">' . $row1['type_location'] . '</td>
                <td class="border-top-0">' . $row1['nom_user'] . '</td>
                <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>
                <td class="border-top-0">' . $row1['date_action'] . '</td>
                <td class="border-top-0">' . $row1['update_contrat'] . '</td>';
            if ($row1['action'] != "Suppression") {
                if ($row1['type_location'] == "Vehicule") {
                    $value .= '<td class="border-top-0">
                        <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client" data-id3=' . $row1['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                    </td>';
                } else if ($row1['type_location'] == "Materiel") {
                    $value .= '<td class="border-top-0">
                        <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel" data-id5=' . $row1['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                    </td>';
                } else {
                    $value .= '<td class="border-top-0">
                        <button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack" data-id3=' . $row1['id_contrat_HC'] . '><i class="fas fa-download"></i></i></button>
                    </td>';
                }
            }
            $value .= '</tr>';
        }
        $value .= '</table>';
        echo $value;
    }
}

function get_contrat_materiel_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT C.id_contrat,C.duree,C.type_location,C.date_debut,C.date_fin,C.prix,C.mode_de_paiement,
    C.caution,C.cautioncheque,C.moyen_caution,C.NbrekmInclus,C.num_cheque_caution,C.num_cb_caution,C.date_prelevement,CL.nom 
    FROM contrat_client as C LEFT JOIN client as CL on C.id_client =CL.id_client 
    WHERE id_contrat='$ContratId '";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $contrat_data = [];
        $contrat_data[0] = $row['id_contrat'];
        $contrat_data[1] = $row['date_fin'];
        $contrat_data[2] = $row['type_location'];
        $contrat_data[3] = $row['date_debut'];
        // $contrat_data[4] = $row['date_debut'];
        $contrat_data[5] = $row['prix'];
        $contrat_data[6] = $row['NbrekmInclus'];
        $contrat_data[7] = $row['mode_de_paiement'];
        $contrat_data[8] = $row['caution'];
        $contrat_data[10] = $row['duree'];
        $contrat_data[11] = $row['moyen_caution'];
        $contrat_data[12] = $row['num_cheque_caution'];
        $contrat_data[13] = $row['num_cb_caution'];
        $contrat_data[14] = $row['cautioncheque'];
    }
    echo json_encode($contrat_data);
}
function get_contrat_pack_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT C.id_contrat,C.duree,C.type_location,C.date_debut,C.date_fin,C.prix,C.mode_de_paiement,
    C.caution,C.NbrekmInclus,C.moyen_caution,C.num_cheque_caution,C.num_cb_caution,C.cautioncheque,C.date_prelevement,CL.nom 
    FROM contrat_client as C LEFT JOIN client as CL on C.id_client =CL.id_client 
    WHERE id_contrat='$ContratId '";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $contrat_data = [];
        $contrat_data[0] = $row['id_contrat'];
        $contrat_data[1] = $row['date_debut'];
        $contrat_data[2] = $row['date_fin'];
        $contrat_data[3] = $row['duree'];
        $contrat_data[4] = $row['prix'];
        $contrat_data[7] = $row['mode_de_paiement'];
        $contrat_data[8] = $row['date_prelevement'];
        $contrat_data[9] = $row['NbrekmInclus'];
        $contrat_data[10] = $row['moyen_caution'];
        $contrat_data[5] = $row['caution'];
        $contrat_data[6] = $row['num_cheque_caution'];
        $contrat_data[11] = $row['num_cb_caution'];
        $contrat_data[12] = $row['cautioncheque'];
    }
    echo json_encode($contrat_data);
}

function InsertContratMateriel()
{
    global $conn;
    $ContratType = "Materiel";
    $ContratDuree = isset($_POST['ContratDuree']) ? $_POST['ContratDuree'] : NULL;
    $ContratDateDebut = isset($_POST['ContratDateDebut']) ? $_POST['ContratDateDebut'] : NULL;
    $ContratDateFin = isset($_POST['ContratDateFin']) ? $_POST['ContratDateFin'] : NULL;
    $ContratClient = isset($_POST['ContratClient']) ? $_POST['ContratClient'] : NULL;
    $ContratAssurence = isset($_POST['ContratAssurence']) ? $_POST['ContratAssurence'] : NULL;
    $AgenceDepClient = $_SESSION['id_agence'];
    $AgenceRetClient = isset($_POST['AgenceRetClient']) ? $_POST['AgenceRetClient'] : NULL;
    $ContratPrixContrat = isset($_POST['ContratPrixContrat']) ? $_POST['ContratPrixContrat'] : NULL;
    $ContratPaiement = isset($_POST['ContratPaiement']) ? $_POST['ContratPaiement'] : NULL;
    $ContratDatePaiement = isset($_POST['ContratDatePaiement']) ? $_POST['ContratDatePaiement'] : NULL;
    $ContratCaution = isset($_POST['ContratCaution']) ? $_POST['ContratCaution'] : NULL;
    $ContratCautionCheque = isset($_POST['ContratCautionCheque']) ? $_POST['ContratCautionCheque'] : NULL;
    $ContratNbreKilometre = isset($_POST['ContratNbreKilometre']) ? $_POST['ContratNbreKilometre'] : NULL;
    $ContratnumCaution = isset($_POST['ContratNumCaution']) ? $_POST['ContratNumCaution'] : NULL;
    $ContratNumCautionCB = isset($_POST['ContratNumCautionCB']) ? $_POST['ContratNumCautionCB'] : NULL;
    $moyenCaution = isset($_POST['moyenCaution']) ? $_POST['moyenCaution'] : NULL;
    $contratmaterielagence = isset($_POST['contratmaterielagence']) ? $_POST['contratmaterielagence'] : NULL;
    $Id_materiel = isset($_POST['Id_materiel']) ? $_POST['Id_materiel'] : NULL;
    $id_user = $_SESSION['id_user'];
    $typecontratavenant = $_POST['typecontratavenant'];
    $ContratAvenant = $_POST['ContratAvenant'];
    $ContratAvenantDateDebut = $_POST['ContratAvenantDateDebut'];
    $ContratAvenantDateFin = $_POST['ContratAvenantDateFin'];

    if($typecontratavenant == "CONTRAT AVENANT"){
        $querydatecontrat = "SELECT date_debut,date_fin FROM contrat_client WHERE id_contrat='$ContratAvenant'";
        $resultdatecontrat = mysqli_query($conn, $querydatecontrat);
        $rowdatecontrat = mysqli_fetch_assoc($resultdatecontrat);
        $datedebutcontrat = $rowdatecontrat['date_debut'];
        $datefincontrat = $rowdatecontrat['date_fin'];
        if(($datedebutcontrat <= $ContratAvenantDateDebut) && ($datefincontrat >= $ContratAvenantDateFin)){
            $query = "INSERT INTO 
                    contrat_client_avenant(debut_contrat_avenant,fin_contrat_avenant,id_voiture_avenant,id_materiel_avenant,id_pack_avenant,id_contrat_client) 
                    VALUES ('$ContratAvenantDateDebut','$ContratAvenantDateFin','0','$Id_materiel','0' ,'$ContratAvenant')";
            $result = mysqli_query($conn, $query);
            if($result){
                $query_get_max_id_contrat = "SELECT max(id_contrat_avenant)
                    FROM contrat_client_avenant";
                    $result_query_get_max_id_contrat = mysqli_query($conn, $query_get_max_id_contrat);
                    $row = mysqli_fetch_row($result_query_get_max_id_contrat);
                    $id_contrat_avenant = $row[0];
                $query_materiels ="SELECT code_materiel,designation,num_serie_materiels,id_materiels_agence 
                    FROM materiels,materiels_agence
                    where materiels.id_materiels = materiels_agence.id_materiels 
                    AND id_materiels_agence = '$Id_materiel'";
                $exection_materiel = mysqli_query($conn, $query_materiels);
                $resultat = mysqli_fetch_array($exection_materiel);
                $querymaterielcontrat = "INSERT INTO materiel_contrat_client
                (id_contrat_avenant,id_materiels_agence,num_serie_contrat,code_materiel_contrat,designation_contrat,quantite_contrat,ContratDateDebut,ContratDateFin) 
                VALUES ('$id_contrat_avenant','$resultat[id_materiels_agence]','$resultat[num_serie_materiels]','$resultat[code_materiel]','$resultat[designation]','1','$ContratAvenantDateDebut', '$ContratAvenantDateFin')";
                $resultmaterielcontrat = mysqli_query($conn, $querymaterielcontrat);

                $query_materiels_comp ="SELECT * FROM composant_materiels where id_materiels_agence = '$resultat[id_materiels_agence]'";
                $exection_materiel_comp = mysqli_query($conn, $query_materiels_comp);
                while ($resultat_comp = mysqli_fetch_array($exection_materiel_comp)) {
                    $query_composant = "INSERT INTO composant_materiels_contrat
                        (id_contrat_avenant,id_materiels_agence,designation_composant,num_serie_composant) 
                        VALUES ('$id_contrat_avenant','$Id_materiel','$resultat_comp[designation_composant]','$resultat_comp[num_serie_composant]')";
                    $result_composant = mysqli_query($conn, $query_composant);
                }
                echo "<div class='text-success'>Le contrat avenant est ajouté avec succés</div>";
            }
        }else{
            echo "<div class='text-danger'>SVP! Vérifiez les dates</div>";
        }   

    }else{
        if ($contratmaterielagence == NULL) {
            $id_agence = $_SESSION['id_agence'];;
        } else {
            $id_agence = $contratmaterielagence;
        }
        $AgenceDepClient = $id_agence;
        if ($ContratAssurence == "") {
            $ContratAssurence = "K2";
        }

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            return;
        }
        if ($id_agence != "0") {
            if ($AgenceRetClient == "") {
                $AgenceRetClient = $AgenceDepClient;
            }
            if($typecontratavenant == "CONTRAT CADRE"){
                $query = "INSERT INTO 
                contrat_client(id_client,id_agencedep,id_agenceret,id_voiture,id_materiels_contrat,id_group_pack,type_location,duree,date_debut,date_fin,
                prix,assurance,mode_de_paiement,caution,cautioncheque,NbrekmInclus,moyen_caution,num_cheque_caution,num_cb_caution,date_prelevement,contratcadre,id_user,id_agence) 
                VALUES ('$ContratClient','$AgenceDepClient','$AgenceRetClient','0','$Id_materiel','0' ,'$ContratType','$ContratDuree','$ContratDateDebut',
                '$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement','$ContratCaution','$ContratCautionCheque','$ContratNbreKilometre','$moyenCaution','$ContratnumCaution','$ContratNumCautionCB','$ContratDatePaiement','1',
                '$id_user','$id_agence')";
            }else{
                $query = "INSERT INTO 
                contrat_client(id_client,id_agencedep,id_agenceret,id_voiture,id_materiels_contrat,id_group_pack,type_location,duree,date_debut,date_fin,
                prix,assurance,mode_de_paiement,caution,cautioncheque,NbrekmInclus,moyen_caution,num_cheque_caution,num_cb_caution,date_prelevement,contratcadre,id_user,id_agence) 
                VALUES ('$ContratClient','$AgenceDepClient','$AgenceRetClient','0','$Id_materiel','0' ,'$ContratType','$ContratDuree','$ContratDateDebut',
                '$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement','$ContratCaution','$ContratCautionCheque','$ContratNbreKilometre','$moyenCaution','$ContratnumCaution','$ContratNumCautionCB','$ContratDatePaiement','0',
                '$id_user','$id_agence')";
            }
            $result = mysqli_query($conn, $query);

            $queryContratID = "SELECT id_contrat,date_ajoute FROM contrat_client WHERE id_contrat=(SELECT max(id_contrat) from contrat_client)";
            $resultContratID = mysqli_query($conn, $queryContratID);

            while ($row = mysqli_fetch_assoc($resultContratID)) {
                $rowid = $row['id_contrat'];
                $rowdate = $row['date_ajoute'];
            }

            if ($result) {
                $query_get_max_id_contrat = "SELECT max(id_contrat)
                FROM contrat_client WHERE type_location ='Materiel'";
                $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
                $row = mysqli_fetch_row($result_query_get_max_id_contra);
                $id_contrat = $row[0];
                $query_materiels =    "SELECT  code_materiel,`designation`, `num_serie_materiels`,id_materiels_agence FROM `materiels`,materiels_agence
                 where 
                 materiels.id_materiels = materiels_agence.id_materiels AND
                 id_materiels_agence = '$Id_materiel'";
                $exection_materiel = mysqli_query($conn, $query_materiels);
                $resultat = mysqli_fetch_array($exection_materiel);

                $querystockMateriel = "UPDATE materiels_agence SET id_agence='$AgenceRetClient' WHERE id_materiels_agence = '$Id_materiel'";
                $resultstockMateriel = mysqli_query($conn, $querystockMateriel);

                $query = "INSERT INTO 
                materiel_contrat_client(id_contrat,id_materiels_agence,num_serie_contrat,code_materiel_contrat,designation_contrat,quantite_contrat,ContratDateDebut,ContratDateFin) 
                VALUES ('$id_contrat','$resultat[id_materiels_agence]','$resultat[num_serie_materiels]','$resultat[code_materiel]','$resultat[designation]','1','$ContratDateDebut', '$ContratDateFin')";
                $result = mysqli_query($conn, $query);
                $query_materiels_comp =    "SELECT  * FROM `composant_materiels` where id_materiels_agence = '$resultat[id_materiels_agence]'";
                $exection_materiel_comp = mysqli_query($conn, $query_materiels_comp);
                while ($resultat_comp = mysqli_fetch_array($exection_materiel_comp)) {
                    $query = "INSERT INTO 
                composant_materiels_contrat(id_contrat,id_materiels_agence,designation_composant,num_serie_composant) 
                VALUES ('$id_contrat','$Id_materiel','$resultat_comp[designation_composant]','$resultat_comp[num_serie_composant]')";
                    $result = mysqli_query($conn, $query);
                }

                $queryContrat = "INSERT INTO  
                 historique_contrat(id_contrat_HC,id_user_HC,action,date_action) 
                 VALUES ('$rowid','$id_user','Ajout','$rowdate')";
                $resultContrat = mysqli_query($conn, $queryContrat);

                $querymailuser = "SELECT email_user FROM user WHERE role='superadmin'";
                $resultmailuser = mysqli_query($conn, $querymailuser);
                while ($rowmailuser = mysqli_fetch_assoc($resultmailuser)) {
                    $mailuser = $rowmailuser['email_user'];
                }
                $querynomuser = "SELECT nom_user FROM user WHERE id_user='$id_user'";
                $resultnomuser = mysqli_query($conn, $querynomuser);
                while ($rownomuser = mysqli_fetch_assoc($resultnomuser)) {
                    $nomuser = $rownomuser['nom_user'];
                }
                $querynomclient = "SELECT nom_entreprise FROM client WHERE id_client='$ContratClient'";
                $resultnomclient = mysqli_query($conn, $querynomclient);
                while ($rownomclient = mysqli_fetch_assoc($resultnomclient)) {
                    $nomclient = $rownomclient['nom_entreprise'];
                }
                
                /////////////////////////Mail AWS/////////////////////////////////
                // require '/var/www/html/Gestion_location/inc/MailAWS/vendor/autoload.php';
                
				// $sender = 'maaloulmedhedi@gmail.com';
                // $senderName = 'K2Location Sender Mail';
                // $recipient = "$mailuser";
                // $usernameSmtp = 'AKIAY2ABOIWIICCHUB4R';
                // $passwordSmtp = 'BD8karZvvhSsE/LQU0BnRXa8KMTKKXr39StWLrNdSAqi';
                // $configurationSet = 'ConfigSet';
                // $host = 'email-smtp.eu-west-3.amazonaws.com';
                // $port = 465;
                // $subject = 'K2Location App (Contrat Location Materiel)';
                // $bodyText =  "";
                // $bodyHtml = "<html><body> Bonjour, <br /> <br />Le contrat numéro $rowid relatif au client $nomclient a été crée le $rowdate avec le montant $ContratPrixContrat.
                // Ce contrat a été crée par $nomuser .</body></html>";
                // $mail = new PHPMailer(true);
                // try {
                //     $mail->isSMTP(true);
                //     $mail->setFrom($sender, $senderName);
                //     $mail->Username   = $usernameSmtp;
                //     $mail->Password   = $passwordSmtp;
                //     $mail->Host       = $host;
                //     $mail->Port       = $port;
                //     $mail->SMTPAuth   = true;
                //     $mail->SMTPSecure = 'ssl';
                //     $mail->CharSet = 'utf-8';
                //     $mail->addAddress($recipient);
                //     $mail->isHTML(true);
                //     $mail->Subject    = $subject;
                //     $mail->Body       = $bodyHtml;
                //     $mail->AltBody    = $bodyText;
                //     $mail->Send();
                //     echo "Email sent!" , PHP_EOL;
                // } catch (Exception $e) {
                //     echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL;
                // }
                $to = "$mailuser";
                $subject = "Ajoutcontratmateriel";
                $message = "Le contrat numéro ".$rowid." relatif au client ".$nomclient." a été crée le ".$rowdate." avec le montant ".$ContratPrixContrat.". Ce contrat a été crée par ".$nomuser."."; 
                $header = "From:appk2contrat@gmail.com \r\n";
                $header .= "Cc:appk2contrat@gmail.com \r\n";
                $header .= "MIME-Version: 1.0\r\n";
                $header .= 'Content-Type: text/plain; charset="utf-8"' . " ";
                mail($to, $subject, $message, $header);
                /////////////////////////Mail AWS/////////////////////////////////
                $date_now = date("Y-m-d H:i:s");
                $liste_user1 = "SELECT * FROM user";
                $liste_user1_query = mysqli_query($conn, $liste_user1);
                while ($row20 = mysqli_fetch_assoc($liste_user1_query)) {
                    $query_voiture = "INSERT INTO 
                    notification(id_user,id_contrat,status,date_creation) 
                    VALUES ('" . $row20["id_user"] . "','" . $rowid . "', 0, '" . $date_now . "')";
                    $query_voiture_s = mysqli_query($conn, $query_voiture);
                }
                ////////////////////////////////////////////////////
                $query_update = "UPDATE client SET etat_client='A' WHERE id_client='$ContratClient'";
                $result_update = mysqli_query($conn, $query_update);
                echo "<div class='text-success'>contrat Ajouté</div>";
            } else {
                echo "<div class='text-danger'>Erreur lors d'ajout d'un matériel</div>";
            }
        } else {
            echo "<div class='text-danger'>SVP! Choisissez l'agence</div>";
        }
    }
}

function InsertContratVoiture()
{
    global $conn;
    $ContratType = "Vehicule";
    $ContratDuree = $_POST['ContratDuree'];
    $ContratDateDebut = $_POST['ContratDateDebut'];
    $ContratDateFin = $_POST['ContratDateFin'];
    $ContratPrixContrat = $_POST['ContratPrixContrat'];
    $ContratAssurence = $_POST['ContratAssurence'];
    $ContratPaiement = $_POST['ContratPaiement'];
    $ContratDatePaiement = $_POST['ContratDatePaiement'];
    $ContratCaution = $_POST['ContratCaution'];
    $ContratCautionCheque = $_POST['ContratCautionCheque'];
    $NbreKilometreContrat = $_POST['NbreKilometreContrat'];
    $ContratMoyenCaution = $_POST['ContratMoyenCaution'];
    $ContratnumCaution = $_POST['ContratNumCaution'];
    $ContratNumCautionCB = $_POST['ContratNumCautionCB'];
    $Contrat_voiture = $_POST['Contrat_voiture'];
    $ContratClient = $_POST['ContratClient'];
    $AgenceRetClient = $_POST['AgenceRetClient'];
    $contratvehiculeagence = $_POST['contratvehiculeagence'];
    $id_user = $_SESSION['id_user'];
    $typecontratavenant = $_POST['typecontratavenant'];
    $ContratAvenant = $_POST['ContratAvenant'];
    $ContratAvenantDateDebut = $_POST['ContratAvenantDateDebut'];
    $ContratAvenantDateFin = $_POST['ContratAvenantDateFin'];
    $checkobgkm = $_POST['checkobgkm'];

    if($typecontratavenant == "CONTRAT AVENANT"){
        $querydatecontrat = "SELECT date_debut,date_fin FROM contrat_client WHERE id_contrat='$ContratAvenant'";
        $resultdatecontrat = mysqli_query($conn, $querydatecontrat);
        $rowdatecontrat = mysqli_fetch_assoc($resultdatecontrat);
        $datedebutcontrat = $rowdatecontrat['date_debut'];
        $datefincontrat = $rowdatecontrat['date_fin'];
        if(($datedebutcontrat <= $ContratAvenantDateDebut) && ($datefincontrat >= $ContratAvenantDateFin)){
            $query = "INSERT INTO 
                    contrat_client_avenant(debut_contrat_avenant,fin_contrat_avenant,id_voiture_avenant,id_materiel_avenant,id_pack_avenant,id_contrat_client) 
                    VALUES ('$ContratAvenantDateDebut','$ContratAvenantDateFin','$Contrat_voiture','0','0' ,'$ContratAvenant')";
            $result = mysqli_query($conn, $query);
            echo "<div class='text-success'>Le contrat avenant est ajouté avec succés</div>";
        }else{
            echo "<div class='text-danger'>SVP! Vérifiez les dates</div>";
        }   
    }else{
        if ($contratvehiculeagence == "") {
            $id_agence = $_SESSION['id_agence'];
        } else {
            $id_agence = $contratvehiculeagence;
        }
        $AgenceDepClient = $id_agence;
        if ($ContratAssurence == "") {
            $ContratAssurence = "K2";
        }
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            return;
        }
        if ($id_agence != "0") {
            if ($Contrat_voiture) {
                if ($AgenceRetClient == "") {
                    $AgenceRetClient = $AgenceDepClient;
                }

                if($typecontratavenant == "CONTRAT CADRE"){
                    $query = "INSERT INTO 
                    contrat_client(id_client,id_agencedep,id_agenceret,id_voiture,id_materiels_contrat,id_group_pack,type_location,duree,date_debut,date_fin,
                    prix,mode_de_paiement,caution,cautioncheque,NbrekmInclus,moyen_caution,num_cheque_caution,num_cb_caution,assurance,date_prelevement,contratcadre,checkkm,id_user,id_agence) 
                    VALUES ('$ContratClient','$AgenceDepClient','$AgenceRetClient','$Contrat_voiture','0','0' ,'$ContratType','$ContratDuree','$ContratDateDebut',
                    '$ContratDateFin','$ContratPrixContrat','$ContratPaiement','$ContratCaution','$ContratCautionCheque','$NbreKilometreContrat','$ContratMoyenCaution','$ContratnumCaution',
                    '$ContratNumCautionCB','$ContratAssurence','$ContratDatePaiement','1','$checkobgkm','$id_user','$id_agence')";
                }else{
                    $query = "INSERT INTO 
                    contrat_client(id_client,id_agencedep,id_agenceret,id_voiture,id_materiels_contrat,id_group_pack,type_location,duree,date_debut,date_fin,
                    prix,mode_de_paiement,caution,cautioncheque,NbrekmInclus,moyen_caution,num_cheque_caution,num_cb_caution,assurance,date_prelevement,checkkm,id_user,id_agence) 
                    VALUES ('$ContratClient','$AgenceDepClient','$AgenceRetClient','$Contrat_voiture','0','0' ,'$ContratType','$ContratDuree','$ContratDateDebut',
                    '$ContratDateFin','$ContratPrixContrat','$ContratPaiement','$ContratCaution','$ContratCautionCheque','$NbreKilometreContrat','$ContratMoyenCaution','$ContratnumCaution',
                    '$ContratNumCautionCB','$ContratAssurence','$ContratDatePaiement','$checkobgkm','$id_user','$id_agence')";
                }
                $result = mysqli_query($conn, $query);
                $queryContratVehiculeID = "SELECT id_contrat,date_ajoute FROM contrat_client WHERE id_contrat=(SELECT max(id_contrat) from contrat_client)";
                $resultContratVehiculeID = mysqli_query($conn, $queryContratVehiculeID);
                while ($row = mysqli_fetch_assoc($resultContratVehiculeID)) {
                    $rowid = $row['id_contrat'];
                    $rowdate = $row['date_ajoute'];
                }
                if ($result) {
    
                    $queryContratVehicule = "INSERT INTO  
                        historique_contrat(id_contrat_HC,id_user_HC,action,date_action) 
                        VALUES ('$rowid','$id_user','Ajout','$rowdate')";
                    $resultContratVehicule = mysqli_query($conn, $queryContratVehicule);
    
                    $querystockVehicule = "UPDATE voiture SET id_agence='$AgenceRetClient' WHERE id_voiture='$Contrat_voiture'";
                    $resultstockVehicule = mysqli_query($conn, $querystockVehicule);
    
                    $querymailuser = "SELECT email_user FROM user WHERE role='superadmin'";
                    $resultmailuser = mysqli_query($conn, $querymailuser);
                    while ($rowmailuser = mysqli_fetch_assoc($resultmailuser)) {
                        $mailuser = $rowmailuser['email_user'];
                    }
                    $querynomuser = "SELECT nom_user FROM user WHERE id_user='$id_user'";
                    $resultnomuser = mysqli_query($conn, $querynomuser);
                    while ($rownomuser = mysqli_fetch_assoc($resultnomuser)) {
                        $nomuser = $rownomuser['nom_user'];
                    }
                    $querynomclient = "SELECT nom_entreprise FROM client WHERE id_client='$ContratClient'";
                    $resultnomclient = mysqli_query($conn, $querynomclient);
                    while ($rownomclient = mysqli_fetch_assoc($resultnomclient)) {
                        $nomclient = $rownomclient['nom_entreprise'];
                    }
                    /////////////////////////Mail AWS/////////////////////////////////
                    // require '/var/www/html/Gestion_location/inc/MailAWS/vendor/autoload.php';
                    
				    // $sender = 'maaloulmedhedi@gmail.com';
                    // $senderName = 'K2Location Sender Mail';
                    // $recipient = "$mailuser";
                    // $usernameSmtp = 'AKIAY2ABOIWIICCHUB4R';
                    // $passwordSmtp = 'BD8karZvvhSsE/LQU0BnRXa8KMTKKXr39StWLrNdSAqi';
                    // $configurationSet = 'ConfigSet';
                    // $host = 'email-smtp.eu-west-3.amazonaws.com';
                    // $port = 465;
                    // $subject = 'Ajoutcontratvoiture';
                    // $bodyText =  "";
                    // $bodyHtml = "<html><body> Bonjour, <br /> <br />Le contrat numéro $rowid relatif au client $nomclient a été crée le $rowdate avec le montant $ContratPrixContrat.
                    // Ce contrat a été crée par $nomuser .</body></html>";
                    // $mail = new PHPMailer(true);
                    // try {
                    //     $mail->isSMTP(true);
                    //     $mail->setFrom($sender, $senderName);
                    //     $mail->Username   = $usernameSmtp;
                    //     $mail->Password   = $passwordSmtp;
                    //     $mail->Host       = $host;
                    //     $mail->Port       = $port;
                    //     $mail->SMTPAuth   = true;
                    //     $mail->SMTPSecure = 'ssl';
                    //     $mail->CharSet = 'utf-8';
                    //     $mail->addAddress($recipient);
                    //     $mail->isHTML(true);
                    //     $mail->Subject    = $subject;
                    //     $mail->Body       = $bodyHtml;
                    //     $mail->AltBody    = $bodyText;
                    //     $mail->Send();
                    //     echo "Email sent!" , PHP_EOL;
                    // } catch (Exception $e) {
                    //     echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL;
                    // }
                    $to = "$mailuser";
                    $subject = "Ajoutcontratvoiture";
                    $message = "Le contrat numéro ".$rowid." relatif au client ".$nomclient." a été crée le ".$rowdate." avec le montant ".$ContratPrixContrat.". Ce contrat a été crée par ".$nomuser."."; 
                    $header = "From:appk2contrat@gmail.com \r\n";
                    $header .= "Cc:appk2contrat@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= 'Content-Type: text/plain; charset="utf-8"' . " ";
                    mail($to, $subject, $message, $header);
                    /////////////////////////Mail AWS/////////////////////////////////
                    $date_now = date("Y-m-d H:i:s");
                    $liste_user1 = "SELECT * FROM user";
                    $liste_user1_query = mysqli_query($conn, $liste_user1);
                    while ($row20 = mysqli_fetch_assoc($liste_user1_query)) {
                        $query_voiture = "INSERT INTO 
                          notification(id_user,id_contrat,status,date_creation) 
                          VALUES ('" . $row20["id_user"] . "','" . $rowid . "', 0, '" . $date_now . "')";
                        $query_voiture_s = mysqli_query($conn, $query_voiture);
                    }
                    //////////////////////////////////////////////////////////////////////
                    $query_update = "UPDATE client SET etat_client='A' WHERE id_client='$ContratClient'";
                    $result_update = mysqli_query($conn, $query_update);
                    echo "<div class='text-success'>Le contrat est ajouté avec succés</div>";
                } else {
                    echo "<div class='text-danger'>Erreur lors d'ajout du contrat</div>";
                }
            } else {
                echo "<div class='text-danger'>Voiture non disponible</div>";
            }
        } else {
            echo "<div class='text-danger'>SVP! Choisissez l'agence</div>";
        }
    }
}


function InsertContrat()
{
    global $conn;
    $ContratmaterielListe = $_POST['ContratmaterielListe'];
    $ContratDate = isset($_POST['ContratDate']) ? $_POST['ContratDate'] : NULL;
    $ContratType = isset($_POST['ContratType']) ? $_POST['ContratType'] : NULL;
    $ContratDuree = isset($_POST['ContratDuree']) ? $_POST['ContratDuree'] : NULL;
    $ContratDateDebut = isset($_POST['ContratDateDebut']) ? $_POST['ContratDateDebut'] : NULL;
    $ContratDateFin = isset($_POST['ContratDateFin']) ? $_POST['ContratDateFin'] : NULL;
    $ContratPrixContrat = isset($_POST['ContratPrixContrat']) ? $_POST['ContratPrixContrat'] : NULL;
    $ContratAssurence = isset($_POST['ContratAssurence']) ? $_POST['ContratAssurence'] : NULL;
    $ContratPaiement = isset($_POST['ContratPaiement']) ? $_POST['ContratPaiement'] : NULL;
    $ContratDatePaiement = isset($_POST['ContratDatePaiement']) ? $_POST['ContratDatePaiement'] : NULL;
    $ContratCaution = isset($_POST['ContratCaution']) ? $_POST['ContratCaution'] : NULL;
    $ContratnumCaution = isset($_POST['ContratNumCaution']) ? $_POST['ContratNumCaution'] : NULL;
    $ContratnumCautionMateriel = isset($_POST['ContratNumCautionMateriel']) ? $_POST['ContratNumCautionMateriel'] : NULL;
    $ContratVoitureModel = isset($_POST['ContratVoitureModel']) ? $_POST['ContratVoitureModel'] : NULL;
    $ContratVoiturePIMM = isset($_POST['ContratVoiturePIMM']) ? $_POST['ContratVoiturePIMM'] : NULL;
    $ContratVoiturekMPrevu = isset($_POST['ContratVoiturekMPrevu']) ? $_POST['ContratVoiturekMPrevu'] : NULL;
    $ContratClient = isset($_POST['ContratClient']) ? $_POST['ContratClient'] : NULL;
    $count = count($ContratmaterielListe);
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        return;
    }
    if ($ContratVoitureModel) {
        //TODO: insert cars records
        $query = "INSERT INTO 
        contrat(id_client,id_voiture,id_materiel,date_contrat,type_location,duree,date_debut,date_fin,prix,assurance,mode_de_paiement,caution,num_cheque_caution,KMPrevu,date_prelevement) 
        VALUES ('$ContratClient','$ContratVoiturePIMM',NULL,'$ContratDate','$ContratType','$ContratDuree','$ContratDateDebut','$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement','$ContratCaution','$ContratnumCaution','$ContratVoiturekMPrevu','$ContratDatePaiement')";
        $result = mysqli_query($conn, $query);
        if ($result) {

            $query_updateC = "UPDATE client SET etat_client='A' WHERE id_client='$ContratClient'";
            $result_update = mysqli_query($conn, $query_updateC);

            echo "<div class='text-success'>contrat véhicule est Ajouté</div>";
            $query_update = "UPDATE voiture SET dispo='NON' WHERE id_voiture='$ContratVoiturePIMM'";
            $result_update = mysqli_query($conn, $query_update);
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout d'entretien</div>";
        }
    } elseif ($ContratmaterielListe) {
        $query = "INSERT INTO contrat(id_client,date_contrat,type_location,date_debut,date_fin,prix,assurance,mode_de_paiement,caution,date_prelevement,duree,num_cb_caution) 
        VALUES('$ContratClient','$ContratDate','$ContratType','$ContratDateDebut','$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement','$ContratCaution','$ContratDatePaiement','$ContratDuree','$ContratnumCautionMateriel')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $query_get_max_id_contrat = "SELECT max(id_contrat)
                    FROM contrat WHERE type_location ='Matériel'";
            $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
            while ($row = mysqli_fetch_row($result_query_get_max_id_contra)) {
                $id_contrat = $row[0];
                $materiel_table = $ContratmaterielListe;
                if ($count >= 1) {
                    for ($i = 0; $i < $count; $i++) {
                        if (trim($_POST["ContratmaterielListe"][$i] != '')) {
                            $query_insert_materiel_list = "INSERT INTO contrat_materiel(id_contrat,id_materiel) VALUES ('$id_contrat','$materiel_table[$i]') ";
                            $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
                        }
                    }
                    if ($result_query_insert_materiel_list) {
                        echo ("<div class='text-success'>Le contrat est ajouté  avec succés</div>");
                    } else {
                        echo ("<div class='text-danger'>échoué!</div>");
                    }
                }
            }
        }
    } else {
        echo 'échoué!';
    }
}

function get_contrat_signe_data()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT C.id_contrat,C.duree,C.contratsigne,C.type_location,C.date_debut,C.date_fin,C.prix,C.NbrekmInclus,C.mode_de_paiement,C.caution,
    C.moyen_caution,C.cautioncheque,C.num_cheque_caution,C.num_cb_caution,C.date_prelevement,CL.nom 
    FROM contrat_client as C LEFT JOIN client as CL on C.id_client =CL.id_client 
    WHERE id_contrat='$ContratId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $contrat_data = [];
        $contrat_data[0] = $row['id_contrat'];
        $contrat_data[1] = $row['contratsigne'];
    }
    echo json_encode($contrat_data);
}

function get_contrat_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT C.id_contrat,C.duree,C.type_location,C.date_debut,C.date_fin,C.prix,C.NbrekmInclus,C.mode_de_paiement,C.caution,
    C.moyen_caution,C.cautioncheque,C.num_cheque_caution,C.num_cb_caution,C.date_prelevement,CL.nom 
    FROM contrat_client as C LEFT JOIN client as CL on C.id_client =CL.id_client 
    WHERE id_contrat='$ContratId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $contrat_data = [];
        $contrat_data[0] = $row['id_contrat'];
        $contrat_data[1] = $row['date_fin'];
        $contrat_data[2] = $row['type_location'];
        $contrat_data[3] = $row['date_debut'];
        $contrat_data[5] = $row['prix'];
        $contrat_data[6] = $row['NbrekmInclus'];
        $contrat_data[7] = $row['mode_de_paiement'];
        $contrat_data[8] = $row['caution'];
        $contrat_data[9] = $row['date_prelevement'];
        $contrat_data[10] = $row['duree'];
        $contrat_data[11] = $row['moyen_caution'];
        $contrat_data[12] = $row['num_cheque_caution'];
        $contrat_data[13] = $row['num_cb_caution'];
        $contrat_data[14] = $row['cautioncheque'];
    }
    echo json_encode($contrat_data);
}

function update_contrat_signe(){
    global $conn;
    $contrat_signe = $_FILES['contratsigne_voiture'];
    $contrat_id = $_POST['_id'];

    $contrat_query = "SELECT * FROM contrat_client where id_contrat = ${contrat_id}";
    $contrat_result = mysqli_query($conn, $contrat_query);
    $contrat = mysqli_fetch_assoc($contrat_result);
    if (!$contrat) {
        echo json_encode(["error" => "Contrat introuvable ", "data" => "Contrat $contrat_id not found."]);
        return;
    }
    
    if (!is_image($contrat_signe["name"])) {
                array_push($errors, ["error" => "Type d'image non pris en charge pour contrat signe", "data" => $contrat_signe["name"]]);
    }
    $unique_id = time();
    
    $contrat_signe_file = $_FILES["contratsigne_voiture"];
            $contrat_signe_filename = $unique_id . "_contratsigne." . strtolower(pathinfo($contrat_signe["name"], PATHINFO_EXTENSION));

            $size = $contrat_signe_file["size"] / 1024;
            $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp', 'pdf');
            $location = "./uploads/contratsigne/${contrat_signe_filename}";
            $file_extension = is_image($location);
            $source_image = $contrat_signe_file["tmp_name"];
            if (in_array($file_extension, $valid_ext)) {
                if ($size >= 2000) {
                    compressImage($source_image, $location, 60);
                } else {
                    move_uploaded_file($contrat_signe_file["tmp_name"], "./uploads/contratsigne/${contrat_signe_filename}");
                }
            }

    $query = "UPDATE contrat_client
                SET contratsigne='$contrat_signe_filename'   
                WHERE id_contrat = '$contrat_id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Le contrat est mis à jour avec succès </div>";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }    
}

function get_contratavenant_data()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT C.id_contrat_avenant,C.debut_contrat_avenant,C.fin_contrat_avenant
    FROM contrat_client_avenant as C
    WHERE C.id_contrat_avenant='$ContratId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $contratavenant_data = [];
        $contratavenant_data[0] = $row['id_contrat_avenant'];
        $contratavenant_data[1] = $row['debut_contrat_avenant'];
        $contratavenant_data[2] = $row['fin_contrat_avenant'];
    }
    echo json_encode($contratavenant_data);
}

function update_contrat_avenant()
{
    global $conn;
    $Update_Contrat_Id = $_POST['up_contraId'];
    $Update_Contrat_Date_Debut = $_POST['up_DateContratDebut'];
    $Update_Contrat_Date_Fin = $_POST['up_DateContratFin'];
    $ContratAvenant_voiture = $_POST['ContratAvenant_voiture'];
    
    $query = "UPDATE contrat_client_avenant SET 
        debut_contrat_avenant='$Update_Contrat_Date_Debut',fin_contrat_avenant='$Update_Contrat_Date_Fin',id_voiture_avenant='$ContratAvenant_voiture'
        WHERE id_contrat_avenant ='$Update_Contrat_Id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<div class='text-success'>Le contrat avenant véhicule est mis à jour avec succès </div>";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
}

function update_contrat_avenant_materiel()
{
    global $conn;
    $Update_Contrat_Id = $_POST['up_contraId'];
    $Update_Contrat_Date_Debut = $_POST['up_DateContratDebut'];
    $Update_Contrat_Date_Fin = $_POST['up_DateContratFin'];
    
    $query = "UPDATE contrat_client_avenant SET 
     debut_contrat_avenant='$Update_Contrat_Date_Debut',fin_contrat_avenant='$Update_Contrat_Date_Fin'
     WHERE id_contrat_avenant ='$Update_Contrat_Id'";
    $result = mysqli_query($conn, $query);


    if ($result) {
        $querymateriel = "UPDATE materiel_contrat_client SET 
            ContratDateDebut='$Update_Contrat_Date_Debut',ContratDateFin='$Update_Contrat_Date_Fin'
            WHERE id_contrat_avenant ='$Update_Contrat_Id'";
        $resultmateriel = mysqli_query($conn, $querymateriel);
        echo "<div class='text-success'>Le contrat avenant matériel est mis à jour avec succès </div>";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
}

function update_contrat_avenant_pack()
{
    global $conn;
    $Update_Contrat_Id = $_POST['up_contraId'];
    $Update_Contrat_Date_Debut = $_POST['up_DateContratDebut'];
    $Update_Contrat_Date_Fin = $_POST['up_DateContratFin'];
    
    $query = "UPDATE contrat_client_avenant SET 
     debut_contrat_avenant='$Update_Contrat_Date_Debut',fin_contrat_avenant='$Update_Contrat_Date_Fin'
     WHERE id_contrat_avenant ='$Update_Contrat_Id'";
    $result = mysqli_query($conn, $query);


    if ($result) {
        $querymateriel = "UPDATE materiel_contrat_client SET 
            ContratDateDebut='$Update_Contrat_Date_Debut',ContratDateFin='$Update_Contrat_Date_Fin'
            WHERE id_contrat_avenant ='$Update_Contrat_Id'";
        $resultmateriel = mysqli_query($conn, $querymateriel);
        echo "<div class='text-success'>Le contrat avenant pack est mis à jour avec succès </div>";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
}

function update_contratmateriel_signe(){
    global $conn;
    $contrat_signe = $_FILES['contratsigne_materiel'];
    $contrat_id = $_POST['_id'];

    $contrat_query = "SELECT * FROM contrat_client where id_contrat = ${contrat_id}";
    $contrat_result = mysqli_query($conn, $contrat_query);
    $contrat = mysqli_fetch_assoc($contrat_result);
    if (!$contrat) {
        echo json_encode(["error" => "Contrat introuvable ", "data" => "Contrat $contrat_id not found."]);
        return;
    }
    
    if (!is_image($contrat_signe["name"])) {
                array_push($errors, ["error" => "Type d'image non pris en charge pour contrat signe", "data" => $contrat_signe["name"]]);
    }
    $unique_id = time();
    
    $contrat_signe_file = $_FILES["contratsigne_materiel"];
            $contrat_signe_filename = $unique_id . "_contratsigne." . strtolower(pathinfo($contrat_signe["name"], PATHINFO_EXTENSION));
            $size = $contrat_signe_file["size"] / 1024;
            $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp', 'pdf');
            $location = "./uploads/contratsigne/${contrat_signe_filename}";
            $file_extension = is_image($location);
            $source_image = $contrat_signe_file["tmp_name"];
            if (in_array($file_extension, $valid_ext)) {
                if ($size >= 2000) {
                    compressImage($source_image, $location, 60);
                } else {
                    move_uploaded_file($contrat_signe_file["tmp_name"], "./uploads/contratsigne/${contrat_signe_filename}");
                }
            }
    $query = "UPDATE contrat_client
                SET contratsigne='$contrat_signe_filename'   
                WHERE id_contrat = '$contrat_id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Le contrat est mis à jour avec succès </div>";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }     
}

function update_contratpack_signe(){
    global $conn;
    $contrat_signe = $_FILES['contratsigne_pack'];
    $contrat_id = $_POST['_id'];

    $contrat_query = "SELECT * FROM contrat_client where id_contrat = ${contrat_id}";
    $contrat_result = mysqli_query($conn, $contrat_query);
    $contrat = mysqli_fetch_assoc($contrat_result);
    if (!$contrat) {
        echo json_encode(["error" => "Contrat introuvable ", "data" => "Contrat $contrat_id not found."]);
        return;
    }
    
    if (!is_image($contrat_signe["name"])) {
                array_push($errors, ["error" => "Type d'image non pris en charge pour contrat signe", "data" => $contrat_signe["name"]]);
    }
    $unique_id = time();
    
    $contrat_signe_file = $_FILES["contratsigne_pack"];
    $contrat_signe_filename = $unique_id . "_contratsigne." . strtolower(pathinfo($contrat_signe["name"], PATHINFO_EXTENSION));

    $size = $contrat_signe_file["size"] / 1024;
    $valid_ext = array('png', 'jpg', 'jpeg', 'gif', 'webp', 'pdf');
    $location = "./uploads/contratsigne/${contrat_signe_filename}";
    $file_extension = is_image($location);
    $source_image = $contrat_signe_file["tmp_name"];
    if (in_array($file_extension, $valid_ext)) {
        if ($size >= 2000) {
            compressImage($source_image, $location, 60);
        } else {
            move_uploaded_file($contrat_signe_file["tmp_name"], "./uploads/contratsigne/${contrat_signe_filename}");
        }
    }

    $query = "UPDATE contrat_client
                SET contratsigne='$contrat_signe_filename'   
                WHERE id_contrat = '$contrat_id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Le contrat est mis à jour avec succès </div>";
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
       
}

function update_contrat()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $Update_Contrat_Id = $_POST['up_contraId'];
    $Update_Contrat_Date_Fin = $_POST['up_DateContratFin'];
    $Update_Contrat_Date_Debut = $_POST['up_DateContratDebut'];
    $Update_Contrat_Duree = $_POST['upDureeContrat'];
    $Update_Contrat_Prix = $_POST['up_contratPrix'];
    $Update_Contrat_Paiement = $_POST['up_contratPaiement'];
    $Update_Contrat_Caution = $_POST['up_contratCaution'];
    $Update_Contrat_Caution_Cheque = $_POST['updateContratCautionCheque'];
    $Update_NbreKilometre_Contrat = $_POST['updateNbreKilometreContrat'];
    $Update_moyenCaution_Contrat = $_POST['up_moyenCaution'];
    $num_caution_voiture = $_POST['updateContratnumCaution'];
    $num_caution_cb = $_POST['updateContratnumCautionCB'];
    $query_select = "SELECT * FROM contrat_client where id_contrat ='$Update_Contrat_Id'";
    $result_select = mysqli_query($conn, $query_select);
    while ($row = mysqli_fetch_assoc($result_select)) {
        $select_data = new stdClass();
        $select_data->DateDebut = $row['date_debut'];
        $select_data->DateFin = $row['date_fin'];
        $select_data->Duree = $row['duree'];
        $select_data->Prix = $row['prix'];
        $select_data->Mode_de_paiement = $row['mode_de_paiement'];
        $select_data->MoyenCaution = $row['moyen_caution'];
        $select_data->Caution = $row['caution'];
        $select_data->CautionCheque = $row['cautioncheque'];
        $select_data->NbreKilometreInclus = $row['NbrekmInclus'];
        $select_data->Num_cheque_caution = $row['num_cheque_caution'];
        $select_data->Num_cb_caution = $row['num_cb_caution'];
    }
    json_encode($select_data);

    $query = "UPDATE contrat_client SET 
     date_debut='$Update_Contrat_Date_Debut',date_fin='$Update_Contrat_Date_Fin',duree='$Update_Contrat_Duree',prix='$Update_Contrat_Prix',
     mode_de_paiement='$Update_Contrat_Paiement',moyen_caution='$Update_moyenCaution_Contrat',caution='$Update_Contrat_Caution',
     cautioncheque='$Update_Contrat_Caution_Cheque',NbrekmInclus='$Update_NbreKilometre_Contrat',num_cheque_caution='$num_caution_voiture',num_cb_caution='$num_caution_cb'
     WHERE id_contrat ='$Update_Contrat_Id'";
    $result = mysqli_query($conn, $query);

    $update_data = new stdClass();
    $update_data->DateDebut = $Update_Contrat_Date_Debut;
    $update_data->DateFin = $Update_Contrat_Date_Fin;
    $update_data->Duree = $Update_Contrat_Duree;
    $update_data->Prix = $Update_Contrat_Prix;
    $update_data->Mode_de_paiement = $Update_Contrat_Paiement;
    $update_data->MoyenCaution = $Update_moyenCaution_Contrat;
    $update_data->Caution = $Update_Contrat_Caution;
    $update_data->CautionCheque = $Update_Contrat_Caution_Cheque;
    $update_data->NbreKilometreInclus = $Update_NbreKilometre_Contrat;
    $update_data->Num_cheque_caution = $num_caution_voiture;
    $update_data->Num_cb_caution = $num_caution_cb;
    json_encode($update_data);

    $update_contrat = new stdClass();
    if (($select_data->DateDebut == $update_data->DateDebut) && ($select_data->DateFin == $update_data->DateFin) && ($select_data->Duree == $update_data->Duree)
        && ($select_data->Prix == $update_data->Prix) && ($select_data->Mode_de_paiement == $update_data->Mode_de_paiement)
        && ($select_data->MoyenCaution == $update_data->MoyenCaution) && ($select_data->Caution == $update_data->Caution)
        && ($select_data->CautionCheque == $update_data->CautionCheque) && ($select_data->NbreKilometreInclus == $update_data->NbreKilometreInclus)
        && ($select_data->Num_cheque_caution == $update_data->Num_cheque_caution) && ($select_data->Num_cb_caution == $update_data->Num_cb_caution)
    ) {
        echo "<div class='text-danger'> Aucune modification faite. Merci de vérifier! </div> ";
        $data = NULL;
    }
    if (($select_data->DateDebut != $update_data->DateDebut)) {
        $update_contrat->DateDebut = $Update_Contrat_Date_Debut;
    }
    if ($select_data->DateFin != $update_data->DateFin) {
        $update_contrat->DateFin = $Update_Contrat_Date_Fin;
    }
    if ($select_data->Duree != $update_data->Duree) {
        $update_contrat->Duree = $Update_Contrat_Duree;
    }
    if ($select_data->Prix != $update_data->Prix) {
        $update_contrat->Prix = $Update_Contrat_Prix;
    }
    if ($select_data->Mode_de_paiement != $update_data->Mode_de_paiement) {
        $update_contrat->Mode_de_paiement = $Update_Contrat_Paiement;
    }
    if ($select_data->MoyenCaution != $update_data->MoyenCaution) {
        $update_contrat->MoyenCaution = $Update_moyenCaution_Contrat;
    }
    if ($select_data->Caution != $update_data->Caution) {
        $update_contrat->Caution = $Update_Contrat_Caution;
    }
    if ($select_data->CautionCheque != $update_data->CautionCheque) {
        $update_contrat->CautionCheque = $Update_Contrat_Caution_Cheque;
    }
    if ($select_data->NbreKilometreInclus != $update_data->NbreKilometreInclus) {
        $update_contrat->NbreKilometreInclus = $Update_NbreKilometre_Contrat;
    }
    if ($select_data->Num_cheque_caution != $update_data->Num_cheque_caution) {
        $update_contrat->Num_cheque_caution = $num_caution_voiture;
    }
    if ($select_data->Num_cb_caution != $update_data->Num_cb_caution) {
        $update_contrat->Num_cb_caution = $num_caution_cb;
    }
    $data = json_encode($update_contrat);

    if ($result) {
        echo "<div class='text-success'>Le contrat est mis à jour avec succès </div>";

        $queryContrat = "INSERT INTO  
         historique_contrat(id_contrat_HC,id_user_HC,action,update_contrat) 
         VALUES ('$Update_Contrat_Id','$id_user','Modification','$data')";
        $resultContrat = mysqli_query($conn, $queryContrat);
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
}
function update_contrat_materiel()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $updateContratId = $_POST['updateContratId'];
    $Update_Contrat_Date_Fin = $_POST['up_DateContratFin'];
    $Update_Contrat_Date_Debut = $_POST['up_DateContratDebut'];
    $Update_Contrat_Duree = $_POST['upDureeContrat'];
    $Update_Contrat_Prix = $_POST['up_contratPrix'];
    $Update_Contrat_Paiement = $_POST['up_contratPaiement'];
    $Update_date_Prelevement = $_POST['up_DatePrelevementContrat'];
    $Update_Contrat_MoyenCaution = $_POST['updateContratMoyenCaution'];
    $Update_Contrat_Caution = $_POST['up_contratCaution'];
    $Update_Contrat_Caution_Cheque = $_POST['updateContratCautionCheque'];
    $Update_num_caution = $_POST['updateContratnumCaution'];
    $Update_num_caution_CB = $_POST['updateContratnumCautionCB'];

    $query_select = "SELECT * FROM contrat_client where id_contrat ='$updateContratId'";
    $result_select = mysqli_query($conn, $query_select);
    while ($row = mysqli_fetch_assoc($result_select)) {
        $select_data = new stdClass();
        $select_data->DateDebut = $row['date_debut'];
        $select_data->DateFin = $row['date_fin'];
        $select_data->Duree = $row['duree'];
        $select_data->Prix = $row['prix'];
        $select_data->Mode_de_paiement = $row['mode_de_paiement'];
        $select_data->Date_prelevement = $row['date_prelevement'];
        $select_data->MoyenCaution = $row['moyen_caution'];
        $select_data->Caution = $row['caution'];
        $select_data->CautionCheque = $row['cautioncheque'];
        $select_data->Num_cheque_caution = $row['num_cheque_caution'];
        $select_data->Num_cb_caution = $row['num_cb_caution'];
    }
    json_encode($select_data);

    $query = "UPDATE contrat_client SET 
     date_debut='$Update_Contrat_Date_Debut',date_fin='$Update_Contrat_Date_Fin',duree='$Update_Contrat_Duree',prix='$Update_Contrat_Prix',
     mode_de_paiement='$Update_Contrat_Paiement',moyen_caution='$Update_Contrat_MoyenCaution',caution='$Update_Contrat_Caution',
     cautioncheque='$Update_Contrat_Caution_Cheque',num_cheque_caution='$Update_num_caution',num_cb_caution='$Update_num_caution_CB',date_prelevement='$Update_date_Prelevement'
     WHERE id_contrat ='$updateContratId'";
    $result = mysqli_query($conn, $query);

    $update_data = new stdClass();
    $update_data->DateDebut = $Update_Contrat_Date_Debut;
    $update_data->DateFin = $Update_Contrat_Date_Fin;
    $update_data->Duree = $Update_Contrat_Duree;
    $update_data->Prix = $Update_Contrat_Prix;
    $update_data->Mode_de_paiement = $Update_Contrat_Paiement;
    $update_data->MoyenCaution = $Update_Contrat_MoyenCaution;
    $update_data->Caution = $Update_Contrat_Caution;
    $update_data->CautionCheque = $Update_Contrat_Caution_Cheque;
    $update_data->Num_cheque_caution = $Update_num_caution;
    $update_data->Num_cb_caution = $Update_num_caution_CB;
    json_encode($update_data);

    $update_contrat = new stdClass();
    if (($select_data->DateDebut == $update_data->DateDebut) && ($select_data->DateFin == $update_data->DateFin) && ($select_data->Duree == $update_data->Duree)
        && ($select_data->Prix == $update_data->Prix) && ($select_data->Mode_de_paiement == $update_data->Mode_de_paiement)
        && ($select_data->MoyenCaution == $update_data->MoyenCaution) && ($select_data->Caution == $update_data->Caution)
        && ($select_data->CautionCheque == $update_data->CautionCheque)
        && ($select_data->Num_cheque_caution == $update_data->Num_cheque_caution) && ($select_data->Num_cb_caution == $update_data->Num_cb_caution)
    ) {
        echo "<div class='text-danger'> Aucune modification faite. Merci de vérifier! </div> ";
    }
    if (($select_data->DateDebut != $update_data->DateDebut)) {
        $update_contrat->DateDebut = $Update_Contrat_Date_Debut;
    }
    if ($select_data->DateFin != $update_data->DateFin) {
        $update_contrat->DateFin = $Update_Contrat_Date_Fin;
    }
    if ($select_data->Duree != $update_data->Duree) {
        $update_contrat->Duree = $Update_Contrat_Duree;
    }
    if ($select_data->Prix != $update_data->Prix) {
        $update_contrat->Prix = $Update_Contrat_Prix;
    }
    if ($select_data->Mode_de_paiement != $update_data->Mode_de_paiement) {
        $update_contrat->Mode_de_paiement = $Update_Contrat_Paiement;
    }
    if ($select_data->MoyenCaution != $update_data->MoyenCaution) {
        $update_contrat->MoyenCaution = $Update_Contrat_MoyenCaution;
    }
    if ($select_data->Caution != $update_data->Caution) {
        $update_contrat->Caution = $Update_Contrat_Caution;
    }
    if ($select_data->CautionCheque != $update_data->CautionCheque) {
        $update_contrat->CautionCheque = $Update_Contrat_Caution_Cheque;
    }
    if ($select_data->Num_cheque_caution != $update_data->Num_cheque_caution) {
        $update_contrat->Num_cheque_caution = $Update_num_caution;
    }
    if ($select_data->Num_cb_caution != $update_data->Num_cb_caution) {
        $update_contrat->Num_cb_caution = $Update_num_caution_CB;
    }

    $data = json_encode($update_contrat);

    if ($result) {
        echo "<div class='text-success'>Le contrat est mis à jour avec succès </div>";

        $queryContrat = "INSERT INTO  
         historique_contrat(id_contrat_HC,id_user_HC,action,update_contrat) 
         VALUES ('$updateContratId','$id_user','Modification','$data')";
        $resultContrat = mysqli_query($conn, $queryContrat);

        $queryupdate = "UPDATE materiel_contrat_client SET 
            ContratDateDebut='$Update_Contrat_Date_Debut',ContratDateFin='$Update_Contrat_Date_Fin'
            WHERE id_contrat ='$updateContratId'";
        $resultupdate = mysqli_query($conn, $queryupdate);
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
}

function delete_contrat_record()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $Del_ID = $_POST['Delete_ContratID'];

    $query = "UPDATE contrat_client SET etat_contrat='S' WHERE id_contrat='$Del_ID' ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Le contrat est supprimé";

        $queryContratdelete = "INSERT INTO  
         historique_contrat(id_contrat_HC,id_user_HC,action) 
         VALUES ('$Del_ID','$id_user','Suppression')";
        $resultContratdelete = mysqli_query($conn, $queryContratdelete);
    } else {
        echo "SVP vérifier votre requette !";
    }
}

function valide_sortie_contrat_record()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $Sortie_Contrat_ID = $_POST['Sortie_ContratID'];
    $rowdate = date("Y-m-d h:i:s");
    $datesys = date("Y-m-d");
    $query = "UPDATE contrat_client SET date_debut_validation='$datesys' WHERE id_contrat='$Sortie_Contrat_ID' ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $queryvalidsortie = "INSERT INTO  
                    historique_contrat(id_contrat_HC,id_user_HC,action,date_action) 
                    VALUES ('$Sortie_Contrat_ID','$id_user','Validation de sortie','$rowdate')";
        $resultvalidsortie = mysqli_query($conn, $queryvalidsortie);
        echo "La sortie est faite avec succés";
    } else {
        echo "SVP vérifier votre requette !";
    }
}

function valide_retour_contrat_record()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $Retour_Contrat_ID = $_POST['Retour_ContratID'];
    $rowdate = date("Y-m-d h:i:s");
    $datesys = date("Y-m-d");
    $query = "UPDATE contrat_client SET date_fin_validation='$datesys' WHERE id_contrat='$Retour_Contrat_ID' ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $queryvalidretour = "INSERT INTO  
                    historique_contrat(id_contrat_HC,id_user_HC,action,date_action) 
                    VALUES ('$Retour_Contrat_ID','$id_user','Validation de retour','$rowdate')";
        $resultvalidretour = mysqli_query($conn, $queryvalidretour);
        echo "Le retour est fait avec succés";
    } else {
        echo "SVP vérifier votre requette !";
    }
}

function DisplayEntretienRecordMateriel()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Type</th>
    <th class="border-top-0">Type d\'intervention</th>
    <th class="border-top-0">Lieu Entretien</th>
    <th class="border-top-0">Matériel</th>
    <th class="border-top-0">Cout Entretien</th>
    <th class="border-top-0">Date Début </th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Commentaire Déclarant</th>
    <th class="border-top-0">Commentaire Intervenant</th>
    </tr>';

    $query = "SELECT *,E.type AS TYPEentretien FROM entretien AS E 
    LEFT JOIN materiels AS M ON E.id_materiel = M.id_materiels
    LEFT JOIN materiels_agence AS MA ON MA.id_materiels = M.id_materiels
    WHERE E.type ='Materiel'
    AND etat_entretien = '1'
    GROUP BY id_entretien";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_entretien'] . '</td>
            <td class="border-top-0">' . $row['type'] . '</td>
            <td class="border-top-0">' . $row['objet_entretien'] . '</td>
            <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
            <td class="border-top-0">' . $row['designation'] . ' - ' . $row['code_materiel'] . ' ' . $row['num_serie_materiels']  . '</td>
            <td class="border-top-0">' . $row['cout_entretien'] . '</td>
            <td class="border-top-0">' . $row['date_entretien'] . '</td>
            <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
            <td class="border-top-0">' . $row['commentaire'] . '</td>
            <td class="border-top-0">' . $row['commentaire_intervenant'] . '</td>
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}


function DisplayEntretienRecordVoitures()
{
    global $conn;
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Type d\'intervention</th>
        <th class="border-top-0">Lieu Entretien</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Cout Entretien</th>
        <th class="border-top-0">Date Début</th>
        <th class="border-top-0">Date Fin</th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        </tr>';
    $query = "SELECT *,E.type AS TYPEentretien FROM entretien AS E 
    LEFT JOIN voiture AS V ON E.id_voiture =V.id_voiture
    LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel
    WHERE  E.type ='Vehicule'
    AND etat_entretien = '1'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
                <tr>
                    <td class="border-top-0">' . $row['id_entretien'] . '</td>
                    <td class="border-top-0">' . $row['TYPEentretien'] . '</td>
                    <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                    <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                    <td class="border-top-0">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                    <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                    <td class="border-top-0">' . $row['date_entretien'] . '</td>
                    <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                    <td class="border-top-0">' . $row['commentaire'] . '</td>
                    <td class="border-top-0">' . $row['commentaire_intervenant'] . '</td>
                </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}


function DisplayControletechniqueRecordVoiture()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "admin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Date</th>
        <th class="border-top-0">Localisation</th>
        <th class="border-top-0">Numéro de tel</th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Date</th>
        <th class="border-top-0">Localisation</th>
        <th class="border-top-0">Numéro de tel</th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    }
    
    $query = "SELECT * 
    FROM controletechnique AS CT
    LEFT JOIN voiture AS V ON CT.id_voiture =V.id_voiture
    LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel
    LEFT JOIN agence AS A ON V.id_agence = A.id_agence 
    LEFT JOIN type_controle_technique AS T ON CT.type_controletechnique = T.id_type_controle 
    WHERE V.actions ='T'";
    $result = mysqli_query($conn, $query);
    $colors = array('#DFE9F2','#F0F0FG','#FGF8F8');
    while ($row = mysqli_fetch_assoc($result)) {
        $disponibilte = disponibilite_Vehicule1($row['id_voiture']);
        $localisation = localisation_Vehicule($row['id_voiture']);
        if ($disponibilte == 'disponibile') {
            $numtel = "";
        } else {
            $row['lieu_agence'] = $localisation;
            $numtel = telclient_VehiculeLoue($row['id_voiture']);
        }

        if($row['id_type_controle'] == 1){
            $i = 0;
        }
        else if($row['id_type_controle'] == 2){
            $i = 1;
        }else{
            $i = 2;
        }
        $style = $colors[$i];

        $date = date("Y-m-d");
        $date_controletechnique = $row['date_controletechnique'];
        if(($date_controletechnique != "0000-00-00") && ($date_controletechnique >= $date)){
            $dateDifference = strtotime($date_controletechnique) - strtotime($date);
            $years  = floor($dateDifference / (365 * 60 * 60 * 24));
            $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
            if($years == 0 && $months == 0 && (7 < $days && $days <= 14)){
                $style = "#FF8000";
            }else if($years == 0 && $months == 0 && (0 < $days && $days <= 7)){
                $style = "#FF0000";
            }
        }
        
        $value .= '
            <tr>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['id_controletechnique'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_typecontrole'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['date_controletechnique'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $numtel . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['comment_declar'] . '</td>
                <td class="border-top-0" bgcolor="'.$style.'">' . $row['comment_interv'] . '</td>';
        if ($_SESSION['Role'] == "mecanicien") {
            $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                <button type="button" title="Modifier le controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-Controletechnique" data-id=' . $row['id_controletechnique'] . '><i class="fas fa-edit"></i></button>
            </td>';
        }
        else if ($_SESSION['Role'] == "responsable") {
            $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                <button type="button" title="Modifier le controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-Controletechnique" data-id=' . $row['id_controletechnique'] . '><i class="fas fa-edit"></i></button>
                <button type="button" title="Confirmer la réalisation de controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-confirmation-Controletechnique" data-id2=' . $row['id_controletechnique'] . '><i class="fas fa-check"></i></button>
            </td>';
        }
        $value .= '</tr>';
    }
    $value .= '</table>';
    echo $value;
}

function searchControleTechnique()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "admin") {
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Date</th>
        <th class="border-top-0">Localisation</th>
        <th class="border-top-0">Numéro de tel</th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Date</th>
        <th class="border-top-0">Localisation</th>
        <th class="border-top-0">Numéro de tel</th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $query = ("SELECT * 
        FROM controletechnique AS CT
        LEFT JOIN voiture AS V ON CT.id_voiture =V.id_voiture
        LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel
        LEFT JOIN agence AS A ON V.id_agence = A.id_agence
        LEFT JOIN type_controle_technique AS T ON CT.type_controletechnique = T.id_type_controle 
        WHERE V.actions ='T'
        AND (id_controletechnique LIKE ('%" . $search . "%')
                OR nom_typecontrole LIKE ('%" . $search . "%')
                OR pimm LIKE ('%" . $search . "%')
                OR Marque LIKE ('%" . $search . "%')
                OR Model LIKE ('%" . $search . "%')
                OR comment_declar LIKE ('%" . $search . "%')
                OR comment_interv LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $query);
        $colors = array('#DFE9F2','#F0F0FG','#FGF8F8');
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $disponibilte = disponibilite_Vehicule1($row['id_voiture']);
                $localisation = localisation_Vehicule($row['id_voiture']);
                $numtel = "";
                if ($disponibilte == 'disponibile') {
                    $numtel = "";
                } else {
                    $row['lieu_agence'] = $localisation;
                    $numtel = telclient_VehiculeLoue($row['id_voiture']);
                }
                if($row['id_type_controle'] == 1){
                    $i = 0;
                }
                else if($row['id_type_controle'] == 2){
                    $i = 1;
                }else{
                    $i = 2;
                }
                $style = $colors[$i];
                $date = date("Y-m-d");
                $date_controletechnique = $row['date_controletechnique'];
                if(($date_controletechnique != "0000-00-00") && ($date_controletechnique >= $date)){
                    $dateDifference = strtotime($date_controletechnique) - strtotime($date);
                    $years  = floor($dateDifference / (365 * 60 * 60 * 24));
                    $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
                    if($years == 0 && $months == 0 && (7 < $days && $days <= 14)){
                        $style = "#FF8000";
                    }else if($years == 0 && $months == 0 && (0 < $days && $days <= 7)){
                        $style = "#FF0000";
                    }
                }

                $value .= '
                    <tr>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['id_controletechnique'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_typecontrole'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['date_controletechnique'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_agence'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $numtel . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['comment_declar'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['comment_interv'] . '</td>';
                if ($_SESSION['Role'] == "mecanicien") {
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                        <button type="button" title="Modifier le controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-Controletechnique" data-id=' . $row['id_controletechnique'] . '><i class="fas fa-edit"></i></button>
                    </td>';
                }
                else if ($_SESSION['Role'] == "responsable") {
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                        <button type="button" title="Modifier le controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-Controletechnique" data-id=' . $row['id_controletechnique'] . '><i class="fas fa-edit"></i></button>
                        <button type="button" title="Confirmer la réalisation de controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-confirmation-Controletechnique" data-id2=' . $row['id_controletechnique'] . '><i class="fas fa-check"></i></button>
                    </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        DisplayControletechniqueRecordVoiture();
    }
}

function searchTypeControleTechnique()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "admin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Date</th>
        <th class="border-top-0">Localisation</th>
        <th class="border-top-0">Numéro de tel</th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Date</th>
        <th class="border-top-0">Localisation</th>
        <th class="border-top-0">Numéro de tel</th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    }
    if ($_POST['querytype'] != "0") {
        $search = $_POST['querytype'];
        $query = "SELECT * 
            FROM controletechnique AS CT
            LEFT JOIN voiture AS V ON CT.id_voiture =V.id_voiture
            LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel
            LEFT JOIN agence AS A ON V.id_agence = A.id_agence
            LEFT JOIN type_controle_technique AS T ON CT.type_controletechnique = T.id_type_controle 
            WHERE V.actions ='T'
            AND type_controletechnique = '$search'";
        $result = mysqli_query($conn, $query);
        $colors = array('#DFE9F2','#F0F0FG','#FGF8F8');
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $disponibilte = disponibilite_Vehicule1($row['id_voiture']);
                $localisation = localisation_Vehicule($row['id_voiture']);
                if ($disponibilte == 'disponibile') {
                    $numtel = "";
                } else {
                    $row['lieu_agence'] = $localisation;
                    $numtel = telclient_VehiculeLoue($row['id_voiture']);
                }

                if($row['id_type_controle'] == 1){
                    $i = 0;
                }
                else if($row['id_type_controle'] == 2){
                    $i = 1;
                }else{
                    $i = 2;
                }
                $style = $colors[$i];
                $date = date("Y-m-d");
                $date_controletechnique = $row['date_controletechnique'];
                if(($date_controletechnique != "0000-00-00") && ($date_controletechnique >= $date)){
                    $dateDifference = strtotime($date_controletechnique) - strtotime($date);
                    $years  = floor($dateDifference / (365 * 60 * 60 * 24));
                    $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
                    if($years == 0 && $months == 0 && (7 < $days && $days <= 14)){
                        $style = "#FF8000";
                    }else if($years == 0 && $months == 0 && (0 < $days && $days <= 7)){
                        $style = "#FF0000";
                    }
                }

                $value .= '
                    <tr>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['id_controletechnique'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_typecontrole'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['date_controletechnique'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_agence'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $numtel . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['comment_declar'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['comment_interv'] . '</td>';
                if ($_SESSION['Role'] == "mecanicien") {
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                        <button type="button" title="Modifier le controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-Controletechnique" data-id=' . $row['id_controletechnique'] . '><i class="fas fa-edit"></i></button>
                    </td>';
                }
                else if ($_SESSION['Role'] == "responsable") {
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                        <button type="button" title="Modifier le controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-Controletechnique" data-id=' . $row['id_controletechnique'] . '><i class="fas fa-edit"></i></button>
                        <button type="button" title="Confirmer la réalisation de controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-confirmation-Controletechnique" data-id2=' . $row['id_controletechnique'] . '><i class="fas fa-check"></i></button>
                    </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        $query = "SELECT *
            FROM controletechnique AS CT
            LEFT JOIN voiture AS V ON CT.id_voiture =V.id_voiture
            LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel
            LEFT JOIN agence AS A ON V.id_agence = A.id_agence
            LEFT JOIN type_controle_technique AS T ON CT.type_controletechnique = T.id_type_controle 
            WHERE V.actions ='T'";
        $result = mysqli_query($conn, $query);
        // $hexaLetters = array('FA','F2','F9','FD','8E','GF');
        // $color = '#';
        $colors = array('#DFE9F2','#F0F0FG','#FGF8F8');
        while ($row = mysqli_fetch_assoc($result)) {
            $disponibilte = disponibilite_Vehicule1($row['id_voiture']);
            $localisation = localisation_Vehicule($row['id_voiture']);
            if ($disponibilte == 'disponibile') {
                $numtel = "";
            } else {
                $row['lieu_agence'] = $localisation;
                $numtel = telclient_VehiculeLoue($row['id_voiture']);
            }

            if($row['id_type_controle'] == 1){
                // $color .= $hexaLetters[rand(0, count($hexaLetters) - 1)];
                $i = 0;
            }
            else if($row['id_type_controle'] == 2){
                $i = 1;
            }else{
                $i = 2;
            }
            $style = $colors[$i];
            $date = date("Y-m-d");
            $date_controletechnique = $row['date_controletechnique'];
            if(($date_controletechnique != "0000-00-00") && ($date_controletechnique >= $date)){
                $dateDifference = strtotime($date_controletechnique) - strtotime($date);
                $years  = floor($dateDifference / (365 * 60 * 60 * 24));
                $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
                if($years == 0 && $months == 0 && (7 < $days && $days <= 14)){
                    $style = "#FF8000";
                }else if($years == 0 && $months == 0 && (0 < $days && $days <= 7)){
                    $style = "#FF0000";
                }
            }

            $value .= '
                <tr>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['id_controletechnique'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_typecontrole'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['date_controletechnique'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_agence'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $numtel . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['comment_declar'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['comment_interv'] . '</td>';
            if ($_SESSION['Role'] == "mecanicien") {
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                    <button type="button" title="Modifier le controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-mecanicien-Controletechnique" data-id3=' . $row['id_controletechnique'] . '><i class="fas fa-edit"></i></button>
                </td>';
            }
            else if ($_SESSION['Role'] == "responsable") {
                $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                    <button type="button" title="Modifier le controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-Controletechnique" data-id=' . $row['id_controletechnique'] . '><i class="fas fa-edit"></i></button>
                    <button type="button" title="Confirmer la réalisation de controle technique" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-confirmation-Controletechnique" data-id2=' . $row['id_controletechnique'] . '><i class="fas fa-check"></i></button>
                </td>';
            }
            $value .= '</tr>';
        }
        $value .= '</table>';
        echo $value;
    }
}

function display_controletechnique_historique_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Type Controle</th>
            <th class="border-top-0">Voiture</th>
            <th class="border-top-0">Utilisateur</th>
            <th class="border-top-0">Activité</th>
            <th class="border-top-0">Date d\'activité</th>
        </tr>';

    $query = ("SELECT *
        from historique_controle AS HC
        LEFT JOIN controletechnique AS CT ON HC.id_controle = CT.id_controletechnique 
        LEFT JOIN voiture AS V ON CT.id_voiture = V.id_voiture
        LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel 
        LEFT JOIN user AS U ON HC.id_user_controle = U.id_user
        ORDER BY HC.id_historique_controle DESC");

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['action_controle'] == "Confirmation") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #2cd07e!important";
            $rowETAT = "Confirmation réalisation de contrôle";
        }
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_historique_controle'] . '</td>
            <td class="border-top-0">' . $row['type_controletechnique'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['nom_user'] . '</td>
            <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>
            <td class="border-top-0">' . $row['date_action_controle'] . '</td>';
        $value .= '</tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function searchHistoriqueControle()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Type Controle</th>
            <th class="border-top-0">Voiture</th>
            <th class="border-top-0">Utilisateur</th>
            <th class="border-top-0">Activité</th>
            <th class="border-top-0">Date d\'activité</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Type Controle</th>
            <th class="border-top-0">Voiture</th>
            <th class="border-top-0">Utilisateur</th>
            <th class="border-top-0">Activité</th>
            <th class="border-top-0">Date d\'activité</th>
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $query = ("SELECT *
            from historique_controle AS HC
            LEFT JOIN controletechnique AS CT ON HC.id_controle = CT.id_controletechnique 
            LEFT JOIN voiture AS V ON CT.id_voiture = V.id_voiture
            LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel 
            LEFT JOIN type_controle_technique AS T ON CT.type_controletechnique = T.id_type_controle 
            JOIN user AS U ON HC.id_user_controle = U.id_user
            AND   (id_historique_controle LIKE ('%" . $search . "%')
                    OR nom_typecontrole LIKE ('%" . $search . "%')
                    OR pimm LIKE ('%" . $search . "%')
                    OR Marque LIKE ('%" . $search . "%')
                    OR Model LIKE ('%" . $search . "%')
                    OR date_action_controle LIKE ('%" . $search . "%')  )
                    ORDER BY id_historique_controle DESC");
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['action_controle'] == "Confirmation") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #2cd07e!important";
                    $rowETAT = "Confirmation réalisation de contrôle";
                }
                $value .= '
            <tr>
            <td class="border-top-0">' . $row['id_historique_controle'] . '</td>
            <td class="border-top-0">' . $row['nom_typecontrole'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['nom_user'] . '</td>
            <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>
            <td class="border-top-0">' . $row['date_action_controle'] . '</td>';
              
            $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_controletechnique_historique_record();
    }
}

function searchHistoriqueControleUser()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type Controle</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Utilisateur</th>
        <th class="border-top-0">Activité</th>
        <th class="border-top-0">Date d\'activité</th>
    </tr>';

    if ($_POST['queryuser'] != "0") {
        $search = $_POST['queryuser'];
        if ($search == 0) {
            $query = ("SELECT *
                from historique_controle AS HC
                LEFT JOIN controletechnique AS CT ON HC.id_controle = CT.id_controletechnique 
                LEFT JOIN voiture AS V ON CT.id_voiture = V.id_voiture
                LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel 
                LEFT JOIN type_controle_technique AS T ON CT.type_controletechnique = T.id_type_controle 
                JOIN user AS U ON HC.id_user_controle = U.id_user
                ORDER BY HC.id_historique_controle DESC");
        } else {
            $query = ("SELECT *
                from historique_controle AS HC
                LEFT JOIN controletechnique AS CT ON HC.id_controle = CT.id_controletechnique 
                LEFT JOIN voiture AS V ON CT.id_voiture = V.id_voiture
                LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel 
                LEFT JOIN type_controle_technique AS T ON CT.type_controletechnique = T.id_type_controle 
                JOIN user AS U ON HC.id_user_controle = U.id_user
                AND HC.id_user_controle = '$search'
                ORDER BY HC.id_historique_controle DESC");
        }
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['action_controle'] == "Confirmation") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #2cd07e!important";
                    $rowETAT = "Confirmation réalisation de contrôle";
                }
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_historique_controle'] . '</td>
                <td class="border-top-0">' . $row['nom_typecontrole'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                <td class="border-top-0">' . $row['nom_user'] . '</td>
                <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>
                <td class="border-top-0">' . $row['date_action_controle'] . '</td>';
                
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        $query1 = ("SELECT *
            from historique_controle AS HC
            LEFT JOIN controletechnique AS CT ON HC.id_controle = CT.id_controletechnique 
            LEFT JOIN voiture AS V ON CT.id_voiture = V.id_voiture
            LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel 
            LEFT JOIN type_controle_technique AS T ON CT.type_controletechnique = T.id_type_controle 
            JOIN user AS U ON HC.id_user_controle = U.id_user
            ORDER BY HC.id_historique_controle DESC");

        $result1 = mysqli_query($conn, $query1);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            if ($row1['action_controle'] == "Confirmation") {
                $color = "badge bg-light-info text-white fw-normal";
                $color1 = "background-color: #2cd07e!important";
                $rowETAT = "Confirmation réalisation de contrôle";
            }
            $value .= '
            <tr>
            <td class="border-top-0">' . $row1['id_historique_controle'] . '</td>
            <td class="border-top-0">' . $row1['nom_typecontrole'] . '</td>
            <td class="border-top-0">' . $row1['pimm'] . " - " . $row1['Marque'] . '</br>' . $row1['Model'] . '</td>
            <td class="border-top-0">' . $row1['nom_user'] . '</td>
            <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>
            <td class="border-top-0">' . $row1['date_action_controle'] . '</td>';
            
            $value .= '</tr>';
        }
        $value .= '</table>';
        echo $value;
    }
}

/*
 * 
 */

function DisplayEntretienRecordVoiture()
{
    global $conn;
    if ($_SESSION['Role'] == "responsable" || $_SESSION['Role'] == "mecanicien") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Type d\'intervention</th>
        <th class="border-top-0">Lieu Entretien</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Matériel</th>
        <th class="border-top-0">Cout Entretien</th>
        <th class="border-top-0">Date Début </th>
        <th class="border-top-0">Date Fin </th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Type d\'intervention</th>
        <th class="border-top-0">Lieu Entretien</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Matériel</th>
        <th class="border-top-0">Cout Entretien</th>
        <th class="border-top-0">Date Début </th>
        <th class="border-top-0">Date Fin </th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        </tr>';
    }

    $query = "SELECT *,E.type AS TYPEentretien FROM entretien AS E 
    LEFT JOIN voiture AS V ON E.id_voiture =V.id_voiture
    LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel
    LEFT JOIN materiels AS M ON E.id_materiel = M.id_materiels
    LEFT JOIN materiels_agence AS MA ON MA.id_materiels = M.id_materiels
    WHERE etat_entretien = '0'
    GROUP BY id_entretien";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['TYPEentretien'] == 'Vehicule') {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_entretien'] . '</td>
                <td class="border-top-0">' . $row['TYPEentretien'] . '</td>
                <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                <td class="border-top-0">' . " " . '</td>
                <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                <td class="border-top-0">' . $row['date_entretien'] . '</td>
                <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                <td class="border-top-0">' . $row['commentaire'] . '</td>
                <td class="border-top-0">' . $row['commentaire_intervenant'] . '</td>';
        } else if ($row['TYPEentretien'] == 'Materiel') {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_entretien'] . '</td>
                <td class="border-top-0">' . $row['TYPEentretien'] . '</td>
                <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                <td class="border-top-0">' . " " . '</td>
                <td class="border-top-0">' . $row['designation'] . ' - ' . $row['code_materiel'] . ' ' . $row['num_serie_materiels']  . '</td>
                <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                <td class="border-top-0">' . $row['date_entretien'] . '</td>
                <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                <td class="border-top-0">' . $row['commentaire'] . '</td>
                <td class="border-top-0">' . $row['commentaire_intervenant'] . '</td>';
        }
        if ($_SESSION['Role'] == "responsable") {
            $value .= '<td class="border-top-0">
                  <button type="button" title="Modifier l\'entretien" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-Entretien" data-id=' . $row['id_entretien'] . '><i class="fas fa-edit"></i></button> 
                  <button type="button" title="Supprimer l\'entretien" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-Entretien" data-id1=' . $row['id_entretien'] . '><i class="fas fa-trash-alt"></i></button>
                  <button type="button" title="Confirmer la réalisation de l\'entretien" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-confirmation-Entretien" data-id2=' . $row['id_entretien'] . '><i class="fas fa-check"></i></button>
            </td>';
        }else if($_SESSION['Role'] == "mecanicien") {
            $value .= '<td class="border-top-0">
                  <button type="button" title="Modifier l\'entretien" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-Entretien-mecanicien" data-id3=' . $row['id_entretien'] . '><i class="fas fa-edit"></i></button> 
            </td>';
        }
        $value .= '</tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function select_contrat_voiture_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT C.id_contrat,C.date_contrat,C.duree,C.caution,C.KMPrevu,C.id_client,
    C.type_location,C.num_contrat,C.date_debut,C.date_prelevement,C.date_fin,C.prix,C.assurance,
    C.mode_de_paiement,C.num_cheque_caution,CL.id_client,CL.nom,CL.adresse,
    CL.tel,CL.email,CL.cin,V.pimm,MM.Model,MM.Marque,V.type,C.id_voiture
    FROM contrat_client AS C 
    LEFT JOIN client AS CL ON C.id_client =CL.id_client 
    LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture 
    LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
    WHERE C.type_location = 'Vehicule' 
    AND C.id_client =CL.id_client 
    AND C.id_contrat='$ContratId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $contrat_materiel_data = [];
        $contrat_materiel_data[0] = $row['id_contrat'];
        $contrat_materiel_data[1] = $row['id_client'];
        $contrat_materiel_data[18] = $row['nom'];
        $contrat_materiel_data[2] = $row['email'];
        $contrat_materiel_data[3] = $row['tel'];
        $contrat_materiel_data[4] = $row['adresse'];
        $contrat_materiel_data[5] = $row['type'];
        $contrat_materiel_data[6] = $row['Marque'] . ' ' . $row['Model'];
        $contrat_materiel_data[7] = $row['pimm'];
        $contrat_materiel_data[8] = $row['date_debut'];
        $contrat_materiel_data[9] = $row['date_fin'];
        $contrat_materiel_data[10] = $row['prix'];
        $contrat_materiel_data[11] = $row['mode_de_paiement'];
        $contrat_materiel_data[12] = $row['caution'];
        $contrat_materiel_data[13] = $row['date_contrat'];
        $contrat_materiel_data[14] = $row['KMPrevu'];
        $contrat_materiel_data[15] = $row['date_prelevement'];
        $contrat_materiel_data[16] = $row['duree'];
        $contrat_materiel_data[17] = $row['num_cheque_caution'];
    }
    echo json_encode($contrat_materiel_data);
}

//select_contrat_materiel_record();
function select_contrat_materiel_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT CL.nom, CL.email, CL.tel, CL.adresse, 
    C.id_contrat, C.date_contrat, C.date_debut, C.date_fin, C.prix,
     C.mode_de_paiement, C.date_prelevement, C.caution, C.num_cb_caution,
      CM.designation_contrat, CM.num_serie_contrat, CC.designation_composant, 
      CC.num_serie_composant 
    FROM materiel_contrat_client AS CM 
    LEFT JOIN contrat_client AS C ON CM.id_contrat =C.id_contrat
    LEFT JOIN client AS CL ON CL.id_client = C.id_client 
    LEFT JOIN composant_materiels_contrat AS CC ON CC.id_contrat =CM.id_contrat
    WHERE C.type_location = 'Materiel' 
    AND C.id_contrat='$ContratId'";
    $result = mysqli_query($conn, $query);
    $contrat_materiel_data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        if (empty($contrat_materiel_data)) {
            $contrat_materiel_data[0] = $row['id_contrat'];
            $contrat_materiel_data[1] = $row['nom'];
            $contrat_materiel_data[2] = $row['email'];
            $contrat_materiel_data[3] = $row['tel'];
            $contrat_materiel_data[4] = $row['adresse'];
            $contrat_materiel_data[5] = $row['designation_contrat'];
            $contrat_materiel_data[6] = $row['num_serie_contrat'];
            $contrat_materiel_data[7][] = $row['designation_composant'];
            $contrat_materiel_data[14][] = $row['num_serie_composant'];
            $contrat_materiel_data[8] = $row['date_debut'];
            $contrat_materiel_data[9] = $row['date_fin'];
            $contrat_materiel_data[10] = $row['prix'];
            $contrat_materiel_data[11] = $row['mode_de_paiement'];
            $contrat_materiel_data[12] = $row['caution'];
            $contrat_materiel_data[13] = $row['date_contrat'];
            $contrat_materiel_data[15] = $row['date_prelevement'];
            $contrat_materiel_data[16] = $row['num_cb_caution'];
        } else {
            $contrat_materiel_data[7][] = $row['designation_composant'];
            $contrat_materiel_data[14][] = $row['num_serie_composant'];
        }
    }
    echo json_encode($contrat_materiel_data);
}

// dispaly client data function
function searchAgence()
{
    global $conn;
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Lieu agence</th>
            <th class="border-top-0">Date création agence</th>
            <th class="border-top-0">E-mail agence</th>
            <th class="border-top-0">Tél agence</th>
            <th class="border-top-0">Horaire</th>
            <th class="border-top-0">Actions</th> 
        </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM  agence
        WHERE  etat_agence !='S' 
        AND id_agence != 0
        AND  ( id_agence LIKE ('%" . $search . "%')
            OR lieu_agence LIKE ('%" . $search . "%')       
            OR date_agence LIKE ('%" . $search . "%')
            OR email_agence LIKE ('%" . $search . "%')
            OR tel_agence LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_agence'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['date_agence'] . '</td>
                <td class="border-top-0">' . $row['email_agence'] . '</td>
                <td class="border-top-0">' . $row['tel_agence'] . '</td>
                <td class="border-top-0">  
                <br> ';
                $id_agence = $row['id_agence'];
                $queryagence = " SELECT * FROM  ouverture_agences
                WHERE  id_agence_oa = $id_agence 
                ORDER BY jours ASC ";
                $resultagence = mysqli_query($conn, $queryagence);
                while ($row1 = mysqli_fetch_assoc($resultagence)) {
                    $value .= '<button  type="button" title="Supprimer l\'horaire" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-agence-heur" data-id4=' . $row1['id_oa'] . '>X</button>' . '    ' .
                                $row1['jours'] . ' : ' . $row1['horaire_debut'] . ' / ' . $row1['horaire_fin'] .
                                '<br>';
                }
                $value .= '<td class="border-top-0">
                  <button type="button" title="Modifier l\'agence" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-agence" data-id=' . $row['id_agence'] . '><i class="fas fa-edit"></i></button> 
                  <button type="button" title="Supprimer l\'agence" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-agence" data-id1=' . $row['id_agence'] . '>
                  <i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
            }
            $value .= '</table>';

            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_agence_record();
    }
}
//end

//
function searchUser()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Nom</th>
    <th class="border-top-0">Login</th>
    <th class="border-top-0">Email</th>
    <th class="border-top-0">Rôle</th>
    <th class="border-top-0">Lieu Agence</th>
    <th class="border-top-0">Etat</th>
    <th class="border-top-0">Actions</th>
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $searchrole = $_POST['query'];
        $mystring = 'agent';
        $mystring1 = 'admin';
        if ($searchrole != "") {
            if(preg_match("/{$searchrole}/i", $mystring)){
                $search = "admin";
            }else if(preg_match("/{$searchrole}/i", $mystring1)){
                $search = "responsable";
            }
        }

        $sql = ("SELECT * 
        FROM user,agence 
        WHERE (user.id_agence = agence.id_agence)
        AND etat_user != 'S'
        AND (id_user LIKE ('%" . $search . "%')
            OR nom_user LIKE ('%" . $search . "%')       
            OR login LIKE ('%" . $search . "%')       
            OR email_user LIKE ('%" . $search . "%')       
            OR role LIKE ('%" . $search . "%')
            OR lieu_agence LIKE ('%" . $search . "%'))");

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['etat_user'] == 'T') {
                    $etat = "active";
                } else {
                    $etat = "désactiver";
                }
                $roles ='';
        
                if ($row['role'] == 'responsable')
                {
                    $roles = "admin";
                }
                else if ($row['role']=='admin')
                {
                    $roles ="agent";
                }
                else {
                    $roles = $row['role'];
                }
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_user'] . '</td>
                <td class="border-top-0">' . $row['nom_user'] . '</td>
                <td class="border-top-0">' . $row['login'] . '</td>
                <td class="border-top-0">' . $row['email_user'] . '</td>
                <td class="border-top-0">' . $roles . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $etat . '</td>
                <td class="border-top-0">
                <button type="button" title="Modifier l\'utilisateur" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-user" data-id=' . $row['id_user'] . '><i class="fas fa-edit"></i></button> ';
                if ($row['role'] != 'superadmin') {
                    $value .= '<button type="button" title="Supprimer l\'utilisateur" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-user" data-id1=' . $row['id_user'] . '><i class="fas fa-trash-alt"></i></button>';
                }
                $value .= '</td></tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_user_record();
    }
}

function searchClient()
{
    global $conn;
    if (($_SESSION['Role']) != "superadmin") {
        $value = '<table class="table table-striped">
        <thead class="thead-light">
        <tr style="height:10px;">
            <th class="border-top-0">Nom de l\'entreprise</th>
            <th class="border-top-0">Nom Conducteur</th>
            <th class="border-top-0">E-mail</th>
            <th class="border-top-0" style="min-width:110px;">Téléphone</th>
            <th class="border-top-0">Adresse</th>
            <th class="border-top-0">Actions</th>   
        </tr>
        </thead>';
    } else {
        $value = '<table class="table table-striped">
        <tr>
            <th class="border-top-0">Nom de l\'entreprise</th>
            <th class="border-top-0">Nom Conducteur</th>
            <th class="border-top-0">E-mail</th>
            <th class="border-top-0" style="min-width:110px;">Téléphone</th>
            <th class="border-top-0">Adresse</th>
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM client
         WHERE etat_client ='A'
         AND ( nom LIKE ('%" . $search . "%')
                OR nom_entreprise LIKE ('%" . $search . "%') 
                OR email LIKE ('%" . $search . "%')       
                OR raison_social LIKE ('%" . $search . "%')   
                OR num_permis LIKE ('%" . $search . "%')      
                OR comment LIKE ('%" . $search . "%')       
                OR type LIKE ('%" . $search . "%')
                OR date_creation_entreprise LIKE ('%" . $search . "%')
                OR siret LIKE ('%" . $search . "%')       
                OR naf LIKE ('%" . $search . "%')       
                OR codetva LIKE ('%" . $search . "%')       
                OR adresse LIKE ('%" . $search . "%')
                OR tel LIKE ('%" . $search . "%')
                OR id_client LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['nom_entreprise'] . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . wordwrap($row['tel'], 2, " ", 1) . '</td>
                <td class="border-top-0">' . $row['adresse'] . '</td>
                <style>
                .cin:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
                </style>';
                if (($_SESSION['Role']) != "superadmin") {
                    if ($row['type'] == "CLIENT PRO") {
                        $value .= '   <td class="border-top-0">';
                        $ddate = $row['date_update_doc'];
                        $cdate = date("Y-m-d");
                        if (strtotime("+3 months", strtotime($ddate)) < strtotime($cdate)) {
                            $value .= '    <button type="button" title="Modifier les documents du client" class="btn waves-effect waves-light btn-outline-danger" style="width:55px; height:45px;" id="btn-edit-doc" data-id3=' . $row['id_client'] . '><i class="fas fa-clock"></i></button> ';
                        }
                        $value .= '    <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> ';
                        $value .= '   <button type="button" title="Modifier le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-client" data-id=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
                    } else {
                        $value .= '   <td class="border-top-0">';
                        $ddate = $row['date_update_doc'];
                        $cdate = date("Y-m-d");
                        if (strtotime("+3 months", strtotime($ddate)) < strtotime($cdate)) {
                            $value .= '    <button type="button" title="Modifier les documents du client" class="btn waves-effect waves-light btn-outline-danger" style="width:55px; height:45px;" id="btn-edit-doc" data-id3=' . $row['id_client'] . '><i class="fas fa-clock"></i></button> ';
                        }
                        $value .= '<button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client-part" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> ';
                        $value .= '<button type="button" title="Modifier le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-client-part" data-id2=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
                    }
                    $value .= '<button type="button" title="Supprimer le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-client" data-id1=' . $row['id_client'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>';
                } else {
                    if ($row['type'] == "CLIENT PRO") {
                        $value .= '   <td class="border-top-0">';
                        $value .= '  <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> 
                        </td></tr>';
                    } else {
                        $value .= '   <td class="border-top-0">';
                        $value .= '  <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client-part" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> 
                        </td></tr>';
                    }
                }
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_client_record();
    }
}
//end

function searchClientInactif()
{
    global $conn;
    if (($_SESSION['Role']) != "superadmin") {
        $value = '<table class="table table-striped">
        <thead class="thead-light">
        <tr style="height:10px;">
            <th class="border-top-0">Nom de l\'entreprise</th>
            <th class="border-top-0">Nom Conducteur</th>
            <th class="border-top-0">E-mail</th>
            <th class="border-top-0" style="min-width:110px;">Téléphone</th>
            <th class="border-top-0">Adresse</th>
            <th class="border-top-0">Actions</th>   
        </tr>
        </thead>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">Nom de l\'entreprise</th>
            <th class="border-top-0">Nom Conducteur</th>
            <th class="border-top-0">E-mail</th>
            <th class="border-top-0" style="min-width:110px;">Téléphone</th>
            <th class="border-top-0">Adresse</th>
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM client
            WHERE etat_client ='I'
            AND ( nom LIKE ('%" . $search . "%')
                OR nom_entreprise LIKE ('%" . $search . "%') 
                OR email LIKE ('%" . $search . "%')       
                OR raison_social LIKE ('%" . $search . "%') 
                OR num_permis LIKE ('%" . $search . "%')       
                OR comment LIKE ('%" . $search . "%')       
                OR type LIKE ('%" . $search . "%')
                OR date_creation_entreprise LIKE ('%" . $search . "%')
                OR siret LIKE ('%" . $search . "%')       
                OR naf LIKE ('%" . $search . "%')       
                OR codetva LIKE ('%" . $search . "%')       
                OR adresse LIKE ('%" . $search . "%')
                OR tel LIKE ('%" . $search . "%')
                OR id_client LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['nom_entreprise'] . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . wordwrap($row['tel'], 2, " ", 1) . '</td>
                <td class="border-top-0">' . $row['adresse'] . '</td>
                <style>
                    .cin:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
                </style>';
                if (($_SESSION['Role']) != "superadmin") {
                    if ($row['type'] == "CLIENT PRO") {
                        $value .= '   <td class="border-top-0">';
                        $ddate = $row['date_update_doc'];
                        $cdate = date("Y-m-d");
                        if (strtotime("+3 months", strtotime($ddate)) < strtotime($cdate)) {
                            $value .= '    <button type="button" title="Modifier les documents du client" class="btn waves-effect waves-light btn-outline-danger" style="width:55px; height:45px;" id="btn-edit-doc" data-id3=' . $row['id_client'] . '><i class="fas fa-clock"></i></button> ';
                        }
                        $value .= '    <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> ';
                        $value .= '   <button type="button" title="Modifier le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-client" data-id=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
                    } else {
                        $value .= '   <td class="border-top-0">';
                        $ddate = $row['date_update_doc'];
                        $cdate = date("Y-m-d");
                        if (strtotime("+3 months", strtotime($ddate)) < strtotime($cdate)) {
                            $value .= '    <button type="button" title="Modifier les documents du client" class="btn waves-effect waves-light btn-outline-danger" style="width:55px; height:45px;" id="btn-edit-doc" data-id3=' . $row['id_client'] . '><i class="fas fa-clock"></i></button> ';
                        }
                        $value .= '   <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client-part" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> ';
                        $value .= '   <button type="button" title="Modifier le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-client-part" data-id2=' . $row['id_client'] . '><i class="fas fa-edit"></i></button> ';
                    }
                    $value .= '       <button type="button" title="Supprimer le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-client" data-id1=' . $row['id_client'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>';
                } else {
                    if ($row['type'] == "CLIENT PRO") {
                        $value .= '   <td class="border-top-0">';
                        $value .= '  <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> 
                        </td></tr>';
                    } else {
                        $value .= '   <td class="border-top-0">';
                        $value .= '  <button type="button" title="Afficher le client" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-show-client-part" data-id=' . $row['id_client'] . '><i class="fas fa-eye"></i></button> 
                        </td></tr>';
                    }
                }
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_client_inactif_record();
    }
}
//end
function searchCategorie()
{
    global $conn;
    if(($_SESSION['Role']) == "responsable"){
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Code de catégorie</th>
            <th class="border-top-0">Famille de catégorie</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Type de location</th>
            <th class="border-top-0">N° serie obligatoire</th>
            <th class="border-top-0">Actions</th>  
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Code de catégorie</th>
            <th class="border-top-0">Famille de catégorie</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Type de location</th>
            <th class="border-top-0">N° serie obligatoire</th> 
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT * FROM materiels
         WHERE etat_materiels_categorie !='S'
         AND ( code_materiel LIKE ('%" . $search . "%')
                OR famille_materiel LIKE ('%" . $search . "%')       
                OR designation LIKE ('%" . $search . "%')
                OR type_location LIKE ('%" . $search . "%')
                OR id_materiels LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['num_serie_obg'] == 'T') {
                    $obligatoireserie = 'OUI';
                } else {
                    $obligatoireserie = 'NON';
                }
                if (($_SESSION['Role']) == "responsable") {
                    $value .= '<tr>
                                <td class="border-top-0">' . $row['id_materiels'] . '</td>
                                <td class="border-top-0">' . $row['code_materiel'] . '</td>
                                <td class="border-top-0">' . $row['famille_materiel'] . '</td>
                                <td class="border-top-0">' . $row['designation'] . '</td>
                                <td class="border-top-0">' . $row['type_location'] . '</td>
                                <td class="border-top-0">' . $obligatoireserie . '</td>
                                <td class="border-top-0">
                                    <button type="button" title="Modifier le catégorie" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-categorie" data-id=' . $row['id_materiels'] . '><i class="fas fa-edit"></i></button>
                                    <button type="button" title="Supprimer le catégorie" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-categorie" data-id1=' . $row['id_materiels'] . '><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>';
                }else{
                    $value .= '<tr>
                                <td class="border-top-0">' . $row['id_materiels'] . '</td>
                                <td class="border-top-0">' . $row['code_materiel'] . '</td>
                                <td class="border-top-0">' . $row['famille_materiel'] . '</td>
                                <td class="border-top-0">' . $row['designation'] . '</td>
                                <td class="border-top-0">' . $row['type_location'] . '</td>
                                <td class="border-top-0">' . $obligatoireserie . '</td>
                            </tr>';
                }
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_categorie_record();
    }
}
//end

//
function searchVoiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($id_agence != "0") {
        $value = '<table class="table">
            <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Type</th>
            <th class="border-top-0">PIMM</th>
            <th class="border-top-0">Marque/Modèle</th>
            <th class="border-top-0">Boite de vitesse</th>
            <th class="border-top-0">Type de carburant</th>
            <th class="border-top-0">Date VGP</th>
            <th class="border-top-0">Date CT</th>
            <th class="border-top-0">Date Pollution</th>
            <th class="border-top-0">Carte grise</th>
            <th class="border-top-0">Carte verte</th>
            <th class="border-top-0">Actions</th>      
            </tr>';
    } else if (($_SESSION['Role']) != "superadmin") {
        $value = '<table class="table">
            <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Type</th>
            <th class="border-top-0">PIMM</th>
            <th class="border-top-0">Marque/Modèle</th>
            <th class="border-top-0">Agence</th>
            <th class="border-top-0">Boite de vitesse</th>
            <th class="border-top-0">Type de carburant</th>
            <th class="border-top-0">Date VGP</th>
            <th class="border-top-0">Date CT</th>
            <th class="border-top-0">Date Pollution</th>
            <th class="border-top-0">Carte grise</th>
            <th class="border-top-0">Carte verte</th>
            <th class="border-top-0">Actions</th>      
            </tr>';
    } else {
        $value = '<table class="table">
            <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Type</th>
            <th class="border-top-0">PIMM</th>
            <th class="border-top-0">Marque/Modèle</th>
            <th class="border-top-0">Agence</th>
            <th class="border-top-0">Boite de vitesse</th>
            <th class="border-top-0">Type de carburant</th>
            <th class="border-top-0">Date VGP</th>
            <th class="border-top-0">Date CT</th>
            <th class="border-top-0">Date Pollution</th>
            <th class="border-top-0">Carte grise</th>
            <th class="border-top-0">Carte verte</th>   
            </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = ("SELECT * 
                FROM voiture as V 
                LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
                WHERE V.etat_voiture = 'Disponible' 
                AND actions='T'
                AND V.id_agence='$id_agence' 
                AND (V.id_voiture LIKE ('%" . $search . "%')
                OR V.type LIKE ('%" . strtoupper($search) . "%')        
                OR V.pimm LIKE ('%" . $search . "%')
                OR V.boite_vitesse LIKE ('%" . $search . "%')       
                OR V.type_carburant LIKE ('%" . $search . "%')
                OR MM.Marque LIKE ('%" . $search . "%')
                OR MM.Model LIKE ('%" . $search . "%')
                OR V.date_DPC_VGP LIKE ('%" . $search . "%')
                OR V.date_DPC_VT LIKE ('%" . $search . "%')
                OR V.date_DPT_Pollution LIKE ('%" . $search . "%'))");
        } else {
            $sql = ("SELECT * 
            FROM voiture as V
            LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
            LEFT JOIN agence AS A on V.id_agence=A.id_agence 
            WHERE V.etat_voiture = 'Disponible' 
            AND actions='T'
            AND (V.id_voiture LIKE ('%" . $search . "%')
                    OR V.type LIKE ('%" . strtoupper($search) . "%')        
                    OR V.pimm LIKE ('%" . $search . "%')
                    OR V.boite_vitesse LIKE ('%" . $search . "%')       
                    OR V.type_carburant LIKE ('%" . $search . "%')
                    OR MM.Marque LIKE ('%" . $search . "%')
                    OR MM.Model LIKE ('%" . $search . "%')
                    OR lieu_agence LIKE ('%" . strtoupper($search) . "%')  
                    OR V.date_DPC_VGP LIKE ('%" . $search . "%')
                    OR V.date_DPC_VT LIKE ('%" . $search . "%')
                    OR V.date_DPT_Pollution LIKE ('%" . $search . "%'))");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($id_agence != "0") {
                    $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_voiture'] . '</td>
                        <td class="border-top-0">' . $row['type'] . '</td>
                        <td class="border-top-0">' . $row['pimm'] . '</td>
                        <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                        <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
                        <td class="border-top-0">' . $row['type_carburant'] . '</td>
                        <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                        <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                        <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
                } else {
                    $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_voiture'] . '</td>
                        <td class="border-top-0">' . $row['type'] . '</td>
                        <td class="border-top-0">' . $row['pimm'] . '</td>
                        <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                        <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                        <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
                        <td class="border-top-0">' . $row['type_carburant'] . '</td>
                        <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                        <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                        <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
                }
                $value .= '
                <style>
                .carte_grise:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
                </style>       
                <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_grise"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>
                <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_verte"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>';
                if (($_SESSION['Role']) != "superadmin") {
                    $value .= '
                    <td class="border-top-0">
                    <button type="button" title="Modifier la voiture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-voiture" data-id=' . $row['id_voiture'] . '><i class="fas fa-edit"></i></button>
                    <button type="button" title="Supprimer la voiture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-voiture" data-id1=' . $row['id_voiture'] . '><i class="fas fa-trash-alt"></i></button>
                    </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_voiture_record();
    }
}
//end

//
function searchVoitureVendu()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($id_agence != "0") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        <th class="border-top-0">Action</th>
        </tr>';
    } else if (($_SESSION['Role']) != "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        <th class="border-top-0">Action</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = ("SELECT * 
            FROM voiture AS V
            LEFT JOIN histrique_voiture AS HV on V.id_voiture=HV.id_voiture_HV
            LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel   
            WHERE HV.action = 'Vendue' 
            AND V.id_agence='$id_agence'
            AND (id_histrique_voiture LIKE ('%" . $search . "%')
                OR type LIKE ('%" . strtoupper($search) . "%')       
                OR pimm LIKE ('%" . $search . "%')                         
                OR date_HV LIKE ('%" . $search . "%')       
                OR commentaire_HV LIKE ('%" . $search . "%')
                OR V.boite_vitesse LIKE ('%" . $search . "%')       
                OR V.type_carburant LIKE ('%" . $search . "%')
                OR MM.Marque LIKE ('%" . $search . "%')
                OR MM.Model LIKE ('%" . $search . "%')
                OR V.date_DPC_VGP LIKE ('%" . $search . "%')
                OR V.date_DPC_VT LIKE ('%" . $search . "%')
                OR V.date_DPT_Pollution LIKE ('%" . $search . "%'))");
        } else {
            $sql = ("SELECT * 
            FROM voiture AS V
            LEFT JOIN histrique_voiture AS HV on V.id_voiture=HV.id_voiture_HV
            LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
            LEFT JOIN agence AS A on V.id_agence=A.id_agence   
            WHERE HV.action = 'Vendue' 
            AND (id_histrique_voiture LIKE ('%" . $search . "%')
                OR type LIKE ('%" . strtoupper($search) . "%')       
                OR pimm LIKE ('%" . $search . "%')                         
                OR date_HV LIKE ('%" . $search . "%')       
                OR commentaire_HV LIKE ('%" . $search . "%')
                OR V.boite_vitesse LIKE ('%" . $search . "%')       
                OR V.type_carburant LIKE ('%" . $search . "%')
                OR MM.Marque LIKE ('%" . $search . "%')
                OR MM.Model LIKE ('%" . $search . "%')
                OR lieu_agence LIKE ('%" . strtoupper($search) . "%')  
                OR V.date_DPC_VGP LIKE ('%" . $search . "%')
                OR V.date_DPC_VT LIKE ('%" . $search . "%')
                OR V.date_DPT_Pollution LIKE ('%" . $search . "%'))");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($id_agence != "0") {
                    $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                        <td class="border-top-0">' . $row['type'] . '</td>
                        <td class="border-top-0">' . $row['pimm'] . '</td>
                        <td class="border-top-0">' . $row['date_HV'] . '</td>
                        <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
                        <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                        <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
                        <td class="border-top-0">' . $row['type_carburant'] . '</td>
                        <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                        <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                        <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
                } else {
                    $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                        <td class="border-top-0">' . $row['type'] . '</td>
                        <td class="border-top-0">' . $row['pimm'] . '</td>
                        <td class="border-top-0">' . $row['date_HV'] . '</td>
                        <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
                        <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                        <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                        <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
                        <td class="border-top-0">' . $row['type_carburant'] . '</td>
                        <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                        <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                        <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
                }
                $value .= '
                <style>
                .carte_grise:hover {   
                    box-shadow: 0px 0px 150px #000000;
                    z-index: 2;
                    -webkit-transition: all 200ms ease-in;
                    -webkit-transform: scale(5);
                    -ms-transition: all 200ms ease-in;
                    -ms-transform: scale(1.5);   
                    -moz-transition: all 200ms ease-in;
                    -moz-transform: scale(1.5);
                    transition: all 200ms ease-in;
                    transform: scale(1.5);}
                </style>       
                <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_grise"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>
                <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_verte"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>';
                if (($_SESSION['Role']) != "superadmin") {
                    $value .= '  
                    <td class="border-top-0">
                    <button type="button" title="Modifier la voiture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-voiture-vendue" data-id=' . $row['id_histrique_voiture'] . '><i class="fas fa-edit"></i></button> 
                    </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_voiture_vendue_record();
    }
}
//end

//searchVoitureHS
function searchVoitureHS()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($id_agence != "0") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        <th class="border-top-0">Action</th> 
        </tr>';
    } else if (($_SESSION['Role']) != "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        <th class="border-top-0">Action</th> 
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date vente</th>
        <th class="border-top-0">Commentaire</th>
        <th class="border-top-0">Marque/Modèle</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Boite de vitesse</th>
        <th class="border-top-0">Type de carburant</th>
        <th class="border-top-0">Date VGP</th>
        <th class="border-top-0">Date CT</th>
        <th class="border-top-0">Date Pollution</th>
        <th class="border-top-0">Carte grise</th>
        <th class="border-top-0">Carte verte</th>
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = ("SELECT * 
            FROM voiture AS V
            LEFT JOIN histrique_voiture AS HV on V.id_voiture=HV.id_voiture_HV
            LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel   
            WHERE V.etat_voiture = 'HS'
            AND HV.action = 'HS'
            AND V.id_agence='$id_agence' 
            AND (id_histrique_voiture LIKE ('%" . $search . "%')
                OR type LIKE ('%" . strtoupper($search) . "%')       
                OR pimm LIKE ('%" . $search . "%')                         
                OR date_HV LIKE ('%" . $search . "%')       
                OR commentaire_HV LIKE ('%" . $search . "%')
                OR boite_vitesse LIKE ('%" . $search . "%')       
                OR type_carburant LIKE ('%" . $search . "%')
                OR Marque LIKE ('%" . $search . "%')
                OR Model LIKE ('%" . $search . "%')
                OR date_DPC_VGP LIKE ('%" . $search . "%')
                OR date_DPC_VT LIKE ('%" . $search . "%')
                OR date_DPT_Pollution LIKE ('%" . $search . "%'))");
        } else {
            $sql = ("SELECT * 
            FROM voiture AS V
            LEFT JOIN histrique_voiture AS HV on V.id_voiture=HV.id_voiture_HV
            LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel   
            LEFT JOIN agence AS A on A.id_agence=V.id_agence  
            WHERE V.etat_voiture = 'HS'
            AND HV.action = 'HS'
            AND (id_histrique_voiture LIKE ('%" . $search . "%')
                OR type LIKE ('%" . strtoupper($search) . "%')       
                OR pimm LIKE ('%" . $search . "%')                         
                OR date_HV LIKE ('%" . $search . "%')       
                OR commentaire_HV LIKE ('%" . $search . "%')
                OR boite_vitesse LIKE ('%" . $search . "%')       
                OR type_carburant LIKE ('%" . $search . "%')
                OR Marque LIKE ('%" . $search . "%')
                OR Model LIKE ('%" . $search . "%')
                OR lieu_agence LIKE ('%" . strtoupper($search) . "%') 
                OR date_DPC_VGP LIKE ('%" . $search . "%')
                OR date_DPC_VT LIKE ('%" . $search . "%')
                OR date_DPT_Pollution LIKE ('%" . $search . "%'))");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($id_agence != "0") {
                    $value .= '
                <tr>
                    <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                    <td class="border-top-0">' . $row['type'] . '</td>
                    <td class="border-top-0">' . $row['pimm'] . '</td>
                    <td class="border-top-0">' . $row['date_HV'] . '</td>
                    <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
                    <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                    <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
                    <td class="border-top-0">' . $row['type_carburant'] . '</td>
                    <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                    <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                    <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
                } else {
                    $value .= '
                    <tr>
                    <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                    <td class="border-top-0">' . $row['type'] . '</td>
                    <td class="border-top-0">' . $row['pimm'] . '</td>
                    <td class="border-top-0">' . $row['date_HV'] . '</td>
                    <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
                    <td class="border-top-0">' . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                    <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                    <td class="border-top-0">' . $row['boite_vitesse'] . '</td>
                    <td class="border-top-0">' . $row['type_carburant'] . '</td>
                    <td class="border-top-0">' . $row['date_DPC_VGP'] . '</td>
                    <td class="border-top-0">' . $row['date_DPC_VT'] . '</td>
                    <td class="border-top-0">' . $row['date_DPT_Pollution'] . '</td>';
                }
                $value .= '
                    <style>
                    .carte_grise:hover {   
                        box-shadow: 0px 0px 150px #000000;
                        z-index: 2;
                        -webkit-transition: all 200ms ease-in;
                        -webkit-transform: scale(5);
                        -ms-transition: all 200ms ease-in;
                        -ms-transform: scale(1.5);   
                        -moz-transition: all 200ms ease-in;
                        -moz-transform: scale(1.5);
                        transition: all 200ms ease-in;
                        transform: scale(1.5);}
                    </style>       
                    <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_grise"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>
                    <td class="border-top-0"><a href="uploads/voiture/' . $row["carte_verte"] . '" target="_blank"><img width="40px"height="30px" class="cin" src="icone.png"></a></td>';
                if (($_SESSION['Role']) != "superadmin") {
                    $value .= '
                        <td class="border-top-0">
                        <button type="button" title="Modifier la voiture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-voiture-HS" data-id=' . $row['id_histrique_voiture'] . '><i class="fas fa-edit"></i></button> 
                        </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_voiture_hs_record();
    }
}
//end searchVoitureHS

// searchMateriel
function searchMateriel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($id_agence != "0") {
        $value = '<div class="table-responsive">
        <table class="table">
        <thead >
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0"> Code de matériel</th>
            <th class="border-top-0">N° de série</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Type de location</th>
            <th class="border-top-0">Quantité</th>
            <th class="border-top-0">Quantité dispo</th>
            <th class="border-top-0">Composant</th>
            <th class="border-top-0">État</th>
                
        </tr>
        </thead>';
    } else if (($_SESSION['Role']) != "superadmin") {
        $value = '<div class="table-responsive">
        <table class="table">
        <thead >
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0"> Code de matériel</th>
            <th class="border-top-0">N° de série</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Agence</th>
            <th class="border-top-0">Type de location</th>
            <th class="border-top-0">Quantité</th>
            <th class="border-top-0">Quantité dispo</th>
            <th class="border-top-0">Composant</th>
            <th class="border-top-0">État</th>
            <th class="border-top-0">Actions</th>     
        </tr>
        </thead>';
    } else {
        $value = '<div class="table-responsive">
        <table class="table">
        <thead >
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0"> Code de matériel</th>
            <th class="border-top-0">N° de série</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Agence</th>
            <th class="border-top-0">Type de location</th>
            <th class="border-top-0">Quantité</th>
            <th class="border-top-0">Quantité dispo</th>
            <th class="border-top-0">Composant</th>
            <th class="border-top-0">État</th>    
        </tr>
        </thead>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = ("  SELECT * FROM materiels,materiels_agence 
        where materiels.id_materiels = materiels_agence.id_materiels 
        AND id_agence ='$id_agence' 
        AND materiels_agence.etat_materiels != 'F'
        AND (id_materiels_agence LIKE ('%" . $search . "%')
                OR code_materiel LIKE ('%" . $search . "%')       
                OR num_serie_materiels LIKE ('%" . $search . "%')
                OR designation LIKE ('%" . $search . "%')
                OR type_location LIKE ('%" . $search . "%')
                OR quantite_materiels LIKE ('%" . $search . "%')
                OR quantite_materiels_dispo LIKE ('%" . $search . "%') )
                ORDER BY id_materiels_agence ASC");
        } else {
            $sql = ("  SELECT * FROM materiels,materiels_agence,agence 
        where materiels.id_materiels = materiels_agence.id_materiels
        AND  materiels_agence.id_agence = agence.id_agence
        AND materiels_agence.etat_materiels != 'F'
        AND (id_materiels_agence LIKE ('%" . $search . "%')
                OR code_materiel LIKE ('%" . $search . "%')       
                OR num_serie_materiels LIKE ('%" . $search . "%')
                OR designation LIKE ('%" . $search . "%')
                OR lieu_agence LIKE ('%" . strtoupper($search) . "%')    
                OR type_location LIKE ('%" . $search . "%')
                OR quantite_materiels LIKE ('%" . $search . "%')
                OR quantite_materiels_dispo LIKE ('%" . $search . "%') )
                ORDER BY id_materiels_agence ASC");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $comp = $row['id_materiels_agence'];
                if ($row['etat_materiels'] == "T") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #2cd07e!important";
                    $etat = "ACTIF ";
                } elseif ($row['etat_materiels'] == "HS") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ffc36d!important";
                    $etat = "Hors Service";
                }

                if ($id_agence != "0") {
                    $value .= '
                    <tbody>
                    <tr ' . $color . ' >
                    <td class="border-top-0">' . $row['id_materiels_agence'] . '</td>
                    <td class="border-top-0">' . $row['code_materiel'] . '</td>
                    <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                    <td class="border-top-0">' . $row['designation'] . '</td>
                    <td class="border-top-0">' . $row['type_location'] . '</td>
                    <td class="border-top-0">' . $row['quantite_materiels'] . '</td>
                    <td class="border-top-0">' . $row['quantite_materiels_dispo'] . '</td>';
                    $value .= '<td class="border-top-0">';
                } else {
                    $value .= '
                    <tbody>
                    <tr ' . $color . ' >
                    <td class="border-top-0">' . $row['id_materiels_agence'] . '</td>
                    <td class="border-top-0">' . $row['code_materiel'] . '</td>
                    <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                    <td class="border-top-0">' . $row['designation'] . '</td>
                    <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                    <td class="border-top-0">' . $row['type_location'] . '</td>
                    <td class="border-top-0">' . $row['quantite_materiels'] . '</td>
                    <td class="border-top-0">' . $row['quantite_materiels_dispo'] . '</td>';
                    $value .= '<td class="border-top-0">';
                }
                $querycomp = "SELECT * FROM materiels_agence,composant_materiels where materiels_agence.id_materiels_agence = composant_materiels.id_materiels_agence 
                AND materiels_agence.id_materiels_agence = '$comp'";
                $resultcom = mysqli_query($conn, $querycomp);
                while ($row1 = mysqli_fetch_assoc($resultcom)) {
                    if (($_SESSION['Role']) == "responsable") {
                        $value .= ' <span class=" text-primary">
                            <button  type="button" title="Supprimer le composant" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-composant" data-id=' . $row1['id_composant_materiels'] . '>X</button> '
                            . $row1['num_serie_composant'] . ' - ' . $row1['designation_composant'] .
                            '</span> <br> ';
                    } else {
                        $value .= ' <span class=" text-primary">' . $row1['num_serie_composant'] . ' - ' . $row1['designation_composant'] .
                            '</span> <br> ';
                    }
                }
                $value .=   '</td>';

                $value .= ' <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                <td class="border-top-0">';
                if (($_SESSION['Role']) == "responsable") {
                    if ($row['num_serie_obg'] == "T") {
                        $value .= '
                        <button  type="button" title="Modifier le matériel" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-materiel" data-id=' . $row['id_materiels_agence'] . '><i class="fas fa-edit"></i></button>
                        <button  type="button" title="Ajouter un composant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-add-composant" data-id=' . $row['id_materiels_agence'] . '><i class="fas fa-plus"></i></button> ';
                    } else {
                        $value .= '  <button  type="button" title="Modifier le matériel" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-materiel-stock" data-id=' . $row['id_materiels_agence'] . '><i class="fas fa-edit"></i></button> ';
                    }
                    $value .=    ' 
                           
                            <button  type="button" title="Supprimer le matériel" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-materiel" data-id1=' . $row['id_materiels_agence'] . '><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>';
                }
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        view_materiel();
    }
}
//end searchMateriel

//searchVoitureHS
function searchGestionPack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($_SESSION['Role'] != "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Désignation</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Matériels</th>
        <th class="border-top-0">Etat Pack</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Désignation</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Matériels</th>
        <th class="border-top-0">Etat Pack</th>
        </tr>';
    }
    if (isset($_POST['query'])) {

        $search = $_POST['query'];
        $sql = ("SELECT * FROM group_packs where etat_group_pack !='S'
        AND (id_group_packs LIKE ('%" . $search . "%')
                OR designation_pack LIKE ('%" . $search . "%')          
                OR type_voiture LIKE ('%" . $search . "%'))");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $comp = $row['id_group_packs'];
                if ($row['etat_group_pack'] == "T") {
                    $etat = "Activer ";
                    $colour = "";
                } elseif ($row['etat_group_pack'] == "F") {
                    $etat = "Hors Service";
                    $colour = "style= 'background:#ececec' ";
                }

                $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_group_packs'] . '</td>
                        <td class="border-top-0">' . $row['designation_pack'] . '</td>
                        <td class="border-top-0">' . $row['type_voiture'] . '</td>';
                $value .= '<td class="border-top-0" >';
                $querycomp = "SELECT * FROM materiel_group_packs,materiels WHERE materiels.id_materiels = materiel_group_packs.id_materiels 
                        AND materiel_group_packs.id_group_packs = '$comp'";
                $resultcom = mysqli_query($conn, $querycomp);

                while ($row_materiels = mysqli_fetch_assoc($resultcom)) {
                    if ($_SESSION['Role'] != "superadmin") {
                        $value .= '<button  type="button" title="Supprimer le matériel" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-materiel" data-id=' . $row_materiels['id_materiel_group_packs'] . '>X</button>';
                    }
                    $value .= ' <span class=" text-primary">(' . $row_materiels['quantite'] . ')' . $row_materiels['designation'] . ' </span>
                    </br>  ';
                }
                $value .=   '</td>
                 <td class="border-top-0">' . $etat . '</td>';
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<td class="border-top-0">
                        <button type="button" title="Modifier le pack" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-pack" data-id=' . $row['id_group_packs'] . '><i class="fas fa-edit"></i></button> 
                        <button type="button" title="Supprimer le pack" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-pack" data-id1=' . $row['id_group_packs'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>';
                }
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_grouppack_record();
    }
}
//end searchVoitureHS


//searchStock
function searchStock()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
            <tr>
            <th class="border-top-1">ID</th>
            <th class="border-top-1">Pimm</th>
            <th class="border-top-1">Type</th>
            <th class="border-top-1">Marque & Modèle</th>
            <th class="border-top-1">Boite de vitesse</th>
            <th class="border-top-1">Type de carburant</th>
            <th class="border-top-1">Date Achat</th>
            <th class="border-top-1">Localisation</th>
            <th class="border-top-1">Disponibilité</th>
            <th class="border-top-1">Transfert </th>  
            </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = ("SELECT * FROM voiture,agence,marquemodel
            WHERE voiture.id_agence = agence.id_agence 
            AND voiture.id_MarqueModel = marquemodel.id_MarqueModel
            AND voiture.id_agence = '$id_agence'
            AND voiture.actions !='S'
            AND  (voiture.id_voiture LIKE ('%" . $search . "%')
                OR voiture.type LIKE ('%" . strtoupper($search) . "%')       
                OR voiture.pimm LIKE ('%" . $search . "%')
                OR marquemodel.Marque LIKE ('%" . $search . "%')
                OR marquemodel.Model LIKE ('%" . $search . "%')
                OR voiture.boite_vitesse LIKE ('%" . $search . "%')
                OR voiture.type_carburant LIKE ('%" . $search . "%')                         
                OR voiture.date_achat LIKE ('%" . $search . "%')
                OR agence.lieu_agence LIKE ('%" . $search . "%')       
                OR voiture.etat_voiture LIKE ('%" . $search . "%'))
                ORDER BY voiture.id_voiture ASC ");
        } else {
            $sql = ("SELECT * FROM voiture,agence,marquemodel
            WHERE voiture.id_agence = agence.id_agence 
            AND voiture.id_MarqueModel = marquemodel.id_MarqueModel
            AND voiture.actions !='S'
            AND  (voiture.id_voiture LIKE ('%" . $search . "%')
                OR voiture.type LIKE ('%" . strtoupper($search)  . "%')       
                OR voiture.pimm LIKE ('%" . $search . "%')
                OR marquemodel.Marque LIKE ('%" . $search . "%')
                OR marquemodel.Model LIKE ('%" . $search . "%')
                OR voiture.boite_vitesse LIKE ('%" . $search . "%')
                OR voiture.type_carburant LIKE ('%" . $search . "%')                         
                OR voiture.date_achat LIKE ('%" . $search . "%')
                OR agence.lieu_agence LIKE ('%" . $search . "%')       
                OR voiture.etat_voiture LIKE ('%" . $search . "%'))
                ORDER BY voiture.id_voiture ASC ");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['etat_voiture'] == "Loue") {
                    $color = "badge bg-light-warning text-warning fw-normal";
                    $color1 = "background-color: #ffedd4!important";
                    $row['etat_voiture'] = "LOUE";
                } elseif ($row['etat_voiture'] == "Entretien") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ffc36d!important";
                    $row['etat_voiture'] = "ENTRETIEN";
                } elseif ($row['etat_voiture'] == "Vendue") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ff5050!important";
                    $row['etat_voiture'] = "VENDUE";
                } elseif ($row['etat_voiture'] == "HS") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #343a40!important";
                    $row['etat_voiture'] = "HORS SERVICE";
                } elseif ($row['etat_voiture'] == "Disponible") {
                    $disponibilte = disponibilite_Vehicule1($row['id_voiture']);
                    $localisation = localisation_Vehicule($row['id_voiture']);
                    if ($disponibilte == 'disponibile') {
                        $color = "badge bg-light-success text-white fw-normal";
                        $color1 = "background-color: #2cd07e!important";
                        $row['etat_voiture'] = "DISPONIBLE";
                    } else {
                        $color = "badge bg-light-info text-white fw-normal";
                        $color1 = "background-color: #ff5050!important";
                        $row['etat_voiture'] = "En Location";
                        $row['lieu_agence'] = $localisation;
                    }
                }
                $value .= '
                <tbody>
                    <tr>
                        <td class="border-top-1  ">' . $row['id_voiture'] . '</td>
                        <td class="border-top-1">' . $row['pimm'] . '</td>
                        <td class="border-top-1">' . $row['type'] . '</td>
                        <td class="border-top-1">' . $row['Marque'] . " " . $row['Model'] . '</td>
                        <td class="border-top-1">' . $row['boite_vitesse'] . '</td>
                        <td class="border-top-1">' . $row['type_carburant'] . '</td>
                        <td class="border-top-1">' . $row['date_achat'] . '</td>
                        <td class="border-top-1">' . $row['lieu_agence'] . '</td>
                        <td><span class="' . $color . '" style ="' . $color1 . '">' . $row['etat_voiture'] . '</span></td>';
                if ($row['etat_voiture'] != "VENDU") {
                    $value .= '<td><button title="Transférer la voiture" class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert" data-id=' . $row['id_voiture'] . '><i class="fas fa-exchange-alt"></i></button></td>';
                }
                $value .= ' </tr>
              </tbody>';
            }
            $value .= '</table> </div>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        selectVoiteurDispoStock();
    }
}
//end searchStock
//
function searchStockMateriel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
        <th class="border-top-0">ID</th>
        <th class="border-top-0">Code de matériel</th>
        <th class="border-top-0">N° de série</th>
        <th class="border-top-0">Désignation</th>
        <th class="border-top-0">Quantité disponible</th>
        <th class="border-top-0">Localisation</th>
        <th class="border-top-0">Disponibilité</th>
        <th class="border-top-0">Transfert</th>
    </tr>';

    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $query = ("SELECT * FROM materiels_agence,materiels,agence
            where materiels_agence.id_materiels = materiels.id_materiels
            AND materiels_agence.id_agence = agence.id_agence
            and  materiels_agence.etat_materiels !='F'
            and materiels_agence.id_agence = '$id_agence'
            AND  (materiels.id_materiels LIKE ('%" . $search . "%')
                OR materiels.code_materiel LIKE ('%" . $search . "%')
                OR materiels_agence.id_materiels_agence LIKE ('%" . $search . "%')     
                OR materiels.designation LIKE ('%" . $search . "%')  
                OR materiels_agence.num_serie_materiels LIKE ('%" . $search . "%')    
                OR agence.lieu_agence LIKE ('%" . $search . "%'))");          
        } else {
            $query = ("SELECT * FROM materiels_agence,materiels,agence 
            where materiels_agence.id_materiels = materiels.id_materiels
            AND materiels_agence.id_agence = agence.id_agence
            and  materiels_agence.etat_materiels !='F'
            AND  (materiels.id_materiels LIKE ('%" . $search . "%')
                OR materiels.code_materiel LIKE ('%" . $search . "%')
                OR materiels_agence.id_materiels_agence LIKE ('%" . $search . "%')     
                OR materiels.designation LIKE ('%" . $search . "%')         
                OR materiels_agence.num_serie_materiels LIKE ('%" . $search . "%')
                OR agence.lieu_agence LIKE ('%" . $search . "%'))");
        }
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['etat_materiels'] == "HS") {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ffc36d!important";
                    $etat = "HORS SERVICE";
                    $qti = 0;
                } elseif ($row['etat_materiels'] == "T") {
                    $id_materiels_agence = $row['id_materiels_agence'];
                    if ($row['num_serie_obg'] == "T") {
                        $disponibilte = disponibilite_materiel_num_seriee($row['id_materiels_agence']);
                        $localisation = Localisation_materiel($row['id_materiels_agence']);
                        if ($disponibilte == "0") {
                            $color = "badge bg-light-success text-white fw-normal";
                            $color1 = "background-color: #2cd07e!important";
                            $etat = "DISPONIBLE";
                            $qti = 1;
                        } else {
                            $color = "badge bg-light-info text-white fw-normal";
                            $color1 = "background-color: #ff5050!important";
                            $etat = "En Location";
                            $qti = 0;
                            $row['lieu_agence'] = $localisation;
                        }
                    }
                    //si le matiriel ne pas de n serie
                    else {
                        $disponibilteqti = disponibilite_materiel_qti_num_seriee($row['id_materiels_agence'], $row['quantite_materiels']);
                        $localisation = Localisation_materiel($row['id_materiels_agence']);
                        if ($disponibilteqti > 0) {
                            $color = "badge bg-light-success text-white fw-normal";
                            $color1 = "background-color: #2cd07e!important";
                            $etat = "DISPONIBLE";
                            $qti = $disponibilteqti;
                        } else {
                            $color = "badge bg-light-info text-white fw-normal";
                            $color1 = "background-color: #ff5050!important";
                            $etat = "En Location";
                            $qti = $disponibilteqti;
                            $row['lieu_agence'] = $localisation;
                        }
                    }
                    $value .= '
                        <tbody>          
                            <tr>
                                <td class="border-top-0">' . $row['id_materiels_agence'] . '</td>
                                <td class="border-top-0">' . $row['code_materiel'] . '</td>
                                <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                                <td class="border-top-0">' . $row['designation'] . '</td>
                                <td class="border-top-0">' .   $qti . '</td>
                                <td class="border-top-0">' . $row['lieu_agence'] . '</td>          
                                <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                                <td class="border-top-0">';
                                    if ($row['num_serie_obg'] == "T") {
                                        $value .= '
                                        <button title="Transférer le matériel" class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert-materiel" data-id=' . $row['id_materiels_agence'] . ' ><i class="fas fa-exchange-alt"></i></button>';
                                    } else {
                                        $value .= '<button title="Transférer le matériel" class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert-materiel-quantite" data-id=' . $row['id_materiels_agence'] . ' ><i class="fas fa-exchange-alt"></i></button>';
                                    }
                                $value .= '</td>
                            </tr>
                        </tbody>';
                }
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    }else {
        selectMaterielQtiDispo();
    }
}
//end

// searchEntretiens
function searchEntretiens()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Type d\'intervention</th>
        <th class="border-top-0">Lieu Entretien</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Matériel</th>
        <th class="border-top-0">Cout Entretien</th>
        <th class="border-top-0">Date Début </th>
        <th class="border-top-0">Date Fin </th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Type d\'intervention</th>
        <th class="border-top-0">Lieu Entretien</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Matériel</th>
        <th class="border-top-0">Cout Entretien</th>
        <th class="border-top-0">Date Début </th>
        <th class="border-top-0">Date Fin </th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT *,E.type AS TYPEentretien FROM entretien AS E 
        LEFT JOIN voiture AS V ON E.id_voiture =V.id_voiture
        LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel
        LEFT JOIN materiels AS M ON E.id_materiel = M.id_materiels
        LEFT JOIN materiels_agence AS MA ON MA.id_materiels = M.id_materiels
        WHERE etat_entretien = '0'
        AND (id_entretien LIKE ('%" . $search . "%')
                OR E.type LIKE ('%" . $search . "%')  
                OR objet_entretien LIKE ('%" . $search . "%')       
                OR lieu_entretien LIKE ('%" . $search . "%')
                OR pimm LIKE ('%" . $search . "%')                         
                OR Marque LIKE ('%" . $search . "%')       
                OR Model LIKE ('%" . $search . "%')  
                OR designation LIKE ('%" . $search . "%')                         
                OR code_materiel LIKE ('%" . $search . "%')       
                OR num_serie_materiels LIKE ('%" . $search . "%')                           
                OR cout_entretien LIKE ('%" . $search . "%')       
                OR date_entretien LIKE ('%" . $search . "%')       
                OR date_fin_entretien LIKE ('%" . $search . "%')       
                OR commentaire_intervenant LIKE ('%" . $search . "%')       
                OR commentaire LIKE ('%" . $search . "%'))
                GROUP BY id_entretien");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['TYPEentretien'] == 'Vehicule') {
                    $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_entretien'] . '</td>
                        <td class="border-top-0">' . $row['TYPEentretien'] . '</td>
                        <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                        <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                        <td class="border-top-0">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                        <td class="border-top-0">' . " " . '</td>
                        <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                        <td class="border-top-0">' . $row['date_entretien'] . '</td>
                        <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                        <td class="border-top-0">' . $row['commentaire'] . '</td>
                        <td class="border-top-0">' . $row['commentaire_intervenant'] . '</td>';
                } else if ($row['TYPEentretien'] == 'Materiel') {
                    $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_entretien'] . '</td>
                        <td class="border-top-0">' . $row['TYPEentretien'] . '</td>
                        <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                        <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                        <td class="border-top-0">' . " " . '</td>
                        <td class="border-top-0">' . $row['designation'] . ' - ' . $row['code_materiel'] . ' ' . $row['num_serie_materiels']  . '</td>
                        <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                        <td class="border-top-0">' . $row['date_entretien'] . '</td>
                        <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                        <td class="border-top-0">' . $row['commentaire'] . '</td>
                        <td class="border-top-0">' . $row['commentaire_intervenant'] . '</td>';
                }
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<td class="border-top-0">
                        <button type="button" title="Modifier l\'entretien" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-Entretien" data-id=' . $row['id_entretien'] . '><i class="fas fa-edit"></i></button> 
                        <button type="button" title="Supprimer l\'entretien" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-Entretien" data-id1=' . $row['id_entretien'] . '><i class="fas fa-trash-alt"></i></button>                    </td>';
                }
                $value .= '</tr>';
            }

            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        DisplayEntretienRecordVoiture();
    }
}
//end searchEntretiens

function searchContratVoiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email du client</th>
        <th class="border-top-0">Modèle de véhicule</th>
        <th class="border-top-0">PIMM de véhicule</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Nombre de kilomètres inclus</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Contrat Signé</th> 
        <th class="border-top-0">Actions</th>  
        </tr>';

    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = ("SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.contratsigne,C.date_debut,C.date_fin,date_debut_validation,date_fin_validation,
            C.prix,C.mode_de_paiement,C.KMPrevu,C.NbrekmInclus,
            CL.id_client,CL.nom,CL.nom_entreprise,CL.email,A.lieu_agence As lieu_dep,
            AR.lieu_agence As lieu_agence_ret,
            V.pimm,MM.Model 
                FROM contrat_client AS C 
                LEFT JOIN client AS CL ON C.id_client =CL.id_client 
                LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
                LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
                LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
                LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
                WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00'))
                AND  C.type_location = 'Vehicule'
                AND  C.etat_contrat != 'S'
                AND C.id_client =CL.id_client
                AND C.id_agence =   $id_agence AND
            (C.id_contrat LIKE ('%" . $search . "%')
            OR C.date_debut LIKE ('%" . $search . "%')   
            OR C.date_fin LIKE ('%" . $search . "%')
            OR C.date_debut_validation LIKE ('%" . $search . "%')   
            OR C.date_fin_validation LIKE ('%" . $search . "%')
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%')
            OR MM.Model LIKE ('%" . $search . "%')
            OR V.pimm LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%')
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')
            OR C.NbrekmInclus LIKE ('%" . $search . "%')
            OR C.mode_de_paiement LIKE ('%" . $search . "%'))
                      ORDER BY C.id_contrat ");
        } else {
            $sql = ("SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.contratsigne,C.date_debut,C.date_fin,date_debut_validation,date_fin_validation,
            C.prix,C.mode_de_paiement,C.KMPrevu,C.NbrekmInclus,
            CL.id_client,CL.nom,CL.nom_entreprise,CL.email,A.lieu_agence As lieu_dep,
            AR.lieu_agence As lieu_agence_ret,
            V.pimm,MM.Model 
                FROM contrat_client AS C 
                LEFT JOIN client AS CL ON C.id_client =CL.id_client 
                LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
                LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
                LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
                LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
                WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00'))
                AND  C.type_location = 'Vehicule'
                AND  C.etat_contrat != 'S'
                AND C.id_client =CL.id_client
                AND (C.id_contrat LIKE ('%" . $search . "%')
            OR C.date_debut LIKE ('%" . $search . "%')   
            OR C.date_fin LIKE ('%" . $search . "%')
            OR C.date_debut_validation LIKE ('%" . $search . "%')   
            OR C.date_fin_validation LIKE ('%" . $search . "%')
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%')
            OR MM.Model LIKE ('%" . $search . "%')
            OR V.pimm LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%')
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')
            OR C.NbrekmInclus LIKE ('%" . $search . "%')
            OR C.mode_de_paiement LIKE ('%" . $search . "%'))
                      ORDER BY C.id_contrat ");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ( (($row["date_fin"] < $date) && ($row["date_fin_validation"] == "0000-00-00")) || (($row["date_fin"] < $date) && ($row["date_debut_validation"] == "0000-00-00"))){
                    $style = "#FF8000";
                    $value .= '<tr>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['id_contrat'] . '</td>';
                    if (($row["date_debut_validation"] == "0000-00-00")){
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                    '.date('d-m-Y', strtotime($row['date_debut'])).'
                                    <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-voiture" data-id-sortie-voiture=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                                    </td>';
                    }else{
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                    '. date('d-m-Y', strtotime($row['date_debut'])).'
                                    <img style= "width:55px; height:45px;" src="sortievalide.png">
                                </td>';
                    }
                    if (($row["date_fin_validation"] == "0000-00-00")){
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                    '. date('d-m-Y', strtotime($row['date_fin'])).'
                                    <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-voiture" data-id-retour-voiture=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                                    </td>';
                    }else {
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                    '. date('d-m-Y', strtotime($row['date_fin'])).' 
                                    <img style= "width:55px; height:45px;" src="entreevalide.png">
                                </td>';
                    }
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_dep'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_agence_ret'] . '</td>'; 
                    if ($row['nom_entreprise'] == ""){
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom'] . '</td>';
                    }else if ($row['nom'] == ""){
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . '</td>';
                    }else{
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                    }
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['email'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['Model'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['pimm'] . '</td> 
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['duree'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['prix'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['caution'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['NbrekmInclus'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['mode_de_paiement'] . '</td>';
                    if ($row["contratsigne"] == ""){
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
                    }else{
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
                    }
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">';
                    if ($_SESSION['Role'] != "superadmin") {
                        $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style= "width:55px; height:45px;" id="btn-edit-contrat-voiture" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                                <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style= "width:55px; height:45px;" id="btn-delete-contrat-voiture" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                                <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style= "width:55px; height:45px;" id="btn-id-client-voiture-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
                    }
                    $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style= "width:55px; height:45px;" id="btn-id-client" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
                    </td></tr>';
                }else{
                    $value .= '<tr>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>';
                    if (($row["date_debut_validation"] == "0000-00-00")){
                        $value .= '<td class="border-top-0">
                                    '.date('d-m-Y', strtotime($row['date_debut'])).'
                                    <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-voiture" data-id-sortie-voiture=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                                    </td>';
                    }else{
                        $value .= '<td class="border-top-0">
                                    '. date('d-m-Y', strtotime($row['date_debut'])).'
                                    <img style= "width:55px; height:45px;" src="sortievalide.png">
                                </td>';
                    }
                    if (($row["date_fin_validation"] == "0000-00-00")){
                        $value .= '<td class="border-top-0">
                                    '. date('d-m-Y', strtotime($row['date_fin'])).'
                                    <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-voiture" data-id-retour-voiture=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                                    </td>';
                    }else {
                        $value .= '<td class="border-top-0">
                                    '. date('d-m-Y', strtotime($row['date_fin'])).' 
                                    <img style= "width:55px; height:45px;" src="entreevalide.png">
                                </td>';
                    }
                    $value .= '<td class="border-top-0">' . $row['lieu_dep'] . '</td>
                    <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
                    if ($row['nom_entreprise'] == ""){
                        $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
                    }else if ($row['nom'] == ""){
                        $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
                    }else{
                        $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                    }
                    $value .= '<td class="border-top-0">' . $row['email'] . '</td>
                    <td class="border-top-0">' . $row['Model'] . '</td>
                    <td class="border-top-0">' . $row['pimm'] . '</td> 
                    <td class="border-top-0">' . $row['duree'] . '</td>
                    <td class="border-top-0">' . $row['prix'] . '</td>
                    <td class="border-top-0">' . $row['caution'] . '</td>
                    <td class="border-top-0">' . $row['NbrekmInclus'] . '</td>
                    <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
                    if ($row["contratsigne"] == ""){
                        $value .= '<td class="border-top-0"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
                    }else{
                        $value .= '<td class="border-top-0"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
                    }
                    $value .= '<td class="border-top-0">';
                    if ($_SESSION['Role'] != "superadmin") {
                        $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style= "width:55px; height:45px;" id="btn-edit-contrat-voiture" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                                <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style= "width:55px; height:45px;" id="btn-delete-contrat-voiture" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                                <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style= "width:55px; height:45px;" id="btn-id-client-voiture-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
                    }
                    $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style= "width:55px; height:45px;" id="btn-id-client" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
                    </td></tr>';
                }
                $queryavenant = "SELECT * 
                FROM contrat_client_avenant AS C
                LEFT JOIN voiture AS V on C.id_voiture_avenant = V.id_voiture 
                LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
                WHERE C.id_contrat_client = ".$row['id_contrat'];
                $resultavenant = mysqli_query($conn, $queryavenant);
                if (mysqli_num_rows($resultavenant) > 0) {
                    while ($rowavenant = mysqli_fetch_assoc($resultavenant)) {
                    $value .= '<tr><td class="border-top-0" style="background-color:#F2F2F2;"></td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['debut_contrat_avenant'])) . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['fin_contrat_avenant'])) . '</td> 
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_dep'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_agence_ret'] . '</td>';
                    if ($row['nom_entreprise'] == ""){
                        $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom'] . '</td>';
                    }else if ($row['nom'] == ""){
                        $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . '</td>';
                    }else{
                        $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                    }
                    $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['email'] . '</td> 
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $rowavenant['Model'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $rowavenant['pimm'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['duree'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['prix'] . '</td> 
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['caution'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['NbrekmInclus'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['mode_de_paiement'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;"></td>
                    <td class="border-top-0" >
                        <button type="button" title="Modifier le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-avenant" data-id1=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-edit"></i></i></button>
                        <button type="button" title="Télécharger le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-contrat-avenant" data-id=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-download"></i></i></button>
                    </td></tr>'; 
                    }
                } 
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche! </h4>";
        }
    } else {
        display_contrat_record_voiture();
    }
}
function searchContratMateriel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email du client</th>
        <th class="border-top-0">Désignation matériel</th>
        <th class="border-top-0">Num Série matériel</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Contrat Signé</th> 
        <th class="border-top-0">Action</th>    
        </tr>';

    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $query = "SELECT DISTINCT C.id_contrat,C.duree,C.id_agencedep,C.id_agenceret,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,
            C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,C.contratsigne,
            CL.nom,CL.nom_entreprise,CL.email,CM.designation_contrat,CM.num_serie_contrat,
            A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
            FROM contrat_client AS C 
            LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
            LEFT JOIN client AS CL ON C.id_client=CL.id_client
            LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
            LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
            WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00') )
            AND C.type_location = 'Materiel'
            AND  C.etat_contrat != 'S'
            AND C.id_agence = $id_agence 
            AND (C.id_contrat LIKE ('%" . $search . "%')
            OR C.date_debut LIKE ('%" . $search . "%')    
            OR C.date_fin LIKE ('%" . $search . "%')  
            OR C.date_debut_validation LIKE ('%" . $search . "%')    
            OR C.date_fin_validation LIKE ('%" . $search . "%')    
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%')
            OR CM.designation_contrat LIKE ('%" . $search . "%')
            OR CM.num_serie_contrat LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%')
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')
            OR C.mode_de_paiement LIKE ('%" . $search . "%'))
            ORDER BY C.id_contrat ";
        } else {
            $query = "SELECT DISTINCT C.id_contrat,C.duree,C.id_agencedep,C.id_agenceret,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,
            C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,C.contratsigne,
            CL.nom,CL.nom_entreprise,CL.email,CM.designation_contrat,CM.num_serie_contrat,
            A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
            FROM contrat_client AS C 
            LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
            LEFT JOIN client AS CL ON C.id_client=CL.id_client
            LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
            LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
            WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00'))
            AND C.type_location = 'Materiel'
            AND  C.etat_contrat != 'S'
            AND (C.id_contrat LIKE ('%" . $search . "%')
            OR C.date_debut LIKE ('%" . $search . "%')    
            OR C.date_fin LIKE ('%" . $search . "%')  
            OR C.date_debut_validation LIKE ('%" . $search . "%')    
            OR C.date_fin_validation LIKE ('%" . $search . "%')  
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%')
            OR CM.designation_contrat LIKE ('%" . $search . "%')
            OR CM.num_serie_contrat LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%')
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')
            OR C.mode_de_paiement LIKE ('%" . $search . "%'))
            ORDER BY C.id_contrat ";
        }
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ( (($row["date_fin"] < $date) && ($row["date_fin_validation"] == "0000-00-00")) || (($row["date_fin"] < $date) && ($row["date_debut_validation"] == "0000-00-00"))){
                    $style = "#FF8000";
                    $value .= '
                    <tr>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['id_contrat'] . '</td>';
                        if (($row["date_debut_validation"] == "0000-00-00")){
                            $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                        '. date('d-m-Y', strtotime($row['date_debut'])).'
                                        <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-materiel" data-id-sortie-materiel=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                                        </td>';
                        }else{
                            $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                        '. date('d-m-Y', strtotime($row['date_debut'])).'
                                        <img style= "width:55px; height:45px;" src="sortievalide.png">
                                        </td>';
                        }
                        if (($row["date_fin_validation"] == "0000-00-00")){
                            $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                        '. date('d-m-Y', strtotime($row['date_fin'])).'
                                        <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-materiel" data-id-retour-materiel=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                                        </td>';
                        }else{
                            $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                        '. date('d-m-Y', strtotime($row['date_fin'])).'
                                        <img style= "width:55px; height:45px;" src="entreevalide.png">
                                        </td>';
                        }
                        $value .= '
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_dep'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_agence_ret'] . '</td>'; 
                        if ($row['nom_entreprise'] == ""){
                            $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom'] . '</td>';
                        }else if ($row['nom'] == ""){
                            $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . '</td>';
                        }else{
                            $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                        }
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['email'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['designation_contrat'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['num_serie_contrat'] . '</td> 
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['duree'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['prix'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['caution'] . '</td>
                        <td class="border-top-0" bgcolor="'.$style.'">' . $row['mode_de_paiement'] . '</td>';
                        if ($row["contratsigne"] == ""){
                            $value .= '<td class="border-top-0" bgcolor="'.$style.'"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
                        }else{
                            $value .= '<td class="border-top-0" bgcolor="'.$style.'"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
                        }
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">';
                    if ($_SESSION['Role'] != "superadmin") {
                        $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-materiel" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                                <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                                <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
                    }
                    $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel" data-id5=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
                    </td></tr>';
                }else{
                    $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_contrat'] . '</td>';
                        if (($row["date_debut_validation"] == "0000-00-00")){
                            $value .= '<td class="border-top-0">
                                        '. date('d-m-Y', strtotime($row['date_debut'])).'
                                        <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-materiel" data-id-sortie-materiel=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                                        </td>';
                        }else{
                            $value .= '<td class="border-top-0">
                                        '. date('d-m-Y', strtotime($row['date_debut'])).'
                                        <img style= "width:55px; height:45px;" src="sortievalide.png">
                                        </td>';
                        }
                        if (($row["date_fin_validation"] == "0000-00-00")){
                            $value .= '<td class="border-top-0">
                                        '. date('d-m-Y', strtotime($row['date_fin'])).'
                                        <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-materiel" data-id-retour-materiel=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                                        </td>';
                        }else{
                            $value .= '<td class="border-top-0">
                                        '. date('d-m-Y', strtotime($row['date_fin'])).'
                                        <img style= "width:55px; height:45px;" src="entreevalide.png">
                                        </td>';
                        }
                        $value .= '
                        <td class="border-top-0">' . $row['lieu_dep'] . '</td>
                        <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
                        if ($row['nom_entreprise'] == ""){
                            $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
                        }else if ($row['nom'] == ""){
                            $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
                        }else{
                            $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                        }
                        $value .= '<td class="border-top-0">' . $row['email'] . '</td>
                        <td class="border-top-0">' . $row['designation_contrat'] . '</td>
                        <td class="border-top-0">' . $row['num_serie_contrat'] . '</td> 
                        <td class="border-top-0">' . $row['duree'] . '</td>
                        <td class="border-top-0">' . $row['prix'] . '</td>
                        <td class="border-top-0">' . $row['caution'] . '</td>
                        <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
                        if ($row["contratsigne"] == ""){
                            $value .= '<td class="border-top-0"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
                        }else{
                            $value .= '<td class="border-top-0"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
                        }
                    $value .= '<td class="border-top-0">';
                    if ($_SESSION['Role'] != "superadmin") {
                        $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-materiel" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                                <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                                <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
                    }
                    $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel" data-id5=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
                    </td></tr>';
                }
                $queryavenant = "SELECT * 
                FROM contrat_client_avenant AS C
                LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat_avenant =C.id_contrat_avenant 
                WHERE C.id_contrat_client = ".$row['id_contrat'];
                $resultavenant = mysqli_query($conn, $queryavenant);
                if (mysqli_num_rows($resultavenant) > 0) {
                    while ($rowavenant = mysqli_fetch_assoc($resultavenant)) {
                    $value .= '<tr><td class="border-top-0" style="background-color:#F2F2F2;"></td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['debut_contrat_avenant'])) . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['fin_contrat_avenant'])) . '</td> 
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_dep'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_agence_ret'] . '</td>';
                    if ($row['nom_entreprise'] == ""){
                        $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom'] . '</td>';
                    }else if ($row['nom'] == ""){
                        $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . '</td>';
                    }else{
                        $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                    }
                    $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['email'] . '</td> 
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $rowavenant['designation_contrat'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $rowavenant['num_serie_contrat'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['duree'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['prix'] . '</td> 
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['caution'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['mode_de_paiement'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;"></td>
                    <td class="border-top-0" >
                        <button type="button" title="Modifier le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-avenant" data-id1=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-edit"></i></i></button>
                        <button type="button" title="Télécharger le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-contrat-avenant-materiel" data-id=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-download"></i></i></button>
                    </td></tr>'; 
                    }
                }
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_record_materiel();
    }
}

function searchContratPack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email du client</th>
        <th class="border-top-0">Désignation Pack</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Nombre de kilomètres inclus</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Contrat Signé</th> 
        <th class="border-top-0">Action</th>     
        </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = " SELECT DISTINCT C.id_contrat,C.duree,C.caution,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,C.contratsigne,
            P.designation_pack,
            CL.nom,CL.nom_entreprise,CL.email,
            A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
            FROM contrat_client AS C 
            LEFT JOIN group_packs AS P ON P.id_group_packs=C.id_group_pack
            LEFT JOIN client AS CL ON C.id_client=CL.id_client
            LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
            LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
            WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00'))
            AND C.type_location = 'Pack'
            AND  C.etat_contrat != 'S' 
            AND C.id_agence = $id_agence  AND
            (C.id_contrat LIKE ('%" . $search . "%')
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%') 
            OR C.date_debut LIKE ('%" . $search . "%')
            OR C.date_fin LIKE ('%" . $search . "%')
            OR C.date_debut_validation LIKE ('%" . $search . "%')
            OR C.date_fin_validation LIKE ('%" . $search . "%')
            OR P.designation_pack LIKE ('%" . $search . "%')   
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')    
            OR C.NbrekmInclus LIKE ('%" . $search . "%')  
            OR C.mode_de_paiement LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%'))
            ORDER BY C.id_contrat ";
        } else {
            $sql = " SELECT DISTINCT C.id_contrat,C.duree,C.caution,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,C.contratsigne,
            P.designation_pack,
            CL.nom,CL.nom_entreprise,CL.email,
            A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
            FROM contrat_client AS C 
            LEFT JOIN group_packs AS P ON P.id_group_packs=C.id_group_pack
            LEFT JOIN client AS CL ON C.id_client=CL.id_client
            LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
            LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
            WHERE ( (DATE(NOW()) < C.date_fin_validation) OR (DATE(NOW()) <= C.date_fin) OR (C.date_fin_validation = '0000-00-00') OR (C.date_debut_validation = '0000-00-00'))
            AND C.type_location = 'Pack'
            AND  C.etat_contrat != 'S' 
            AND (C.id_contrat LIKE ('%" . $search . "%')
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%') 
            OR C.date_debut LIKE ('%" . $search . "%')
            OR C.date_fin LIKE ('%" . $search . "%')
            OR C.date_debut_validation LIKE ('%" . $search . "%')
            OR C.date_fin_validation LIKE ('%" . $search . "%')
            OR P.designation_pack LIKE ('%" . $search . "%')   
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%') 
            OR C.NbrekmInclus LIKE ('%" . $search . "%')     
            OR C.mode_de_paiement LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%'))
            ORDER BY C.id_contrat ";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ( (($row["date_fin"] < $date) && ($row["date_fin_validation"] == "0000-00-00")) || (($row["date_fin"] < $date) && ($row["date_debut_validation"] == "0000-00-00"))){
                    $style = "#FF8000";
                    $value .= '<tr>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['id_contrat'] . '</td>';
                    if (($row["date_debut_validation"] == "0000-00-00")){
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                    '.date('d-m-Y', strtotime($row['date_debut'])).'
                                    <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-pack" data-id-sortie-pack=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                                    </td>';
                    }else{
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                    '. date('d-m-Y', strtotime($row['date_debut'])).'
                                    <img style= "width:55px; height:45px;" src="sortievalide.png">
                                </td>';
                    }
                    if (($row["date_fin_validation"] == "0000-00-00")){
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                    '. date('d-m-Y', strtotime($row['date_fin'])).'
                                    <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-pack" data-id-retour-pack=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                                    </td>';
                    }else {
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">
                                    '. date('d-m-Y', strtotime($row['date_fin'])).' 
                                    <img style= "width:55px; height:45px;" src="entreevalide.png">
                                </td>';
                    }
                    $value .= '
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_dep'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['lieu_agence_ret'] . '</td>'; 
                    if ($row['nom_entreprise'] == ""){
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom'] . '</td>';
                    }else if ($row['nom'] == ""){
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . '</td>';
                    }else{
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                    }
                    $value .= '
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['email'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['designation_pack'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['duree'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['prix'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['caution'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['NbrekmInclus'] . '</td>
                    <td class="border-top-0" bgcolor="'.$style.'">' . $row['mode_de_paiement'] . '</td>';
                    if ($row["contratsigne"] == ""){
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
                    }else{
                        $value .= '<td class="border-top-0" bgcolor="'.$style.'"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
                    }
                    $value .= '<td class="border-top-0" bgcolor="'.$style.'">';
                    if ($_SESSION['Role'] != "superadmin") {
                        $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-pack" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                                <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-pack" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                                <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
                    }
                    $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
                    </td></tr>';
                }else{
                    $value .= '
                    <tr>
                        <td class="border-top-0">' . $row['id_contrat'] . '</td>';
                        if (($row["date_debut_validation"] == "0000-00-00")){
                            $value .= '<td class="border-top-0">
                                        '.date('d-m-Y', strtotime($row['date_debut'])).'
                                        <button type="button" title="Valider la sortie" id="btn-valide-sortie-contrat-pack" data-id-sortie-pack=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="sortienonvalide.png"></button> 
                                        </td>';
                        }else{
                            $value .= '<td class="border-top-0">
                                        '. date('d-m-Y', strtotime($row['date_debut'])).'
                                        <img style= "width:55px; height:45px;" src="sortievalide.png">
                                    </td>';
                        }
                        if (($row["date_fin_validation"] == "0000-00-00")){
                            $value .= '<td class="border-top-0">
                                        '. date('d-m-Y', strtotime($row['date_fin'])).'
                                        <button type="button" title="Valider le retour" id="btn-valide-retour-contrat-pack" data-id-retour-pack=' . $row['id_contrat'] . '><img style= "width:55px; height:45px;" src="entreenonvalide.png"></button> 
                                        </td>';
                        }else {
                            $value .= '<td class="border-top-0">
                                        '. date('d-m-Y', strtotime($row['date_fin'])).' 
                                        <img style= "width:55px; height:45px;" src="entreevalide.png">
                                    </td>';
                        }
                        $value .= '
                        <td class="border-top-0">' . $row['lieu_dep'] . '</td>
                        <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
                        if ($row['nom_entreprise'] == ""){
                            $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
                        }else if ($row['nom'] == ""){
                            $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
                        }else{
                            $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                        }
                        $value .= '
                        <td class="border-top-0">' . $row['email'] . '</td>
                        <td class="border-top-0">' . $row['designation_pack'] . '</td>
                        <td class="border-top-0">' . $row['duree'] . '</td>
                        <td class="border-top-0">' . $row['prix'] . '</td>
                        <td class="border-top-0">' . $row['caution'] . '</td>
                        <td class="border-top-0">' . $row['NbrekmInclus'] . '</td>
                        <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
                        if ($row["contratsigne"] == ""){
                            $value .= '<td class="border-top-0"><img style= "width:55px; height:45px;" src="contratsignenonvalide.png"></td>';
                        }else{
                            $value .= '<td class="border-top-0"><a href="uploads/contratsigne/' . $row["contratsigne"] . '" target="_blank"><img style= "width:55px; height:45px;" src="contratsignevalide.png"></a></td>';
                        }
                    $value .= '<td class="border-top-0">';
                    if ($_SESSION['Role'] != "superadmin") {
                        $value .= '<button type="button" title="Modifier le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-pack" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
                                <button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-pack" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                                <button type="button" title="Ajouter le contrat signé" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack-signe" data-id4=' . $row['id_contrat'] . '><i class="fas fa-plus"></i></i></button>';
                    }
                    $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
                    </td></tr>';
                }
                $queryavenant = "SELECT * 
                FROM contrat_client_avenant AS C
                LEFT JOIN group_packs AS P ON P.id_group_packs=C.id_pack_avenant
                WHERE C.id_contrat_client = ".$row['id_contrat'];
                $resultavenant = mysqli_query($conn, $queryavenant);
                if (mysqli_num_rows($resultavenant) > 0) {
                    while ($rowavenant = mysqli_fetch_assoc($resultavenant)) {
                    $value .= '<tr><td class="border-top-0" style="background-color:#F2F2F2;"></td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['debut_contrat_avenant'])) . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . date('d-m-Y', strtotime($rowavenant['fin_contrat_avenant'])) . '</td> 
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_dep'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['lieu_agence_ret'] . '</td>';
                    if ($row['nom_entreprise'] == ""){
                        $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom'] . '</td>';
                    }else if ($row['nom'] == ""){
                        $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . '</td>';
                    }else{
                        $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                    }
                    $value .= '<td class="border-top-0" style="background-color:#F2F2F2;">' . $row['email'] . '</td> 
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $rowavenant['designation_pack'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['duree'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['prix'] . '</td> 
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['caution'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['NbrekmInclus'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;">' . $row['mode_de_paiement'] . '</td>
                    <td class="border-top-0" style="background-color:#F2F2F2;"></td>
                    <td class="border-top-0" >
                        <button type="button" title="Modifier le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-contrat-avenant" data-id1=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-edit"></i></i></button>
                        <button type="button" title="Télécharger le contrat avenant" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-contrat-avenant-pack" data-id=' . $rowavenant['id_contrat_avenant'] . '><i class="fas fa-download"></i></i></button>
                    </td></tr>';
                    }
                } 
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_record_pack();
    }
}

function searchEntretienMateriel()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Type</th>
    <th class="border-top-0">Type d\'intervention</th>
    <th class="border-top-0">Lieu Entretien</th>
    <th class="border-top-0">Matériel</th>
    <th class="border-top-0">Cout Entretien</th>
    <th class="border-top-0">Date Début </th>
    <th class="border-top-0">Date Fin </th>
    <th class="border-top-0">Commentaire Déclarant</th>
    <th class="border-top-0">Commentaire Intervenant</th>
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT *,E.type AS TYPEentretien FROM entretien AS E 
        LEFT JOIN materiels AS M ON E.id_materiel = M.id_materiels
        LEFT JOIN materiels_agence AS MA ON MA.id_materiels = M.id_materiels
        WHERE E.type ='Materiel'
        AND etat_entretien = '1'
        AND (id_entretien LIKE ('%" . $search . "%')
        OR E.type LIKE ('%" . $search . "%')
        OR objet_entretien LIKE ('%" . $search . "%')
        OR lieu_entretien LIKE ('%" . $search . "%')
        OR designation LIKE ('%" . $search . "%')
        OR code_materiel LIKE ('%" . $search . "%')
        OR num_serie_materiels LIKE ('%" . $search . "%')
        OR cout_entretien LIKE ('%" . $search . "%')
        OR date_entretien LIKE ('%" . $search . "%')
        OR date_fin_entretien LIKE ('%" . $search . "%')
        OR commentaire_intervenant LIKE ('%" . $search . "%')
        OR commentaire LIKE ('%" . $search . "%'))
        GROUP BY id_entretien ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                    <td class="border-top-0">' . $row['id_entretien'] . '</td>
                    <td class="border-top-0">' . $row['type'] . '</td>
                    <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                    <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                    <td class="border-top-0">' . $row['designation'] . ' - ' . $row['code_materiel'] . ' ' . $row['num_serie_materiels']  . '</td>
                    <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                    <td class="border-top-0">' . $row['date_entretien'] . '</td>
                    <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                    <td class="border-top-0">' . $row['commentaire'] . '</td>
                    <td class="border-top-0">' . $row['commentaire_intervenant'] . '</td>
                </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        DisplayEntretienRecordMateriel();
    }
}
function searchEntretienVoiture()
{
    global $conn;
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">Type d\'intervention</th>
        <th class="border-top-0">Lieu Entretien</th>
        <th class="border-top-0">Voiture</th>
        <th class="border-top-0">Cout Entretien</th>
        <th class="border-top-0">Date Début </th>
        <th class="border-top-0">Date Fin </th>
        <th class="border-top-0">Commentaire Déclarant</th>
        <th class="border-top-0">Commentaire Intervenant</th>
        </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT *,E.type AS TYPEentretien FROM entretien AS E 
        LEFT JOIN voiture AS V ON E.id_voiture =V.id_voiture
        LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel
        WHERE E.type ='Vehicule'
        AND etat_entretien = '1'
        AND(id_entretien LIKE ('%" . $search . "%')
        OR E.type LIKE ('%" . $search . "%')
        OR objet_entretien LIKE ('%" . $search . "%')
        OR lieu_entretien LIKE ('%" . $search . "%')
        OR pimm LIKE ('%" . $search . "%')
        OR Marque LIKE ('%" . $search . "%')
        OR Model LIKE ('%" . $search . "%')
        OR cout_entretien LIKE ('%" . $search . "%')
        OR date_entretien LIKE ('%" . $search . "%')
        OR date_fin_entretien LIKE ('%" . $search . "%')
        OR commentaire_intervenant LIKE ('%" . $search . "%')
        OR commentaire LIKE ('%" . $search . "%'))
        ORDER BY id_entretien ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                        <tr>
                            <td class="border-top-0">' . $row['id_entretien'] . '</td>
                            <td class="border-top-0">' . $row['type'] . '</td>
                            <td class="border-top-0">' . $row['objet_entretien'] . '</td>
                            <td class="border-top-0">' . $row['lieu_entretien'] . '</td>
                            <td class="border-top-0">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                            <td class="border-top-0">' . $row['cout_entretien'] . '</td>
                            <td class="border-top-0">' . $row['date_entretien'] . '</td>
                            <td class="border-top-0">' . $row['date_fin_entretien'] . '</td>
                            <td class="border-top-0">' . $row['commentaire'] . '</td>
                            <td class="border-top-0">' . $row['commentaire_intervenant'] . '</td>    
                        </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        DisplayEntretienRecordVoitures();
    }
}

function display_entretien_historique_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Type Entretien</th>
            <th class="border-top-0">Voiture</th>
            <th class="border-top-0">Matériel</th>
            <th class="border-top-0">Utilisateur</th>
            <th class="border-top-0">Activité</th>
            <th class="border-top-0">Date d\'activité</th>
        </tr>';
   
    $query = ("SELECT *,E.type AS TYPEentretien
        from historique_entretien AS HE
        LEFT JOIN entretien AS E ON HE.id_entretien = E.id_entretien 
        LEFT JOIN voiture AS V ON E.id_voiture =V.id_voiture
        LEFT JOIN marquemodel AS MM ON MM.id_MarqueModel =V.id_MarqueModel
        LEFT JOIN materiels AS M ON E.id_materiel = M.id_materiels
        LEFT JOIN materiels_agence AS MA ON MA.id_materiels = M.id_materiels
        JOIN user AS U ON HE.id_user_entretien = U.id_user
        ORDER BY HE.id_historique_entretien DESC");
 
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $color = "badge bg-light-info text-white fw-normal";
        $color1 = "background-color: #2cd07e!important";
        $rowETAT = "Confirmation réalisation de l'entretien";
        if ($row['TYPEentretien'] == 'Vehicule') {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_historique_entretien'] . '</td>
                <td class="border-top-0">' . $row['TYPEentretien'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . " - " . $row['Marque'] . '</br>' . $row['Model'] . '</td>
                <td class="border-top-0">' . " " . '</td>
                <td class="border-top-0">' . $row['nom_user'] . '</td>
                <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>
                <td class="border-top-0">' . $row['date_action_entretien'] . '</td>';
        } else if ($row['TYPEentretien'] == 'Materiel') {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_historique_entretien'] . '</td>
                <td class="border-top-0">' . $row['TYPEentretien'] . '</td>
                <td class="border-top-0">' . " " . '</td>
                <td class="border-top-0">' . $row['designation'] . ' - ' . $row['code_materiel'] . ' ' . $row['num_serie_materiels']  . '</td>
                <td class="border-top-0">' . $row['nom_user'] . '</td>
                <td><span class="' . $color . '" style ="' . $color1 . '">' . $rowETAT . '</span></td>
                <td class="border-top-0">' . $row['date_action_entretien'] . '</td>';
        }
        $value .= '</tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function InsertSettingVoiture()
{
    global $conn;
    $voitureMarque = $_POST['voitureMarque'];
    $voitureModel = $_POST['voitureModel'];
    // validate unique email"
    $sql_e = "SELECT * FROM marquemodel WHERE Marque='$voitureMarque' AND Model='$voitureModel'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger">
            Désolé... Marque ou Modéle est déjà existant!</div>';
    } else {

        $query = "INSERT INTO marquemodel(Marque,Model) VALUE('$voitureMarque','$voitureModel')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo '<div class="text-success">Marque ou Modèle est ajouté  avec succés</div>';
        } else {
            echo 'Veuillez vérifier votre requête';
        }
    }
}
function DisplaySettingVoiture()
{
    global $conn;
    $value = "";
    $value = '<table class="table">
                <tr>
                    <th class="border-top-0"> Marque </th>
                    <th class="border-top-0"> Modèle </th>
                    <th class="border-top-0"> Action</th>
                </tr>';
    $query = "SELECT * FROM marquemodel  WHERE  etat_marque!='S'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $value .= ' <tr>
                        <td> ' . $row['Marque'] . ' </td>
                        <td> ' . $row['Model'] . ' </td>
                        <td> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn_delete_marque" data-id6=' . $row['id_MarqueModel'] . '><span class="fa fa-trash"></span></button> </td>
                    </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}


function DisplaySettingVoitureHS()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $id_user = $_SESSION['id_user'];
    if ($id_agence != "0") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Date Hors service</th>
        <th class="border-top-0">Commentaire</th> 
        </tr>';
        $query = "SELECT * 
        FROM voiture,histrique_voiture 
        WHERE  voiture.id_voiture=histrique_voiture.id_voiture_HV
        AND histrique_voiture.action = 'HS'
        AND histrique_voiture.id_user_HV='$id_user' 
        ORDER BY `histrique_voiture`.`date_action` DESC";

        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $value .= '
            <tr>
            <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
            <td class="border-top-0">' . $row['type'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['date_HV'] . '</td>
            <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
            </tr>';
        }
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Type</th>
        <th class="border-top-0">PIMM</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">Date Hors service</th>
        <th class="border-top-0">Commentaire</th> 
        </tr>';
        $query = "SELECT * 
        FROM voiture,histrique_voiture,agence 
        WHERE voiture.id_voiture=histrique_voiture.id_voiture_HV
        AND voiture.id_agence=agence.id_agence
        AND histrique_voiture.action = 'HS'
        ORDER BY `histrique_voiture`.`date_action` DESC";

        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $value .= '
            <tr>
            <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
            <td class="border-top-0">' . $row['type'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['lieu_agence'] . '</td>
            <td class="border-top-0">' . $row['date_HV'] . '</td>
            <td class="border-top-0">' . $row['commentaire_HV'] . '</td>
            </tr>';
        }
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function DisplaySettingVoitureTransf()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $id_user = $_SESSION['id_user'];
    $value = "<table class='table'>
        <tr>
        <th class='border-top-0'>#</th>
        <th class='border-top-0'>Immat voiture</th>
        <th class='border-top-0'>De l'agence</th>
        <th class='border-top-0'>À l'agence</th>
        <th class='border-top-0'>Date de transfert</th>      
        </tr>";
    if ($id_agence != "0") {
        $query = "SELECT * FROM histrique_voiture,voiture,agence 
        WHERE action = 'Transferer' 
        AND (histrique_voiture.id_agence_em='$id_agence' or histrique_voiture.id_agence_recv='$id_agence')
        AND agence.id_agence='$id_agence' 
        GROUP BY id_histrique_voiture ";
    } else {
        $query = "SELECT * FROM histrique_voiture,agence,voiture 
        WHERE action = 'Transferer' 
        GROUP BY id_histrique_voiture ";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id_agence_em =  $row['id_agence_em'];
        $id_agence_recv =  $row['id_agence_recv'];
        $queryagence = "SELECT * FROM agence  ";
        $resultagence = mysqli_query($conn, $queryagence);
        while ($rowagence = mysqli_fetch_assoc($resultagence)) {
            if ($id_agence_em == $rowagence['id_agence']) {
                $lieu_agence_em = $rowagence['lieu_agence'];
            } else if ($id_agence_recv == $rowagence['id_agence']) {
                $lieu_agence_rec = $rowagence['lieu_agence'];
            }
        }
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_histrique_voiture'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $lieu_agence_em . '</td>
                <td class="border-top-0">' .  $lieu_agence_rec . '</td>
                <td class="border-top-0">' . $row['date_action'] . '</td>               
            </tr>';
    }

    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function delete_SettingVoiture_record()
{
    global $conn;
    $Del_Id = $_POST['Del_ID'];
    $query = "UPDATE marquemodel SET etat_marque='S' where id_MarqueModel='$Del_Id' ";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Votre enregistrement a été supprimé ';
    } else {
        echo ' Veuillez vérifier votre requête ';
    }
}

function display_contrat_archived_materiel()
{

    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date Contrat</th>
    <th class="border-top-0">Type Location</th>
    <th class="border-top-0">Durée Location</th>
    <th class="border-top-0">Num Contrat</th>
    <th class="border-top-0">Date Debut</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode Paiement</th>
    <th class="border-top-0">Nom Client</th>
    <th class="border-top-0">CIN Client</th>
    <th class="border-top-0">Action</th>
        
    </tr>';


    $query = "SELECT DISTINCT C.id_contrat,C.date_contrat,C.duree,C.caution,C.type_location,C.num_cb_caution,C.date_debut,C.date_fin,
    C.prix,C.assurance,C.mode_de_paiement,CL.nom,CL.cin 
        FROM contrat_client AS C 
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
         WHERE DATE(NOW()) <= C.date_fin
         AND  C.etat_contrat != 'S'
          AND  C.type_location = 'Materiel'
          AND C.id_agence = $id_agence";




    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['assurance'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
            <td class="border-top-0">' . $row['nom'] . '</td>                
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-materiel" data-id4=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-id-client-materiel" data-id5=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
            </td>
            
        </tr>';
    }

    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function display_contrat_archived_voiture()
{

    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date de contrat</th>
    <th class="border-top-0">Type de location</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">Date début</th>
    <th class="border-top-0">Date de fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode de paiement</th>
    <th class="border-top-0">Nom de client</th>
    <th class="border-top-0">CIN Client</th>
    <th class="border-top-0">Modèle de véhicule</th>
    <th class="border-top-0">PIMM de véhicule</th>
    <th class="border-top-0">KM Prévu</th>
    <th class="border-top-0">Action</th>  
    </tr>';

    $query = "SELECT C.id_contrat,C.date_contrat,C.caution,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,C.KMPrevu,CL.id_client,CL.nom,CL.cin,V.pimm,MM.Model 
        FROM contrat AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE DATE(NOW()) >= C.date_fin AND  C.type_location = 'Véhicule' AND  C.etat_contrat != 'S' AND C.id_client =CL.id_client";

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['assurance'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>                
            <td class="border-top-0">' . $row['nom'] . '</td>
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['KMPrevu'] . '</td>
            <td class="border-top-0">
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat" data-id2=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
            </td>
            
        </tr>';
    }

    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function searchContratMaterielArchive()
{
    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date de contrat</th>
    <th class="border-top-0">Type de location</th>
    <th class="border-top-0">Durée</th>
    <th class="border-top-0">N° de contrat</th>
    <th class="border-top-0">Date Début</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode de paiement</th>
    <th class="border-top-0">N° de client</th>
    <th class="border-top-0">CIN de client</th>
    <th class="border-top-0">Action</th>  
    </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = ("SELECT DISTINCT C.id_contrat,C.date_contrat,C.duree,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,CL.nom,CL.cin 
        FROM contrat_client AS C 
        LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
        LEFT JOIN client AS CL ON C.id_client=CL.id_client
        WHERE DATE(NOW()) > C.date_fin 
        AND  C.etat_contrat != 'S'
        AND  C.type_location = 'Materiel'
        AND  (C.id_contrat LIKE ('%" . $search . "%')
        OR C.date_contrat LIKE ('%" . $search . "%')     
        OR C.caution LIKE ('%" . $search . "%')
        OR C.duree LIKE ('%" . $search . "%')
        OR C.date_debut LIKE ('%" . $search . "%')
        OR C.date_fin LIKE ('%" . $search . "%')
        OR C.prix LIKE ('%" . $search . "%')
        OR C.assurance LIKE ('%" . $search . "%')
        OR C.mode_de_paiement LIKE ('%" . $search . "%')
        OR CL.nom LIKE ('%" . $search . "%'))
                  ORDER BY C.id_contrat ");
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
                <td class="border-top-0">' . $row['type_location'] . '</td>
                <td class="border-top-0">' . $row['duree'] . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
                <td class="border-top-0">' . $row['prix'] . '</td>
                <td class="border-top-0">' . $row['assurance'] . '</td>
                <td class="border-top-0">' . $row['caution'] . '</td>
                <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>     
                <td class="border-top-0">' . $row['nom'] . '</td>                
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
                <td class="border-top-0">
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
                      <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat" data-id2=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
                    </td>      
                </tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_archived_materiel();
    }
}
function searchContratVoitureArchivage()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email de client</th>
        <th class="border-top-0">Modèle de véhicule</th>
        <th class="border-top-0">PIMM de véhicule</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Nombre de kilomètres inclus</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Actions</th>  
        </tr>';
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = ("SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,
            C.prix,C.mode_de_paiement,C.KMPrevu,C.NbrekmInclus,
            CL.id_client,CL.nom,CL.nom_entreprise,CL.email,A.lieu_agence As lieu_dep,
            AD.lieu_agence As lieu_agence_dep,AR.lieu_agence As lieu_agence_ret,
            V.pimm,MM.Model 
                FROM contrat_client AS C 
                LEFT JOIN client AS CL ON C.id_client =CL.id_client 
                LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
                LEFT JOIN agence AS AD ON AD.id_agence =C.id_agencedep 
                LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
                LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
                LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
                WHERE (DATE(NOW()) >= C.date_fin_validation)
                AND (DATE(NOW()) > C.date_fin)
                AND (C.date_fin_validation != '0000-00-00')
                AND (C.date_debut_validation != '0000-00-00')
                AND C.etat_contrat != 'S' 
                AND  C.type_location = 'Vehicule'
                AND C.id_client =CL.id_client
                AND C.id_agence =   $id_agence
            AND
            (C.id_contrat LIKE ('%" . $search . "%')
            OR C.date_debut LIKE ('%" . $search . "%')     
            OR C.date_fin LIKE ('%" . $search . "%') 
            OR C.date_debut_validation LIKE ('%" . $search . "%')     
            OR C.date_fin_validation LIKE ('%" . $search . "%')     
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%')
            OR MM.Model LIKE ('%" . $search . "%')
            OR V.pimm LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%')
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')
            OR C.NbrekmInclus LIKE ('%" . $search . "%')
            OR C.mode_de_paiement LIKE ('%" . $search . "%'))
                      ORDER BY C.id_contrat DESC");
        } else {
            $sql = ("SELECT C.id_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,
            C.prix,C.mode_de_paiement,C.KMPrevu,C.NbrekmInclus,
            CL.id_client,CL.nom,CL.nom_entreprise,CL.email,A.lieu_agence As lieu_dep,
            AD.lieu_agence As lieu_agence_dep,AR.lieu_agence As lieu_agence_ret,
            V.pimm,MM.Model 
                FROM contrat_client AS C 
                LEFT JOIN client AS CL ON C.id_client =CL.id_client 
                LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
                LEFT JOIN agence AS AD ON AD.id_agence =C.id_agencedep 
                LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
                LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
                LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
                WHERE (DATE(NOW()) >= C.date_fin_validation)
                AND (DATE(NOW()) > C.date_fin)
                AND (C.date_fin_validation != '0000-00-00')
                AND (C.date_debut_validation != '0000-00-00')
                AND C.etat_contrat != 'S' 
                AND  C.type_location = 'Vehicule'
                AND C.id_client =CL.id_client
                AND (C.id_contrat LIKE ('%" . $search . "%')
            OR C.date_debut LIKE ('%" . $search . "%')     
            OR C.date_fin LIKE ('%" . $search . "%') 
            OR C.date_debut_validation LIKE ('%" . $search . "%')     
            OR C.date_fin_validation LIKE ('%" . $search . "%')    
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%')
            OR MM.Model LIKE ('%" . $search . "%')
            OR V.pimm LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%')
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')
            OR C.NbrekmInclus LIKE ('%" . $search . "%')
            OR C.mode_de_paiement LIKE ('%" . $search . "%'))
                      ORDER BY C.id_contrat DESC");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_debut'])).' </td>
                <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_fin'])).' </td>
                <td class="border-top-0">' . $row['lieu_dep'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
                if ($row['nom_entreprise'] == ""){
                    $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
                }else if ($row['nom'] == ""){
                    $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
                }else{
                    $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                }
                $value .= '<td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . $row['Model'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td> 
                <td class="border-top-0">' . $row['duree'] . '</td>
                <td class="border-top-0">' . $row['prix'] . '</td>
                <td class="border-top-0">' . $row['caution'] . '</td>
                <td class="border-top-0">' . $row['NbrekmInclus'] . '</td>
                <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
                $value .= '<td class="border-top-0">';
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-voiture" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>';
                }
                $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
                </td></tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_archivage_record_voiture();
    }
}

function searchContratMaterielArchivage()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email de client</th>
        <th class="border-top-0">Désignation matériel</th>
        <th class="border-top-0">Num Série matériel</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Nombre de kilomètres inclus</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Action</th>  
        </tr>';

    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = ("SELECT DISTINCT C.id_contrat,C.duree,C.id_agencedep,C.id_agenceret,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,
            C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,
            CL.nom,CL.nom_entreprise,CL.email,
            CM.designation_contrat,CM.num_serie_contrat,
            A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
            FROM contrat_client AS C 
            LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
            LEFT JOIN client AS CL ON C.id_client=CL.id_client
            LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
            LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
            WHERE (DATE(NOW()) >= C.date_fin_validation)
            AND (DATE(NOW()) > C.date_fin)
            AND (C.date_fin_validation != '0000-00-00')
            AND (C.date_debut_validation != '0000-00-00')
            AND  C.type_location = 'Materiel'
            AND C.etat_contrat != 'S' 
            AND C.id_agence = $id_agence
            AND
            (C.id_contrat LIKE ('%" . $search . "%')
            OR C.date_debut LIKE ('%" . $search . "%')     
            OR C.date_fin LIKE ('%" . $search . "%')
            OR C.date_debut_validation LIKE ('%" . $search . "%')     
            OR C.date_fin_validation LIKE ('%" . $search . "%')        
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%')
            OR CM.designation_contrat LIKE ('%" . $search . "%')
            OR CM.num_serie_contrat LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%')
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')
            OR C.NbrekmInclus LIKE ('%" . $search . "%')
            OR C.mode_de_paiement LIKE ('%" . $search . "%'))
            ORDER BY C.id_contrat DESC");
        } else {
            $sql = ("SELECT DISTINCT C.id_contrat,C.duree,C.id_agencedep,C.id_agenceret,C.caution,C.type_location,C.num_cheque_caution,C.date_debut,C.date_fin,
            C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,
            CL.nom,CL.nom_entreprise,CL.email,CM.designation_contrat,CM.num_serie_contrat,
            A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
            FROM contrat_client AS C 
            LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
            LEFT JOIN client AS CL ON C.id_client=CL.id_client
            LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
            LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
            WHERE (DATE(NOW()) >= C.date_fin_validation)
            AND (DATE(NOW()) > C.date_fin)
            AND (C.date_fin_validation != '0000-00-00')
            AND (C.date_debut_validation != '0000-00-00')
            AND  C.type_location = 'Materiel'
            AND C.etat_contrat != 'S' 
            AND (C.id_contrat LIKE ('%" . $search . "%')
            OR C.date_debut LIKE ('%" . $search . "%')     
            OR C.date_fin LIKE ('%" . $search . "%')
            OR C.date_debut_validation LIKE ('%" . $search . "%')     
            OR C.date_fin_validation LIKE ('%" . $search . "%')      
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%')
            OR CM.designation_contrat LIKE ('%" . $search . "%')
            OR CM.num_serie_contrat LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%')
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')
            OR C.NbrekmInclus LIKE ('%" . $search . "%')
            OR C.mode_de_paiement LIKE ('%" . $search . "%'))
            ORDER BY C.id_contrat DESC");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_debut'])).'</td>
                <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_fin'])).'</td>
                <td class="border-top-0">' . $row['lieu_dep'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
                if ($row['nom_entreprise'] == ""){
                    $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
                }else if ($row['nom'] == ""){
                    $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
                }else{
                    $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                }
                $value .= '<td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . $row['designation_contrat'] . '</td>
                <td class="border-top-0">' . $row['num_serie_contrat'] . '</td> 
                <td class="border-top-0">' . $row['duree'] . '</td>
                <td class="border-top-0">' . $row['prix'] . '</td>
                <td class="border-top-0">' . $row['caution'] . '</td>
                <td class="border-top-0">' . $row['NbrekmInclus'] . '</td>
                <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
                $value .= '<td class="border-top-0">';
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-materiel" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>';
                }
                $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-materiel" data-id5=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
                </td></tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_archivage_record_materiel();
    }
}

function searchContratPackArchivage()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $date=date("Y-m-d");
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email de client</th>
        <th class="border-top-0">Désignation Pack</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Nombre de kilomètres inclus</th>
        <th class="border-top-0">Mode de paiement</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">#</th>
        <th class="border-top-0">Date de départ</th>
        <th class="border-top-0">Date de retour</th>
        <th class="border-top-0">Agence de départ</th>
        <th class="border-top-0">Agence de retour</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">Email de client</th>
        <th class="border-top-0">Désignation Pack</th>
        <th class="border-top-0">Durée de location</th>
        <th class="border-top-0">Prix</th>
        <th class="border-top-0">Caution</th>
        <th class="border-top-0">Nombre de kilomètres inclus</th>
        <th class="border-top-0">Mode de paiement</th>
        <th class="border-top-0">Action</th> 
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($id_agence != "0") {
            $sql = ("SELECT DISTINCT C.id_contrat,C.duree,C.caution,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,
                P.designation_pack,
                CL.nom,CL.nom_entreprise,CL.email,
                A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
                    FROM contrat_client AS C 
                    LEFT JOIN group_packs AS P ON P.id_group_packs=C.id_group_pack
                    LEFT JOIN client AS CL ON C.id_client=CL.id_client
                    LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
                    LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
                    WHERE (DATE(NOW()) >= C.date_fin_validation)
                    AND (DATE(NOW()) > C.date_fin)
                    AND (C.date_fin_validation != '0000-00-00') 
                    AND C.type_location = 'Pack' 
                    AND  C.etat_contrat != 'S'
                    AND C.id_agence = $id_agence
                    AND (C.id_contrat LIKE ('%" . $search . "%')
            OR C.date_debut LIKE ('%" . $search . "%')     
            OR C.date_fin LIKE ('%" . $search . "%') 
            OR C.date_debut_validation LIKE ('%" . $search . "%')     
            OR C.date_fin_validation LIKE ('%" . $search . "%')
            OR P.designation_pack LIKE ('%" . $search . "%')     
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%')
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')
            OR C.mode_de_paiement LIKE ('%" . $search . "%'))
            ORDER BY C.id_contrat DESC");
        } else {
            $sql = ("SELECT DISTINCT C.id_contrat,C.duree,C.caution,C.date_debut,C.date_fin,C.date_debut_validation,C.date_fin_validation,C.prix,C.mode_de_paiement,C.NbrekmInclus,
                P.designation_pack,
                CL.nom,CL.nom_entreprise,CL.email,
                A.lieu_agence As lieu_dep,AR.lieu_agence As lieu_agence_ret
                    FROM contrat_client AS C 
                    LEFT JOIN group_packs AS P ON P.id_group_packs=C.id_group_pack
                    LEFT JOIN client AS CL ON C.id_client=CL.id_client
                    LEFT JOIN agence AS A ON A.id_agence =C.id_agence 
                    LEFT JOIN agence AS AR ON AR.id_agence =C.id_agenceret
                    WHERE (DATE(NOW()) >= C.date_fin_validation)
                    AND (DATE(NOW()) > C.date_fin)
                    AND (C.date_fin_validation != '0000-00-00') 
                    AND C.type_location = 'Pack' 
                    AND  C.etat_contrat != 'S'
                    AND (C.id_contrat LIKE ('%" . $search . "%')
            OR C.date_debut LIKE ('%" . $search . "%')     
            OR C.date_fin LIKE ('%" . $search . "%') 
            OR C.date_debut_validation LIKE ('%" . $search . "%')     
            OR C.date_fin_validation LIKE ('%" . $search . "%')
            OR P.designation_pack LIKE ('%" . $search . "%')     
            OR A.lieu_agence LIKE ('%" . $search . "%')
            OR AR.lieu_agence LIKE ('%" . $search . "%')
            OR CL.nom LIKE ('%" . $search . "%')
            OR CL.nom_entreprise LIKE ('%" . $search . "%')
            OR CL.email LIKE ('%" . $search . "%')
            OR C.duree LIKE ('%" . $search . "%')
            OR C.prix LIKE ('%" . $search . "%')
            OR C.caution LIKE ('%" . $search . "%')
            OR C.mode_de_paiement LIKE ('%" . $search . "%'))
            ORDER BY C.id_contrat DESC");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '
                <tr>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_debut'])).'</td>
                <td class="border-top-0">'. date('d-m-Y', strtotime($row['date_fin'])).'</td>
                <td class="border-top-0">' . $row['lieu_dep'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence_ret'] . '</td>'; 
                if ($row['nom_entreprise'] == ""){
                    $value .= '<td class="border-top-0">' . $row['nom'] . '</td>';
                }else if ($row['nom'] == ""){
                    $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . '</td>';
                }else{
                    $value .= '<td class="border-top-0">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                }
                $value .= '<td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">' . $row['designation_pack'] . '</td>
                <td class="border-top-0">' . $row['duree'] . '</td>
                <td class="border-top-0">' . $row['prix'] . '</td>
                <td class="border-top-0">' . $row['caution'] . '</td>
                <td class="border-top-0">' . $row['NbrekmInclus'] . '</td>
                <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>';
                $value .= '<td class="border-top-0">';
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<button type="button" title="Supprimer le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-contrat-pack" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>';
                }
                $value .= '<button type="button" title="Télécharger le contrat" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-pack" data-id3=' . $row['id_contrat'] . '><i class="fas fa-download"></i></i></button>
                </td></tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_contrat_archivage_record_pack();
    }
}

//function notification creation de contrat
function ContratCreateNotification()
{
    global $conn;
    if (isset($_POST["view"])) {
        $output = '';
        if ($_SESSION['Role'] == "mecanicien") {
            $output
            .= '<li class="text-bold text-italic">Aucune notification trouvée</li>';
            $count = 0;
            $data = array('notification_contratDebut' => $output, 'unseen_notification_contratDebut' => $count);
            echo json_encode($data);
        }else{
            $query = "SELECT * FROM `notification` where id_user = " . $_SESSION['id_user'] . " ORDER BY date_creation DESC LIMIT 4 ";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $query_nomuser = "SELECT nom_user FROM user AS U,contrat_client AS C
                    where U.id_user = C.id_user
                    AND C.id_contrat =".$row["id_contrat"];
                    $result_nomuser = mysqli_query($conn, $query_nomuser);
                    $row_nomuser = mysqli_fetch_row($result_nomuser);
                    $nomuser = $row_nomuser[0];

                    $color = $row["status"];
                    if ($color == 0) {
                        $style = "background-color: #DFE9F2";
                    } else {
                        $style = "background-color: white";
                    }
                    $output .= '
                        <li>
                            <div class="border-bottom border-dark p-3" style="' . $style . '">
                            <div class="text-secondary"><a onClick="reply_click(this.id)" id="' . $row["id_contrat"] . '" target="_blank"
                                att="' . $row["id_contrat"] . '" href="Liste_notif_debut_contrat.php?clicked_id=' . $row["id_contrat"]
                        . '">Le contrat n°'. $row["id_contrat"] .' a été crée par "'. $nomuser .'" le ' . $row["date_creation"] . '</a></div>
                            </div>
                        </li>
                        <li class="divider"></li>';
                }
                $output .= ' 
                    <div > <a href="ListeNotificationCreateDebutContra.php"> Voir Plus </a>  </div>';
            } else {
                $output
                    .= '<li class="text-bold text-italic">Aucune notification trouvée</li>';
            }
            $query_1 = "SELECT * FROM `notification` where id_user= " . $_SESSION['id_user'] . " AND status=0";
            $result_1 = mysqli_query($conn, $query_1);
            $count = mysqli_num_rows($result_1);
            $data = array('notification_contratDebut' => $output, 'unseen_notification_contratDebut' => $count);
            echo json_encode($data);
        } 
        
    }
}

// founction de notification de contrat

function ContratNotification()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    
    if (isset($_POST["view"])) {
        if ($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable") {
            $query = "SELECT C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.email,CL.tel,CL.adresse,C.view,CL.nom_entreprise
            FROM contrat_client as C
            left JOIN client as CL
            on C.id_client=CL.id_client
            WHERE C.etat_contrat != 'S'
            AND (DATE(NOW()) BETWEEN DATE_SUB(C.date_fin, INTERVAL 7 DAY) AND DATE_SUB(C.date_fin, INTERVAL -3 DAY))
            LIMIT 4";
        }else{
            $query = "SELECT C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.email,CL.tel,CL.adresse,C.view,CL.nom_entreprise
            FROM contrat_client as C
            left JOIN client as CL
            on C.id_client=CL.id_client
            WHERE C.etat_contrat != 'S'
            AND C.id_agence = $id_agence
            AND (DATE(NOW()) BETWEEN DATE_SUB(C.date_fin, INTERVAL 7 DAY) AND DATE_SUB(C.date_fin, INTERVAL -3 DAY))
            LIMIT 4";
        }
        $result = mysqli_query($conn, $query);
        $output = '';

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $str1 = "Le contrat de ";
                $str2 = " du client ";
                $str3 = " se terminera bientôt";

                if ($row['view'] == 1) {
                    $style = 'background-color: #DFE9F2;';
                } else {
                    $style = 'background-color: white;';
                }

                if ($row['nom_entreprise'] == "") {
                    $output .= '
                        <li>
                            <div class="border-bottom border-dark p-3" style="' . $style . '">
                                <div class="text-secondary" ><a onClick="reply_click(this.id)" id="' . $row["id_contrat"] . '" target="_blank" att="' . $row["id_contrat"] .
                        '" href="Liste_notifications_update.php?clicked_id=' . $row["id_contrat"] . '">' . $str1 . '' . $row["type_location"] . '' . $str2 . '' .
                        $row["nom"] . '' . $str3 . '</a></div>
                            </div>
                        </li>
                        <li class="divider"></li>';
                } else if ($row['nom'] == "") {
                    $output .= '
                        <li>
                            <div class="border-bottom border-dark p-3" style="' . $style . '">
                                <div class="text-secondary" ><a onClick="reply_click(this.id)" id="' . $row["id_contrat"] . '" target="_blank" att="' . $row["id_contrat"] .
                        '" href="Liste_notifications_update.php?clicked_id=' . $row["id_contrat"] . '">' . $str1 . '' . $row["type_location"] . '' . $str2 . '' .
                        $row["nom_entreprise"] . '' . $str3 . '</a></div>
                            </div>
                        </li>
                        <li class="divider"></li>';
                } else {
                    $output .= '
                        <li>
                            <div class="border-bottom border-dark p-3" style="' . $style . '">
                                <div class="text-secondary" ><a onClick="reply_click(this.id)" id="' . $row["id_contrat"] . '" target="_blank" att="' . $row["id_contrat"] .
                        '" href="Liste_notifications_update.php?clicked_id=' . $row["id_contrat"] . '">' . $str1 . '' . $row["type_location"] . '' . $str2 . '' .
                        $row["nom"] . '(' . $row["nom_entreprise"] . ')' . '' . $str3 . '</a></div>
                            </div>
                        </li>
                        <li class="divider"></li>';
                }
            }
            $output .= ' <div > <a href="Liste_notifications.php"> Voir Plus </a> </div>';
        } else {
            $output .= '<li class="text-bold text-italic">Aucune notification trouvée</li>';
        }

        if ($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable") {
            $query_1 = "SELECT C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.email,CL.tel,CL.adresse
            FROM contrat_client as C
            left JOIN client as CL on C.id_client=CL.id_client
            WHERE C.contrat_status = 0
            AND C.view = 1
            AND C.etat_contrat != 'S'
            AND (DATE(NOW()) BETWEEN DATE_SUB(C.date_fin, INTERVAL 7 DAY) AND DATE_SUB(C.date_fin, INTERVAL 0 DAY))";
        }else{
            $query_1 = "SELECT C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.email,CL.tel,CL.adresse
            FROM contrat_client as C
            left JOIN client as CL on C.id_client=CL.id_client
            WHERE C.contrat_status = 0
            AND C.view = 1
            AND C.id_agence = $id_agence
            AND C.etat_contrat != 'S'
            AND (DATE(NOW()) BETWEEN DATE_SUB(C.date_fin, INTERVAL 7 DAY) AND DATE_SUB(C.date_fin, INTERVAL 0 DAY))";
        }
        $result_1 = mysqli_query($conn, $query_1);
        $count = mysqli_num_rows($result_1);
        $data = array(
            'notification_contrat' => $output,
            'unseen_notification' => $count
        );
        echo json_encode($data);
    }
}

// fin  founction de notification de contrat


function EntretienNotification()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if (isset($_POST["view"])) {
        if ($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable") {
            $query = "SELECT *
                    FROM controletechnique AS CT 
                    LEFT JOIN voiture AS V ON CT.id_voiture=V.id_voiture
                    WHERE CT.controle_status = 0
                    AND CT.date_controletechnique != '0000-00-00'
                    AND DATEDIFF(CT.date_controletechnique, NOW()) BETWEEN 0 AND 14
                    LIMIT 4";
        }else{
            $query = "SELECT *
                    FROM controletechnique AS CT 
                    LEFT JOIN voiture AS V ON CT.id_voiture=V.id_voiture
                    WHERE CT.controle_status = 0
                    AND V.id_agence = $id_agence
                    AND CT.date_controletechnique != '0000-00-00'
                    AND DATEDIFF(CT.date_controletechnique, NOW()) BETWEEN 0 AND 14
                    LIMIT 4";
        }
        $result = mysqli_query($conn, $query);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $str1 = "Le Contrôle Périodique de la voiture ";
                $str2 = " à vérifier  ";
                $output .= '<li>
                    <div class="border-bottom border-dark p-3">
                        <div class="text-secondary"><a onClick="reply_click1(this.id)" id="'.$row["id_controletechnique"].'" target="_blank" att="'.$row["id_controletechnique"].'" href="ListeNotifEntretienUpdate.php?clicked_id=' . $row["id_controletechnique"] . '" >' . $str1 . $row["pimm"] . $str2 . '' . date('d-m-Y', strtotime($row['date_controletechnique'])) .'</a></div>
                    </div>
                </li>
                <li class="divider"></li>';
            }
            $output .= '<div> <a href="ListeNotifcationEntretien.php"> Voir Plus </a>  </div>';
        } else {
            $output .= '<li class="text-bold text-italic">Aucune notification trouvée</li>';
        }

        if ($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable") {
            $query_1 = "SELECT *
                    FROM controletechnique AS CT 
                    LEFT JOIN voiture AS V ON CT.id_voiture=V.id_voiture
                    WHERE CT.controle_status = 0
                    AND CT.date_controletechnique != '0000-00-00'
                    AND DATEDIFF(CT.date_controletechnique, NOW()) BETWEEN 0 AND 14";
        }else{
            $query_1 = "SELECT *
                    FROM controletechnique AS CT 
                    LEFT JOIN voiture AS V ON CT.id_voiture=V.id_voiture
                    WHERE CT.controle_status = 0
                    AND V.id_agence = $id_agence
                    AND CT.date_controletechnique != '0000-00-00'
                    AND DATEDIFF(CT.date_controletechnique, NOW()) BETWEEN 0 AND 14";
        }
        $result_1 = mysqli_query($conn, $query_1);
        $count = mysqli_num_rows($result_1);
        $data = array(
            'notification_entretien' => $output,
            'unseen_notification_entretien' => $count
        );
        echo json_encode($data);
    }
}

function PaiementNotification()
{
    global $conn;
    if (isset($_POST["view"])) {
        $query = "SELECT DAY(date_prelevement)AS day_prelevement,date_prelevement,id_contrat,date_fin,type_location,paiemenet_satatus 
        FROM contrat WHERE (duree='LLD'OR duree='Standard') AND  (DATE(NOW())<=date_fin AND paiemenet_satatus=0) ";
        $result = mysqli_query($conn, $query);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $date_prelevement = $row['day_prelevement'];
                $date_today = date("d");
                if ($date_prelevement == $date_today) {


                    $str1 = " la date du paiement de contrat ";
                    $str2 = " num:  ";
                    $str3 = " est expirée!  ";
                    $output .= '<div class="alert alert-danger" id="paiement-list" style="padding-left: 3%;border-bottom: 1px solid rgba(120, 130, 140, 0.13)!important;margin-bottom:0px" role="alert">
                            ' . $str1 . '' . $row["type_location"] . '' . '' . $row['day_prelevement'] . '' . $str2 . '' . $row["id_contrat"] . '' . $str3 . '
                            <button type="button"  data-target="#exampleModal" id="contrat-paiement" class="btn btn-success" data-paiement=' . $row['id_contrat'] . '>
                            Valider paiement</button></div>';
                    $queryupdate = "UPDATE contrat SET 
                            paiemenet_satatus=0 AND date_prelevement = DATE(NOW()+1)";
                    $result_update = mysqli_query($conn, $queryupdate);
                }
            }
        } else {
            $output .= '<li class="text-bold text-italic">Aucune notification trouvée</li>';
        }
        $query_1 = "SELECT DAY(date_prelevement)AS day_prelevement,date_prelevement,id_contrat,date_fin,type_location,paiemenet_satatus 
        FROM contrat 
        WHERE (duree='LLD'OR duree='Standard') 
        AND (DATE(NOW())<=date_fin AND paiemenet_satatus=0) 
        AND (DAY(NOW())=DAY(date_prelevement))";
        $result_1 = mysqli_query($conn, $query_1);
        $count = mysqli_num_rows($result_1);
        $data = array(
            'notification_paiement' => $output,
            'unseen_notification_paiement' => $count
        );
        echo json_encode($data);
    }
}
function get_validate_contrat_paiement_record()
{
    global $conn;
    $contratPaiementId = $_POST['contrat_ID'];
    $query = " SELECT id_contrat FROM contrat WHERE id_contrat =$contratPaiementId ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $contrat_data = [];
        $contrat_data[0] = $row['id_contrat'];
    }
    echo json_encode($contrat_data);
}
function update_contrat_validate_paiement()
{
    global $conn;
    $Update_Contrat_Id = $_POST['updateContratId'];
    $query = "UPDATE contrat SET 
     paiemenet_satatus = 1
     WHERE id_contrat ='$Update_Contrat_Id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $query_1 = "INSERT INTO archive_paiement (contrat_id,date_validation) VALUE  ('$Update_Contrat_Id',NOW())";
        $result_1 = mysqli_query($conn, $query_1);
    } else {
        echo 'maselktch';
    }
}

function display_contrat_record_mixte()
{

    global $conn;
    $value = '<table class="table">
    <tr>
    <th class="border-top-0">#</th>
    <th class="border-top-0">Date Contrat</th>
    <th class="border-top-0">Type Location</th>
    <th class="border-top-0">Durée Location</th>
    <th class="border-top-0">N° de Contrat</th>
    <th class="border-top-0">Date Debut</th>
    <th class="border-top-0">Date Fin</th>
    <th class="border-top-0">Prix</th>
    <th class="border-top-0">Assurance</th>
    <th class="border-top-0">Caution</th>
    <th class="border-top-0">Mode Paiement</th>
    <th class="border-top-0">Nom Client</th>
    <th class="border-top-0">CIN Client</th>
    <th class="border-top-0">Modele Véhicule</th>
    <th class="border-top-0">PIMM Véhicule</th>
    <th class="border-top-0">KM Prévu</th>

    <th class="border-top-0">Action</th>  
    </tr>';

    $query = "SELECT
     C.id_contrat,C.date_contrat,C.caution,C.duree,C.id_client,C.type_location,C.num_contrat,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,C.KMPrevu,C.contrat_file,CL.id_client,CL.nom,CL.cin,V.pimm,MM.Model 
        FROM contrat_mixte AS C 
        LEFT JOIN client AS CL ON C.id_client =CL.id_client 
        LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
        LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
        WHERE DATE(NOW()) <= C.date_fin AND C.id_client =CL.id_client";

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
        <tr>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_contrat'])) . '</td>
            <td class="border-top-0">' . $row['type_location'] . '</td>
            <td class="border-top-0">' . $row['duree'] . '</td>
            <td class="border-top-0">' . $row['id_contrat'] . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
            <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_fin'])) . '</td>
            <td class="border-top-0">' . $row['prix'] . '</td>
            <td class="border-top-0">' . $row['assurance'] . '</td>
            <td class="border-top-0">' . $row['caution'] . '</td>
            <td class="border-top-0">' . $row['mode_de_paiement'] . '</td>                
            <td class="border-top-0">' . $row['nom'] . '</td>
            <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>
            <td class="border-top-0">' . $row['Model'] . '</td>
            <td class="border-top-0">' . $row['pimm'] . '</td>
            <td class="border-top-0">' . $row['KMPrevu'] . '</td>
          
            <td class="border-top-0">
        
            <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat-mixte" data-id3=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-contrat-mixte" data-id1=' . $row['id_contrat'] . '><i class="fas fa-trash-alt"></i></button>
              <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-show-contrat-mixte" data-id2=' . $row['id_contrat'] . '><i class="fas fa-eye"></i></i></button>
            </td>
            
        </tr>';
    }
    //   <td class="border-top-0">' . $row['contrat_file'] . '</td>  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-contrat-mixte" data-id=' . $row['id_contrat'] . '><i class="fas fa-edit"></i></button> 
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// delete_contrat_record_mixte
function delete_contrat_record_mixte()
{
    global $conn;
    $Del_ID = $_POST['Delete_ContratID'];
    $query = "DELETE FROM contrat_mixte WHERE id_contrat='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $query = "DELETE FROM contrat_materiel_mixte WHERE id_contrat='$Del_ID'";
        $result = mysqli_query($conn, $query);
        echo "Le contrat est supprimé avec succés";
    } else {
        echo "SVP vérifier votre requette !";
    }
}

//end  delete_contrat_record_mixte


function InsertContratMixte()
{
    global $conn;

    $ContratmaterielListe = isset($_POST['ContratmaterielListe']) ? $_POST['ContratmaterielListe'] : [];
    $ContratmaterielListe = explode(',', $ContratmaterielListe);
    $ContratDate = isset($_POST['ContratDate']) ? $_POST['ContratDate'] : NULL;
    $ContratType = isset($_POST['ContratType']) ? $_POST['ContratType'] : NULL;
    $ContratDuree = isset($_POST['ContratDuree']) ? $_POST['ContratDuree'] : NULL;
    $ContratDateDebut = isset($_POST['ContratDateDebut']) ? $_POST['ContratDateDebut'] : NULL;
    $ContratDateFin = isset($_POST['ContratDateFin']) ? $_POST['ContratDateFin'] : NULL;
    $ContratPrixContrat = isset($_POST['ContratPrixContrat']) ? $_POST['ContratPrixContrat'] : NULL;
    $ContratAssurence = isset($_POST['ContratAssurence']) ? $_POST['ContratAssurence'] : NULL;
    $ContratPaiement = isset($_POST['ContratPaiement']) ? $_POST['ContratPaiement'] : NULL;
    $ContratDatePaiement = isset($_POST['ContratDatePaiement']) ? $_POST['ContratDatePaiement'] : NULL;
    $ContratCaution = isset($_POST['ContratCaution']) ? $_POST['ContratCaution'] : NULL;
    $ContratnumCaution = isset($_POST['ContratNumCaution']) ? $_POST['ContratNumCaution'] : NULL;
    $ContratVoitureModel = isset($_POST['ContratVoitureModel']) ? $_POST['ContratVoitureModel'] : NULL;
    $ContratVoiturePIMM = isset($_POST['ContratVoiturePIMM']) ? $_POST['ContratVoiturePIMM'] : NULL;
    $ContratVoiturekMPrevu = isset($_POST['ContratVoiturekMPrevu']) ? $_POST['ContratVoiturekMPrevu'] : NULL;
    $ContratClient = isset($_POST['ContratClient']) ? $_POST['ContratClient'] : NULL;
    $ContratFileMixte = isset($_FILES['ContratFileMixte']) ? $_FILES['ContratFileMixte'] : NULL;
    $count = count($ContratmaterielListe);
    $unique_id = hash("sha256", strval(rand(1000, 9999999)) + strval(time()));
    $contrat_filename = $unique_id . "_contratControl." . strtolower(pathinfo($ContratFileMixte["name"], PATHINFO_EXTENSION));
    move_uploaded_file($ContratFileMixte["tmp_name"], "./uploads/${contrat_filename}");

    if ($count >= 1) {
        $query = "INSERT INTO 
        contrat_mixte(id_client,id_voiture,date_contrat,type_location,duree,date_debut,date_fin,prix,assurance,mode_de_paiement,caution,num_cheque_caution,KMPrevu,date_prelevement,contrat_file) 
        VALUES ('$ContratClient','$ContratVoiturePIMM','$ContratDate','$ContratType','$ContratDuree','$ContratDateDebut','$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement',
        '$ContratCaution','$ContratnumCaution','$ContratVoiturekMPrevu','$ContratDatePaiement','$contrat_filename')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $query_get_max_id_contrat = "SELECT max(id_contrat)
                    FROM contrat_mixte";
            $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
            while ($row = mysqli_fetch_row($result_query_get_max_id_contra)) {
                $id_contrat = $row[0];
                $materiel_table = $ContratmaterielListe;

                if ($count >= 1) {
                    for ($i = 0; $i < $count; $i++) {
                        $query_insert_materiel_list = "INSERT INTO contrat_materiel_mixte(id_contrat,id_materiel) VALUES ('$id_contrat','$materiel_table[$i]') ";
                        $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
                    }
                    if ($result_query_insert_materiel_list) {
                        echo ("<div class='text-success'>Le contrat est inseré</div>");
                    } else {
                        echo ("<div class='text-danger'>échoué : lors d'ajout de contrat !</div>");
                    }
                }
            }
        } else {
            echo ("<div class='text-danger'>Erreur lors d'ajout de contrat</div>");
        }
    } else {
        echo ("<div class='text-danger'>Erreur lors d'ajout de contrat Mixte</div>");
    }
}

//contrat pack
function select_contrat_pack_record()
{
    global $conn;
    $ContratId = $_POST['ContratID'];
    $query = "SELECT CL.nom, CL.email, CL.tel, CL.adresse, 
    C.id_contrat, C.date_contrat, C.date_debut, C.date_fin, C.prix, C.mode_de_paiement, C.date_prelevement, C.caution, C.num_cheque_caution,
    CM.designation_contrat, CM.num_serie_contrat,
    CC.designation_composant, CC.num_serie_composant, C.id_contrat,
    MM.Marque, MM.Model,V.pimm,C.id_voiture
    FROM materiel_contrat_client AS CM 
    LEFT JOIN contrat_client AS C ON CM.id_contrat =C.id_contrat
    LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture 
    LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
    LEFT JOIN client AS CL ON CL.id_client = C.id_client 
    LEFT JOIN composant_materiels_contrat AS CC ON CC.id_contrat =CM.id_contrat
    WHERE C.type_location = 'Pack' 
    AND C.id_contrat='$ContratId'";
    $result = mysqli_query($conn, $query);
    $contrat_materiel_data = [];
    $ttc = 0;
    $t = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        if (empty($contrat_materiel_data)) {
            $contrat_materiel_data[0] = $row['id_contrat'];
            $contrat_materiel_data[1] = $row['nom'];
            $contrat_materiel_data[2] = $row['email'];
            $contrat_materiel_data[3] = $row['tel'];
            $contrat_materiel_data[4] = $row['adresse'];
            if ($row['id_voiture'] != 0) {
                $contrat_materiel_data[5] = 'Immatriculation :' . $row['pimm'];
                $contrat_materiel_data[6] = 'Marque :' . $row['Marque'] . ' ' . $row['Model'];
            } else {
                $contrat_materiel_data[6] = "Véhicule : sans voiture";
                $contrat_materiel_data[5] = '';
            }
            $contrat_materiel_data[7] = $row['date_debut'];
            $contrat_materiel_data[8] = $row['date_fin'];
            $contrat_materiel_data[9] = $row['prix'];
            $ttc = $row['prix'] + ($row['prix'] * 0.2);
            $contrat_materiel_data[10] = $ttc;
            $contrat_materiel_data[11] =  $row['mode_de_paiement'];
            $contrat_materiel_data[12] = '';
            $contrat_materiel_data[13] = $row['caution'];
            $contrat_materiel_data[15] = $row['num_cheque_caution'];
            $contrat_materiel_data[17] = $row['date_contrat'];
            $contrat_materiel_data[18][] = $row['designation_composant'];
            $contrat_materiel_data[19][] = $row['num_serie_composant'];
            $contrat_materiel_data[21] =  $t + 1;
        } else {
            $contrat_materiel_data[18][] = $row['designation_composant'];
            $contrat_materiel_data[19][] = $row['num_serie_composant'];
            $contrat_materiel_data[21] =  $t + 1;
        }
    }
    echo json_encode($contrat_materiel_data);
}

function get_mixte_record()
{
    global $conn;
    $MaterielID = $_POST['MaterielID'];
    $query = " SELECT * FROM contrat_mixte WHERE id_contrat='$MaterielID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $Materiel_data = [];
        $Materiel_data[0] = $row['id_contrat'];
        $Materiel_data[1] = $row['date_contrat'];
        $Materiel_data[2] = $row['duree'];
        $Materiel_data[3] = $row['date_debut'];
        $Materiel_data[4] = $row['date_fin'];
        $Materiel_data[5] = $row['prix'];
        $Materiel_data[6] = $row['assurance'];
        $Materiel_data[7] = $row['mode_de_paiement'];
        $Materiel_data[8] = $row['caution'];
        $Materiel_data[9] = $row['num_cheque_caution'];
    }
    echo json_encode($Materiel_data);
}


function update_contrat_pack()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $updateContratId = $_POST['updateContratId'];
    $Update_Contrat_Date_Fin = $_POST['up_DateContratFin'];
    $Update_Contrat_Date_Debut = $_POST['up_DateContratDebut'];
    $Update_Contrat_Duree = $_POST['upDureeContrat'];
    $Update_Contrat_Prix = $_POST['up_contratPrix'];
    $Update_Contrat_NbreKilometre = $_POST['updateContratNbreKilometre'];
    $Update_Contrat_Paiement = $_POST['up_contratPaiement'];
    $Update_date_Prelevement = $_POST['up_DatePrelevementContrat'];
    $Update_moyen_caution = $_POST['updateContratmoyenCaution'];
    $Update_Contrat_Caution = $_POST['updateContratCaution'];
    $Update_Contrat_Caution_Cheque = $_POST['updateContratCautionCheque'];
    $Update_num_caution = $_POST['updateContratnumCaution'];
    $Update_num_caution_CB = $_POST['updateContratnumCautionCB'];

    $query_select = "SELECT * FROM contrat_client where id_contrat ='$updateContratId'";
    $result_select = mysqli_query($conn, $query_select);
    while ($row = mysqli_fetch_assoc($result_select)) {
        $select_data = new stdClass();
        $select_data->DateDebut = $row['date_debut'];
        $select_data->DateFin = $row['date_fin'];
        $select_data->Duree = $row['duree'];
        $select_data->Prix = $row['prix'];
        $select_data->Mode_de_paiement = $row['mode_de_paiement'];
        $select_data->NbreKilometre = $row['NbrekmInclus'];
        $select_data->Moyen_caution = $row['moyen_caution'];
        $select_data->Caution = $row['caution'];
        $select_data->CautionCheque = $row['cautioncheque'];
        $select_data->Num_cheque_caution = $row['num_cheque_caution'];
        $select_data->Num_cb_caution = $row['num_cb_caution'];
    }
    json_encode($select_data);

    $query = "UPDATE contrat_client SET 
     date_debut='$Update_Contrat_Date_Debut',date_fin='$Update_Contrat_Date_Fin',duree='$Update_Contrat_Duree',NbrekmInclus='$Update_Contrat_NbreKilometre',
     prix='$Update_Contrat_Prix',mode_de_paiement='$Update_Contrat_Paiement',moyen_caution='$Update_moyen_caution',caution='$Update_Contrat_Caution',
     cautioncheque='$Update_Contrat_Caution_Cheque',num_cheque_caution='$Update_num_caution',num_cb_caution='$Update_num_caution_CB',date_prelevement='$Update_date_Prelevement'
     WHERE id_contrat ='$updateContratId'";
    $result = mysqli_query($conn, $query);

    $update_data = new stdClass();
    $update_data->DateDebut = $Update_Contrat_Date_Debut;
    $update_data->DateFin = $Update_Contrat_Date_Fin;
    $update_data->Duree = $Update_Contrat_Duree;
    $update_data->Prix = $Update_Contrat_Prix;
    $update_data->Mode_de_paiement = $Update_Contrat_Paiement;
    $update_data->NbreKilometre = $Update_Contrat_NbreKilometre;
    $update_data->Moyen_caution = $Update_moyen_caution;
    $update_data->Caution = $Update_Contrat_Caution;
    $update_data->CautionCheque = $Update_Contrat_Caution_Cheque;
    $update_data->Num_cheque_caution = $Update_num_caution;
    $update_data->Num_cb_caution = $Update_num_caution_CB;
    json_encode($update_data);

    $update_contrat = new stdClass();
    if (($select_data->DateDebut == $update_data->DateDebut) && ($select_data->DateFin == $update_data->DateFin) && ($select_data->Duree == $update_data->Duree)
        && ($select_data->Prix == $update_data->Prix) && ($select_data->Mode_de_paiement == $update_data->Mode_de_paiement) && ($select_data->NbreKilometre == $update_data->NbreKilometre)
        && ($select_data->Moyen_caution == $update_data->Moyen_caution) && ($select_data->Caution == $update_data->Caution) && ($select_data->CautionCheque == $update_data->CautionCheque)
        && ($select_data->Num_cheque_caution == $update_data->Num_cheque_caution) && ($select_data->Num_cb_caution == $update_data->Num_cb_caution)
    ) {
        echo "<div class='text-danger'> Aucune modification faite. Merci de vérifier!</div> ";
    }
    if (($select_data->DateDebut != $update_data->DateDebut)) {
        $update_contrat->DateDebut = $Update_Contrat_Date_Debut;
    }
    if ($select_data->DateFin != $update_data->DateFin) {
        $update_contrat->DateFin = $Update_Contrat_Date_Fin;
    }
    if ($select_data->Duree != $update_data->Duree) {
        $update_contrat->Duree = $Update_Contrat_Duree;
    }
    if ($select_data->Prix != $update_data->Prix) {
        $update_contrat->Prix = $Update_Contrat_Prix;
    }
    if ($select_data->Mode_de_paiement != $update_data->Mode_de_paiement) {
        $update_contrat->Mode_de_paiement = $Update_Contrat_Paiement;
    }
    if ($select_data->NbreKilometre != $update_data->NbreKilometre) {
        $update_contrat->NbreKilometre = $Update_Contrat_NbreKilometre;
    }
    if ($select_data->Moyen_caution != $update_data->Moyen_caution) {
        $update_contrat->Moyen_caution = $Update_moyen_caution;
    }
    if ($select_data->Caution != $update_data->Caution) {
        $update_contrat->Caution = $Update_Contrat_Caution;
    }
    if ($select_data->CautionCheque != $update_data->CautionCheque) {
        $update_contrat->CautionCheque = $Update_Contrat_Caution_Cheque;
    }
    if ($select_data->Num_cheque_caution != $update_data->Num_cheque_caution) {
        $update_contrat->Num_cheque_caution = $Update_num_caution;
    }
    if ($select_data->Num_cb_caution != $update_data->Num_cb_caution) {
        $update_contrat->Num_cb_caution = $Update_num_caution_CB;
    }
    $data = json_encode($update_contrat);


    if ($result) {
        echo "<div class='text-success'>Le contrat est mis à jour avec succès </div>";
        $queryContrat = "INSERT INTO historique_contrat(id_contrat_HC,id_user_HC,action,update_contrat) 
        VALUES ('$updateContratId','$id_user','Modification','$data')";
        $resultContrat = mysqli_query($conn, $queryContrat);

        $queryupdate = "UPDATE materiel_contrat_client SET 
            ContratDateDebut='$Update_Contrat_Date_Debut',ContratDateFin='$Update_Contrat_Date_Fin'
            WHERE id_contrat ='$updateContratId'";
        $resultupdate = mysqli_query($conn, $queryupdate);
    } else {
        echo "<div class='text-danger'> Veuillez vérifier votre requête</div> ";
    }
}

//insert Clients Records function
function InsertUser()
{
    global $conn;
    $errors = [];
    if (!empty($errors)) {
        echo json_encode(["error" => "Requête invalide", "data" => $errors]);
        return;
    }
    $typeuser = $_POST['typeuser'];
    $nom = $_POST['nom'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = md5($_POST['passord']);
    $id_user_agence = $_POST['id_user_agence'];

    $sql_e = "SELECT * FROM user WHERE (login='$login')";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... login déjà utilisé !</div>';
    } else {
        if ($typeuser == "admin") {
            $query = "INSERT INTO 
            user(nom_user,login,password,role,email_user,id_agence) 
            VALUES ('$nom','$login','$password','$typeuser','$email','$id_user_agence')";
        } else {
            $query = "INSERT INTO 
            user(nom_user,login,password,role,email_user,id_agence) 
            VALUES ('$nom','$login','$password','$typeuser','$email','0')";
        }
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'>L'utilisateur est ajouté avec succès</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors de l'ajout d'utilisateur</div>";
        }
    }
}
//End insert Clients Records function
// dispaly client data function
function display_user_record()
{
    global $conn;
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Nom</th>
            <th class="border-top-0">Login</th>
            <th class="border-top-0">Email</th>
            <th class="border-top-0">Rôle</th>
            <th class="border-top-0">Lieu Agence</th>
            <th class="border-top-0">Etat</th>
            <th class="border-top-0">Actions</th>
            
        </tr>';
    $query = " SELECT * FROM user ,agence 
        WHERE (user.id_agence = agence.id_agence)
        AND  etat_user != 'S'
        ORDER BY user.role DESC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['etat_user'] == 'T') {
            $etat = "active";
        } else {
            $etat = "désactiver";
        }
        $roles ='';
        
        if ($row['role'] == 'responsable')
        {
            $roles = "admin";
        }
        else if ($row['role']=='admin')
        {
            $roles ="agent";
        }
        else {
            $roles = $row['role'];
        }
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_user'] . '</td>
                <td class="border-top-0">' . $row['nom_user'] . '</td>
                <td class="border-top-0">' . $row['login'] . '</td>
                <td class="border-top-0">' . $row['email_user'] . '</td>
                <td class="border-top-0">' . $roles . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $etat . '</td>
                <td class="border-top-0">
                <button type="button" title="Modifier l\'utilisateur" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-user" data-id=' . $row['id_user'] . '><i class="fas fa-edit"></i></button> ';
        if ($row['role'] != 'superadmin') {
            $value .= '   <button type="button" title="Supprimer l\'utilisateur" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-user" data-id1=' . $row['id_user'] . '><i class="fas fa-trash-alt"></i></button>';
        }
        $value .= ' </td>
                            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// dispaly stock data function
function display_stock_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">ID</th>
            <th class="border-top-0">pimm</th>
            <th class="border-top-0">type</th>
            <th class="border-top-0">date</th>
            <th class="border-top-0">état de voiture</th>
        </tr>';
    if ($id_agence != "0") {
        $query = " SELECT * FROM `voiture`
            WHERE id_agence = '$id_agence'
            ORDER BY `etat_voiture` ASC";
    } else {
        $query = " SELECT * FROM `voiture`
            ORDER BY `etat_voiture` ASC";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        if ($row['etat_voiture'] == "Loue") {
            $color = "#e7959578";
        } elseif ($row['etat_voiture'] == "Entretien") {
            $color = "#afd2ed";
        } elseif ($row['etat_voiture'] == "Vendue") {
            $color = "#dd70704d";
        } elseif ($row['etat_voiture'] == "HS") {
            $color = "#dda8704d";
        } elseif ($row['etat_voiture'] == "Disponible") {
            $color = "#dda8000";
        }
        $value .= '
            <tr style="background:' . $color . ';border: 1px solid;">
                <td class="border-top-0  ">' . $row['id_voiture'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['date_achat'] . '</td>
                <td class="border-top-0">' . $row['etat_voiture'] . '</td>
                <td class="border-top-0">
                </td>
            </tr>';
        $color = "";
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// dispaly stock data function
function display_stock_materiel_record()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">ID</th>
            <th class="border-top-0">Pimm</th>
            <th class="border-top-0">Type</th>
            <th class="border-top-0">Date</th>
            <th class="border-top-0">État voiture</th> 
        </tr>';
    if ($id_agence != "0") {
        $query = " SELECT * FROM `voiture`
            WHERE id_agence = '$id_agence'
            ORDER BY `etat_voiture` ASC";
    } else {
        $query = " SELECT * FROM `voiture`
            ORDER BY `etat_voiture` ASC";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $id_voiture =  $row['id_voiture'];
        if ($row['etat_voiture'] == "Loue") {
            $color = "#ffdcdc";
        } elseif ($row['etat_voiture'] == "Entretien") {
            $color = "#fff3e2";
        } elseif ($row['etat_voiture'] == "Vendue") {
            $color = "#dd70704d";
        } elseif ($row['etat_voiture'] == "HS") {
            $color = "#dda8704d";
        } elseif ($row['etat_voiture'] == "Disponible") {
            $color = "#d5eef9";
        }
        $value .= '
            <tr style="background:' . $color . ';">
                <td class="border-top-0  ">' . $row['id_voiture'] . '</td>
                <td class="border-top-0">' . $row['pimm'] . '</td>
                <td class="border-top-0">' . $row['type'] . '</td>
                <td class="border-top-0">' . $row['date_achat'] . '</td>
                <td class="border-top-0">' . $row['etat_voiture'] . '</td>
                <td class="border-top-0">
                </td>
            </tr>';
        $color = "";
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

//get particular client record
function get_user_record()
{
    global $conn;
    $UserId = $_POST['ClientID'];
    $query = " SELECT * FROM user WHERE id_user='$UserId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $user_data = [];
        $user_data[0] = $row['id_user'];
        $user_data[1] = $row['nom_user'];
        $user_data[2] = $row['login'];
        // $user_data[3] = $row['password'];
        $user_data[4] = $row['etat_user'];
        $user_data[5] = $row['email_user'];
    }
    echo json_encode($user_data);
}

// update Client
function update_user_value()
{
    global $conn;
    if (!array_key_exists("_id", $_POST)) {
        echo json_encode(["error" => "ID utilisateur manquant ", "data" => "ID utilisateur manquant"]);
        return;
    }
    $user_id = $_POST["_id"];
    $user_query = "SELECT * FROM  user where id_user = $user_id";
    $user_result = mysqli_query($conn, $user_query);
    $user = mysqli_fetch_assoc($user_result);
    if (!$user) {
        echo json_encode(["error" => "Client introuvable ", "data" => "user $user_id not found."]);
        return;
    }
    $mdp = $user['password'];
    if ($_POST["password"] == "*****"){
        $user_updated_password = $mdp;
    }else{
        $user_updated_password = md5($_POST["password"]);
    }
    $user_updated_nom = $_POST["nom"];
    $user_updated_email = $_POST["email"];
    $user_updated_login = $_POST["login"];
    $updateuseretat = $_POST["updateuseretat"];
    $update_query = "UPDATE user SET 
    nom_user='$user_updated_nom',
    login='$user_updated_login',
    etat_user='$updateuseretat',
    email_user='$user_updated_email',
    password='$user_updated_password'
    WHERE id_user = $user_id";
    $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour du utilisateur!</div>";
        return;
    }
    echo "<div class='text-success'>User a été mis à jour avec succès!</div>";
    return;
}

function delete_user_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_UserID'];
    $query = "Update   user SET etat_user='S' WHERE id_user='$Del_ID'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "L'utilisateur est supprimé avec succès";
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

//insert agence  function
function InsertAgence()
{
    global $conn;
    $errors = [];
    if (!empty($errors)) {
        echo json_encode(["error" => "Requête invalide", "data" => $errors]);
        return;
    }
    $agenceLien = mysqli_real_escape_string($conn, $_POST['agenceLien']);
    $agenceDate = mysqli_real_escape_string($conn, $_POST['agenceDate']);
    $agenceEmail = mysqli_real_escape_string($conn, $_POST['agenceEmail']);
    $agenceTele = mysqli_real_escape_string($conn, $_POST['agenceTele']);
    $JourListe = $_POST['JourListe'];
    $DateDebutListe = $_POST['DateDebutListe'];
    $DateFinListe = $_POST['DateFinListe'];
    $JourListe = explode(',', $JourListe);
    $DateDebutListe = explode(',', $DateDebutListe);
    $DateFinListe = explode(',', $DateFinListe);
    $count = count($JourListe);
    $sql_e = "SELECT * FROM agence WHERE lieu_agence='$agenceLien'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... agence est déjà pris!</div>';
    } else {
        $query = "INSERT INTO 
            agence(lieu_agence,date_agence,email_agence,tel_agence) 
            VALUES ('$agenceLien', '$agenceDate', '$agenceEmail', '$agenceTele')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $query_get_max_id_agence = "SELECT max(id_agence) FROM agence  ";
            $result_get_max_id_agence = mysqli_query($conn, $query_get_max_id_agence);
            $row = mysqli_fetch_row($result_get_max_id_agence);
            $id_agence = $row[0];
            for ($i = 0; $i < $count; $i++) {
                if ($JourListe[$i] != "" && $DateDebutListe[$i] != "" && $DateFinListe[$i] != "") {
                    $query_insert_heur_list = "INSERT INTO ouverture_agences(id_agence_oa,jours,horaire_debut,horaire_fin)
                         VALUES ('$id_agence','$JourListe[$i]','$DateDebutListe[$i]','$DateFinListe[$i]') ";
                    $result_query_insert_heur_list = mysqli_query($conn, $query_insert_heur_list);
                }
            }
            echo "<div class='text-success'>L'agence est ajouté avec succès</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors de l'ajout d'agence </div>";
        }
    }
}
//End insert Clients Records function

//insert agence  function
function InsertAgenceHeur()
{
    global $conn;
    $errors = [];
    if (!empty($errors)) {
        echo json_encode(["error" => "Requête invalide", "data" => $errors]);
        return;
    }
    $IdAgence = $_POST['IdAgence'];
    $jourH = $_POST['jourH'];
    $heurdebutH = $_POST['heurdebutH'];
    $heurfinH = $_POST['heurfinH']; {
        $query = "INSERT INTO 
            ouverture_agences(id_agence_oa,jours,horaire_debut,horaire_fin) 
            VALUES ('$IdAgence', '$jourH', '$heurdebutH', '$heurfinH')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'>L'agence est ajouté avec succès</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors de l'ajout d'agence </div>";
        }
    }
}
//End insert Clients Records 

// dispaly client data function
function display_agence_record()
{
    global $conn;
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Lieu agence</th>
            <th class="border-top-0">Date création agence</th>
            <th class="border-top-0">E-mail agence</th>
            <th class="border-top-0">Tél agence</th>
            <th class="border-top-0">Horaire</th>
            <th class="border-top-0">Actions</th> 
        </tr>';
    $query = " SELECT * FROM  agence
    WHERE  etat_agence !='S' 
    AND id_agence != 0 ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_agence'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['date_agence'] . '</td>
                <td class="border-top-0">' . $row['email_agence'] . '</td>
                <td class="border-top-0">' . $row['tel_agence'] . '</td>
                <td class="border-top-0">  
               <br> ';
        $id_agence = $row['id_agence'];
        $queryagence = " SELECT * FROM  ouverture_agences
        WHERE  id_agence_oa = $id_agence 
         ORDER BY jours ASC ";
        $resultagence = mysqli_query($conn, $queryagence);
        while ($row1 = mysqli_fetch_assoc($resultagence)) {
            $value .= '<button  type="button" title="Supprimer l\'horaire" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-agence-heur" data-id4=' . $row1['id_oa'] . '>X</button>' . '    ' .
                        $row1['jours'] . ' : ' . $row1['horaire_debut'] . ' / ' . $row1['horaire_fin'] .
                        '<br>';
        }
        $value .= '  </td>  <td class="border-top-0">
                  <button   type="button" title="Modifier l\'agence" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-agence" data-id=' . $row['id_agence'] . '>
                  <i class="fas fa-edit"></i></button> <button type="button" title="Supprimer l\'agence" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-agence" data-id1=' . $row['id_agence'] . '>
                  <i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }
    $value .= '</table>';
    //header('Content-type:application/json;charset=utf-8');
    echo json_encode(['status' => 'success', 'html' => $value]);
}

//get particular client record
function get_agence_record()
{
    global $conn;
    $AgenceId = $_POST['ClientID'];
    $query = " SELECT * FROM agence WHERE id_agence='$AgenceId'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $user_data = [];
        $user_data[0] = $row['id_agence'];
        $user_data[1] = $row['lieu_agence'];
        $user_data[2] = $row['date_agence'];
        $user_data[3] = $row['email_agence'];
        $user_data[4] = $row['tel_agence'];
        $user_data[5] = $row['etat_agence'];
    }
    echo json_encode($user_data);
}

// update Client
function update_agence_value()
{
    global $conn;
    if (!array_key_exists("up_idagence", $_POST)) {
        echo json_encode(["error" => "ID utilisateur manquant ", "data" => "ID utilisateur manquant"]);
        return;
    }
    $agence_id = $_POST["up_idagence"];
    $user_query = "SELECT * FROM  agence where id_agence = $agence_id";
    $user_result = mysqli_query($conn, $user_query);
    $user = mysqli_fetch_assoc($user_result);
    if (!$user) {
        echo json_encode(["error" => "Agence introuvable ", "data" => "user $agence_id not found."]);
        return;
    }
    $up_agenceLien = $_POST["up_agenceLien"];
    $up_agenceDate = $_POST["up_agenceDate"];
    $up_agenceEmail = $_POST["up_agenceEmail"];
    $up_agenceTele = $_POST["up_agenceTele"];
    $update_query = "UPDATE agence SET 
    lieu_agence='$up_agenceLien',
    date_agence='$up_agenceDate',
    email_agence='$up_agenceEmail',
    tel_agence='$up_agenceTele'
    WHERE id_agence = $agence_id";
    $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour d'agence !</div>";
        return;
    }
    echo "<div class='text-success'>Agence a été mis à jour avec succès!</div>";
    return;
}

function delete_agence_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_AgenceID'];
    $query = "Update agence SET etat_agence='S' WHERE id_agence='$Del_ID'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "L'agence est supprimé avec succès";
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

function delete_agence_heur_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_AgenceID'];
    $query = "DELETE from ouverture_agences where id_oa='$Del_ID' ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Horaire agence est supprimé avec succès";
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

/**************************
              end 
 ***************************/

function InsertGroupPack()
{
    global $conn;

    $PackListe = isset($_POST['PackListe']) ? $_POST['PackListe'] : [];
    $PackListe = explode(',', $PackListe);
    $QuantiteListe = isset($_POST['QuantiteListe']) ? $_POST['QuantiteListe'] : [];
    $QuantiteListe = explode(',', $QuantiteListe);
    $VoitureType = $_POST['VoitureType'];
    $DesignationPack = isset($_POST['DesignationPack']) ? $_POST['DesignationPack'] : NULL;
    $id_user = $_SESSION['id_user'];
    $count = count($PackListe);

    if ($count >= 1) {
        $query = "INSERT INTO 
        group_packs(designation_pack,type_voiture,id_user) 
        VALUES ('$DesignationPack','$VoitureType','$id_user')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $query_get_max_id_contrat = "SELECT max(id_group_packs) FROM group_packs where id_user='$id_user' ";
            $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
            $row = mysqli_fetch_row($result_query_get_max_id_contra);
            $id_group_packs = $row[0];
            for ($i = 0; $i < $count; $i++) {
                if ($QuantiteListe[$i] < 1 || $QuantiteListe[$i] == "")
                    $qti = 1;
                else {
                    $qti =  $QuantiteListe[$i];
                }
                $query_insert_materiel_list = "INSERT INTO materiel_group_packs(id_group_packs,id_materiels,quantite) VALUES ('$id_group_packs','$PackListe[$i]','$qti') ";
                $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
            }
            echo ("<div class='text-success'>Le pack est ajouté avec succès</div>");
        } else {
            echo ("<div class='text-danger'>Erreur lors d'ajout de pack!</div>");
        }
    } else {
        echo ("<div class='text-danger'>Liste de matériel manquant!</div>");
    }
}

function InsertMaterielPack()
{
    global $conn;
    $id_group_packs = $_POST["id_pack"];
    $PackListe = isset($_POST['PackListe1']) ? $_POST['PackListe1'] : [];
    $PackListe = explode(',', $PackListe);
    $QuantiteListe = isset($_POST['QuantiteListe1']) ? $_POST['QuantiteListe1'] : [];
    $QuantiteListe = explode(',', $QuantiteListe);
    $id_user = $_SESSION['id_user'];
    $count = count($PackListe);
    if ($count >= 1) {
        for ($i = 0; $i < $count; $i++) {
            if ($QuantiteListe[$i] < 1 || $QuantiteListe[$i] == "")
                $qti = 1;
            else {
                $qti =  $QuantiteListe[$i];
            }
            $query_insert_materiel_list = "INSERT INTO materiel_group_packs(id_group_packs,id_materiels,quantite) VALUES ('$id_group_packs','$PackListe[$i]','$qti') ";
            $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
        }
        echo ("<div class='text-success'>Liste de matériel est ajoutée avec succès</div>");
    } else {
        echo ("<div class='text-danger'>Liste de matériel manquant!</div>");
    }
}

function display_grouppack_record()
{
    global $conn;
    if ($_SESSION['Role'] != "superadmin") {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Voiture</th>
            <th class="border-top-0">Matériels</th>
            <th class="border-top-0">Etat Pack</th>
            <th class="border-top-0">Actions</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Voiture</th>
            <th class="border-top-0">Matériels</th>
            <th class="border-top-0">Etat Pack</th>     
        </tr>';
    }
    $query = "SELECT * FROM group_packs where etat_group_pack !='S' ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $comp = $row['id_group_packs'];
        if ($row['etat_group_pack'] == "T") {
            $etat = "Activer ";
            $colour = "";
        } elseif ($row['etat_group_pack'] == "F") {
            $etat = "Hors Service";
            $colour = "style= 'background:#ececec' ";
        }
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_group_packs'] . '</td>
                <td class="border-top-0">' . $row['designation_pack'] . '</td>
                <td class="border-top-0">' . $row['type_voiture'] . '</td>';
        $value .= '<td class="border-top-0" >';
        $querycomp = "SELECT * FROM materiel_group_packs,materiels WHERE materiels.id_materiels = materiel_group_packs.id_materiels 
                AND materiel_group_packs.id_group_packs = '$comp'";
        $resultcom = mysqli_query($conn, $querycomp);
        while ($row_materiels = mysqli_fetch_assoc($resultcom)) {
            if ($_SESSION['Role'] != "superadmin") {
            $value .= ' 
            <button  type="button" title="Supprimer le matériel" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-materiel" data-id=' . $row_materiels['id_materiel_group_packs'] . '>X</button>';
            }
            $value .= '<span class=" text-primary">(' . $row_materiels['quantite'] . ')' . $row_materiels['designation'] . ' </span>
            </br>  ';
        }
        $value .=   '</td>
        <td class="border-top-0">' . $etat . '</td>';
        if ($_SESSION['Role'] != "superadmin") {
            $value .= ' <td class="border-top-0">
                <button type="button" title="Modifier le pack" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-pack" data-id=' . $row['id_group_packs'] . '><i class="fas fa-edit"></i></button> 
                <button  type="button" title="Ajouter un matériel" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-add-materiel" data-id=' . $row['id_group_packs'] . '><i class="fas fa-plus"></i></button>
                <button type="button" title="Supprimer le pack" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-pack" data-id1=' . $row['id_group_packs'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
        }
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function delete_pack_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_PackID'];
    $query = "Update   group_packs SET etat_group_pack='S' WHERE id_group_packs='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Le pack est supprimé avec succès';
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

function delete_materiel_pack_record()
{
    global $conn;
    $Del_ID = $_POST['Delete_MATERIELID'];
    $query = "DELETE from materiel_group_packs where id_materiel_group_packs='$Del_ID' ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Le matériel est supprimé avec succès";
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

function get_pack_record()
{
    global $conn;
    $PackID = $_POST['PackID'];
    $query = " SELECT * FROM group_packs WHERE id_group_packs='$PackID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {

        $pack_data = [];
        $pack_data[0] = $row['id_group_packs'];
        $pack_data[1] = $row['designation_pack'];
        $pack_data[2] = $row['type_voiture'];
        $pack_data[3] = $row['etat_group_pack'];
    }
    echo json_encode($pack_data);
}

function update_group_pack_value()
{
    $id_user = $_SESSION['id_user'];
    $pack_id = $_POST["pack_id"];
    global $conn;
    if (!array_key_exists("pack_id", $_POST)) {
        echo json_encode(["error" => "ID Pack manquant ", "data" => "ID pack manquant"]);
        return;
    }
    $pack_query = "SELECT * FROM group_packs WHERE id_group_packs=$pack_id";
    $pack_result = mysqli_query($conn, $pack_query);
    $pack = mysqli_fetch_assoc($pack_result);
    if (!$pack) {
        echo json_encode(["error" => "pack introuvable ", "data" => "pack $pack_id not found."]);
        return;
    }
    $up_DesignationPack = $_POST["up_DesignationPack"];
    $up_TypeVoiturePack = $_POST["up_TypeVoiturePack"];
    $up_EtatPack = $_POST["up_EtatPack"];
    $update_query = "UPDATE group_packs SET 
    designation_pack='$up_DesignationPack',
    type_voiture='$up_TypeVoiturePack',
    etat_group_pack='$up_EtatPack',
    id_user='$id_user'
    WHERE id_group_packs = $pack_id";
    $update_result = mysqli_query($conn, $update_query);
    if (!$update_result) {
        echo "<div class='text-danger'>Erreur lors de la mise à jour du pack!</div>";
    }
    echo "<div class='text-success'>Le pack a été mis à jour avec succès!</div>";
}

function InsertContratPack()
{
    global $conn;
    $id_user = $_SESSION['id_user'];
    $ContratmaterielListe = isset($_POST['ContratmaterielListe']) ? $_POST['ContratmaterielListe'] : [];
    $ContratmaterielListe = explode(',', $ContratmaterielListe);
    $ContratquantiteListe = isset($_POST['ContratquantiteListe']) ? $_POST['ContratquantiteListe'] : [];
    $ContratquantiteListe = explode(',', $ContratquantiteListe);
    $ContratDate = isset($_POST['ContratDate']) ? $_POST['ContratDate'] : "";
    $VehiculePack = isset($_POST['VehiculePack']) ? $_POST['VehiculePack'] : "";
    $id_pack = isset($_POST['id_pack']) ? $_POST['id_pack'] : "";
    $ContratType = isset($_POST['ContratType']) ? $_POST['ContratType'] : "";
    $ContratDuree = isset($_POST['ContratDuree']) ? $_POST['ContratDuree'] : "";
    $ContratDateDebut = isset($_POST['ContratDateDebut']) ? $_POST['ContratDateDebut'] : "";
    $ContratDateFin = isset($_POST['ContratDateFin']) ? $_POST['ContratDateFin'] :  "";
    $AgenceRetClient = isset($_POST['AgenceRetClient']) ? $_POST['AgenceRetClient'] :  "";
    $ContratPrixContrat = isset($_POST['ContratPrixContrat']) ? $_POST['ContratPrixContrat'] :  "";
    $ContratAssurence = "K2";
    $ContratPaiement = isset($_POST['ContratPaiement']) ? $_POST['ContratPaiement'] : "";
    $ContratDatePaiement = isset($_POST['ContratDatePaiement']) ? $_POST['ContratDatePaiement'] :  "";
    $ContratCaution = isset($_POST['ContratCaution']) ? $_POST['ContratCaution'] :  "";
    $ContratCautionCheque = isset($_POST['ContratCautionCheque']) ? $_POST['ContratCautionCheque'] :  "";
    $NbreKilometreContrat = isset($_POST['NbreKilometreContrat']) ? $_POST['NbreKilometreContrat'] :  "0";
    $ContratmoyenCaution = isset($_POST['ContratmoyenCaution']) ? $_POST['ContratmoyenCaution'] :  "";
    $ContratnumCaution = isset($_POST['ContratNumCaution']) ? $_POST['ContratNumCaution'] :  "";
    $ContratNumCautionCB = isset($_POST['ContratNumCautionCB']) ? $_POST['ContratNumCautionCB'] :  "";
    $ContratVoiturekMPrevu = "0";
    $contratpackagence = isset($_POST['contratpackagence']) ? $_POST['contratpackagence'] :  "";
    $checkobgkm = $_POST['checkobgkm'];

    $ContratAvenantmaterielListe = isset($_POST['ContratAvenantmaterielListe']) ? $_POST['ContratAvenantmaterielListe'] : [];
    $ContratAvenantmaterielListe = explode(',', $ContratAvenantmaterielListe);
    $ContratAvenantquantiteListe = isset($_POST['ContratAvenantquantiteListe']) ? $_POST['ContratAvenantquantiteListe'] : [];
    $ContratAvenantquantiteListe = explode(',', $ContratAvenantquantiteListe);
    $ContratClient = isset($_POST['ContratClient']) ? $_POST['ContratClient'] :  "";
    $typecontratavenant = isset($_POST['typecontratavenant']) ? $_POST['typecontratavenant'] :  "";
    $ContratAvenant = isset($_POST['ContratAvenant']) ? $_POST['ContratAvenant'] :  "";
    $ContratAvenantDateDebut = isset($_POST['ContratAvenantDateDebut']) ? $_POST['ContratAvenantDateDebut'] :  "";
    $ContratAvenantDateFin = isset($_POST['ContratAvenantDateFin']) ? $_POST['ContratAvenantDateFin'] :  "";
    $count = count($ContratmaterielListe);
    $countavenant = count($ContratAvenantmaterielListe);

    if ($contratpackagence == "") {
        $id_agence = $_SESSION['id_agence'];;
    } else {
        $id_agence = $contratpackagence;
    }
    $AgenceDepClient = $id_agence;
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode($errors);
        return;
    }

    if($typecontratavenant == "CONTRAT AVENANT"){
        $querydatecontrat = "SELECT date_debut,date_fin FROM contrat_client WHERE id_contrat='$ContratAvenant'";
        $resultdatecontrat = mysqli_query($conn, $querydatecontrat);
        $rowdatecontrat = mysqli_fetch_assoc($resultdatecontrat);
        $datedebutcontrat = $rowdatecontrat['date_debut'];
        $datefincontrat = $rowdatecontrat['date_fin'];
        if(($datedebutcontrat <= $ContratAvenantDateDebut) && ($datefincontrat >= $ContratAvenantDateFin)){
            $query = "INSERT INTO 
                    contrat_client_avenant(debut_contrat_avenant,fin_contrat_avenant,id_voiture_avenant,id_materiel_avenant,id_pack_avenant,id_contrat_client) 
                    VALUES ('$ContratAvenantDateDebut','$ContratAvenantDateFin','$VehiculePack','0','$id_pack','$ContratAvenant')";
            $result = mysqli_query($conn, $query);
            if($result){
                $query_get_max_id_contrat = "SELECT max(id_contrat_avenant) FROM contrat_client_avenant";
                $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
                $row = mysqli_fetch_row($result_query_get_max_id_contra);
                $id_contrat = $row[0];
                for ($i = 0; $i < $countavenant; $i++) {
                    $Id_materiel = $ContratAvenantmaterielListe[$i];
                    $quantite = $ContratAvenantquantiteListe[$i];
                    $query_materiels = "SELECT code_materiel,designation,num_serie_materiels,id_materiels_agence 
                        FROM materiels,materiels_agence
                        where materiels.id_materiels = materiels_agence.id_materiels 
                        AND id_materiels_agence = '$Id_materiel'";
                    $exection_materiel = mysqli_query($conn, $query_materiels);
                    $resultat = mysqli_fetch_array($exection_materiel);
                    $querymateriel = "INSERT INTO materiel_contrat_client
                        (id_contrat_avenant,id_materiels_agence,num_serie_contrat,code_materiel_contrat,designation_contrat,quantite_contrat,ContratDateDebut,ContratDateFin) 
                        VALUES ('$id_contrat','$resultat[id_materiels_agence]','$resultat[num_serie_materiels]','$resultat[code_materiel]','$resultat[designation]','$quantite', '$ContratAvenantDateDebut', '$ContratAvenantDateFin')";
                    $resultmateriel = mysqli_query($conn, $querymateriel);
                    $query_materiels_comp ="SELECT * 
                        FROM composant_materiels 
                        where id_materiels_agence ='$resultat[id_materiels_agence]'";
                    $exection_materiel_comp = mysqli_query($conn, $query_materiels_comp);
                    while ($resultat_comp = mysqli_fetch_array($exection_materiel_comp)) {
                        $querycomposant = "INSERT INTO 
                            composant_materiels_contrat(id_contrat_avenant,id_materiels_agence,designation_composant,num_serie_composant) 
                            VALUES ('$id_contrat','$Id_materiel','$resultat_comp[designation_composant]','$resultat_comp[num_serie_composant]')";
                        $resultcomposant = mysqli_query($conn, $querycomposant);
                    }
                }
            }
            echo "<div class='text-success'>Le contrat avenant est ajouté avec succés</div>";
        }else{
            echo "<div class='text-danger'>SVP! Vérifiez les dates</div>";
        }  
    }else{
        if ($id_agence != "0") {
            if ($AgenceRetClient == 'null') {
                $AgenceRetClient = $AgenceDepClient;
            }

            if($typecontratavenant == "CONTRAT CADRE"){
                $query = "INSERT INTO 
                contrat_client(id_client,id_agencedep,id_agenceret,id_voiture,id_materiels_contrat,id_group_pack,date_contrat,type_location,duree,date_debut,date_fin,prix,
                assurance,mode_de_paiement,caution,cautioncheque,NbrekmInclus,moyen_caution,num_cheque_caution,num_cb_caution,KMPrevu,date_prelevement,contratcadre,checkkm,id_user,id_agence) 
                VALUES ('$ContratClient','$AgenceDepClient','$AgenceRetClient','$VehiculePack','0','$id_pack','$ContratDate','$ContratType','$ContratDuree','$ContratDateDebut',
                '$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement','$ContratCaution','$ContratCautionCheque','$NbreKilometreContrat',
                '$ContratmoyenCaution','$ContratnumCaution','$ContratNumCautionCB','$ContratVoiturekMPrevu','$ContratDatePaiement','1','$checkobgkm','$id_user','$id_agence')";
            }else{
                $query = "INSERT INTO 
                contrat_client(id_client,id_agencedep,id_agenceret,id_voiture,id_materiels_contrat,id_group_pack,date_contrat,type_location,duree,date_debut,date_fin,prix,
                assurance,mode_de_paiement,caution,cautioncheque,NbrekmInclus,moyen_caution,num_cheque_caution,num_cb_caution,KMPrevu,date_prelevement,contratcadre,checkkm,id_user,id_agence) 
                VALUES ('$ContratClient','$AgenceDepClient','$AgenceRetClient','$VehiculePack','0','$id_pack','$ContratDate','$ContratType','$ContratDuree','$ContratDateDebut',
                '$ContratDateFin','$ContratPrixContrat','$ContratAssurence','$ContratPaiement','$ContratCaution','$ContratCautionCheque','$NbreKilometreContrat',
                '$ContratmoyenCaution','$ContratnumCaution','$ContratNumCautionCB','$ContratVoiturekMPrevu','$ContratDatePaiement','0','$checkobgkm','$id_user','$id_agence')";
            }
            $result = mysqli_query($conn, $query);
            if ($result) {
                $queryContratID = "SELECT id_contrat,date_ajoute FROM contrat_client WHERE id_contrat=(SELECT max(id_contrat) from contrat_client)";
                $resultContratID = mysqli_query($conn, $queryContratID);
                while ($row = mysqli_fetch_assoc($resultContratID)) {
                    $rowid = $row['id_contrat'];
                    $rowdate = $row['date_ajoute'];
                }
                $queryContrat = "INSERT INTO  
                     historique_contrat(id_contrat_HC,id_user_HC,action,date_action) 
                     VALUES ('$rowid','$id_user','Ajout','$rowdate')";
                $resultContrat = mysqli_query($conn, $queryContrat);

                $querymailuser = "SELECT email_user FROM user WHERE role='superadmin'";
                $resultmailuser = mysqli_query($conn, $querymailuser);
                while ($rowmailuser = mysqli_fetch_assoc($resultmailuser)) {
                    $mailuser = $rowmailuser['email_user'];
                }
                $querynomuser = "SELECT nom_user FROM user WHERE id_user='$id_user'";
                $resultnomuser = mysqli_query($conn, $querynomuser);
                while ($rownomuser = mysqli_fetch_assoc($resultnomuser)) {
                    $nomuser = $rownomuser['nom_user'];
                }
                $querynomclient = "SELECT nom_entreprise FROM client WHERE id_client='$ContratClient'";
                $resultnomclient = mysqli_query($conn, $querynomclient);
                while ($rownomclient = mysqli_fetch_assoc($resultnomclient)) {
                    $nomclient = $rownomclient['nom_entreprise'];
                }

                /////////////////////////Mail AWS/////////////////////////////////
                // require '/var/www/html/Gestion_location/inc/MailAWS/vendor/autoload.php';
				// $sender = 'maaloulmedhedi@gmail.com';
                // $senderName = 'K2Location Sender Mail';
                // $recipient = "$mailuser";
                // $usernameSmtp = 'AKIAY2ABOIWIICCHUB4R';
                // $passwordSmtp = 'BD8karZvvhSsE/LQU0BnRXa8KMTKKXr39StWLrNdSAqi';
                // $host = 'email-smtp.eu-west-3.amazonaws.com';
                // $port = 465;
                // $subject = 'Ajoutcontratpack';
                // $bodyText =  "";
                // $bodyHtml = "<html><body> Bonjour, <br /> <br />Le contrat numéro $rowid relatif au client $nomclient a été crée le $rowdate avec le montant $ContratPrixContrat.
                // Ce contrat a été crée par $nomuser .</body></html>";
                // $mail = new PHPMailer(true);
                // try {
                //     $mail->isSMTP(true);
                //     $mail->setFrom($sender, $senderName);
                //     $mail->Username   = $usernameSmtp;
                //     $mail->Password   = $passwordSmtp;
                //     $mail->Host       = $host;
                //     $mail->Port       = $port;
                //     $mail->SMTPAuth   = true;
                //     $mail->SMTPSecure = 'ssl';
                //     $mail->CharSet = 'utf-8';
                //     $mail->addAddress($recipient);
                //     $mail->isHTML(true);
                //     $mail->Subject    = $subject;
                //     $mail->Body       = $bodyHtml;
                //     $mail->AltBody    = $bodyText;
                //     $mail->Send();
                //     echo "Email sent!" , PHP_EOL;
                // } catch (Exception $e) {
                //     echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL;
                // }
                $to = "$mailuser";
                $subject = "Ajoutcontratpack";
                $message = "Le contrat numéro ".$rowid." relatif au client ".$nomclient." a été crée le ".$rowdate." avec le montant ".$ContratPrixContrat.". Ce contrat a été crée par ".$nomuser.".";
                $header = "From:appk2contrat@gmail.com \r\n";
                $header .= "Cc:appk2contrat@gmail.com \r\n";
                $header .= "MIME-Version: 1.0\r\n";
                $header .= 'Content-Type: text/plain; charset="utf-8"' . " ";
                mail($to, $subject, $message, $header);
                /////////////////////////Mail AWS/////////////////////////////////
                
                $date_now = date("Y-m-d H:i:s");
                $liste_user1 = "SELECT * FROM user";
                $liste_user1_query = mysqli_query($conn, $liste_user1);
                while ($row20 = mysqli_fetch_assoc($liste_user1_query)) {
                    $query_pack = "INSERT INTO 
                    notification(id_user,id_contrat,status,date_creation) 
                    VALUES ('" . $row20["id_user"] . "','" . $rowid . "', 0, '" . $date_now . "')";
                    $query_pack_s = mysqli_query($conn, $query_pack);
                }
                $query_updateC = "UPDATE client SET etat_client='A' WHERE id_client='$ContratClient'";
                $result_update = mysqli_query($conn, $query_updateC);
                $querystockVehicule = "UPDATE voiture SET id_agence='$AgenceRetClient' WHERE id_voiture='$VehiculePack'";
                $resultstockVehicule = mysqli_query($conn, $querystockVehicule);
                $query_get_max_id_contrat = "SELECT max(id_contrat)
                FROM contrat_client WHERE type_location ='Pack'";
                $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
                $row = mysqli_fetch_row($result_query_get_max_id_contra);
                $id_contrat = $row[0];
                for ($i = 0; $i < $count; $i++) {
                    $Id_materiel = $ContratmaterielListe[$i];
                    $quantite = $ContratquantiteListe[$i];
                    $query_materiels = "SELECT  code_materiel,`designation`, `num_serie_materiels`,id_materiels_agence 
                    FROM `materiels`,materiels_agence
                    where materiels.id_materiels = materiels_agence.id_materiels 
                    AND id_materiels_agence = '$Id_materiel'";
                    $exection_materiel = mysqli_query($conn, $query_materiels);
                    $resultat = mysqli_fetch_array($exection_materiel);
                    $query = "INSERT INTO 
                    materiel_contrat_client(id_contrat,id_materiels_agence,num_serie_contrat,code_materiel_contrat,designation_contrat,quantite_contrat,ContratDateDebut,ContratDateFin) 
                    VALUES ('$id_contrat','$resultat[id_materiels_agence]','$resultat[num_serie_materiels]','$resultat[code_materiel]','$resultat[designation]','$quantite', '$ContratDateDebut', '$ContratDateFin')";
                    $result = mysqli_query($conn, $query);
                    $querystockMateriel = "UPDATE materiels_agence SET id_agence='$AgenceRetClient' WHERE id_materiels_agence = '$resultat[id_materiels_agence]'";
                    $resultstockMateriel = mysqli_query($conn, $querystockMateriel);
                    $query_materiels_comp =    "SELECT  * FROM `composant_materiels` where id_materiels_agence = '$resultat[id_materiels_agence]'";
                    $exection_materiel_comp = mysqli_query($conn, $query_materiels_comp);
                    while ($resultat_comp = mysqli_fetch_array($exection_materiel_comp)) {
                        $query = "INSERT INTO 
                        composant_materiels_contrat(id_contrat,id_materiels_agence,designation_composant,num_serie_composant) 
                        VALUES ('$id_contrat','$Id_materiel','$resultat_comp[designation_composant]','$resultat_comp[num_serie_composant]')";
                        $result = mysqli_query($conn, $query);
                    }
                }
                echo "<div class='text-success'>Le contrat est ajouté avec succés</div>";
            } else {
                echo ("<div class='text-danger'>Erreur lors d'ajout de contrat Mixte</div>");
            }
        } else {
            echo "<div class='text-danger'>SVP! Choisissez l'agence</div>";
        }
    }
}


function disponibilite_materiel_num_serie($id_materiels_agence, $debut, $fin)
{
    global $conn;
    $query = "SELECT * 
        FROM contrat_client, materiel_contrat_client
        where contrat_client.id_contrat= materiel_contrat_client.id_contrat 
        and id_materiels_agence ='$id_materiels_agence' 
        and ((date_debut <='$debut' and date_fin >='$debut' )
        or (date_debut <='$fin' and date_fin >='$fin' ) 
        or (date_debut >='$debut' and date_fin <='$fin' ))";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        return "disponibile";
    } else {
        return "disponibile";
    }
}

function disponibilite_voiture($id_voiture, $debut, $fin)
{
    global $conn;
    $query = "SELECT * 
        FROM contrat_client, voiture
        where  contrat_client.id_voiture= voiture.id_voiture 
        and contrat_client.id_voiture ='$id_voiture' 
        and ((date_debut <='$debut' and date_fin >='$debut' )
        or (date_debut <='$fin' and date_fin >='$fin' ) 
        or (date_debut >='$debut' and date_fin <='$fin'))";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        return "disponibile";
    } else {
        return "Non disponibile";
    }
}

function disponibilite_quantite_materiel($id_materiels_agence, $debut, $fin, $quantite)
{
    global $conn;
    $sqlqtidispo = "SELECT quantite_materiels_dispo 
        from materiels_agence 
        where  id_materiels_agence ='$id_materiels_agence' ";
    $resultqtidispo = mysqli_query($conn, $sqlqtidispo);
    $row = mysqli_fetch_assoc($resultqtidispo);
    $quantite_materiels_dispo = $row['quantite_materiels_dispo'];
    $query = "SELECT SUM(quantite_contrat) as quantite_loue
        FROM contrat_client, materiel_contrat_client
        where  contrat_client.id_contrat= materiel_contrat_client.id_contrat 
        and id_materiels_agence ='$id_materiels_agence' 
        and ((date_debut <='$debut' and date_fin >='$debut')
        or (date_debut <='$fin' and date_fin >='$fin') 
        or (date_debut >='$debut' and date_fin <='$fin'))";
    $result = mysqli_query($conn, $query);
    $row_quantite = mysqli_fetch_assoc($result);
    $quantite_loue = $row_quantite['quantite_loue'];
    if ($quantite_loue == '')
        $quantite_loue = 0;
    $quantite_disponible = $quantite_materiels_dispo - $quantite_loue;
    if ($quantite <= $quantite_disponible) {
        return "disponibile";
    } else {
        return
            "Non disponibile";
    }
}

function InsertCategorie()
{
    global $conn;
    $errors = [];
    if (!empty($errors)) {
        echo json_encode(["error" => "Requête invalide", "data" => $errors]);
        return;
    }
    $code_materiel = $_POST['code_materiel'];
    $designation = $_POST['designation'];
    $famille_materiel = $_POST['famille_materiel'];
    $type_location = $_POST['type_location'];
    $num_serie_obg = $_POST['num_serie_obg'];
    $id_user = $_SESSION['id_user'];
    $sql_e = "SELECT * FROM materiels 
        WHERE code_materiel='$code_materiel' 
        and etat_materiels_categorie='T' ";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... catégorie est déjà pris!</div>';
    } else {
        $query = "INSERT INTO 
            materiels(code_materiel,designation,famille_materiel,type_location,num_serie_obg,id_user) 
            VALUES ('$code_materiel','$designation','$famille_materiel','$type_location','$num_serie_obg','$id_user')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'>Le catégorie est ajouté avec succés</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors de l'ajout du catégorie </div>";
        }
    }
}

function get_categorie_agence_record()
{
    global $conn;
    $CategorieID = $_POST['CategorieID'];
    $query = " SELECT * FROM  materiels
    WHERE id_materiels='$CategorieID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $Categorie_data = [];
        $Categorie_data[0] = $row['id_materiels'];
        $Categorie_data[1] = $row['code_materiel'];
        $Categorie_data[2] = $row['designation'];
        $Categorie_data[3] = $row['famille_materiel'];
        $Categorie_data[4] = $row['type_location'];
        $Categorie_data[5] = $row['num_serie_obg'];
    }
    echo json_encode($Categorie_data);
}

function update_categorie()
{
    global $conn;
    $updateCategorieId = $_POST['updateCategorieId'];
    $updateCategorieCodemateriel = $_POST['updateCategorieCodemateriel'];
    $updateCategorieDesignation = $_POST['updateCategorieDesignation'];
    $updateCategorieFamillemateriel = $_POST['updateCategorieFamillemateriel'];
    $updateCategorieTypelocation = $_POST['updateCategorieTypelocation'];
    $updateCategorieNumserie = $_POST['updateCategorieNumserie'];
    $id_user = $_SESSION['id_user'];
    $sql_e = "SELECT * FROM materiels 
        WHERE id_materiels!='$updateCategorieId' 
        AND code_materiel='$updateCategorieCodemateriel' 
        AND etat_materiels_categorie='T'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo '<div class="text-danger" role="alert">
        Désolé ... Code Materiel est déjà pris!</div>';
        return;
    } else {
        $query = "UPDATE materiels
        SET code_materiel='$updateCategorieCodemateriel',designation='$updateCategorieDesignation',famille_materiel='$updateCategorieFamillemateriel',
        type_location='$updateCategorieTypelocation',num_serie_obg='$updateCategorieNumserie',id_user='$id_user'
        where id_materiels='$updateCategorieId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='text-success'> Modification a été mis à jour </div> ";
        } else {
            echo " <div class='text-danger'>Veuillez vérifier votre requête</div> ";
        }
    }
}

function display_categorie_record()
{
    global $conn;
    if(($_SESSION['Role']) == "responsable"){
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Code de catégorie</th>
            <th class="border-top-0">Famille de catégorie</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Type de location</th>
            <th class="border-top-0">N° serie obligatoire</th>
            <th class="border-top-0">Actions</th>  
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Code de catégorie</th>
            <th class="border-top-0">Famille de catégorie</th>
            <th class="border-top-0">Désignation</th>
            <th class="border-top-0">Type de location</th>
            <th class="border-top-0">N° serie obligatoire</th> 
        </tr>';
    }
    $query = " SELECT * FROM materiels
    where etat_materiels_categorie !='S'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['num_serie_obg'] == 'T') {
            $obligatoireserie = 'OUI';
        } else {
            $obligatoireserie = 'NON';
        }
        if (($_SESSION['Role']) == "responsable") {
            $value .= '<tr>
                        <td class="border-top-0">' . $row['id_materiels'] . '</td>
                        <td class="border-top-0">' . $row['code_materiel'] . '</td>
                        <td class="border-top-0">' . $row['famille_materiel'] . '</td>
                        <td class="border-top-0">' . $row['designation'] . '</td>
                        <td class="border-top-0">' . $row['type_location'] . '</td>
                        <td class="border-top-0">' . $obligatoireserie . '</td>
                        <td class="border-top-0">
                            <button type="button" title="Modifier le catégorie" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-categorie" data-id=' . $row['id_materiels'] . '><i class="fas fa-edit"></i></button>
                            <button type="button" title="Supprimer le catégorie" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-categorie" data-id1=' . $row['id_materiels'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>';
        }else{
            $value .= '<tr>
                        <td class="border-top-0">' . $row['id_materiels'] . '</td>
                        <td class="border-top-0">' . $row['code_materiel'] . '</td>
                        <td class="border-top-0">' . $row['famille_materiel'] . '</td>
                        <td class="border-top-0">' . $row['designation'] . '</td>
                        <td class="border-top-0">' . $row['type_location'] . '</td>
                        <td class="border-top-0">' . $obligatoireserie . '</td>
                    </tr>';
        }
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function delete_categorie_record()
{
    global $conn;
    $Del_ID = $_POST['Del_ID'];
    $query = "Update materiels SET etat_materiels_categorie='S' WHERE id_materiels='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Le catégorie est supprimé avec succés';
    } else {
        echo 'SVP vérifier votre requette !';
    }
}

function InsertStock()
{
    global $conn;
    $id = $_POST['ID'];
    $signe = $_POST['signe'];
    $quitite = $_POST['value'];
    $etat = $_POST['etat'];
    $materielstockagence = isset($_POST['materielstockagence']) ? $_POST['materielstockagence'] :  "";
    $id_user = $_SESSION['id_user'];
    if ($materielstockagence == "") {
        $id_agence = $_SESSION['id_agence'];;
    } else {
        $id_agence = $materielstockagence;
    }
    if ($signe == "add") {
        $query = "update materiels_agence set id_agence = '$id_agence',id_user = '$id_user',quantite_materiels = quantite_materiels +$quitite, quantite_materiels_dispo =quantite_materiels_dispo +$quitite  , etat_materiels ='$etat'
        where id_materiels_agence =$id ";
    } else {
        $query = "update materiels_agence set id_agence = '$id_agence',id_user = '$id_user',quantite_materiels = quantite_materiels -$quitite, quantite_materiels_dispo =quantite_materiels_dispo -$quitite , etat_materiels ='$etat'
        where id_materiels_agence =$id ";
    }
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>Stock mise à jour avec succès</div>";
    } else {
        echo "<div class='text-danger'>Veuillez vérifier votre requête</div>";
    }
}

/*
 * 
 */
function DisplaySettingmateriel()
{
    global $conn;
    $value = '<table class="table">
                <tr>
                    <th class="border-top-0"> Pack </th>
                    <th class="border-top-0"> Materiel </th>
                    <th class="border-top-0"> Quantite </th>
                    <th class="border-top-0"> Action</th>
                </tr>';
    $query = "SELECT * FROM `materiels` , materiel_group_packs , group_packs 
        WHERE materiels.id_materiels=materiel_group_packs.id_materiels
        and group_packs.id_group_packs=materiel_group_packs.id_group_packs 
        ORDER BY `group_packs`.`designation_pack` ASC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= ' <tr>
                        <td> ' . $row['designation_pack'] . ' </td>
                        <td> ' . $row['code_materiel'] . ' </td>
                        <td> ' . $row['quantite'] . ' </td>
                        <td> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn_delete_materielgrp" data-id3=' . $row['id_materiel_group_packs'] . '><span class="fa fa-trash"></span></button> </td>
                    </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function delete_Settingmaterielgrp_record()
{
    global $conn;
    $Del_Id = $_POST['Del_ID'];
    $query = "DELETE from materiel_group_packs where id_materiel_group_packs='$Del_Id' ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo ' Votre enregistrement a été supprimé';
    } else {
        echo ' Veuillez vérifier votre requête ';
    }
}
/**/

function display_grp_pack_record()
{
    global $conn;
    $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">ID de groupe pack </th>
            <th class="border-top-0">ID de materiel</th>
            <th class="border-top-0">Quantité</th>
        </tr>';
    $query = "SELECT * FROM materiel_group_packs  ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_materiel_group_packs'] . '</td>
                <td class="border-top-0">' . $row['id_group_packs'] . '</td>
                <td class="border-top-0">' . $row['id_materiels'] . '</td>
                <td class="border-top-0">' . $row['quantite'] . '</td>
                <td class="border-top-0">
                  <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-edit-client" data-id=' . $row['id_materiels'] . '><i class="fas fa-edit"></i></button> <button type="button" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-client" data-id1=' . $row['id_materiels'] . '><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

/// SelectVoiteurDispoStock
function selectMaterielQtiDispo()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $debut = date('');
    $fin = date('');

    $value = '<table class="table">
    <tr>
        <th class="border-top-0">ID</th>
        <th class="border-top-0">Code de matériel</th>
        <th class="border-top-0">N° de série</th>
        <th class="border-top-0">Désignation</th>
        <th class="border-top-0">Quantité disponible</th>
        <th class="border-top-0">Localisation</th>
        <th class="border-top-0">Disponibilité</th>
        <th class="border-top-0">Transfert</th>
    </tr>';

    if ($id_agence != "0") {
        $query = "SELECT * FROM materiels_agence,materiels,agence
         where materiels_agence.id_materiels = materiels.id_materiels
         AND materiels_agence.id_agence = agence.id_agence
     and  materiels_agence.etat_materiels !='F'
    and materiels_agence.id_agence = '$id_agence'
    ORDER BY id_materiels_agence ASC";
    } else {
        $query = "SELECT * FROM materiels_agence,materiels,agence 
        where materiels_agence.id_materiels = materiels.id_materiels
         AND materiels_agence.id_agence = agence.id_agence
        and  materiels_agence.etat_materiels !='F'
        ORDER BY id_materiels_agence ASC";
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['etat_materiels'] == "HS") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ffc36d!important";
            $etat = "HORS SERVICE";
            $qti = 0;
        } elseif ($row['etat_materiels'] == "T") {
            $id_materiels_agence = $row['id_materiels_agence'];
            if ($row['num_serie_obg'] == "T") {
                $disponibilte = disponibilite_materiel_num_seriee($row['id_materiels_agence']);
                $localisation = Localisation_materiel($row['id_materiels_agence']);
                if ($disponibilte == "0") {
                    $color = "badge bg-light-success text-white fw-normal";
                    $color1 = "background-color: #2cd07e!important";
                    $etat = "DISPONIBLE";
                    $qti = 1;
                    $update_query = "UPDATE materiels_agence SET quantite_materiels_dispo=1 WHERE id_materiels_agence=$id_materiels_agence";
                    mysqli_query($conn, $update_query);
                } else {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ff5050!important";
                    $etat = "En Location";
                    $qti = 0;
                    $row['lieu_agence'] = $localisation;
                    $update_query = "UPDATE materiels_agence SET quantite_materiels_dispo=0 WHERE id_materiels_agence='$id_materiels_agence'";
                    mysqli_query($conn, $update_query);
                }
            }
            //si le matiriel ne pas de n serie
            else {
                $disponibilteqti = disponibilite_materiel_qti_num_seriee($row['id_materiels_agence'], $row['quantite_materiels']);
                $localisation = Localisation_materiel($row['id_materiels_agence']);
                if ($disponibilteqti > 0) {
                    $color = "badge bg-light-success text-white fw-normal";
                    $color1 = "background-color: #2cd07e!important";
                    $etat = "DISPONIBLE";
                    $qti = $disponibilteqti;
                    $update_query = "UPDATE materiels_agence SET quantite_materiels_dispo=$qti WHERE id_materiels_agence='$id_materiels_agence'";
                    mysqli_query($conn, $update_query);
                } else {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ff5050!important";
                    $etat = "En Location";
                    $qti = $disponibilteqti;
                    $row['lieu_agence'] = $localisation;
                    $update_query = "UPDATE materiels_agence SET quantite_materiels_dispo=$qti WHERE id_materiels_agence='$id_materiels_agence'";
                    mysqli_query($conn, $update_query);
                }
            }
            $value .= '
                <tbody>          
                    <tr>
                        <td class="border-top-0">' . $row['id_materiels_agence'] . '</td>
                        <td class="border-top-0">' . $row['code_materiel'] . '</td>
                        <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                        <td class="border-top-0">' . $row['designation'] . '</td>
                        <td class="border-top-0">' .   $qti . '</td>
                        <td class="border-top-0">' . $row['lieu_agence'] . '</td>          
                        <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                        <td class="border-top-0">';
                            if ($row['num_serie_obg'] == "T") {
                                $value .= '
                                <button title="Transférer le matériel" class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert-materiel" data-id=' . $row['id_materiels_agence'] . ' ><i class="fas fa-exchange-alt"></i></button>';
                            } else {
                                $value .= '<button title="Transférer le matériel" class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert-materiel-quantite" data-id=' . $row['id_materiels_agence'] . ' ><i class="fas fa-exchange-alt"></i></button>';
                            }
                        $value .= '</td>
                    </tr>
                </tbody>';
        }
    }
    
    $value .= '</table>';

    echo json_encode(['status' => 'success', 'html' => $value]);
}

function disponibilite_materiel_num_seriee($id_materiels_agence)
{
    global $conn;
    $date = date('Y-m-d');

    $queryp = "SELECT * FROM contrat_client,materiel_contrat_client
    where contrat_client.id_contrat =materiel_contrat_client.id_contrat
    and id_materiels_agence ='$id_materiels_agence'
    and etat_contrat ='A'
    and (ContratDateDebut <= '$date' and ContratDateFin>= '$date')";
    $resultp = mysqli_query($conn, $queryp);
    $queryavenant = "SELECT * FROM contrat_client,contrat_client_avenant,materiel_contrat_client
    where contrat_client_avenant.id_contrat_avenant =materiel_contrat_client.id_contrat_avenant
    AND contrat_client_avenant.id_contrat_client =contrat_client.id_contrat
    and materiel_contrat_client.id_materiels_agence ='$id_materiels_agence'
    and contrat_client.etat_contrat ='A'
    and (materiel_contrat_client.ContratDateDebut <= '$date' and materiel_contrat_client.ContratDateFin>= '$date')";
    $resultavenant = mysqli_query($conn, $queryavenant);
    
    if ($resultp->num_rows > 0 || $resultavenant->num_rows > 0)  {
        return "1";  
    }else{
        return "0";  
    }
}

function Localisation_materiel($id_materiels_agence)
{
    global $conn;
    $date = date('Y-m-d');
    
    $queryi = "SELECT CL.nom_entreprise,CL.nom FROM materiel_contrat_client As C,client AS CL,contrat_client AS CC
    where C.id_materiels_agence ='$id_materiels_agence'
    and C.id_contrat =CC.id_contrat
    and CC.id_client = CL.id_client
    and CC.etat_contrat ='A'
    and (C.ContratDateDebut <= '$date' and C.ContratDateFin>= '$date')";    
    $resulti = mysqli_query($conn, $queryi);

    $queryavenant = "SELECT CL.nom_entreprise,CL.nom 
    FROM contrat_client AS CC,contrat_client_avenant AS CA,materiel_contrat_client AS C,client AS CL
    where CA.id_contrat_avenant =C.id_contrat_avenant
    AND CA.id_contrat_client =CC.id_contrat
    and CC.id_client = CL.id_client
    and C.id_materiels_agence ='$id_materiels_agence'
    and CC.etat_contrat ='A'
    and (C.ContratDateDebut <= '$date' and C.ContratDateFin>= '$date')";
    $resultavenant = mysqli_query($conn, $queryavenant);

    if($resulti->num_rows > 0){
        $row = mysqli_fetch_row($resulti);
        $nomentreprise = $row[0];
        $nom = $row[1];
        if ($nomentreprise == ""){
            $nomclient=$nom;
        }else if ($nom == ""){
            $nomclient=$nomentreprise;
        }else{
            $nomclient=$nomentreprise . " / Conducteur : " . $nom;
        }
    }else if($resultavenant->num_rows > 0){
        $row1 = mysqli_fetch_row($resultavenant);
        $nomentreprise1 = $row1[0];
        $nom1 = $row1[1];
        if ($nomentreprise1 == ""){
            $nomclient=$nom1;
        }else if ($nom1 == ""){
            $nomclient=$nomentreprise1;
        }else{
            $nomclient=$nomentreprise1 . " / Conducteur : " . $nom1;
        }
    }else{
        $nomclient = "";
    }
    return $nomclient;
}

function disponibilite_materiel_qti_num_seriee($id_materiels_agence, $quantite_materiels)
{
    global $conn;
    $date = date('Y-m-d');
    $qti = $quantite_materiels;
    $queryi = "SELECT SUM(quantite_contrat) AS qutite FROM materiel_contrat_client AS MC,contrat_client AS C
    where  MC.id_contrat = C.id_contrat
    and C.etat_contrat ='A'
    and ( MC.ContratDateDebut <= '$date' and MC.ContratDateFin >= '$date')
    and MC.id_materiels_agence = $id_materiels_agence";
    $resulti = mysqli_query($conn, $queryi);

    $queryavenant = "SELECT SUM(quantite_contrat) AS qutite
    FROM contrat_client AS C,contrat_client_avenant AS CA,materiel_contrat_client AS MC
    where CA.id_contrat_avenant = MC.id_contrat_avenant
    AND CA.id_contrat_client =C.id_contrat
    and MC.id_materiels_agence ='$id_materiels_agence'
    and C.etat_contrat ='A'
    and (MC.ContratDateDebut <= '$date' and MC.ContratDateFin >= '$date')";
    $resultavenant = mysqli_query($conn, $queryavenant);

    if($resulti->num_rows > 0 && $resultavenant->num_rows == 0){
        $row = mysqli_fetch_assoc($resulti);
        $qtite = $qti - $row['qutite'];
    }else if($resultavenant->num_rows > 0 && $resulti->num_rows == 0){
        $row1 = mysqli_fetch_assoc($resultavenant);
        $qtite = $qti - $row1['qutite'];
    }else if($resultavenant->num_rows > 0 && $resulti->num_rows > 0){
        $row1 = mysqli_fetch_assoc($resultavenant);
        $row = mysqli_fetch_assoc($resulti);
        $qtite = $qti - $row1['qutite'] - $row['qutite'];
    }else{
        $qtite =  $qti;
    }
    return $qtite;
}

/// SelectVoiteurDispoStock
function selectVoiteurDispoStock()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    $value = '<table class="table">
        <tr>
              <th class="border-top-1">ID</th>
              <th class="border-top-1">Pimm</th>
              <th class="border-top-1">Type</th>
              <th class="border-top-1">Marque & Modèle</th>
              <th class="border-top-1">Boite de vitesse</th>
              <th class="border-top-1">Type de carburant</th>
              <th class="border-top-1">Date Achat</th>
              <th class="border-top-1">Localisation</th>
              <th class="border-top-1">Disponibilité</th>
              <th class="border-top-1">Transfert </th>     
        </tr>';
    if ($id_agence != "0") {
        $query = "SELECT * FROM voiture,agence,marquemodel
        WHERE voiture.id_agence = agence.id_agence 
        AND voiture.id_MarqueModel = marquemodel.id_MarqueModel
        AND voiture.id_agence = '$id_agence'
        AND voiture.actions !='S'
        ORDER BY voiture.id_voiture ASC";
    } else {
        $query = "SELECT * FROM voiture,agence,marquemodel
         WHERE voiture.id_agence = agence.id_agence
         AND voiture.id_MarqueModel = marquemodel.id_MarqueModel 
         AND  voiture.actions !='S'
         ORDER BY voiture.id_voiture ASC";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['etat_voiture'] == "Loue") {
            $color = "badge bg-light-warning text-warning fw-normal";
            $color1 = "background-color: #ffedd4!important";
            $row['etat_voiture'] = "LOUER";
        } elseif ($row['etat_voiture'] == "Entretien") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ffc36d!important";
            $row['etat_voiture'] = "ENTRETIEN";
        } elseif ($row['etat_voiture'] == "Vendue") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ff5050!important";
            $row['etat_voiture'] = "VENDU";
        } elseif ($row['etat_voiture'] == "HS") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #343a40!important";
            $row['etat_voiture'] = "HORS SERVICE";
        } elseif ($row['etat_voiture'] == "Disponible") {
            $disponibilte = disponibilite_Vehicule1($row['id_voiture']);
            $localisation = localisation_Vehicule($row['id_voiture']);
            if ($disponibilte == 'disponibile') {
                $color = "badge bg-light-success text-white fw-normal";
                $color1 = "background-color: #2cd07e!important";
                $row['etat_voiture'] = "DISPONIBLE";
            } else {
                $color = "badge bg-light-info text-white fw-normal";
                $color1 = "background-color: #ff5050!important";
                $row['etat_voiture'] = "En Location";
                $row['lieu_agence'] = $localisation;
            }
        }
        $value .= '
      <tbody>
              <tr>
                  <td class="border-top-1  ">' . $row['id_voiture'] . '</td>
                  <td class="border-top-1">' . $row['pimm'] . '</td>
                  <td class="border-top-1">' . $row['type'] . '</td>
                  <td class="border-top-1">' . $row['Marque'] . " " . $row['Model'] . '</td>
                  <td class="border-top-1">' . $row['boite_vitesse'] . '</td>
                  <td class="border-top-1">' . $row['type_carburant'] . '</td>
                  <td class="border-top-1">' . $row['date_achat'] . '</td>
                  <td class="border-top-1">' . $row['lieu_agence'] . '</td>
                  <td><span class="' . $color . '" style ="' . $color1 . '">' . $row['etat_voiture'] . '</span></td>';
        if ($row['etat_voiture'] != "VENDU") {
            $value .= '<td><button title="Transférer la voiture" class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert" data-id=' . $row['id_voiture'] . '><i class="fas fa-exchange-alt"></i></button></td>';
        }
        $value .= ' </tr>
      </tbody>';
    }
    $value .= '</table>
  </div>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
function disponibilite_Vehicule1($id_voiture)
{
    global $conn;
    $query = "SELECT * FROM contrat_client 
       where  
       id_voiture ='$id_voiture' and 
       etat_contrat = 'A' and
       ((date_debut <= DATE(NOW()) and date_fin >=DATE(NOW()) ))  ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        return "disponibile";
    } else {
        return "non disponibile";
    }
}
function localisation_Vehicule($id_voiture)
{
    global $conn;
    $query = "SELECT CL.nom_entreprise,CL.nom FROM contrat_client As C,client AS CL
       where  
       C.id_voiture ='$id_voiture' and 
       C.id_client = CL.id_client and
       C.etat_contrat = 'A' and
       ((C.date_debut <= DATE(NOW()) and C.date_fin >=DATE(NOW()) ))  ";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $nomentreprise = $row[0];
    $nom = $row[1];
    if ($nomentreprise == ""){
        $nomclient=$nom;
    }else if ($nom == ""){
        $nomclient=$nomentreprise;;
    }else{
        $nomclient=$nomentreprise . " / Conducteur : " . $nom;
    }
    
    return $nomclient;
}
function telclient_VehiculeLoue($id_voiture)
{
    global $conn;
    $query = "SELECT CL.tel FROM contrat_client As C,client AS CL
       where  
       C.id_voiture ='$id_voiture' and 
       C.id_client = CL.id_client and
       C.etat_contrat = 'A' and
       ((C.date_debut <= DATE(NOW()) and C.date_fin >=DATE(NOW()) ))  ";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $tel = $row[0];
    return $tel;
}
/// End selectVoiteurDispoStock


function selectMaterielDispoStock()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];

    $value = '<div class="table-responsive">
    <table class="table customize-table mb-0 v-middle">
    <thead class="table-light">
        <tr>
            <th class="border-top-0">ID</th>
            <th class="border-top-0">N° série de matériel </th>
            <th class="border-top-0">Quantité disponible ss</th>
            <th class="border-top-0">Disponibilité</th>   
        </tr>
    </thead>';
    if ($id_agence != "0") {
        $query = "SELECT * FROM materiels_agence,materiels where materiels_agence.id_materiels = materiels.id_materiels
     and  materiels_agence.etat_materiels !='F'
    and id_agence = '$id_agence'
    ORDER BY etat_materiels ASC ";
    } else {
        $query = "SELECT * FROM materiels_agence,materiels where materiels_agence.id_materiels = materiels.id_materiels
        and  materiels_agence.etat_materiels !='F'
        ORDER BY etat_materiels ASC ";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['etat_materiels'] == "HS") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ffc36d!important";
            $etat = "HORS SERVICE";
        } elseif ($row['etat_materiels'] == "T") {
            $disponibilte =  $row['quantite_materiels_dispo'];
            if ($disponibilte > 0) {
                $color = "badge bg-light-success text-white fw-normal";
                $color1 = "background-color: #2cd07e!important";
                $etat = "DISPONIBLE";
            } else {
                $color = "badge bg-light-info text-white fw-normal";
                $color1 = "background-color: #ff5050!important";
                $etat = "NON DISPONIBLE";
            }
        } else {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ff5050!important";
            $etat = "NON DISPONIBLE";
        }
        $value .= '
        <tbody>          
            <tr>
                <td class="border-top-0">' . $row['id_materiels'] . '</td>
                <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                <td class="border-top-0">' . $row['quantite_materiels_dispo'] . '</td>            
                <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                <td class="border-top-0">
                </td>
            </tr>
        </tbody>';
    }
    $value .= '</table> </div>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function InserDevis()
{
    global $conn;
    $ClientDevis = $_POST['ClientDevis'];
    $NomDevis = $_POST['NomDevis'];
    $ModePaiementDevis = $_POST['ModePaiementDevis'];
    $CommentaireDevis = $_POST['CommentaireDevis'];
    $DateDevis = $_POST['DateDevis'];
    $RemiseDevis = $_POST['RemiseDevis'];
    $EscompteDevis = $_POST['EscompteDevis'];
    $codeListe = $_POST['codeListe'];
    $designationListe = $_POST['designationListe'];
    $quantitionListe = $_POST['quantitionListe'];
    $prixListe = $_POST['prixListe'];
    $devisagence = $_POST['devisagence'];
    $depotListe = $_POST['depotListe'];
    $count = count($depotListe);
    $id_user = $_SESSION['id_user'];
    if ($devisagence == "") {
        $id_agence = $_SESSION['id_agence'];;
    } else {
        $id_agence = $devisagence;
    }
    if ($id_agence != "0") {
        $query = "INSERT INTO devis(id_client_devis,id_agence,ModePaiement_Devis,Commentaire_Devis,date_devis,nom_devis,remise,id_user_devis,escompte) 
        VALUES('$ClientDevis','$id_agence','$ModePaiementDevis','$CommentaireDevis','$DateDevis','$NomDevis','$RemiseDevis', '$id_user','$EscompteDevis')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $query_get_max_id_contrat = "SELECT max(id_devis)
                    FROM devis ";
            $result_query_get_max_id_contra = mysqli_query($conn, $query_get_max_id_contrat);
            while ($row = mysqli_fetch_row($result_query_get_max_id_contra)) {
                $id_contrat = $row[0];
                $materiel_table = $codeListe;
                if ($count >= 1) {
                    for ($i = 0; $i < $count; $i++) {
                        $query_insert_materiel_list = "INSERT INTO article_devis(id_article_devis,code_article_devis,designation_article_devis,
                        quantite_article_devis,prix_unitaire,depot)
                         VALUES ('$id_contrat','$materiel_table[$i]',
                        '$designationListe[$i]','$quantitionListe[$i]','$prixListe[$i]','$depotListe[$i]') ";
                        $result_query_insert_materiel_list = mysqli_query($conn, $query_insert_materiel_list);
                    }
                    if ($result_query_insert_materiel_list) {
                        echo ("<div class='text-success'>Le contrat est ajouté  avec succés</div>");
                    } else {
                        echo ("<div class='text-danger'>échoué!</div>");
                    }
                }
            }
        }
    } else {
        echo "<div class='text-danger'>SVP! Choisissez l'agence</div>";
    }
}

function delete_devis()
{
    global $conn;
    $Del_ID = $_POST['Delete_DevisID'];
    $query = "DELETE FROM devis WHERE id_devis='$Del_ID'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Le devis est supprimé";
    } else {
        echo "SVP vérifier votre requette !";
    }
}

function get_Devis()
{
    global $conn;
    $DevisID = $_POST['DevisID'];
    $query = " SELECT * FROM devis AS D LEFT JOIN client AS C ON D.id_client_devis =C.id_client
    LEFT JOIN article_devis AS AD ON AD.id_article_devis= D.id_devis
    WHERE D.id_devis='$DevisID'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $devis_data = array();
        if (empty($devis_data)) {
            $devis_data[0][] = $row['id_devis'];
            $devis_data[1][] = $row['nom_devis'];
            $devis_data[2][] = $row['ModePaiement_Devis'];
            $devis_data[3][] = $row['Commentaire_Devis'];
            $devis_data[4][] = $row['date_devis'];
            $devis_data[5][] = $row['remise'];
            $devis_data[6][] = $row['tva'];
            $devis_data[7][] = $row['escompte'];
            $devis_data[8][] = $row['id_client'];
            $devis_data[10][] = $row['code_article_devis'];
            $devis_data[11][] = $row['designation_article_devis'];
            $devis_data[12][] = $row['quantite_article_devis'];
            $devis_data[13][] = $row['prix_unitaire'];
            $devis_data[14][] = $row['depot'];
            $devis_data[15][] = $row['id_agence'];
        } else {
            $devis_data[10][] = $row['code_article_devis'];
            $devis_data[11][] = $row['designation_article_devis'];
            $devis_data[12][] = $row['quantite_article_devis'];
            $devis_data[13][] = $row['prix_unitaire'];
            $devis_data[14][] = $row['depot'];
            $devis_data[15][] = $row['id_agence'];
        }
    }
    echo json_encode($devis_data);
}

// update Client
function update_devis()
{
    global $conn;
    if (!array_key_exists("up_idDevis", $_POST)) {
        echo json_encode(["error" => "ID Devis manquant ", "data" => "ID Devis manquant"]);
        return;
    }
    $updateDevislId = $_POST["up_idDevis"];
    $devis_query = "SELECT * FROM  devis where id_devis = $updateDevislId";
    $devis_result = mysqli_query($conn, $devis_query);
    $devis = mysqli_fetch_assoc($devis_result);
    if (!$devis) {
        echo json_encode(["error" => "Devis introuvable ", "data" => "Devis $updateDevislId not found."]);
        return;
    }
    $updateDevislId = $_POST['up_idDevis'];
    $updateDevisClient = $_POST['up_ClientDevis'];
    $updateDevisName = $_POST['up_NomDevis'];
    $updateDevisModePaiement = $_POST['up_ModePaiementDevis'];
    $updateDevisCommentaire = $_POST['up_CommentaireDevis'];
    $updateDevisDate = $_POST['up_DateDevis'];
    $updateDevisRemise = $_POST['up_RemiseDevis'];
    $updateDevisEscompte = $_POST['up_EscompteDevis'];
    $up_devisagence = isset($_POST['up_devisagence']) ? $_POST['up_devisagence'] :  "";
    if ($up_devisagence == "") {
        $id_agence = $_SESSION['id_agence'];;
    } else {
        $id_agence = $up_devisagence;
    }
    $query = "UPDATE devis SET 
    id_client_devis='$updateDevisClient',nom_devis='$updateDevisName',id_agence='$id_agence',ModePaiement_Devis='$updateDevisModePaiement',
    Commentaire_Devis='$updateDevisCommentaire',date_devis='$updateDevisDate',remise='$updateDevisRemise',escompte='$updateDevisEscompte'
    where id_devis='$updateDevislId'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo ("<div class='text-success'>Le devis est mis à jour avec succès</div>");
    } else {
        echo ("<div class='text-danger'>échoué!</div>");
    }
}

function view_devis()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<div class="table-responsive">
        <table class="table">
        <thead >
            <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0">Nom devis</th>
                <th class="border-top-0">Agence</th>
                <th class="border-top-0">Mode Paiement</th>
                <th class="border-top-0">Commentaire</th>
                <th class="border-top-0">Date devis</th>
                <th class="border-top-0">Remise</th>
                <th class="border-top-0">Escompte</th>
                <th class="border-top-0">Nom client</th>
            </tr>
            </thead>';
    } else if ($_SESSION['Role'] == "responsable") {
        $value = '<div class="table-responsive">
        <table class="table">
        <thead >
            <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0">Nom devis</th>
                <th class="border-top-0">Agence</th>
                <th class="border-top-0">Mode Paiement</th>
                <th class="border-top-0">Commentaire</th>
                <th class="border-top-0">Date devis</th>
                <th class="border-top-0">Remise</th>
                <th class="border-top-0">Escompte</th>
                <th class="border-top-0">Nom client</th>
                <th class="border-top-0">Actions</th>
            </tr>
            </thead>';
    } else {
        $value = '<div class="table-responsive">
        <table class="table">
        <thead >
            <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0">Nom devis</th>
                <th class="border-top-0">Mode Paiement</th>
                <th class="border-top-0">Commentaire</th>
                <th class="border-top-0">Date devis</th>
                <th class="border-top-0">Remise</th>
                <th class="border-top-0">Escompte</th>
                <th class="border-top-0">Nom client</th>
                <th class="border-top-0">Actions</th>
            </tr>
            </thead>';
    }
    if ($_SESSION['Role'] != "admin") {
        $query = "SELECT * FROM devis,client,agence 
        where devis.id_client_devis = client.id_client 
        and devis.id_agence = agence.id_agence 
        ORDER BY id_devis  ";
    } else {
        $query = "SELECT * FROM devis,client 
        where devis.id_client_devis = client.id_client
        and id_agence = $id_agence
        ORDER BY id_devis ";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($_SESSION['Role'] != "admin") {
            $value .= '
            <tbody>
            <tr>
                <td class="border-top-0">' . $row['id_devis'] . '</td>
                <td class="border-top-0">' . $row['nom_devis'] . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['ModePaiement_Devis'] . '</td>
                <td class="border-top-0">' . $row['Commentaire_Devis'] . '</td>
                <td class="border-top-0">' . $row['date_devis'] . '</td>
                <td class="border-top-0">' . $row['remise'] . '%</td>
                <td class="border-top-0">' . $row['escompte'] . '%</td>
                <td class="border-top-0">' . $row['nom'] . '</td>';
        } else {
            $value .= '
            <tbody>
            <tr>
                <td class="border-top-0">' . $row['id_devis'] . '</td>
                <td class="border-top-0">' . $row['nom_devis'] . '</td>
                <td class="border-top-0">' . $row['ModePaiement_Devis'] . '</td>
                <td class="border-top-0">' . $row['Commentaire_Devis'] . '</td>
                <td class="border-top-0">' . $row['date_devis'] . '</td>
                <td class="border-top-0">' . $row['remise'] . '%</td>
                <td class="border-top-0">' . $row['escompte'] . '%</td>
                <td class="border-top-0">' . $row['nom'] . '</td>';
        }
        if ($_SESSION['Role'] != "superadmin") {
            $value .= '<td class="border-top-0">
                <button  type="button" title="Modifier le devis" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-devis" data-id=' . $row['id_devis'] . '><i class="fas fa-edit"></i></button> 
                <button  type="button" title="Supprimer le devis" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-devis" data-id1=' . $row['id_devis'] . '><i class="fas fa-trash-alt"></i></button>
                <button type="button" title="Télécharger le devis" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-devis" data-id2=' . $row['id_devis'] . '><i class="fas fa-list-alt"></i></i></button>
                </td>
                </tr>';
        }
    }

    $value .= ' </tbody>
    </table>
</div>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}


// Afficher FACTURES 
function InsertFacture()
{
    global $conn;

    $ContratFacture = $_POST['ContratFacture'];
    $DateArret = $_POST['DateArret'];
    $id_agence = $_SESSION['id_agence'];

    $queryclientid = "SELECT id_client FROM contrat_client
     WHERE id_contrat = '$ContratFacture'";
    $resultclientid = mysqli_query($conn, $queryclientid);

    while ($row = mysqli_fetch_assoc($resultclientid)) {
        $idclient = $row['id_client'];
    }
    $query = "INSERT INTO facture_client(id_client,id_contrat,id_agence,date_arret)
                VALUES ('$idclient','$ContratFacture','$id_agence','$DateArret')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<div class='text-success'>La facture est ajouté avec succés</div>";
    } else {
        echo "<div class='text-danger'>Erreur lors de l'ajout du facture </div>";
    }
}

function display_facture_voiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI du client</th>
        </tr>';
    } else if ($_SESSION['Role'] == "responsable") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI du client</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI du client</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    }
    if ($_SESSION['Role'] != "admin") {
        $query = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin,A.lieu_agence
        FROM  facture_client AS FC
        LEFT JOIN contrat_client AS C ON C.id_contrat = FC.id_contrat
        LEFT JOIN client AS CL ON FC.id_client = CL.id_client 
        LEFT JOIN agence AS A ON A.id_agence = C.id_agence
        WHERE C.type_location = 'Vehicule' and  FC.id_client = C.id_client";
    } else {
        $query = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin
        FROM  facture_client AS FC
        LEFT JOIN contrat_client AS C ON C.id_contrat = FC.id_contrat
        LEFT JOIN client AS CL ON FC.id_client = CL.id_client 
        WHERE C.type_location = 'Vehicule' and  FC.id_client = C.id_client
        AND FC.id_agence = $id_agence ";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($_SESSION['Role'] != "admin") {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_facture'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
        } else {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_facture'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
        }
        if ($_SESSION['Role'] != "superadmin") {
            $value .= '<td class="border-top-0">
              <button type="button" title="Télécharger la facture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-facture" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
            </td>';
        }
        $value .= '</tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

function display_facture_materiel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI de client</th>
        </tr>';
    } else if ($_SESSION['Role'] == "responsable") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI de client</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI de client</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    }
    if ($_SESSION['Role'] != "admin") {
        $query = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin,A.lieu_agence
        FROM  facture_client AS FC
        LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
        LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
        LEFT JOIN agence AS A ON A.id_agence = C.id_agence
        WHERE C.type_location = 'Materiel'
        AND FC.id_client = C.id_client";
    } else {
        $query = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin
        FROM  facture_client AS FC
        LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
        LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
        WHERE C.type_location = 'Materiel'
        AND FC.id_client = C.id_client
        AND FC.id_agence =   $id_agence";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($_SESSION['Role'] != "admin") {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_facture'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
        } else {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_facture'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
        }
        if ($_SESSION['Role'] != "superadmin") {
            $value .= '<td class="border-top-0">
              <button type="button" title="Télécharger la facture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-facture-materiel" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
            </td>';
        }
        $value .= '</tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}


function display_facture_pack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI du client</th>
        </tr>';
    } else if ($_SESSION['Role'] == "responsable") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI du client</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI du client</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    }
    if ($_SESSION['Role'] != "admin") {
        $query = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin,A.lieu_agence
        FROM  facture_client AS FC
        LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
        LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
        LEFT JOIN agence AS A ON A.id_agence = C.id_agence
        WHERE C.type_location = 'Pack'
        AND FC.id_client = C.id_client";
    } else {
        $query = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin
        FROM  facture_client AS FC
        LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
        LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
        WHERE C.type_location = 'Pack'
        AND FC.id_client = C.id_client
        AND FC.id_agence = $id_agence ";
    }
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($_SESSION['Role'] != "admin") {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_facture'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
        } else {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_facture'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                <td class="border-top-0">' . $row['id_contrat'] . '</td>
                <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                <td class="border-top-0">' . $row['nom'] . '</td>
                <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
        }
        if ($_SESSION['Role'] != "superadmin") {
            $value .= '<td class="border-top-0">
              <button type="button" title="Télécharger la facture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-facture-pack" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
            </td>';
        }
        $value .= '</tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// dispaly client data function
function view_chauffeur()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Nom / Prenom</th>
            <th class="border-top-0">Email</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Nom / Prenom</th>
            <th class="border-top-0">Email</th>
            <th class="border-top-0">Actions</th> 
        </tr>';
    }
    $query = " SELECT * FROM k2_chauffeur
        WHERE 
        etat != 'S'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['etat'] == 'T') {
            $etat = "active";
        } else {
            $etat = "désactiver";
        }
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id'] . '</td>
                <td class="border-top-0">' . $row['nom_complet'] . '</td>
                <td class="border-top-0">' . $row['email'] . '</td>
                <td class="border-top-0">';
        if ($_SESSION['Role'] != "superadmin") {
            $value .= '<button type="button" title="Supprimer le chauffeur" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-chauffeur" data-id1=' . $row['id'] . '><i class="fas fa-trash-alt"></i></button>
                    </td>';
        }
        $value .= '    </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// dispaly client data function
function view_k2voiture()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Immatriculation</th>
            <th class="border-top-0">Marque</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Immatriculation</th>
            <th class="border-top-0">Marque</th>
            <th class="border-top-0">Actions</th> 
        </tr>';
    }
    $query = " SELECT * FROM k2_vehicule
        WHERE etat != 'S'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['etat'] == 'T') {
            $etat = "Active";
        } else {
            $etat = "Désactiver";
        }
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_vehicule'] . '</td>
                <td class="border-top-0">' . $row['immatriculation'] . '</td>
                <td class="border-top-0">' . $row['marque'] . '</td>
                <td class="border-top-0">';
        if ($_SESSION['Role'] != "superadmin") {
            $value .= '   <button type="button" title="Supprimer la voiture" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-k2vehicule" data-id1=' . $row['id_vehicule'] . '><i class="fas fa-trash-alt"></i></button>';
        }
        $value .= ' </td>
        </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}

// dispaly client data function
function view_k2affectation()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Immatriculation/marque</th>
            <th class="border-top-0">Nom/Prenom</th>
            <th class="border-top-0">Date debut</th>
            <th class="border-top-0">Date fin</th>                 
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Immatriculation/marque</th>
            <th class="border-top-0">Nom/Prenom</th>
            <th class="border-top-0">Date debut</th>
            <th class="border-top-0">Date fin</th>         
            <th class="border-top-0">Actions</th>         
        </tr>';
    }
    $query = "SELECT * FROM k2_affectation , k2_chauffeur , k2_vehicule
         WHERE k2_affectation.id_chauffeur=k2_chauffeur.id
        and k2_affectation.id_vehicule=k2_vehicule.id_vehicule
        ORDER BY id_affectation DESC ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= '
            <tr>
                <td class="border-top-0">' . $row['id_affectation'] . '</td>
                <td class="border-top-0">' . $row['immatriculation'] . ' ' . $row['marque'] . '</td>
                <td class="border-top-0">' . $row['nom_complet'] . '</td>
                <td class="border-top-0">' . $row['date_debut'] . '</td>
                <td class="border-top-0">' . $row['date_fin'] . '</td>';
        if ($_SESSION['Role'] != "superadmin") {
            $value .= '<td> <button type="button" title="Supprimer l\'affectation" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-k2affectation" data-id1=' . $row['id_affectation'] . '><i class="fas fa-trash-alt"></i></button>
                    </td>';
        }
        $value .= ' </tr>';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
//Ajouter Affectation
function InsertK2Affectation()
{
    global $conn;
    $IDaffectationK2_vehicule = $_POST['IDaffectationK2_vehicule'];
    $IDaffectationChauffeur = $_POST['IDaffectationChauffeur'];
    $IDaffectationDateDebutNew = $_POST['IDaffectationDateDebut'];
    $IDaffectationDateDebutNew = date('Y-m-d\TH:i', strtotime($IDaffectationDateDebutNew));
    $query_get_max_id_materiel = "SELECT id_affectation , date_debut 
        FROM k2_affectation 
        WHERE id_vehicule=$IDaffectationK2_vehicule  
        ORDER BY id_affectation DESC";
    $result_query_get_max_materie = mysqli_query($conn, $query_get_max_id_materiel);
    $row = mysqli_fetch_row($result_query_get_max_materie);
    $max_id = $row[0];

    $max_datedebut = $row[1];

    $IDDateDebut = date('YmdHis', strtotime($IDaffectationDateDebutNew));
    echo "<br>";

    $IDDateDebutfin = date('YmdHis', strtotime($max_datedebut));
    echo "<br>";

    $dateDifference = $IDDateDebut - $IDDateDebutfin;
    if ($dateDifference > 0) {
        $update_query = "UPDATE k2_affectation SET 
    date_fin='$IDaffectationDateDebutNew'
    WHERE id_affectation ='$max_id' ";
        $update_result = mysqli_query($conn, $update_query);

        $query = "INSERT INTO 
        k2_affectation(id_vehicule,id_chauffeur,date_debut) 
        VALUES ('$IDaffectationK2_vehicule','$IDaffectationChauffeur','$IDaffectationDateDebutNew')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<div class='text-success'>Le Affectation est Ajouté avec succés</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout de Affectation </div>";
        }
    } else {
        echo "<div class='text-danger'>Merci de choisir une date après " . $max_datedebut . " </div>";
    }
}

function searchChauffeur()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Nom / Prenom</th>
            <th class="border-top-0">Email</th>    
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Nom / Prenom</th>
            <th class="border-top-0">Email</th>
            <th class="border-top-0">Actions</th>     
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = "SELECT * FROM k2_chauffeur
        WHERE etat != 'S'
        AND ( id LIKE ('%" . $search . "%')
                     OR nom_complet LIKE ('%" . $search . "%')
                     OR email LIKE ('%" . $search . "%'))";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '<tr>
                    <td class="border-top-0">' . $row['id'] . '</td>
                    <td class="border-top-0">' . $row['nom_complet'] . '</td>
                    <td class="border-top-0">' . $row['email'] . '</td>';
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<td class="border-top-0">
                        <button type="button" title="Supprimer le chauffeur" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-chauffeur" data-id1=' . $row['id'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        view_chauffeur();
    }
}

function searchVoiturek2()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Immatriculation</th>
            <th class="border-top-0">Marque</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Immatriculation</th>
            <th class="border-top-0">Marque</th>
            <th class="border-top-0">Actions</th>   
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $sql = "SELECT * FROM k2_vehicule
        WHERE etat != 'S'
        AND  (id_vehicule LIKE ('%" . $search . "%')
                     OR immatriculation LIKE ('%" . $search . "%')
                     OR marque LIKE ('%" . $search . "%'))";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '<tr>
                    <td class="border-top-0">' . $row['id_vehicule'] . '</td>
                    <td class="border-top-0">' . $row['immatriculation'] . '</td>
                    <td class="border-top-0">' . $row['marque'] . '</td>';
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<td class="border-top-0">
                        <button type="button" title="Supprimer la voiture" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-k2vehicule" data-id1=' . $row['id_vehicule'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        view_k2voiture();
    }
}

// search Affectation
function searchAffectation()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Immatriculation/marque</th>
            <th class="border-top-0">Nom/Prenom</th>
            <th class="border-top-0">Date debut</th>
            <th class="border-top-0">Date fin</th>        
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Immatriculation/marque</th>
            <th class="border-top-0">Nom/Prenom</th>
            <th class="border-top-0">Date debut</th>
            <th class="border-top-0">Date fin</th>
            <th class="border-top-0">Actions</th>          
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        $query = ("SELECT * FROM k2_affectation , k2_chauffeur , k2_vehicule
            WHERE k2_affectation.id_chauffeur=k2_chauffeur.id
            AND k2_affectation.id_vehicule=k2_vehicule.id_vehicule
            AND   (id_affectation LIKE ('%" . $search . "%')
                     OR immatricule_marque LIKE ('%" . $search . "%')
                     OR nom_complet LIKE ('%" . $search . "%')
                     OR date_debut LIKE ('%" . $search . "%')
                     OR date_fin LIKE ('%" . $search . "%')  )
                     ORDER BY id_affectation DESC");
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '<tr>
                    <td class="border-top-0">' . $row['id_affectation'] . '</td>
                    <td class="border-top-0">' . $row['immatriculation'] . ' ' . $row['marque'] . '</td>
                    <td class="border-top-0">' . $row['nom_complet'] . '</td>
                    <td class="border-top-0">' . $row['date_debut'] . '</td>
                    <td class="border-top-0">' . $row['date_fin'] . '</td>';
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<td> <button type="button" title="Supprimer l\'affectation" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-k2affectation" data-id1=' . $row['id_affectation'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        view_k2affectation();
    }
}
//

function searchAffectationId()
{
    global $conn;
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Immatriculation/marque</th>
            <th class="border-top-0">Nom/Prenom</th>
            <th class="border-top-0">Date debut</th>
            <th class="border-top-0">Date fin</th>        
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Immatriculation/marque</th>
            <th class="border-top-0">Nom/Prenom</th>
            <th class="border-top-0">Date debut</th>
            <th class="border-top-0">Date fin</th>
            <th class="border-top-0">Actions</th>          
        </tr>';
    }
    if ($_POST['queryk2'] != "0") {
        $search = $_POST['queryk2'];
        $query = ("SELECT * FROM k2_affectation , k2_chauffeur , k2_vehicule
            WHERE k2_affectation.id_chauffeur=k2_chauffeur.id
            AND k2_affectation.id_vehicule=k2_vehicule.id_vehicule
            AND   k2_affectation.id_vehicule='$search'
            ORDER BY id_affectation DESC ");
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $value .= '<tr>
                    <td class="border-top-0">' . $row['id_affectation'] . '</td>
                    <td class="border-top-0">' . $row['immatriculation'] . ' ' . $row['marque'] . '</td>
                    <td class="border-top-0">' . $row['nom_complet'] . '</td>
                    <td class="border-top-0">' . $row['date_debut'] . '</td>
                    <td class="border-top-0">' . $row['date_fin'] . '</td>';
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<td> <button type="button" title="Supprimer l\'affectation" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-k2affectation" data-id1=' . $row['id_affectation'] . '><i class="fas fa-trash-alt"></i></button>
                        </td>';
                }
                $value .= '</tr>';
            }
        }
        $value .= '</table>';
        echo $value;
    } else {
        $query1 = ("SELECT * FROM k2_affectation , k2_chauffeur , k2_vehicule
        WHERE k2_affectation.id_chauffeur=k2_chauffeur.id
        AND k2_affectation.id_vehicule=k2_vehicule.id_vehicule
        ORDER BY id_affectation DESC");
        $result1 = mysqli_query($conn, $query1);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $value .= '
            <tr>
                <td class="border-top-0">' . $row1['id_affectation'] . '</td>
                <td class="border-top-0">' . $row1['immatriculation'] . ' ' . $row1['marque'] . '</td>
                <td class="border-top-0">' . $row1['nom_complet'] . '</td>
                <td class="border-top-0">' . $row1['date_debut'] . '</td>
                <td class="border-top-0">' . $row1['date_fin'] . '</td>';
                if ($_SESSION['Role'] != "superadmin"){
                    $value .= '<td> <button type="button" title="Supprimer l\'affectation" class="btn waves-effect waves-light btn-outline-dark" id="btn-delete-k2affectation" data-id1=' . $row1['id_affectation'] . '><i class="fas fa-trash-alt"></i></button>
                    </td>';
            }
            $value .= '</tr>';
        }
        $value .= '</table>';
        echo $value;
    }
}

//Ajouter Affectation
function InsertK2Voiture()
{
    global $conn;
    $voitureImmatriculation = $_POST['voitureImmatriculation'];
    $voitureMarque = $_POST['voitureMarque'];
    $immatricule_marque = $voitureImmatriculation . " " . $voitureMarque;

    $sql_e = "SELECT * FROM k2_vehicule WHERE immatriculation='$voitureImmatriculation'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo "<div class='text-danger'>
            Désolé ... PIMM est déjà existant!</div>";
    } else {
        $query = "INSERT INTO 
        k2_vehicule(immatriculation,marque,immatricule_marque) 
        VALUES ('$voitureImmatriculation','$voitureMarque','$immatricule_marque')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<div class='text-success'>Le Affectation est Ajouté avec succés</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout de Affectation </div>";
        }
    }
}


//Ajouter Affectation
function InsertK2chauffeur()
{
    global $conn;
    $chauffeurName = $_POST['chauffeurName'];
    $chauffeurEmail = $_POST['chauffeurEmail'];


    $sql_e = "SELECT * FROM k2_chauffeur WHERE nom_complet='$chauffeurName'";
    $res_e = mysqli_query($conn, $sql_e);
    if (mysqli_num_rows($res_e) > 0) {
        echo "<div class='text-danger'>
            Désolé ... Nom est déjà existant!</div>";
    } else {
        $query = "INSERT INTO 
        k2_chauffeur(nom_complet,email) 
        VALUES ('$chauffeurName','$chauffeurEmail')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<div class='text-success'>Le Chauffeur est Ajouté avec succés</div>";
        } else {
            echo "<div class='text-danger'>Erreur lors d'ajout de Chauffeur </div>";
        }
    }
}


//supprime   InsertVoitureVendue()
function delete_voiturek2_record()
{
    global $conn;
    $Del_ID = $_POST['id_voiture'];
    $query = "UPDATE k2_vehicule SET etat ='S' 
    WHERE id_vehicule='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Le véhicule est supprimé avec succés";
    } else {
        echo "SVP vérifier votre requette !";
    }
}


//supprime   InsertVoitureVendue()
function delete_chauffeurk2_record()
{
    global $conn;
    $Del_ID = $_POST['id_chauffeur'];
    $query = "UPDATE k2_chauffeur SET etat ='S' 
    WHERE id='$Del_ID'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Le chauffeur est Supprimé avec succés";
    } else {
        echo "SVP Vérifier votre requette !";
    }
}


//supprime   InsertVoitureVendue()
function delete_affectationk2_record()
{
    global $conn;
    $Del_ID = $_POST['id_affectation'];
    $query = "DELETE FROM k2_affectation WHERE id_affectation='$Del_ID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Le affectation est Supprimé avec succés";
    } else {
        echo "SVP Vérifier votre requette !";
    }
}


function searchDevis()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<div class="table-responsive">
        <table class="table">
        <thead >
            <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0">Nom devis</th>
                <th class="border-top-0">Agence</th>
                <th class="border-top-0">Mode Paiement</th>
                <th class="border-top-0">Commentaire</th>
                <th class="border-top-0">Date devis</th>
                <th class="border-top-0">Remise</th>
                <th class="border-top-0">Escompte</th>
                <th class="border-top-0">Nom client</th>
            </tr>
            </thead>';
    } else if ($_SESSION['Role'] == "responsable") {
        $value = '<div class="table-responsive">
        <table class="table">
        <thead >
            <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0">Nom devis</th>
                <th class="border-top-0">Agence</th>
                <th class="border-top-0">Mode Paiement</th>
                <th class="border-top-0">Commentaire</th>
                <th class="border-top-0">Date devis</th>
                <th class="border-top-0">Remise</th>
                <th class="border-top-0">Escompte</th>
                <th class="border-top-0">Nom client</th>
                <th class="border-top-0">Actions</th>
            </tr>
            </thead>';
    } else {
        $value = '<div class="table-responsive">
        <table class="table">
        <thead >
            <tr>
                <th class="border-top-0">#</th>
                <th class="border-top-0">Nom devis</th>
                <th class="border-top-0">Mode Paiement</th>
                <th class="border-top-0">Commentaire</th>
                <th class="border-top-0">Date devis</th>
                <th class="border-top-0">Remise</th>
                <th class="border-top-0">Escompte</th>
                <th class="border-top-0">Nom client</th>
                <th class="border-top-0">Actions</th>
            </tr>
            </thead>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($_SESSION['Role'] != "admin") {
            $sql = ("SELECT * FROM devis,client,agence 
            where devis.id_client_devis = client.id_client 
            and devis.id_agence = agence.id_agence 
            AND (devis.id_devis LIKE ('%" . $search . "%')
                     OR devis.nom_devis LIKE ('%" . $search . "%')
                     OR devis.ModePaiement_Devis LIKE ('%" . $search . "%')
                     OR devis.Commentaire_Devis LIKE ('%" . $search . "%')
                     OR devis.date_devis LIKE ('%" . $search . "%') 
                     OR devis.remise LIKE ('%" . $search . "%')  
                     OR devis.escompte LIKE ('%" . $search . "%')
                     OR client.nom LIKE ('%" . $search . "%') 
                     OR agence.lieu_agence LIKE ('%" . $search . "%')) 
                        ORDER BY devis.id_devis ");
        } else {
            $sql = ("SELECT * FROM devis,client 
            WHERE devis.id_client_devis = client.id_client
            AND devis.id_agence = $id_agence 
            AND   (devis.id_devis LIKE ('%" . $search . "%')
                     OR devis.nom_devis LIKE ('%" . $search . "%')
                     OR devis.ModePaiement_Devis LIKE ('%" . $search . "%')
                     OR devis.Commentaire_Devis LIKE ('%" . $search . "%')
                     OR devis.date_devis LIKE ('%" . $search . "%') 
                     OR devis.remise LIKE ('%" . $search . "%')  
                     OR devis.escompte LIKE ('%" . $search . "%')
                     OR client.nom LIKE ('%" . $search . "%')) 
                     ORDER BY devis.id_devis ");
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($_SESSION['Role'] != "admin") {
                    $value .= '
                    <tbody>
                    <tr>
                        <td class="border-top-0">' . $row['id_devis'] . '</td>
                        <td class="border-top-0">' . $row['nom_devis'] . '</td>
                        <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                        <td class="border-top-0">' . $row['ModePaiement_Devis'] . '</td>
                        <td class="border-top-0">' . $row['Commentaire_Devis'] . '</td>
                        <td class="border-top-0">' . $row['date_devis'] . '</td>
                        <td class="border-top-0">' . $row['remise'] . '%</td>
                        <td class="border-top-0">' . $row['escompte'] . '%</td>
                        <td class="border-top-0">' . $row['nom'] . '</td>';
                } else {
                    $value .= '
                    <tbody>
                    <tr>
                        <td class="border-top-0">' . $row['id_devis'] . '</td>
                        <td class="border-top-0">' . $row['nom_devis'] . '</td>
                        <td class="border-top-0">' . $row['ModePaiement_Devis'] . '</td>
                        <td class="border-top-0">' . $row['Commentaire_Devis'] . '</td>
                        <td class="border-top-0">' . $row['date_devis'] . '</td>
                        <td class="border-top-0">' . $row['remise'] . '%</td>
                        <td class="border-top-0">' . $row['escompte'] . '%</td>
                        <td class="border-top-0">' . $row['nom'] . '</td>';
                }
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<td class="border-top-0">
                        <button  type="button" title="Modifier le devis" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-edit-devis" data-id=' . $row['id_devis'] . '><i class="fas fa-edit"></i></button> 
                        <button  type="button" title="Supprimer le devis" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-delete-devis" data-id1=' . $row['id_devis'] . '><i class="fas fa-trash-alt"></i></button>
                        <button type="button" title="Télécharger le devis" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-devis" data-id2=' . $row['id_devis'] . '><i class="fas fa-list-alt"></i></i></button>
                    </td>  
                    </tr>';
                }
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        view_devis();
    }
}



function searchFactureVoiture()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
            <tr>
                <th class="border-top-0">ID FACTURE</th>
                <th class="border-top-0">DATE DE FACTURATION</th>
                <th class="border-top-0">Agence</th>
                <th class="border-top-0">N° de contrat</th>
                <th class="border-top-0">DATE DE CONTRAT</th>
                <th class="border-top-0">Nom du client</th>
                <th class="border-top-0">CNI de client</th>       
            </tr>';
    } else if ($_SESSION['Role'] == "responsable") {
        $value = '<table class="table">
            <tr>
                <th class="border-top-0">ID FACTURE</th>
                <th class="border-top-0">DATE DE FACTURATION</th>
                <th class="border-top-0">Agence</th>
                <th class="border-top-0">N° de contrat</th>
                <th class="border-top-0">DATE DE CONTRAT</th>
                <th class="border-top-0">Nom du client</th>
                <th class="border-top-0">CNI de client</th>
                <th class="border-top-0">Actions</th>       
            </tr>';
    } else {
        $value = '<table class="table">
            <tr>
                <th class="border-top-0">ID FACTURE</th>
                <th class="border-top-0">DATE DE FACTURATION</th>
                <th class="border-top-0">N° de contrat</th>
                <th class="border-top-0">DATE DE CONTRAT</th>
                <th class="border-top-0">Nom du client</th>
                <th class="border-top-0">CNI de client</th>
                <th class="border-top-0">Actions</th>       
            </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($_SESSION['Role'] != "admin") {
            $sql = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin,A.lieu_agence
            FROM  facture_client AS FC
            LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
            LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
            LEFT JOIN agence AS A ON A.id_agence =C.id_agence
            WHERE C.type_location = 'Vehicule' and  FC.id_client = C.id_client
            AND (id_facture LIKE ('%" . $search . "%')
                     OR date_facture LIKE ('%" . $search . "%')
                     OR FC.id_contrat LIKE ('%" . $search . "%')
                     OR date_debut LIKE ('%" . $search . "%')
                     OR lieu_agence LIKE ('%" . $search . "%')
                     OR nom LIKE ('%" . $search . "%') )";
        } else {
            $sql = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin
            FROM  facture_client AS FC
            LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
            LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
            WHERE C.type_location = 'Vehicule' and  FC.id_client = C.id_client
            AND FC.id_agence =   $id_agence 
            AND (id_facture LIKE ('%" . $search . "%')
                     OR date_facture LIKE ('%" . $search . "%')
                     OR FC.id_contrat LIKE ('%" . $search . "%')
                     OR date_debut LIKE ('%" . $search . "%')
                     OR nom LIKE ('%" . $search . "%') )";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($_SESSION['Role'] != "admin") {
                    $value .= '
                    <tr>
                    <td class="border-top-0">' . $row['id_facture'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                    <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                    <td class="border-top-0">' . $row['nom'] . '</td>
                    <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
                } else {
                    $value .= '
                    <tr>
                    <td class="border-top-0">' . $row['id_facture'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                    <td class="border-top-0">' . $row['nom'] . '</td>
                    <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
                }
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '
                    <td class="border-top-0">
                        <button type="button" title="Télécharger la facture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-facture" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
                    </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_facture_voiture();
    }
}
function searchFactureMateriel()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI de client</th>
        </tr>';
    } else if ($_SESSION['Role'] == "responsable") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI de client</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI de client</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($_SESSION['Role'] != "admin") {
            $sql = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin,A.lieu_agence
            FROM  facture_client AS FC
            LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
            LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
            LEFT JOIN agence AS A ON A.id_agence = C.id_agence
            WHERE C.type_location = 'Materiel'
            AND FC.id_client = C.id_client
            AND (id_facture LIKE ('%" . $search . "%')
                     OR date_facture LIKE ('%" . $search . "%')
                     OR FC.id_contrat LIKE ('%" . $search . "%')
                     OR date_debut LIKE ('%" . $search . "%')
                     OR lieu_agence LIKE ('%" . $search . "%')
                     OR nom LIKE ('%" . $search . "%') )";
        } else {
            $sql = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin
            FROM  facture_client AS FC
            LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
            LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
            WHERE C.type_location = 'Materiel'
            AND FC.id_client = C.id_client
            AND FC.id_agence =   $id_agence
            AND (id_facture LIKE ('%" . $search . "%')
                     OR date_facture LIKE ('%" . $search . "%')
                     OR FC.id_contrat LIKE ('%" . $search . "%')
                     OR date_debut LIKE ('%" . $search . "%')
                     OR nom LIKE ('%" . $search . "%') )";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($_SESSION['Role'] != "admin") {
                    $value .= '
                    <tr>
                    <td class="border-top-0">' . $row['id_facture'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                    <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                    <td class="border-top-0">' . $row['nom'] . '</td>
                    <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
                } else {
                    $value .= '
                    <tr>
                    <td class="border-top-0">' . $row['id_facture'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                    <td class="border-top-0">' . $row['nom'] . '</td>
                    <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
                }
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<td class="border-top-0">
                        <button type="button" title="Télécharger la facture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-facture" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
                    </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_facture_materiel();
    }
}
function searchFacturePack()
{
    global $conn;
    $id_agence = $_SESSION['id_agence'];
    if ($_SESSION['Role'] == "superadmin") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI du client</th>
        </tr>';
    } else if ($_SESSION['Role'] == "responsable") {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">Agence</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI du client</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    } else {
        $value = '<table class="table">
        <tr>
        <th class="border-top-0">ID FACTURE</th>
        <th class="border-top-0">DATE DE FACTURATION</th>
        <th class="border-top-0">N° de contrat</th>
        <th class="border-top-0">DATE DE CONTRAT</th>
        <th class="border-top-0">Nom du client</th>
        <th class="border-top-0">CNI du client</th>
        <th class="border-top-0">Actions</th>
        </tr>';
    }
    if (isset($_POST['query'])) {
        $search = $_POST['query'];
        if ($_SESSION['Role'] != "admin") {
            $sql = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin,A.lieu_agence
            FROM  facture_client AS FC
            LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
            LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
            LEFT JOIN agence AS A ON A.id_agence = C.id_agence
            WHERE C.type_location = 'Pack'
            AND FC.id_client = C.id_client
            AND (id_facture LIKE ('%" . $search . "%')
                     OR date_facture LIKE ('%" . $search . "%')
                     OR FC.id_contrat LIKE ('%" . $search . "%')
                     OR date_debut LIKE ('%" . $search . "%')
                     OR lieu_agence LIKE ('%" . $search . "%')
                     OR nom LIKE ('%" . $search . "%') )";
        } else {
            $sql = "SELECT FC.id_facture,FC.id_client,FC.date_facture,FC.id_contrat,C.date_debut,CL.id_client,CL.nom,CL.cin
            FROM  facture_client AS FC
            LEFT JOIN contrat_client AS C ON C.id_contrat =FC.id_contrat
            LEFT JOIN client AS CL ON FC.id_client =CL.id_client 
            WHERE C.type_location = 'Pack'
            AND FC.id_client = C.id_client
            AND FC.id_agence =   $id_agence 
            AND (id_facture LIKE ('%" . $search . "%')
                     OR date_facture LIKE ('%" . $search . "%')
                     OR FC.id_contrat LIKE ('%" . $search . "%')
                     OR date_debut LIKE ('%" . $search . "%')
                     OR nom LIKE ('%" . $search . "%') )";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($_SESSION['Role'] != "admin") {
                    $value .= '
                    <tr>
                    <td class="border-top-0">' . $row['id_facture'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                    <td class="border-top-0">' . $row['lieu_agence'] . '</td>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                    <td class="border-top-0">' . $row['nom'] . '</td>
                    <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
                } else {
                    $value .= '
                    <tr>
                    <td class="border-top-0">' . $row['id_facture'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_facture'])) . '</td>
                    <td class="border-top-0">' . $row['id_contrat'] . '</td>
                    <td class="border-top-0">' . date('d-m-Y', strtotime($row['date_debut'])) . '</td>
                    <td class="border-top-0">' . $row['nom'] . '</td>
                    <td class="border-top-0"><img width="50px" src="uploads/' . $row["cin"] . '"></td>';
                }
                if ($_SESSION['Role'] != "superadmin") {
                    $value .= '<td class="border-top-0">
                        <button type="button" title="Télécharger la facture" class="btn waves-effect waves-light btn-outline-dark" style="width:55px; height:45px;" id="btn-id-client-facture" data-id4=' . $row['id_facture'] . '><i class="fas fa-list-alt"></i></i></button>
                    </td>';
                }
                $value .= '</tr>';
            }
            $value .= '</table>';
            echo $value;
        } else {
            echo "<h4>Aucune donnée correspond à votre recherche!</h4>";
        }
    } else {
        display_facture_pack();
    }
}