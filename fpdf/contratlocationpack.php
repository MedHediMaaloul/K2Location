<?php

if (isset($_GET['id'])){

include("../Gestion_location/inc/connect_db.php");
$id_contrat = $_GET['id'];

    $query = "SELECT CL.nom_entreprise,CL.nom,CL.email,CL.cin,CL.tel,CL.adresse,
              V.type,V.pimm,V.id_voiture,MM.Model,MM.Marque,
              C.id_contrat,C.duree,C.moyen_caution,C.caution,C.cautioncheque,C.NbrekmInclus,C.type_location,C.num_cheque_caution,C.num_cb_caution,C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,C.contratcadre,C.checkkm,
              CM.designation_contrat, CM.num_serie_contrat, 
              CC.designation_composant, CC.num_serie_composant,
              A.lieu_agence
              FROM contrat_client AS C 
              LEFT JOIN materiel_contrat_client AS CM ON CM.id_contrat =C.id_contrat 
              LEFT JOIN composant_materiels_contrat AS CC ON CC.id_contrat =CM.id_contrat
              LEFT JOIN client AS CL ON C.id_client=CL.id_client
              LEFT JOIN voiture AS V ON V.id_voiture=C.id_voiture
              LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
              LEFT JOIN agence as A on C.id_agence=A.id_agence
              WHERE C.type_location = 'Pack'
              AND C.id_client =CL.id_client
              AND C.id_contrat = $id_contrat";

    $result = mysqli_query($conn, $query);
    $list_composant = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $contrat_materiel_id = $row['id_contrat'];
                
                $Conducteur_name = $row['nom'];
                $Entreprise_name = $row['nom_entreprise'];
                if ($Entreprise_name == ""){
                  $contrat_materiel_name = $Conducteur_name;
                }else if($Conducteur_name == ""){
                  $contrat_materiel_name = $Entreprise_name;
                }else{
                  $contrat_materiel_name = $Conducteur_name . " ( " . $Entreprise_name . " ) ";
                }

                $contrat_materiel_mail = $row['email'];
                $contrat_materiel_tel = $row['tel'];
                $contrat_materiel_adresse = $row['adresse'];

                $id_voiture = $row['id_voiture'];
                if ($row['id_voiture'] != 0) {
                    $contrat_materiel_imm = 'Immatriculation :' . $row['pimm'];
                    $contrat_materiel_marque = 'Marque :' . $row['Marque'] . ' ' . $row['Model'];
                } else {
                    $contrat_materiel_marque = "V??hicule : sans voiture";
                    $contrat_materiel_imm = '';
                }
                $Contrat_km = $row['NbrekmInclus'];
                $Contrat_duration = $row['duree'];
                $Lieu_agence = $row['lieu_agence'];

                $contrat_materiel_datedebut = $row['date_debut'];
                $contrat_materiel_datedebut = date("d-m-Y", strtotime($contrat_materiel_datedebut));
                $contrat_materiel_datefin = $row['date_fin'];
                $contrat_materiel_datefin = date("d-m-Y", strtotime($contrat_materiel_datefin));
                $contrat_materiel_prix = $row['prix'];
                $contrat_materiel_prix_ttc = $row['prix'] + ($row['prix'] * 0.2);
               
                $contrat_materiel_mode_paiement =  $row['mode_de_paiement'];

                $Contrat_moyen_caution = $row['moyen_caution'];
                $cautioncb = $row['caution'];
                $cautioncheque = $row['cautioncheque'];
                if ($Contrat_moyen_caution == "Carte bancaire"){
                  $Contrat_caution = $cautioncb;
                }else if($Contrat_moyen_caution == "Cheque"){
                  $Contrat_caution = $cautioncheque;
                }else{
                  $Contrat_caution = $cautioncb + $cautioncheque;
                }
                $Contrat_num_caution_cheque = $row['num_cheque_caution'];
                $Contrat_num_caution_cb = $row['num_cb_caution'];

                $Contrat_cadre = $row['contratcadre'];
                $Check_km = $row['checkkm'];
            }
        } 
        $query1 = " SELECT * FROM composant_materiels_contrat WHERE id_contrat='$id_contrat'";
        $result1 = mysqli_query($conn, $query1);
        
        while ($row = mysqli_fetch_assoc($result1)) {
          if (empty($list_composant)) {
            $list_composant[0][] = $row['designation_composant'];
            $list_composant[1][] = $row['num_serie_composant'];

          } else {
            $list_composant[0][] = $row['designation_composant'];
            $list_composant[1][] = $row['num_serie_composant'];
          }
        }

        $query2 = " SELECT * FROM materiel_contrat_client WHERE id_contrat='$id_contrat'";
        $result2 = mysqli_query($conn, $query2);

        while ($row = mysqli_fetch_assoc($result2)) {
          if (empty($list_materiel)) {
            $list_materiel[0][] = $row['designation_contrat'];
            $list_materiel[1][] = $row['num_serie_contrat'];
          } else {
            $list_materiel[0][] = $row['designation_contrat'];
            $list_materiel[1][] = $row['num_serie_contrat'];
          }
        }
       
