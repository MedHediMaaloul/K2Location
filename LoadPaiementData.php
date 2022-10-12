<?php
include_once('Gestion_location/inc/functions.php');
$output = '';
$paiement_id = '';
sleep(1);
$getpaimentid = $_POST['paiement_id'];
$sql = "SELECT C.id_contrat,C.type_location,AP.id,AP.contrat_id,AP.date_validation 
FROM contrat AS C 
INNER JOIN archive_paiement AS AP 
on C.id_contrat = AP.contrat_id WHERE AP.id > $getpaimentid  LIMIT 3";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $paiement_id = $row["id"];
        $date_today = strtotime($row["date_validation"]);
        $date_format_fr = date("d-m-Y", $date_today);
        $output .= '  
               <tbody>  
               <tr class="text-center font-weight-bold">  
                    <td><i class="font-20 far fa-credit-card" style="font-size:15px;"></i>  Le paiement du contrat num ' . '' . $row["id_contrat"] . ' de ' . $row["type_location"] . ' est validé le ' . $date_format_fr . ' 
                    </td> 
               </tr></tbody>';
    }
    $output .= '  
               <tbody><tr id="remove_row">  
                    <td><button type="button" name="btn_more" data-vid="' . $paiement_id  . '" id="btn_more" class="btn btn-secondary form-control">Voir plus</button></td>  
               </tr></tbody>  
     ';
    echo $output;
}
