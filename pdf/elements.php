<?php

	include "../BDD.php";

	extract($_GET);

	$query ="SELECT cli.*, el.*, con.* FROM `clients et prospects` cli, `elements` el, `conseillers` con WHERE cli.`CLT-NumID`=$idClient AND el.`ELT-NumClt`=$idClient AND cli.`CLT-Conseiller`=con.`CON-NumID`
	";

	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$res2 = $res->fetchALL(PDO::FETCH_ASSOC);

	$logo = explode("\\",$res2[0]['CON-Logo'])[3];

    $content="<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:0;left:0'><img style='width:250px;height:48px;' src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:-;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
		<div style='position:absolute;top:83;left:20'><span>".$res2[0]['CON-Adresse']."</span></div>
		<div style='position:absolute;top:99;left:20'><span>".$res2[0]['CON-Adresse2']."</span></div>
		<div style='position:absolute;top:114;left:20'><span>".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div>
    </page_header>

    <span style='font-size:12px'>
 	
		<div style='position:absolute;top:165;left:259;border:1px solid black;padding:5px;margin:0px'><h4><i>Eléments préparatoires à l'étude de </i></h4></div>
		<div style='position:absolute;top:190;left:311'><h5>Dr Mohamed Lotfi ABDENNEBI</h5></div>

		<span style='font-size:11px'>
		<div style='position:absolute;top:296;left:50'>Conformément à votre demande, voici la liste des éléments nécessaires a fin de mieux préparer votre rencontre avec Stéphane SAULNIER, Gérant de la société Social Concept Développement</div>
		</span>

		<span style='font-size:10px'><i>
		<div style='position:absolute;top:328;left:30'>SARL au Capital de 5100 € inscrite au Registre du commerce et des Sociétés de Nancy sous le N° 523 922 961 00017 -  Code APE 7022 Z</div>

		<div style='position:absolute;top:340;left:30'>Sise Pôle Technologique Nancy-Brabois 6 allée Pelletier Doisy 54603 VILLERS LES NANCY Cedex</div>

		<div style='position:absolute;top:351;left:30'>Immatriculée  à l'ORIAS sous le N° 10057159 www.or ias.fr et placée sous le contrôle de l'ACP - 61 rue Taitbout - 75436 PARIS Cedex 09</div>
		</i></span>

		<div style='position:absolute;top:488;left:450'>Avis Imposition (2042)</div>

		<div style='position:absolute;top:508;left:450'>Déclaration Impôts (2042)</div>

		<div style='position:absolute;top:528;left:450'>Déclaration (2035)</div>

		<div style='position:absolute;top:421;left:31'><b>Relevé Individuel de Situation Retraite</b></div>

		<div style='position:absolute;top:489;left:31'>CRAM Relevé de Carrière </div>
		<div style='position:absolute;top:489;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>
		<div style='position:absolute;top:489;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>

		<div style='position:absolute;top:509;left:31'>MSA Relevé de Carrière</div>
		<div style='position:absolute;top:509;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>
		<div style='position:absolute;top:509;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>

		<div style='position:absolute;top:528;left:31'>ARRCO Relevé de Points</div>
		<div style='position:absolute;top:528;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>
		<div style='position:absolute;top:528;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>

		<div style='position:absolute;top:548;left:31'>AGIRC Relevé de Points</div>
		<div style='position:absolute;top:548;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>
		<div style='position:absolute;top:548;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>

		<div style='position:absolute;top:568;left:31'>IRCANTEC Relevé de Points</div>
		<div style='position:absolute;top:568;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>
		<div style='position:absolute;top:568;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>

		<div style='position:absolute;top:421;left:450'> Dernier Bulletin Salaire (Année N et N-1)</div>

		<div style='position:absolute;top:465;left:450;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Informations Fiscales</b></div>

		<div style='position:absolute;top:394;left:657'> Monsieur</div>

		<div style='position:absolute;top:394;left:716'> Madame</div>

		<div style='position:absolute;top:401;left:31;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Situation Retraite</b></div>

		<div style='position:absolute;top:394;left:310'> Monsieur</div>

		<div style='position:absolute;top:394;left:374'> Madame</div>

		<div style='position:absolute;top:622;left:31'>CARPIMKO Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:642;left:31'>CARMF Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:661;left:31'>CARPV Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:681;left:31'>CAVAMAC Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:701;left:31'>CAVEC Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:721;left:31'>CAVOM Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:740;left:31'>CIPAV Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:760;left:31'>CNBF Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:780;left:31'>CARCDSF Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:799;left:31'>CRN Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:819;left:31'>CAVP Appel de cotisations et Relevé de points</div>

		<div style='position:absolute;top:874;left:31'>RSI  Relevé de Carrière</div>

		<div style='position:absolute;top:894;left:31'>ORGANIC  Relevé de Points</div>

		<div style='position:absolute;top:914;left:31'>AVA  Relevé de Points</div>

		<div style='position:absolute;top:602;left:31;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Professions Libérales</b></div>

		<div style='position:absolute;top:850;left:31;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Indépendants</b></div>

		<div style='position:absolute;top:823;left:450'>Conditions Générales</div>

		<div style='position:absolute;top:843;left:450'>Conditions Particulières</div>

		<div style='position:absolute;top:862;left:450'>Appel de cotisations</div>

		<div style='position:absolute;top:725;left:450'>Tableau des Garanties</div>

		<div style='position:absolute;top:744;left:450'>Appel de cotisations</div>

		<div style='position:absolute;top:598;left:450;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Contrats Retraite</b></div>

		<div style='position:absolute;top:799;left:450;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Contrats Prévoyance</b></div>

		<div style='position:absolute;top:705;left:450;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Contrats Santé</b></div>

		<div style='position:absolute;top:914;left:450;'>Autres Dossiers</div>

		<div style='position:absolute;top:618;left:450'>Conditions Générales</div>

		<div style='position:absolute;top:638;left:450'>Conditions Particulières</div>

		<div style='position:absolute;top:658;left:450'>Appel de cotisations</div>

		<span style='font-size:11px'><i><div style='position:absolute;top:445;left:31'>Si ce document n'est pas disponible uniquement, merci de nous faire parvenir</div></i></span>

		<div style='position:absolute;top:469;left:31;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Salariés</b></div>

		<div style='position:absolute;top:571;left:500'><b><u>Dossiers Complémentaires</u></b></div>

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