require('fpdf.php');
class PDF extends FPDF{
protected $col = 0; // Colonne courante
protected $y0;      // Ordonn??e du d??but des colonnes
function Header()
{
    global $titre;
        $this->SetFont('Arial','B',12);
        $w = $this->GetStringWidth($titre)+20;
        $this->SetX((310-$w)/8);
        $this->Cell($w,35,utf8_decode($titre),0,1,'C',false);
        $this->Ln(-13);
        $this->y0 = $this->GetY(); 
}
function Footer()
{
    // Pied de page
    $this->SetY(-15);
    $texte = "k2 Group SAS au capital de 146.000 euro - RC DIJON:4669B
    7 RUE JEAN BAPTISTE SAY 21800 CHEVIGNY ST SAUVEUR
    Siret: 88236307000013 TVA: FR59882363090 APE: 4669B";
    $this->SetFont('Arial','B',6);
    $this->MultiCell(0,3,utf8_decode($texte),0,'C');
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,0,"Page ".$this->PageNo(),0,0,'R');
  
}
function SetCol($col)
{
    // Positionnement sur une colonne
    $this->col = $col;
    $x = 10 + $col * 50;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}
function AcceptPageBreak()
{
    // M??thode autorisant ou non le saut de page automatique
    if($this->col<3)
    {
        // Passage ?? la colonne suivante
        $this->SetCol($this->col+1);
        // Ordonn??e en haut
        $this->SetY($this->y0);
        // On reste sur la page
        return false;
    }
    else
    {
        // Retour en premi??re colonne
        $this->SetCol(0);
        // Saut de page
        return true;
    }
}
function printTableHeader($header,$w){
	//Couleurs, ??paisseur du trait et police grasse
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0);
	$this->SetFont('Arial','B',9);
  $this->Cell($w[0],7,$header[0],'LRT',0,'C');
  $this->Cell($w[1],7,$header[1],'LRT',0,'C');
  $this->Cell($w[2],7,$header[2],'LT',0,'C');
  $this->Cell($w[3],7,$header[3],'RT',0,'C');
	// for($i=0;$i<count($header);$i++)
	// 	$this->Cell($w[$i],7,$header[$i],'LRT',0,'C');
	$this->Ln();
	//Restauration des couleurs et de la police pour les donn??es du tableau
	$this->SetFillColor(245,245,245);
	$this->SetTextColor(0);
	$this->SetFont('Arial');
 
}
function table($header,$w,$al,$datas){
	//Impression de l'ent??te tableau
	$this->SetLineWidth(.3);
	$this->printTableHeader($header,$w);
 
	$posStartX=$this->getX();	
	$posBeforeX=$posStartX;
 
	$posBeforeY=$this->getY();
	$posAfterY=$posBeforeY;
	$posStartY=$posBeforeY;
 
	//On parcours le tableau des donn??es
	foreach($datas as $row){
		$posBeforeX=$posStartX;
		$posBeforeY=$posAfterY;
 
		//On v??rifie qu'il n'y a pas d??bordement de page.
		$nb=0;
		for($i=0;$i<count($header);$i++){
			$nb=max($nb,$this->NbLines($w[$i],$row[$i]));
		}
		$h=6*$nb;
 
		//Effectue un saut de page si il y a d??bordement
		$resultat = $this->CheckPageBreak($h,$w,$header,$posStartX,$posStartY,$posAfterY);
		if($resultat>0){
			$posAfterY=$resultat;
			$posBeforeY=$resultat;
			$posStartY=$resultat;
		}
 
		//Impression de la ligne
		for($i=0;$i<count($header);$i++){
			$this->MultiCell($w[$i],6,strip_tags($row[$i]),'',$al[$i],false);
			//On enregistre la plus grande hauteur de cellule
			if($posAfterY<$this->getY()){
				$posAfterY=$this->getY();
			}
			$posBeforeX+=$w[$i];
			$this->setXY($posBeforeX,$posBeforeY);
		}
		//Trac?? de la ligne du dessous
		$this->Line($posStartX,$posAfterY,$posBeforeX,$posAfterY);
		$this->setXY($posStartX,$posAfterY);
	}
 
	//Trac?? des colonnes
	$this->PrintCols($w,$posStartX,$posStartY,$posAfterY);
}
function PrintCols($w,$posStartX,$posStartY,$posAfterY){
	$this->Line($posStartX,$posStartY,$posStartX,$posAfterY);
	$colX=$posStartX;
	//On trace la ligne pour chaque colonne
  // $this->Line($w,$posStartY,$w,$posAfterY);
  $this->Line(70,$posStartY,70,$posAfterY);
  $this->Line(120,$posStartY,120,$posAfterY);
  $this->Line(200,$posStartY,200,$posAfterY);
	// foreach($w as $row){
	// 	$colX+=$row;
	// 	$this->Line($colX,$posStartY,$colX,$posAfterY);
	// }
}
function CheckPageBreak($h,$w,$header,$posStartX,$posStartY,$posAfterY){
	//Si la hauteur h provoque un d??bordement, saut de page manuel
	if($this->GetY()+$h>$this->PageBreakTrigger){
		//On imprime les colonnes de la page actuelle
		$this->PrintCols($w,$posStartX,$posStartY,$posAfterY);
		//On ajoute une page
		$this->AddPage();
		//On r??imprime l'ent??te du tableau
		$this->printTableHeader($header,$w);
		//On renvoi la position courante sur la nouvelle page
		return $this->GetY();
	}
	//On a pas effectu?? de saut on revoie 0
	return 0;
}
function NbLines($w,$txt){
  $cw=&$this->CurrentFont['cw'];
  if($w==0)
      $w=$this->w-$this->rMargin-$this->x;
  $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
  $s=str_replace("\r",'',$txt);
  $nb=strlen($s);
  if($nb>0 and $s[$nb-1]=="\n")
      $nb--;
  $sep=-1;
  $i=0;
  $j=0;
  $l=0;
  $nl=1;
  while($i<$nb)
  {
      $c=$s[$i];
      if($c=="\n")
      {
          $i++;
          $sep=-1;
          $j=$i;
          $l=0;
          $nl++;
          continue;
      }
      if($c==' ')
          $sep=$i;
      $l+=$cw[$c];
      if($l>$wmax)
      {
          if($sep==-1)
          {
              if($i==$j)
                  $i++;
          }
          else
              $i=$sep+1;
          $sep=-1;
          $j=$i;
          $l=0;
          $nl++;
      }
      else
          $i++;
  }
  return $nl;
}
function CorpsChapitre($fichier)
{
    // Lecture du fichier texte
    $txt = file_get_contents($fichier);
    $this->Image('logok2.jpg',10,13,20,15);
    // Police
    $this->SetFont('Arial','',5.4);
    // Sortie du texte sur 6 cm de largeur
    $this->MultiCell(47,2.4,utf8_decode($txt));
    $this->Ln();
    // Mention
    $this->SetFont('Arial','B',6);
    $this->Cell(0,"2","Paraphe");
    // Retour en premi??re colonne
    $this->SetCol(0);
}
function AjouterChapitre($num, $titre, $fichier)
{
    // Ajout du chapitre
    $this->AddPage();
    // $this->TitreChapitre($num,$titre);
    $this->CorpsChapitre($fichier);
}
function VerifPage()
{
  if( (($this->GetY())==0) | (($this->GetY())>=240) ) {
    $this->AddPage();
  }
}
}

