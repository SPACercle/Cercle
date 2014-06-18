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

    $content="<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:0;left:0'><img style='width:250px;height:48px;' src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:-;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
		<div style='position:absolute;top:83;left:20'><span>".$res2[0]['CON-Adresse']."</span></div>
		<div style='position:absolute;top:99;left:20'><span>".$res2[0]['CON-Adresse2']."</span></div>
		<div style='position:absolute;top:114;left:20'><span>".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div>
    </page_header>

    <span style='font-size:12px'>
    <b><div style='position:absolute;top:312;left:20'><span>Je Soussigné(e) ".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']."</span></div></b>
	<div style='position:absolute;top:342;left:45'><span>Demeurant au ".$res2[0]['CLT-AdressePro']." ".$res2[0]['CLT-CodePostalPro']." ".$res2[0]['CLT-VillePro']."</span></div>
	<div style='position:absolute;top:365;left:45'><span>Né(e) le ".date('d/m/Y',strtotime($res2[0]['CLT-DateNaissance']))."</span></div>
	<div style='position:absolute;top:422;left:20'><span>Donne par la présente, mandat conformément aux articles 1984 et suivants du Code civil,<br/><br/>
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;au cabinet ".$res2[0]['CON-Société']."</b></span></div>

	<div style='position:absolute;top:507;left:20'><span>Afin de collecter pour mon compte, directement auprès de mes employeurs, organismes de retraite (CNAV, RSI, ARRCO, AGIRC, ....), entreprises d'assurances, et plus généralement, à intervenir auprès de tout organisme nécessaire à l'élaboration de mon Audit Social, Fiscal ou Patrimonial et en particulier : </span></div>

	<div style='position:absolute;top:578;left:50'><span>- recevoir toute correspondance en mon nom et adresser tout document nécessitant mon accord et/ou ma signature,<br/>- adresser toute réponse aux organismes précités, et <br/>- fournir toute information dans le but d'étudier ma situation.</span></div>

	<div style='position:absolute;top:660;left:20'><span>Le présent mandat prend effet à compter de ce jour pour une durée indéterminée. Il peut être révoqué par lettre recommandée avec AR, à tout moment par l'une ou l'autre des parties moyennant un délai de préavis de 1 mois</span></div>

	<div style='position:absolute;top:739;left:20'><span>Fait en 2 exemplaires originaux à ".$res2[0]['CLT-VillePro'].", le ".$date."</span></div>
	<div style='position:absolute;top:205;left:250;border:1px solid black;padding:5px;'><span><h4><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mandat Administratif<br/>Audit Social, Fiscal ou Patrimonial</i></h4></span></div>
	<div style='position:absolute;top:798;left:450'><span>".$res2[0]['CON-Société']."</span></div>
	<div style='position:absolute;top:818;left:430'><span>Représentée par ".$res2[0]['CON-Prénom']." ".$res2[0]['CON-Nom']."</span></div>

	<div style='position:absolute;top:818;left:143'><span>".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']."</span></div>
	<div style='position:absolute;top:774;left:480'><span>Le Mandataire</span></div>
	<div style='position:absolute;top:798;left:182'><span>Le Mandant</span></div>

	<div style='position:absolute;top:898;left:137'><span>Signature précédée de la mention</span></div>
	<div style='position:absolute;top:918;left:137'><span>Lu et Approuvé, bon pour Mandat</span></div>
	<div style='position:absolute;top:899;left:427'><span>Signature précédée de la mention</span></div>
	<div style='position:absolute;top:917;left:412'><span>Lu et Approuvé, bon pour Acceptation de Mandat</span></div>
	<i><div style='position:absolute;top:975;left:40'><span>Loi du 6 janvier 1978 : Le(s) signataire(s) peut (peuvent) demander communication et rectification de toute information le concernant.</span></div></i>
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
    $html2pdf->Output('Mandat.pdf');


?>