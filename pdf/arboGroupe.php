<?php

	include "../BDD.php";

	$query ="SELECT `Statut Professionnel`.`SPR-Nom` AS Type, 
		   `Clients et Prospects`.`CLT-NumID` AS NumID, 
		   `Clients et Prospects`.`CLT-Nom` AS Nom, 
		   `Relations`.`REL-Nom` AS Relation, 
		   `Statut Professionnel_1`.`SPR-Nom` AS SousType, 
		   `Clients et Prospects_1`.`CLT-NumID` AS SousNumID, 
		   `Clients et Prospects_1`.`CLT-Nom` AS SousNom, 
		   Relations.`REL-Sens`
	FROM Relations INNER JOIN (`Statut Professionnel` AS `Statut Professionnel_1` RIGHT JOIN (`Clients et Prospects` AS `Clients et Prospects_1` INNER JOIN ((`Statut Professionnel` INNER JOIN `Clients et Prospects` ON `Statut Professionnel`.`SPR-NumID` = `Clients et Prospects`.`CLT-Statut`) INNER JOIN `Relations par personne` ON `Clients et Prospects`.`CLT-NumID` = `Relations par personne`.`R/P-NumApporteur`) ON `Clients et Prospects_1`.`CLT-NumID` = `Relations par personne`.`R/P-NumReco`) ON `Statut Professionnel_1`.`SPR-NumID` = `Clients et Prospects_1`.`CLT-Statut`) ON `Relations`.`REL-Num` = `Relations par personne`.`R/P-Type` WHERE ((`Clients et Prospects`.`CLT-NumID`=".$_GET['idClient']."));
	";

	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$res2 = $res->fetchALL(PDO::FETCH_ASSOC);


    $content="<page>
	<h1 align='center'>".$res2[0]['Type']." ".$res2[0]['Nom']."</h1>";
	foreach($res2 as $r){
		$content.="<h3>".$r['Relation']."</h3>".$r['SousType']." ".$r['SousNom']."";
	}
	 $content.="</page>";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Arborescence Groupe.pdf');


?>