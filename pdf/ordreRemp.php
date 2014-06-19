<?php

	include "../BDD.php";

	$query ="SELECT `Conseillers`.*, `Clients et Prospects`.*, `Civilites`.*
			 FROM `Conseillers` INNER JOIN (`Civilites` INNER JOIN `Clients et Prospects` ON `Civilites`.`CIV-NumID` = `Clients et Prospects`.`CLT-Civilité`) ON `Conseillers`.`CON-NumID` = `Clients et Prospects`.`CLT-Conseiller`
			 WHERE (((`Clients et Prospects`.`CLT-NumID`)=".$_GET['idClient']."));
	";

	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$res2 = $res->fetchALL(PDO::FETCH_ASSOC);

	$logo = explode("\\",$res2[0]['CON-Logo'])[3];

	$tab = explode("/",$_GET['date']);
	switch($tab[1]){
		case 1:
			$mois = "janvier";
			break;
		case 2:
			$mois = "février";
			break;
		case 3:
			$mois = "mars";
			break;
		case 4:
			$mois = "avril";
			break;
		case 5:
			$mois = "mai";
			break;
		case 6:
			$mois = "juin";
			break;
		case 7:
			$mois = "juillet";
			break;
		case 8:
			$mois = "août";
			break;
		case 9:
			$mois = "septembre";
			break;
		case 01:
			$mois = "janvier";
			break;
		case 02:
			$mois = "février";
			break;
		case 03:
			$mois = "mars";
			break;
		case 04:
			$mois = "avril";
			break;
		case 05:
			$mois = "mai";
			break;
		case 06:
			$mois = "juin";
			break;
		case 07:
			$mois = "juillet";
			break;
		case 08:
			$mois = "août";
			break;
		case 09:
			$mois = "septembre";
			break;
		case 10:
			$mois = "octobre";
			break;
		case 11:
			$mois = "novembre";
			break;
		case 12:
			$mois = "décembre";
			break;
	}
	$tab = explode("/",$_GET['date']);
	if(sizeof($tab) > 2){
		$date2 = $tab[1]."/".$tab[0]."/".$tab[2];
		$date = date("d",strtotime($date2))." ".$mois." ".$tab[2];
	} else {
		if(sizeof($tab) == 2){
			$date2 = $tab[1]."/".$tab[0];
			$annee = date("Y");
			$date = date("d",strtotime($date2))." ".$mois." ".$annee;
		}
	}

    $content="<page backright='15mm'>

	<page_header>
		<div style='position:absolute;top:0;left:0'><img style='width:250px;height:48px;' src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:-;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
		<div style='position:absolute;top:83;left:20'><span>".$res2[0]['CON-Adresse']."</span></div>
		<div style='position:absolute;top:99;left:20'><span>".$res2[0]['CON-Adresse2']."</span></div>
		<div style='position:absolute;top:114;left:20'><span>".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div>
    </page_header>

    <span style='font-size:12px'>
    	<div style='position:absolute;top:205;left:267;border:1px solid black;padding:5px;'><i><h4>Ordre Exclusif de Remplacement</h4></i></div>

    	<b><div style='position:absolute;top:292;left:50'>Je Soussigné(e) ".$res2[0]['CIV-Nom']." ".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']."</div></b>

		<div style='position:absolute;top:322;left:75'>Demeurant au ".$res2[0]['CLT-Adresse']." ".$res2[0]['CLT-Code Postal']." ".$res2[0]['CLT-Ville']."</div>

		<div style='position:absolute;top:352;left:75'>Né(e) le ".date('d/m/Y',strtotime($res2[0]['CLT-DateNaissance']))."</div>

		<b><div style='position:absolute;top:407;left:50'>Donne par la présente, ordre exclusif de remplacement à la société de courtage en assurances, Social Concept Développement, pour les polices d'assurances suivantes</div>
		</b>
		<div style='position:absolute;top:473;left:65'>".$_GET['num']."</div>

		<div style='position:absolute;top:597;left:50'>Cet ordre exclusif est accompagné de la dénonciation régulière de la (les) police(s) visée(s) ci-dessus pour sa (leur) date d'échéance annuelle.</div>

		<div style='position:absolute;top:656;left:50'>Le présent ordre annule dans tous ses effets tout ordre qui aurait pu être donné antérieurement concernant la (les) police(s) ci-dessus visée(s).</div>

		<div style='position:absolute;top:718;left:50'>Fait en 2 exemplaires originaux à ".$res2[0]['CLT-Ville'].", le ".$date."</div>

		<div style='position:absolute;top:818;left:435'> ".$res2[0]['CON-Société']."</div>
		<div style='position:absolute;top:842;left:146'>".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']."</div>
		<div style='position:absolute;top:793;left:482'> Le Mandataire</div>
		<div style='position:absolute;top:817;left:191'>Le Mandant</div>
		<div style='position:absolute;top:841;left:470'> ".$res2[0]['CON-Prénom']." ".$res2[0]['CON-Nom']."</div>
		
		<i><div style='position:absolute;top:931;left:154'>Signature précédée de la mention</div>
		<div style='position:absolute;top:947;left:154'>Lu et Approuvé, bon pour Mandat</div>
		<div style='position:absolute;top:931;left:450'> Signature précédée de la mention</div>
		<div style='position:absolute;top:947;left:415'>Lu et Approuvé, bon pour Acceptation de Mandat</div>

		<div style='position:absolute;top:990;left:85'><span style='font-size:10px'>Loi du 6 janvier 1978 : Le(s) signataire(s) peut (peuvent) demander communication et rectification de toute information le concernant.</span></div>
		</i>
	</span>

    <page_footer>
    	<span style='font-size:10px'>
    	<b><div style='position:absolute;top:1015;left:90'><span>Siège Social : ".$res2[0]['CON-Adresse']." ".$res2[0]['CON-Adresse2']." ".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div></b>
		<div style='position:absolute;top:1030;left:40'><span>SARL au Capital de ".$res2[0]['CON-CapitalSocial']." euros inscrite au Registre du commerce et des Sociétés de ".$res2[0]['CON-RCSVille']." sous le N°".$res2[0]['CON-NumRCS']." -  Code APE ".$res2[0]['CON-APE']."</span></div>
		<div style='position:absolute;top:1045;left:110'><span> Téléphone :  ".$res2[0]['CON-Tel']."        Fax : ".$res2[0]['CON-Fax']."       ".$res2[0]['CON-Internet']."</span></div>
		<div style='position:absolute;top:1060;left:65'><span>Immatriculée  à l'ORIAS sous le N° ".$res2[0]['CON-NumORIAS']." www.orias.fr et placée sous le contrôle de l'ACPR - 61 rue Taitbout - 75436 PARIS Cedex 09</span></div>
		<div style='position:absolute;top:1075;left:85'><span>Responsabilité Civile Professionnelle et Garanties Financières conformes aux articles L.530-1 et L.530-2 du Code des Assurances</span></div>
		</span>
    </page_footer>

	</page>";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Mandat Placement.pdf');


?>