$pdf = new PDF('P','mm','A4');
// Nouvelle page A4 (incluant ici logo, titre et pied de page)
$pdf->AddPage();
define('EURO',chr(128));
$pdf->SetTitle(utf8_decode("Contrat Pack_N??:".$contrat_materiel_id."_".$contrat_materiel_name));
if (empty($list_composant[0])){
$pdf->Image('logok2.jpg',10,15,20,15);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,4,utf8_decode('CONTRAT DE LOCATION N??'). $contrat_materiel_id,0,2,'',false);
$position=$pdf->getY();

if($pdf->getY()>$position){
  $position=$pdf->getY();
}
$pdf->SetXY(10,$position+2);

// $pdf->SetTextColor(0,0,200);
// $texte = " Voir liste d??taill??e du mat??riel en location sur la fiche de contr??le mat??riel en annexe.";
$materiel = array();
$num_serie = array();
for ($i=0; $i < count($list_materiel[0]); $i++) {
  $materiel[] = $list_materiel[0][$i];
  $num_serie[] = $list_materiel[1][$i];
}
//Tableau
$position=0;
$datas = array();
$datas[] = array("Nom: ".utf8_decode($contrat_materiel_name)."\n"."Mail: ".utf8_decode($contrat_materiel_mail)."\n"."Tel: ".utf8_decode($contrat_materiel_tel)."\n"."Adresse: ".utf8_decode($contrat_materiel_adresse),utf8_decode($contrat_materiel_imm)."\n".utf8_decode($contrat_materiel_marque),
utf8_decode("Nom de Mat??riel:"."\n".implode("\n",$materiel)),utf8_decode("Num de S??rie:"."\n".implode("\n",$num_serie)."\n"." "));
//Tableau contenant les titres des colonnes
$header=array(utf8_decode('INFORMATIONS CLIENT'),utf8_decode('INFORMATIONS V??HICULE'),utf8_decode('                                      INFORMATIONS MAT??RIEL')," ");
//Tableau contenant la largeur des colonnes
$w=array(60,50,50,30);
//Tableau contenant le centrage des colonnes
$al=array('L','L','L','L');
//G??n??ration de la table ?? proprement dite
$pdf->table($header,$w,$al,$datas);
$pdf->VerifPage();
$position=$pdf->getY();
if($pdf->getY()>$position){
  $position=$pdf->getY();
}
$pdf->SetXY(10,$position+10);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,'CONDITIONS PARTICULIERES',0,0,'C');
$pdf->Ln(8);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte1 = "Le locataire reconnait que le mat??riel lou?? a bien un rapport direct avec son activit?? et que ce faisant le code de la consommation ne s'applique pas. Le loueur et le locataire certifient, attestent et conviennent que le mat??riel est livr?? ce jour, qu'il est conforme ?? sa d??signation, aux prescriptions des r??glements d'hygi??ne et de s??curit?? du travail, qu'il est en bon ??tat de fonctionnement sans vice apparent ou cach?? et r??pond aux besoins du locataire, qu'il n'est pas contrefaisant et qu'il est conforme ?? la r??glementation relative ?? la pollution et ?? la protection de l'environnement.";
$pdf->MultiCell(0,5,utf8_decode($texte1));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,'AUTRES INFORMATIONS',0,0);
$pdf->VerifPage();
$pdf->Ln(8);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('??tat du v??hicule:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte2 = "Lors de la remise du v??hicule et lors de sa restitution, une fiche de contr??le de l'??tat du v??hicule sera ??tablie entre le locataire et le loueur. Le v??hicule devra ??tre restitu?? dans le m??me ??tat que lors de sa mise ?? disposition au locataire. Toutes les d??t??riorations constat??es sur le v??hicule seront ?? la charge du locataire et/ou ??tre d??duites en partie ou totalit?? sur le montant de la caution.";
$pdf->MultiCell(0,5,utf8_decode($texte2));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('??tat du mat??riel:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
if($Contrat_cadre == "1"){
  $texte21 = "Lors de la remise du mat??riel et lors de sa restitution, une fiche de contr??le de l'??tat sera ??tablie entre le locataire et le loueur. Le mat??riel devra ??tre restitu?? dans le m??me ??tat que lors de sa mise ?? disposition au locataire. En cas de perte et/ou d??t??rioration de mat??riel lou??, le montant factur?? sera ??gal au prix de vente du ou des articles concern??s.";
}else{
  $texte21 = "Lors de la remise du mat??riel et lors de sa restitution, une fiche de contr??le de l'??tat sera ??tablie entre le locataire et le loueur. Le mat??riel devra ??tre restitu?? dans le m??me ??tat que lors de sa mise ?? disposition au locataire. Toutes les d??t??riorations constat??es sur le mat??riel seront ?? la charge du locataire et/ou ??tre d??duites en partie ou totalit?? sur le montant de la caution.";
}
$pdf->MultiCell(0,5,utf8_decode($texte21));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Dur??e:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->MultiCell(0,5,"Du"." ".$contrat_materiel_datedebut." "."au"." ".$contrat_materiel_datefin);
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Prix de location:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
if ($id_voiture != 0) {
  if ($Check_km == "1"){
    if ($Contrat_duration == "Standard") {
      $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
      " euros. "."\n"."Kilom??trage illimit?? inclus.";
    } else if ($Contrat_duration == "Par Jour") {
        $texte3 = $contrat_materiel_prix. " Euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage illimit?? inclus.";
    } else if ($Contrat_duration == "Par Semaine") {
        $texte3 = $contrat_materiel_prix. " Euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage illimit?? inclus.";
    } else if ($Contrat_duration == "Par Mois") {
        $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage illimit?? inclus.";
    } else if ($Contrat_duration == "LLD") {
        $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage illimit?? inclus.";
    }
  }else{
    if ($Contrat_duration == "Standard") {
      $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
      " euros. "."\n"."Kilom??trage pr??vu ".$Contrat_km." km/mois (tarification du kilom??tre suppl??mentaire 0.12 euros HT).";
    } else if ($Contrat_duration == "Par Jour") {
        $texte3 = $contrat_materiel_prix. " Euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage pr??vu ".$Contrat_km." km/jour (tarification du kilom??tre suppl??mentaire 0.12 euros HT).";
    } else if ($Contrat_duration == "Par Semaine") {
        $texte3 = $contrat_materiel_prix. " Euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage pr??vu ".$Contrat_km." km/semaine (tarification du kilom??tre suppl??mentaire 0.12 euros HT).";
    } else if ($Contrat_duration == "Par Mois") {
        $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage pr??vu ".$Contrat_km." km/mois (tarification du kilom??tre suppl??mentaire 0.12 euros HT).";
    } else if ($Contrat_duration == "LLD") {
        $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage pr??vu ".$Contrat_km." km/mois (tarification du kilom??tre suppl??mentaire 0.12 euros HT).";
    }
  }
}else{
  $texte3 = $contrat_materiel_prix." euros HT par mois auquel se rajouterons le montant de la TVA (20%), soit un prix TTC de " . $contrat_materiel_prix_ttc." euros. "."\n";
}
$pdf->MultiCell(0,5,utf8_decode($texte3));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Mode de paiement:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
if ($Contrat_cadre == "1"){
  $texte4 = "Les paiements sont ?? ??choir.";
  $texte5 = "Le mode de r??glement sera en fonction des termes fix??s sur le bon de commande.";
  $pdf->MultiCell(0,5,utf8_decode($texte4)."\n".utf8_decode($texte5));
}else{
  $texte4 = "Les loyers sont dus ?? date ??chu. Le premier paiement s'effectuera le jour de la mise ?? disposition du mat??riel.";
  if ($contrat_materiel_mode_paiement == "Virements bancaires"){
    $texte5 = "Des Virements bancaires seront effectu??s.";
  } else if ($contrat_materiel_mode_paiement == "Carte bancaire") {
    $texte5 = "Des paiements par carte bancaire seront effectu??s.";
  } else if ($contrat_materiel_mode_paiement == "Pr??l??vements automatiques") {
    $texte5 = "Des pr??l??vements automatiques seront effectu??s.";
  } else if ($contrat_materiel_mode_paiement == "Esp??ces") {
    $texte5 = "Des paiements en esp??ces seront effectu??s.";
  } else {
    $texte5 = "Ch??que";
  }
  $texte51 = "Toute rupture de contrat avec un engagement minimum de 6 mois, engendre des frais de r??siliation ?? hauteur de 30% de la totalit?? des factures restantes.";
  $pdf->MultiCell(0,5,utf8_decode($texte4)."\n".utf8_decode($texte5)."\n".utf8_decode($texte51));
}
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
if ($Contrat_cadre == "1"){
  $pdf->Cell(0,0,utf8_decode('Franchises Applicables:'),0,0);
  $pdf->SetY($pdf->GetY()+2);
  $pdf->SetFont('Arial','',8);
  $pdf->SetTextColor(0);
  $textefranchise = "* Le montant de la franchise en cas de vol exclu la perte de clef, dans ce cas, le montant factur?? sera ??gal ?? la valeur du v??hicule"; 
  $pdf->MultiCell(0,5,utf8_decode("1??re cat??gorie : (Type Berlingo / Kangoo / Jumpy / Trafic) : 1500 ").EURO." maximum / Franchise en cas de vol 2200 ".EURO."*".
  "\n".utf8_decode("2??me cat??gorie : (Type Master / Jumper) : 2500 ").EURO." maximum / Franchise en cas de vol 3000 ".EURO."*".
  "\n".utf8_decode("3??me cat??gorie : (Type Fourgon Nacelle) : 6000 ").EURO." maximum / Franchise en cas de vol 7000 ".EURO."*"."\n".utf8_decode($textefranchise));
  $pdf->SetY($pdf->GetY()+5);
  $pdf->SetFont('Arial','B',7);
  $pdf->VerifPage();
}
$pdf->Cell(0,0,utf8_decode('D??p??t de garantie:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte6 = " ?? titre de d??p??t de garantie pour r??pondre des d??g??ts qui pourraient ??tre caus??s aux mat??riels lou??s. Le remboursement du d??p??t de garantie sera effectu?? au retour du mat??riel si celui-ci n'a pas ??t?? endommag??."; 
if ($Contrat_moyen_caution == "Carte bancaire"){
  $texte61 = utf8_decode("N?? Carte Bancaire de caution : ").$Contrat_num_caution_cb;
} else if ($Contrat_moyen_caution == "Cheque") {
  $texte61 = utf8_decode("N?? Ch??que de caution : ").$Contrat_num_caution_cheque;
} else {
  $texte61 = $cautioncb ." ".chr(128).utf8_decode(" de caution par carte bancaire N?? : ").$Contrat_num_caution_cb."\n".$cautioncheque ." ".chr(128).utf8_decode(" de caution par ch??que N?? : ").$Contrat_num_caution_cheque;
}
$pdf->MultiCell(0,5,utf8_decode("Le locataire verse ?? K2, une somme de ").$Contrat_caution ." ".chr(128).utf8_decode($texte6)."\n".$texte61);
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Autres ??l??ments et accessoires:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte8 = "Le locataire prendra en charge l'ensemble des charges aff??rentes ?? la mise ?? disposition du v??hicule:";
$pdf->Cell(0,5,utf8_decode($texte8));
$pdf->VerifPage();
$pdf->Ln(10);
$pdf->Cell(100, 0,utf8_decode("        - Frais d'entretien(lave glace, liquide de refroidissement, adBlue)."));
$pdf->Ln(3);
$pdf->Cell(74, 0,utf8_decode("        - Les frais de carburant, de stationnement et de contravention."));
$pdf->Ln(10);
$pdf->Cell(80, 0,utf8_decode("La sous-location du v??hicule par le locataire ?? un tiers est exclue."));
$pdf->Ln(10);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Clause en cas de litige:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte8 = "Les parties conviennent express??ment que tout litige pouvant na??tre de l'ex??cution du pr??sent contrat rel??vera de la comp??tence du tribunal de commerce de DIJON. Fait en deux exemplaires originaux remis ?? chacune des parties, A ".$Lieu_agence.", le ";
$pdf->MultiCell(0,5,utf8_decode($texte8).$contrat_materiel_datedebut.".");
$pdf->VerifPage();
$pdf->Ln(10);
$texte9 = "Le locataire soussign?? d??clare accepter toutes les conditions g??n??rales figurant sur les pages suivantes du contrat qui a ??t?? ??tabli en autant d'exemplaires que de parties. Signature du contrat et l'autorisation de pr??l??vement ci-dessous et paraphe de chaque page.";
$pdf->MultiCell(0,5,utf8_decode($texte9));
$pdf->VerifPage();
$pdf->Ln(5);
$Y5 = $pdf->GetY();
$pdf->Line(10, $Y5, 200, $Y5);
$pdf->Line(10, $Y5, 10, $Y5 + 50);
$pdf->Line(100, $Y5, 100, $Y5 + 50);
$pdf->Line(200, $Y5, 200, $Y5 + 50);
$pdf->Line(10, $Y5 + 50, 200, $Y5 + 50);
$pdf->Ln(5);
$y4 = $pdf->GetY();
$x4 = $pdf->GetX();
$texte10 = "             Cachet commercial et signature du LOCATAIRE (client)";
$texte11 = "             pr??c??d??e de la mention manuscrite Bon pour accord";
$texte12 = "Signature du LOUEUR et cachet commercial";
$pdf->Cell($x4 + 100,0,utf8_decode($texte10),0,'C');
$pdf->SetX($pdf->GetX()+110);
$pdf->Cell($x4 + 100,0,utf8_decode($texte12),0,'C');
$pdf->Ln(5);
$pdf->Cell($x4 + 100,0,utf8_decode($texte11),0,'C');
$pdf->Ln(50);
$x5 = $pdf->GetX();
$pdf->Cell(0,0,"                                                                                                               
                                                                                            Paraphe",0);
$titre = "CONDITIONS G??N??RALES DE LOCATION DE MAT??RIEL - K2" ;
$pdf->AjouterChapitre(1,utf8_decode($titre),utf8_decode('conditiongeneral.txt'));
$pdf->Image('logok2.jpg',10,13,20,15);
}

else{

$pdf->Image('logok2.jpg',10,15,20,15);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,4,utf8_decode('CONTRAT DE LOCATION N??'). $contrat_materiel_id,0,2,'',false);
$position=$pdf->getY();

if($pdf->getY()>$position){
  $position=$pdf->getY();
}
$pdf->SetXY(10,$position+2);

// $pdf->SetTextColor(0,0,200);
// $texte = " Voir liste d??taill??e du mat??riel en location sur la fiche de contr??le mat??riel en annexe.";
$materiel = array();
$num_serie = array();
for ($i=0; $i < count($list_materiel[0]); $i++) {
  $materiel[] = $list_materiel[0][$i];
  $num_serie[] = $list_materiel[1][$i];
}
$composant = array();
$num_serie_compo = array();
for ($i=0; $i < count($list_composant[0]); $i++) { 
  $composant[] = $list_composant[0][$i];
  $num_serie_compo[] = $list_composant[1][$i];
}
//Tableau
$position=0;
$datas = array();
// for ($i=0; $i < count($list_materiel[0]); $i++) {
$datas[] = array("Nom: ".utf8_decode($contrat_materiel_name)."\n"."Mail: ".utf8_decode($contrat_materiel_mail)."\n"."Tel: ".utf8_decode($contrat_materiel_tel)."\n"."Adresse: ".utf8_decode($contrat_materiel_adresse),
utf8_decode($contrat_materiel_imm)."\n".utf8_decode($contrat_materiel_marque),
utf8_decode("Nom de Mat??riel:"."\n".implode("\n",$materiel)."\n"."Nom de Composants: "."\n".implode("\n",$composant)),
utf8_decode("Num de S??rie:"."\n".implode("\n",$num_serie)."\n"."Num de S??rie: "."\n".implode("\n",$num_serie_compo)));
//}
//Tableau contenant les titres des colonnes
$header=array(utf8_decode('INFORMATIONS CLIENT'),utf8_decode('INFORMATIONS V??HICULE'),utf8_decode('                                      INFORMATIONS MAT??RIEL')," ");
//Tableau contenant la largeur des colonnes
$w=array(60,50,50,30);
//Tableau contenant le centrage des colonnes
$al=array('L','L','L','L');
//G??n??ration de la table ?? proprement dite
$pdf->table($header,$w,$al,$datas);
$pdf->VerifPage();
if($pdf->getY()>$position){
  $position=$pdf->getY();
}
$pdf->SetXY(10,$position+10);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,'CONDITIONS PARTICULIERES',0,0,'C');
$pdf->Ln(8);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte1 = "Le locataire reconnait que le mat??riel lou?? a bien un rapport direct avec son activit?? et que ce faisant le code de la consommation ne s'applique pas. Le loueur et le locataire certifient, attestent et conviennent que le mat??riel est livr?? ce jour, qu'il est conforme ?? sa d??signation, aux prescriptions des r??glements d'hygi??ne et de s??curit?? du travail, qu'il est en bon ??tat de fonctionnement sans vice apparent ou cach?? et r??pond aux besoins du locataire, qu'il n'est pas contrefaisant et qu'il est conforme ?? la r??glementation relative ?? la pollution et ?? la protection de l'environnement.";
$pdf->MultiCell(0,5,utf8_decode($texte1));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,'AUTRES INFORMATIONS',0,0);
$pdf->VerifPage();
$pdf->Ln(8);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('??tat du v??hicule:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte2 = "Lors de la remise du v??hicule et lors de sa restitution, une fiche de contr??le de l'??tat du v??hicule sera ??tablie entre le locataire et le loueur. Le v??hicule devra ??tre restitu?? dans le m??me ??tat que lors de sa mise ?? disposition au locataire. Toutes les d??t??riorations constat??es sur le v??hicule seront ?? la charge du locataire et/ou ??tre d??duites en partie ou totalit?? sur le montant de la caution.";
$pdf->MultiCell(0,5,utf8_decode($texte2));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('??tat du mat??riel:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
if($Contrat_cadre == "1"){
  $texte21 = "Lors de la remise du mat??riel et lors de sa restitution, une fiche de contr??le de l'??tat sera ??tablie entre le locataire et le loueur. Le mat??riel devra ??tre restitu?? dans le m??me ??tat que lors de sa mise ?? disposition au locataire. En cas de perte et/ou d??t??rioration de mat??riel lou??, le montant factur?? sera ??gal au prix de vente du ou des articles concern??s.";
}else{
  $texte21 = "Lors de la remise du mat??riel et lors de sa restitution, une fiche de contr??le de l'??tat sera ??tablie entre le locataire et le loueur. Le mat??riel devra ??tre restitu?? dans le m??me ??tat que lors de sa mise ?? disposition au locataire. Toutes les d??t??riorations constat??es sur le mat??riel seront ?? la charge du locataire et/ou ??tre d??duites en partie ou totalit?? sur le montant de la caution.";
}
$pdf->MultiCell(0,5,utf8_decode($texte21));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Dur??e:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->MultiCell(0,5,"Du"." ".$contrat_materiel_datedebut." "."au"." ".$contrat_materiel_datefin);
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Prix de location:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
if ($id_voiture != 0) {
  if ($Check_km == "1"){
    if ($Contrat_duration == "Standard") {
      $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
      " euros. "."\n"."Kilom??trage illimit?? inclus.";
    } else if ($Contrat_duration == "Par Jour") {
        $texte3 = $contrat_materiel_prix. " Euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage illimit?? inclus.";
    } else if ($Contrat_duration == "Par Semaine") {
        $texte3 = $contrat_materiel_prix. " Euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage illimit?? inclus.";
    } else if ($Contrat_duration == "Par Mois") {
        $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage illimit?? inclus.";
    } else if ($Contrat_duration == "LLD") {
        $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage illimit?? inclus.";
    }
  }else{
    if ($Contrat_duration == "Standard") {
      $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
      " euros. "."\n"."Kilom??trage pr??vu ".$Contrat_km." km/mois (tarification du kilom??tre suppl??mentaire 0.12 euros HT).";
    } else if ($Contrat_duration == "Par Jour") {
        $texte3 = $contrat_materiel_prix. " Euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage pr??vu ".$Contrat_km." km/jour (tarification du kilom??tre suppl??mentaire 0.12 euros HT).";
    } else if ($Contrat_duration == "Par Semaine") {
        $texte3 = $contrat_materiel_prix. " Euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage pr??vu ".$Contrat_km." km/semaine (tarification du kilom??tre suppl??mentaire 0.12 euros HT).";
    } else if ($Contrat_duration == "Par Mois") {
        $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage pr??vu ".$Contrat_km." km/mois (tarification du kilom??tre suppl??mentaire 0.12 euros HT).";
    } else if ($Contrat_duration == "LLD") {
        $texte3 = $contrat_materiel_prix. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$contrat_materiel_prix_ttc.
        " euros. "."\n"."Kilom??trage pr??vu ".$Contrat_km." km/mois (tarification du kilom??tre suppl??mentaire 0.12 euros HT).";
    }
  }
}else{
  $texte3 = $contrat_materiel_prix." euros HT par mois auquel se rajouterons le montant de la TVA (20%), soit un prix TTC de " . $contrat_materiel_prix_ttc." euros. "."\n";
}
$pdf->MultiCell(0,5,utf8_decode($texte3));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Mode de paiement:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
if ($Contrat_cadre == "1"){
  $texte4 = "Les paiements sont ?? ??choir.";
  $texte5 = "Le mode de r??glement sera en fonction des termes fix??s sur le bon de commande.";
  $pdf->MultiCell(0,5,utf8_decode($texte4)."\n".utf8_decode($texte5));
}else{
  $texte4 = "Les loyers sont dus ?? date ??chu. Le premier paiement s'effectuera le jour de la mise ?? disposition du mat??riel.";
  if ($contrat_materiel_mode_paiement == "Virements bancaires"){
    $texte5 = "Des Virements bancaires seront effectu??s.";
  } else if ($contrat_materiel_mode_paiement == "Carte bancaire") {
    $texte5 = "Des paiements par carte bancaire seront effectu??s.";
  } else if ($contrat_materiel_mode_paiement == "Pr??l??vements automatiques") {
    $texte5 = "Des pr??l??vements automatiques seront effectu??s.";
  } else if ($contrat_materiel_mode_paiement == "Esp??ces") {
    $texte5 = "Des paiements en esp??ces seront effectu??s.";
  } else {
    $texte5 = "Ch??que";
  }
  $texte51 = "Toute rupture de contrat avec un engagement minimum de 6 mois, engendre des frais de r??siliation ?? hauteur de 30% de la totalit?? des factures restantes.";
  $pdf->MultiCell(0,5,utf8_decode($texte4)."\n".utf8_decode($texte5)."\n".utf8_decode($texte51));
}
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
if ($Contrat_cadre == "1"){
  $pdf->Cell(0,0,utf8_decode('Franchises Applicables:'),0,0);
  $pdf->SetY($pdf->GetY()+2);
  $pdf->SetFont('Arial','',8);
  $pdf->SetTextColor(0);
  $textefranchise = "* Le montant de la franchise en cas de vol exclu la perte de clef, dans ce cas, le montant factur?? sera ??gal ?? la valeur du v??hicule"; 
  $pdf->MultiCell(0,5,utf8_decode("1??re cat??gorie : (Type Berlingo / Kangoo / Jumpy / Trafic) : 1500 ").EURO." maximum / Franchise en cas de vol 2200 ".EURO."*".
  "\n".utf8_decode("2??me cat??gorie : (Type Master / Jumper) : 2500 ").EURO." maximum / Franchise en cas de vol 3000 ".EURO."*".
  "\n".utf8_decode("3??me cat??gorie : (Type Fourgon Nacelle) : 6000 ").EURO." maximum / Franchise en cas de vol 7000 ".EURO."*"."\n".utf8_decode($textefranchise));
  $pdf->SetY($pdf->GetY()+5);
  $pdf->SetFont('Arial','B',7);
  $pdf->VerifPage();
}
$pdf->Cell(0,0,utf8_decode('D??p??t de garantie:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte6 = " ?? titre de d??p??t de garantie pour r??pondre des d??g??ts qui pourraient ??tre caus??s aux mat??riels lou??s. Le remboursement du d??p??t de garantie sera effectu?? au retour du mat??riel si celui-ci n'a pas ??t?? endommag??."; 
if ($Contrat_moyen_caution == "Carte bancaire"){
  $texte61 = utf8_decode("N?? Carte Bancaire de caution : ").$Contrat_num_caution_cb;
} else if ($Contrat_moyen_caution == "Cheque") {
  $texte61 = utf8_decode("N?? Ch??que de caution : ").$Contrat_num_caution_cheque;
} else {
  $texte61 = $cautioncb ." ".chr(128).utf8_decode(" de caution par carte bancaire N?? : ").$Contrat_num_caution_cb."\n".$cautioncheque ." ".chr(128).utf8_decode(" de caution par ch??que N?? : ").$Contrat_num_caution_cheque;
}
$pdf->MultiCell(0,5,utf8_decode("Le locataire verse ?? K2, une somme de ").$Contrat_caution ." ".chr(128).utf8_decode($texte6)."\n".$texte61);
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Autres ??l??ments et accessoires:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte8 = "Le locataire prendra en charge l'ensemble des charges aff??rentes ?? la mise ?? disposition du v??hicule:";
$pdf->Cell(0,5,utf8_decode($texte8));
$pdf->VerifPage();
$pdf->Ln(10);
$pdf->Cell(100, 0,utf8_decode("        - Frais d'entretien(lave glace, liquide de refroidissement, adBlue)."));
$pdf->Ln(3);
$pdf->Cell(74, 0,utf8_decode("        - Les frais de carburant, de stationnement et de contravention."));
$pdf->Ln(10);
$pdf->Cell(80, 0,utf8_decode("La sous-location du v??hicule par le locataire ?? un tiers est exclue."));
$pdf->Ln(10);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Clause en cas de litige:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte8 = "Les parties conviennent express??ment que tout litige pouvant na??tre de l'ex??cution du pr??sent contrat rel??vera de la comp??tence du tribunal de commerce de DIJON. Fait en deux exemplaires originaux remis ?? chacune des parties, A ".$Lieu_agence.", le ";
$pdf->MultiCell(0,5,utf8_decode($texte8).$contrat_materiel_datedebut.".");
$pdf->VerifPage();
$pdf->Ln(10);
$texte9 = "Le locataire soussign?? d??clare accepter toutes les conditions g??n??rales figurant sur les pages suivantes du contrat qui a ??t?? ??tabli en autant d'exemplaires que de parties. Signature du contrat et l'autorisation de pr??l??vement ci-dessous et paraphe de chaque page.";
$pdf->MultiCell(0,5,utf8_decode($texte9));
$pdf->VerifPage();
$pdf->Ln(5);
$Y5 = $pdf->GetY();
$pdf->Line(10, $Y5, 200, $Y5);
$pdf->Line(10, $Y5, 10, $Y5 + 50);
$pdf->Line(100, $Y5, 100, $Y5 + 50);
$pdf->Line(200, $Y5, 200, $Y5 + 50);
$pdf->Line(10, $Y5 + 50, 200, $Y5 + 50);
$pdf->Ln(5);
$y4 = $pdf->GetY();
$x4 = $pdf->GetX();
$texte10 = "             Cachet commercial et signature du LOCATAIRE (client)";
$texte11 = "             pr??c??d??e de la mention manuscrite Bon pour accord";
$texte12 = "Signature du LOUEUR et cachet commercial";
$pdf->Cell($x4 + 100,0,utf8_decode($texte10),0,'C');
$pdf->SetX($pdf->GetX()+110);
$pdf->Cell($x4 + 100,0,utf8_decode($texte12),0,'C');
$pdf->Ln(5);
$pdf->Cell($x4 + 100,0,utf8_decode($texte11),0,'C');
$pdf->Ln(50);
$x5 = $pdf->GetX();
$pdf->Cell(0,0,"                                                                                                               
                                                                                            Paraphe",0);
$titre = "CONDITIONS G??N??RALES DE LOCATION DE MAT??RIEL - K2" ;
$pdf->AjouterChapitre(1,utf8_decode($titre),'conditiongeneral.txt');
$pdf->Image('logok2.jpg',10,13,20,15);
}
$pdf->Output('I',utf8_decode("Contrat Pack_N??:".$contrat_materiel_id."_".$contrat_materiel_name.".pdf"));
  }
else {
  echo "erreur";
} 
?>