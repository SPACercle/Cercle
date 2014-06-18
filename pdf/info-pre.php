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

	$tab = explode("/",$_GET['date1']);
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
	$tab = explode("/",$_GET['date1']);
	if(sizeof($tab) > 2){
		$date2 = $tab[1]."/".$tab[0]."/".$tab[2];
		$date_un = date("d",strtotime($date2))." ".$mois." ".$tab[2];
	} else {
		if(sizeof($tab) == 2){
			$date2 = $tab[1]."/".$tab[0];
			$annee = date("Y");
			$date_un = date("d",strtotime($date2))." ".$mois." ".$annee;
		}
	}

	$tab = explode("/",$_GET['date2']);
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
	$tab = explode("/",$_GET['date2']);
	if(sizeof($tab) > 2){
		$date2 = $tab[1]."/".$tab[0]."/".$tab[2];
		$date_deux = date("d",strtotime($date2))." ".$mois." ".$tab[2];
	} else {
		if(sizeof($tab) == 2){
			$date2 = $tab[1]."/".$tab[0];
			$annee = date("Y");
			$date_deux = date("d",strtotime($date2))." ".$mois." ".$annee;
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

    <span style='font-size:11.5px'>
  		<div style='position:absolute;top:150;left:319;border:1px solid black;padding:5px;'><span><h4>Fiche d'informations</h4></span></div>

		<div style='position:absolute;top:230;left:30'>Les informations ci-après sont délivrées à l’attention de Dr Mohamed Lotfi ABDENNEBI né(e) le 19/12/1956, demeurant au 12, allée des Poiriers 54520 Laxou conf ormément aux dispositions des articles L520-1-II 1°, R520-1 et R520-2 du Code des assurances par Stéphane SAULNIER pour le compte du Cabinet Social Concept Développement.</div>
		
		<div style='position:absolute;top:295;left:29'>I - Références et Coordonnées</div>

		<div style='position:absolute;top:327;left:53'>Informations générales sur notre cabinet</div>

		<div style='position:absolute;top:347;left:30'>Le Cabinet Social Concept Développement est inscrit au Registre du commerce et des Sociétés de Nancy sous le N° 523 922 961 00017 -  Code APE 7022 Z. Son siège social est sis Pôle Technologique Nancy-Brabois 6 allée Pelletier Doisy 54603 VILLERS LES NANCY Cedex. Le Cabinet Social Concept Développement est Immatriculé  à l'ORIAS sous le N° 10057159 en tant que Courtier d'Assurance. Cette immatriculation peut être vérifiée auprès de l'ORIAS sur son site internet www.orias.fr ou par courrier adressé à son attention au 1, rue Jules Lefebvre - 75731 PARIS Cedex 09.</div>

		<div style='position:absolute;top:425;left:53'> Informations complémentaires</div>

		<div style='position:absolute;top:445;left:30'>Notre cabinet ne détient pas directement ou indirectement plus de 10% des droits de vote ou du capital d'une compagnie d’assurance. Parmi nos actionnaires, nous ne comptons aucune compagnie d'assurance détenant directement ou indirectement plus de 10% des droits de vote ou du capital de notre cabinet</div>

		<div style='position:absolute;top:504;left:29'>II- Litiges et Réclamations - Médiation</div>

		<div style='position:absolute;top:528;left:30'>Toutes informations complémentaires concernant les dossiers en cours peuvent être obtenues en adressant directement cette demande au cabinet Social Concept Développement Pôle Technologique Nancy-Brabois 6 allée Pelletier Doisy 54603 VILLERS LES NANCY Cedex. En cas de difficultés rencontrées, vous pouvez notifier par recommandé avec AR au service réclamation du cabinet Social Concept Développement, le motif  de vos réclamations, qui vous répondra dans les plus brefs délais. En cas de désaccord, et si toutes les voies de recours amiable ont été épuisées, l'adhérent peut adresser une réclamation écrite avec le motif du litige à l’autorité de Contrôle  Prudentiel (ACP) dont les coordonnées sont les suivantes : 61, rue Taitbout – 75436 Paris cedex 09. Vous pouvez également demander l'avis d'un médiateur. Les modalités vous seront communiquées, sur simple demande par le Service Réclamation du cabinet Social Concept Développement.</div>

		<div style='position:absolute;top:642;left:29'>III- Analyse du Marché</div>

		<div style='position:absolute;top:666;left:30'>Le Cabinet Social Concept Développement exerce son activité d'intermédiation selon les dispositions prévues à l’article L520-1-II b du code des Assurances. Ainsi, le ou les contrats proposés sont sélectionnés parmi le catalogue produit des organismes assureurs partenaires de notre cabinet, eu égard aux besoins exprimés, à la pertinence des garanties proposées et des conditions tarifaires, sans prétendre à une analyse exhaustive des offres proposées par l'intégralité des entreprises d'assurance présentes sur le marché. Le Cabinet peut communiquer au client qui en fait la demande la liste des entreprises d’assurance avec lesquelles il travaille.</div>

		<div style='position:absolute;top:750;left:26'>Les informations recueillies sont nécessaires au traitement de votre demande en matière d'assurance et peuvent faire l'objet d'un traitement informatique. Le destinataire des données est la société Stratégies &amp; Perspectives d'Avenir. Le fichier est enregistré à la CNIL sous le N° 1525993. Conformément à l'article 23 de la loi Informatique et libertés N° 78-17 du 6 janvier 1978 modifiée en 2004, vous bénéficiez d'un droit d'accès et de rectification aux informations vous concernant, que vous pouvez exercer en vous adressant à Stratégies &amp; perspectives d'Avenir - Pôle technologique Nancy - Brabois    6 allée Pelletier Doisy 54603 VILLERS LES NANCY Cedex</div>
		
		<div style='position:absolute;top:943;left:490'>Stéphane SAULNIER</div>
		<div style='position:absolute;top:943;left:167'>Mohamed Lotfi ABDENNEBI</div>
		<div style='position:absolute;top:922;left:460'> L'intermédiaire en Assurances</div>
		<div style='position:absolute;top:870;left:179'>Le Candidat à l'Assurance</div>
	
		<div style='position:absolute;top:830;left:26'>Fait en 2 exemplaires à Laxou, le 01 janvier 2014 en deux exemplaires, dont un pour Dr Mohamed Lotfi ABDENNEBI qui reconnait l'avoir reçu.</div>
		<div style='position:absolute;top:1107;left:725'>Paraphe</div>
		<div style='position:absolute;top:1088;left:716'>Page 1 sur 1</div>
		<div style='position:absolute;top:1081;left:51'>SARL au Capital de 3774 euros inscrite au Registre du commerce et des Sociétés de Nancy sous le N° 523 922 961 00017 -  Code APE 7022 Z</div>
		<div style='position:absolute;top:1064;left:123'>Siège Social : Pôle Technologique Nancy-Brabois 6 allée Pelletier Doisy 54603 VILLERS LES NANCY Cedex</div>
		<div style='position:absolute;top:1097;left:165'> Téléphone :  03 83 51 32 02        Fax : 03 83 51 32 97       contact@strategies-avenir.com</div>
		<div style='position:absolute;top:1114;left:58'>Immatriculée  à l'ORIAS sous le N° 10057159 www.orias.fr et placée sous le contrôle de l'ACPR - 61 rue Taitbout - 75436 PARIS Cedex 09</div>
		<div style='position:absolute;top:1131;left:76'>Responsabilité Civile Professionnelle et Garanties Financières conformes aux articles L.530-1 et L.530-2 du Code des Assurances</div>
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

	$content.="<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:0;left:0'><img style='width:250px;height:48px;' src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:-;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
		<div style='position:absolute;top:83;left:20'><span>".$res2[0]['CON-Adresse']."</span></div>
		<div style='position:absolute;top:99;left:20'><span>".$res2[0]['CON-Adresse2']."</span></div>
		<div style='position:absolute;top:114;left:20'><span>".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div>
    </page_header>

    <span style='font-size:12px'>
  		
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
    $html2pdf->Output('InfoPre1.pdf');



?>