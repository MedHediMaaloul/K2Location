<?php

if (isset($_GET['id'])){

include("../Gestion_location/inc/connect_db.php");
$id_contrat = $_GET['id'];
$query = "SELECT CL.nom_entreprise,CL.nom, CL.email, CL.tel, CL.adresse, 
      C.id_contrat, C.date_debut, C.date_fin, C.prix,
      C.mode_de_paiement, C.date_prelevement,C.caution,C.cautioncheque,C.moyen_caution, C.num_cheque_caution,C.num_cb_caution,
      CM.designation_contrat, CM.num_serie_contrat, CC.designation_composant, 
      CC.num_serie_composant 
    FROM materiel_contrat_client AS CM 
    LEFT JOIN contrat_client AS C ON CM.id_contrat = C.id_contrat
    LEFT JOIN client AS CL ON CL.id_client = C.id_client 
    LEFT JOIN composant_materiels_contrat AS CC ON CC.id_contrat =CM.id_contrat
    WHERE C.type_location = 'Materiel'
    AND C.id_client =CL.id_client
    AND C.id_contrat = $id_contrat";
$result = mysqli_query($conn, $query);
$list_composant = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $Contrat_number = $row['id_contrat'];
      $Contrat_date_debut = $row['date_debut'];
      $Contrat_date_debut = date("d-m-Y", strtotime($Contrat_date_debut));
      $Contrat_date_fin = $row['date_fin'];
      $Contrat_date_fin = date("d-m-Y", strtotime($Contrat_date_fin));
      $Contrat_price = $row['prix'];
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
      $Contrat_mode_paiement = $row['mode_de_paiement'];

      $Conducteur_name = $row['nom'];
      $Entreprise_name = $row['nom_entreprise'];
      if ($Entreprise_name == ""){
        $Client_name = $Conducteur_name;
      }else if($Conducteur_name == ""){
        $Client_name = $Entreprise_name;
      }else{
        $Client_name = $Conducteur_name . " ( " . $Entreprise_name . " ) ";
      }
      $Client_mail = $row['email'];
      $Client_tel = $row['tel'];
      $Client_adress = $row['adresse'];
      $Materiel_Designation = $row['designation_contrat'];
      $Materiel_num_serie = $row['num_serie_contrat'];
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
     
require('fpdf.php');
class PDF extends FPDF
{
protected $col = 0; // Colonne courante
protected $y0;      // Ordonnée du début des colonnes
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
    // Méthode autorisant ou non le saut de page automatique
    if($this->col<3)
    {
        // Passage à la colonne suivante
        $this->SetCol($this->col+1);
        // Ordonnée en haut
        $this->SetY($this->y0);
        // On reste sur la page
        return false;
    }
    else
    {
        // Retour en première colonne
        $this->SetCol(0);
        // Saut de page
        return true;
    }
}
function printTableHeader($header,$w){
	//Couleurs, épaisseur du trait et police grasse
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0);
	$this->SetFont('Arial','B',9);
  $this->Cell($w[0],7,$header[0],'LRT',0,'C');
  $this->Cell($w[1],7,$header[1],'LT',0,'C');
  $this->Cell($w[2],7,$header[2],'RT',0,'C');
	// for($i=0;$i<count($header);$i++)
	// 	$this->Cell($w[$i],7,$header[$i],'LRT',0,'C');
	$this->Ln();
	//Restauration des couleurs et de la police pour les données du tableau
	$this->SetFillColor(245,245,245);
	$this->SetTextColor(0);
	$this->SetFont('Arial');
 
}
function table($header,$w,$al,$datas){
	//Impression de l'entête tableau
	$this->SetLineWidth(.3);
	$this->printTableHeader($header,$w);
 
	$posStartX=$this->getX();	
	$posBeforeX=$posStartX;
 
	$posBeforeY=$this->getY();
	$posAfterY=$posBeforeY;
	$posStartY=$posBeforeY;
 
	//On parcours le tableau des données
	foreach($datas as $row){
		$posBeforeX=$posStartX;
		$posBeforeY=$posAfterY;
 
		//On vérifie qu'il n'y a pas débordement de page.
		$nb=0;
		for($i=0;$i<count($header);$i++){
			$nb=max($nb,$this->NbLines($w[$i],$row[$i]));
		}
		$h=6*$nb;
 
		//Effectue un saut de page si il y a débordement
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
		//Tracé de la ligne du dessous
		$this->Line($posStartX,$posAfterY,$posBeforeX,$posAfterY);
		$this->setXY($posStartX,$posAfterY);
	}
 
	//Tracé des colonnes
	$this->PrintCols($w,$posStartX,$posStartY,$posAfterY);
}
function PrintCols($w,$posStartX,$posStartY,$posAfterY){
	$this->Line($posStartX,$posStartY,$posStartX,$posAfterY);
	$colX=$posStartX;
	//On trace la ligne pour chaque colonne
  // $this->Line($w,$posStartY,$w,$posAfterY);
  $this->Line(90,$posStartY,90,$posAfterY);
  $this->Line(200,$posStartY,200,$posAfterY);
	// foreach($w as $row){
	// 	$colX+=$row;
	// 	$this->Line($colX,$posStartY,$colX,$posAfterY);
	// }
}
function CheckPageBreak($h,$w,$header,$posStartX,$posStartY,$posAfterY){
	//Si la hauteur h provoque un débordement, saut de page manuel
	if($this->GetY()+$h>$this->PageBreakTrigger){
		//On imprime les colonnes de la page actuelle
		$this->PrintCols($w,$posStartX,$posStartY,$posAfterY);
		//On ajoute une page
		$this->AddPage();
		//On réimprime l'entête du tableau
		$this->printTableHeader($header,$w);
		//On renvoi la position courante sur la nouvelle page
		return $this->GetY();
	}
	//On a pas effectué de saut on revoie 0
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
    // Retour en première colonne
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
$pdf->AddPage();
define('EURO',chr(128));
$pdf->SetTitle(utf8_decode("Contrat Matériel_N°:".$Contrat_number."_".$Client_name));
if(empty($list_composant[0])){

$pdf->Image('logok2.jpg',10,15,20,15);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,4,utf8_decode('CONTRAT DE LOCATION N°'). $Contrat_number,0,2,'',false);

$position=$pdf->getY();

if($pdf->getY()>$position){
  $position=$pdf->getY();
}
$pdf->SetXY(10,$position+2);

//Tableau
$position=0;
$datas = array();
$datas[] = array("Nom: ".$Client_name."\n"."Mail: ".$Client_mail."\n"."Tel: ".$Client_tel."\n"."Adresse: ".utf8_decode($Client_adress),utf8_decode("Nom de Matériel:"."\n".$Materiel_Designation),utf8_decode("Num de Série:"."\n".$Materiel_num_serie)."\n"." ");
//Tableau contenant les titres des colonnes
$header=array(utf8_decode('INFORMATIONS CLIENT'),utf8_decode('                                                         INFORMATIONS MATÉRIEL')," ");
//Tableau contenant la largeur des colonnes
$w=array(80,60,50);
//Tableau contenant le centrage des colonnes
$al=array('L','L','L');
//Génération de la table à proprement dite
$pdf->table($header,$w,$al,$datas);
$pdf->SetFont('Arial','U',4.4);
$pdf->SetY($pdf->GetY()-5);
$pdf->SetX($pdf->GetX()+80);
$link = "./PACKLOCATIONMATERIEL.pdf";
$pdf->Write(0,utf8_decode("Voir liste détaillée du matériel en location sur la fiche de contrôle matériel en annexe."),$link);
$pdf->SetY($pdf->GetY()+10);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,'CONDITIONS PARTICULIERES',0,0,'C');
$pdf->Ln(8);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte1 = "Le locataire reconnait que le matériel loué a bien un rapport direct avec son activité et que ce faisant le code de la consommation ne s'applique pas. Le loueur et le locataire certifient, attestent et conviennent que le matériel est livré ce jour, qu'il est conforme à sa désignation, aux prescriptions des règlements d'hygiène et de sécurité du travail, qu'il est en bon état de fonctionnement sans vice apparent ou caché et répond aux besoins du locataire, qu'il n'est pas contrefaisant et qu'il est conforme à la réglementation relative à la pollution et à la protection de l'environnement.";
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
$pdf->Cell(0,0,utf8_decode('État du matériel:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte2 = "Lors de la remise du matériel et lors de sa restitution, une fiche de contrôle de l'état sera établie entre le locataire et le loueur. Le matériel devra être restitué dans le même état que lors de sa mise à disposition au locataire. Toutes les détériorations constatées sur le matériel seront à la charge du locataire et/ou être déduites en partie ou totalité sur le montant de la caution.";
$pdf->MultiCell(0,5,utf8_decode($texte2));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Durée:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->MultiCell(0,5,"Du"." ".$Contrat_date_debut." "."au"." ".$Contrat_date_fin);
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Prix de location:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$Contrat_price_ttc = $Contrat_price + $Contrat_price* 0.2 ;
$pdf->MultiCell(0,5,$Contrat_price." euros en HT ".$Contrat_price_ttc." euros en TTC.");
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Mode de paiement:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte4 = "Les loyers sont dus à date échu. Le premier paiement s'effectuera le jour de la mise à disposition du matériel.";
if ($Contrat_mode_paiement == "Virements bancaires"){
    $texte5 = "Des Virements bancaires seront effectués.";
  } else if ($Contrat_mode_paiement == "Carte bancaire") {
    $texte5 = "Des paiements par carte bancaire seront effectués.";
  } else if ($Contrat_mode_paiement == "Prélèvements automatiques") {
    $texte5 = "Des prélèvements automatiques seront effectués.";
  } else if ($Contrat_mode_paiement == "Espèces") {
    $texte5 = "Des paiements en espèces seront effectués.";
  } else {
    $texte5 = "Chèque";
  }
$pdf->MultiCell(0,5,utf8_decode($texte4)."\n".utf8_decode($texte5));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Dépôt de garantie:'),0,0);
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte6 = " à titre de dépôt de garantie pour répondre des dégâts qui pourraient être causés aux matériels loués. Le remboursement du dépôt de garantie sera effectué au retour du matériel si celui-ci n'a pas été endommagé."; 
if ($Contrat_moyen_caution == "Carte bancaire"){
  $texte61 = utf8_decode("N° Carte Bancaire de caution : ").$Contrat_num_caution_cb;
} else if ($Contrat_moyen_caution == "Cheque") {
  $texte61 = utf8_decode("N° chèque de caution: ").$Contrat_num_caution_cheque;
} else {
  $texte61 = $cautioncb ." ".chr(128).utf8_decode(" de caution par carte bancaire N° : ").$Contrat_num_caution_cb."\n".$cautioncheque ." ".chr(128).utf8_decode(" de caution par chèque N° : ").$Contrat_num_caution_cheque;
}
$texte7 = "Pour les contrats avec engagement (minimum 6 mois), toute rupture de contrat, engendrera des frais de résiliation à hauteur de 30% de la totalité des factures restantes. ";
$pdf->MultiCell(0,5,utf8_decode("Le locataire verse à K2, une somme de ").$Contrat_caution ." ".chr(128).utf8_decode($texte6)."\n".$texte61."\n".utf8_decode($texte7));
$pdf->Ln(5);
$pdf->VerifPage();
$pdf->Cell(80, 0,utf8_decode("La sous-location du matériel par le locataire à un tiers est exclue ."));
$pdf->Ln(10);
$pdf->VerifPage();
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Clause en cas de litige:'),0,0);
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte8 = "Les parties conviennent expressément que tout litige pouvant naître de l'exécution du présent contrat relèvera de la compétence du tribunal de commerce de DIJON. Fait en deux exemplaires originaux remis à chacune des parties, A CHEVIGNY SAINT SAUVEUR, le ";
$pdf->MultiCell(0,5,utf8_decode($texte8).$Contrat_date_debut.".");
$pdf->Ln(5);
$pdf->VerifPage();
$texte9 = "Le locataire soussigné déclare accepter toutes les conditions générales figurant sur les pages suivantes du contrat qui a été établi en autant d'exemplaires que de parties. Signature du contrat et l'autorisation de prélèvement ci-dessous et paraphe de chaque page.";
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
$texte11 = "             précédée de la mention manuscrite Bon pour accord";
$texte12 = "Signature du LOUEUR et cachet commercial";
$pdf->Cell($x4 + 100,0,utf8_decode($texte10),0,'C');
$pdf->SetX($pdf->GetX()+120);
$pdf->Cell($x4 + 100,0,utf8_decode($texte12),0,'C');
$pdf->Ln(5);
$pdf->Cell($x4 + 100,0,utf8_decode($texte11),0,'C');
$pdf->Ln(50);
$x5 = $pdf->GetX();
$pdf->Cell(0,0,"                                                                                                               
                                                                                            Paraphe",0);
$titre = "CONDITIONS GÉNÉRALES DE LOCATION DE MATÉRIEL - K2" ;
$pdf->AjouterChapitre(1,utf8_decode($titre),utf8_decode('conditiongeneral.txt'));
$pdf->Image('logok2.jpg',10,13,20,15);
}

else{

$pdf->Image('logok2.jpg',10,15,20,15);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,4,utf8_decode('CONTRAT DE LOCATION N°'). $Contrat_number,0,2,'',false);

$position=$pdf->getY();

if($pdf->getY()>$position){
  $position=$pdf->getY();
}
$pdf->SetXY(10,$position+2);

//Tableau
$position=0;
//Création des données qui seront contenues la table
$datas = array();
$composant = array();
$num_serie = array();

for ($i=0; $i < count($list_composant[0]); $i++) {
  $composant[] = $list_composant[0][$i];
  $num_serie[] = $list_composant[1][$i];
}

$datas[] = array("Nom: ".$Client_name."\n"."Mail: ".$Client_mail."\n"."Tel: ".$Client_tel."\n"."Adresse: ".utf8_decode($Client_adress),
utf8_decode("Nom de Matériel:"."\n".$Materiel_Designation."\n"."Nom de Composants: "."\n".implode("\n",$composant)."\n"." "),
utf8_decode("Num de Série:"."\n".$Materiel_num_serie."\n"."Num de Série: "."\n".implode("\n",$num_serie)."\n"." "));

//Tableau contenant les titres des colonnes
$header=array(utf8_decode('INFORMATIONS CLIENT'),utf8_decode('                                                         INFORMATIONS MATÉRIEL')," ");
//Tableau contenant la largeur des colonnes
$w=array(80,60,50);
//Tableau contenant le centrage des colonnes
$al=array('L','L','L');
//Génération de la table à proprement dite
$pdf->table($header,$w,$al,$datas);

if($pdf->getY()>$position){
  $position=$pdf->getY();
}
$pdf->SetFont('Arial','U',4.4);
$pdf->SetY($pdf->GetY()-5);
$pdf->SetX($pdf->GetX()+80);
$link = "./PACKLOCATIONMATERIEL.pdf";
$pdf->Write(0,utf8_decode("Voir liste détaillée du matériel en location sur la fiche de contrôle matériel en annexe."),$link);
$pdf->SetXY(10,$position+10);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,'CONDITIONS PARTICULIERES',0,0,'C');
$pdf->VerifPage();
$pdf->Ln(8);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte1 = "Le locataire reconnait que le matériel loué a bien un rapport direct avec son activité et que ce faisant le code de la consommation ne s'applique pas. Le loueur et le locataire certifient, attestent et conviennent que le matériel est livré ce jour, qu'il est conforme à sa désignation, aux prescriptions des règlements d'hygiène et de sécurité du travail, qu'il est en bon état de fonctionnement sans vice apparent ou caché et répond aux besoins du locataire, qu'il n'est pas contrefaisant et qu'il est conforme à la réglementation relative à la pollution et à la protection de l'environnement.";
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
$pdf->Cell(0,0,utf8_decode('État du matériel:'),0,0);
$pdf->VerifPage();
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte2 = "Lors de la remise du matériel et lors de sa restitution, une fiche de contrôle de l'état sera établie entre le locataire et le loueur. Le matériel devra être restitué dans le même état que lors de sa mise à disposition au locataire. Toutes les détériorations constatées sur le matériel seront à la charge du locataire et/ou être déduites en partie ou totalité sur le montant de la caution.";
$pdf->MultiCell(0,5,utf8_decode($texte2));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Durée:'),0,0);
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->MultiCell(0,5,"Du"." ".$Contrat_date_debut." "."au"." ".$Contrat_date_fin);
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Prix de location:'),0,0);
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$Contrat_price_ttc = $Contrat_price + $Contrat_price* 0.2 ;
$pdf->MultiCell(0,5,$Contrat_price." euros en HT ".$Contrat_price_ttc." euros en TTC.");
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Mode de paiement:'),0,0);
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte4 = "Les loyers sont dus à date échu. Le premier paiement s'effectuera le jour de la mise à disposition du matériel.";
if ($Contrat_mode_paiement == "Virements bancaires"){
    $texte5 = "Des Virements bancaires seront effectués.";
  } else if ($Contrat_mode_paiement == "Carte bancaire") {
    $texte5 = "Des paiements par carte bancaire seront effectués.";
  } else if ($Contrat_mode_paiement == "Prélèvements automatiques") {
    $texte5 = "Des prélèvements automatiques seront effectués.";
  } else if ($Contrat_mode_paiement == "Espèces") {
    $texte5 = "Des paiements en espèces seront effectués.";
  } else {
    $texte5 = "Chèque.";
  }
$pdf->MultiCell(0,5,utf8_decode($texte4)."\n".utf8_decode($texte5));
$pdf->VerifPage();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Dépôt de garantie:'),0,0);
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte6 = " à titre de dépôt de garantie pour répondre des dégâts qui pourraient être causés aux matériels loués. Le remboursement du dépôt de garantie sera effectué au retour du matériel si celui-ci n'a pas été endommagé."; 
if ($Contrat_moyen_caution == "Carte bancaire"){
  $texte61 = utf8_decode("N° Carte Bancaire de caution : ").$Contrat_num_caution_cb;
} else if ($Contrat_moyen_caution == "Cheque") {
  $texte61 = utf8_decode("N° chèque de caution: ").$Contrat_num_caution_cheque;
} else {
  $texte61 = $cautioncb ." ".chr(128).utf8_decode(" de caution par carte bancaire N° : ").$Contrat_num_caution_cb."\n".$cautioncheque ." ".chr(128).utf8_decode(" de caution par chèque N° : ").$Contrat_num_caution_cheque;
}
$texte7 = "Pour les contrats avec engagement (minimum 6 mois), toute rupture de contrat, engendrera des frais de résiliation à hauteur de 30% de la totalité des factures restantes. ";
$pdf->MultiCell(0,5,utf8_decode("Le locataire verse à K2, une somme de ").$Contrat_caution ." ".chr(128).utf8_decode($texte6)."\n".$texte61."\n".utf8_decode($texte7));
$pdf->Ln(5);
$pdf->VerifPage();
$pdf->Cell(80, 0,utf8_decode("La sous-location du matériel par le locataire à un tiers est exclue ."));
$pdf->Ln(10);
$pdf->VerifPage();
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('Clause en cas de litige:'),0,0);
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte8 = "Les parties conviennent expressément que tout litige pouvant naître de l'exécution du présent contrat relèvera de la compétence du tribunal de commerce de DIJON. Fait en deux exemplaires originaux remis à chacune des parties, A CHEVIGNY SAINT SAUVEUR, le ";
$pdf->MultiCell(0,5,utf8_decode($texte8).$Contrat_date_debut.".");
$pdf->Ln(5);
$pdf->VerifPage();
$texte9 = "Le locataire soussigné déclare accepter toutes les conditions générales figurant sur les pages suivantes du contrat qui a été établi en autant d'exemplaires que de parties. Signature du contrat et l'autorisation de prélèvement ci-dessous et paraphe de chaque page.";
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
$texte11 = "             précédée de la mention manuscrite Bon pour accord";
$texte12 = "Signature du LOUEUR et cachet commercial";
$pdf->Cell($x4 + 100,0,utf8_decode($texte10),0,'C');
$pdf->SetX($pdf->GetX()+120);
$pdf->Cell($x4 + 100,0,utf8_decode($texte12),0,'C');
$pdf->Ln(5);
$pdf->Cell($x4 + 100,0,utf8_decode($texte11),0,'C');
$pdf->Ln(50);
$x5 = $pdf->GetX();
$pdf->Cell(0,0,"                                                                                                               
                                                                                            Paraphe",0);
$titre = "CONDITIONS GÉNÉRALES DE LOCATION DE MATÉRIEL - K2" ;
$pdf->AjouterChapitre(1,utf8_decode($titre),'conditiongeneral.txt');
$pdf->Image('logok2.jpg',10,13,20,15);
}
$pdf->Output('I',utf8_decode("Contrat Matériel_N°:".$Contrat_number."_".$Client_name.".pdf"));
  }
else {
  echo "erreur";
} 
?>