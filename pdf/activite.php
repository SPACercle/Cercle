<?php
    session_start();

    include "../BDD.php";
    include "../Auth.php";

    $query ="
    SELECT `Produits par Clients`.`P/C-DossierConcurrent`, Conseillers.`CON-NumORIAS`, `Clients et Prospects`.`CLT-Nom` AS Nom2, `Clients et Prospects`.`CLT-Prénom` AS Prénom2, `Relations par personne`.`R/P-Type`, Relations.`REL-Nom`, `Clients et Prospects_1`.`CLT-NumID`, `Clients et Prospects_1`.`CLT-Nom`, `Clients et Prospects_1`.`CLT-Prénom`, `Produits par Clients`.`P/C-Type Prescripteur`, `Evenements par Produits`.`E/P-DateSignature`, `Type Produit`.`TPD-Nom`, Compagnies.`CIE-Nom`, Produits.`PDT-Nom`, `Evenements par Produits`.`E/P-MontantPP`, `E/P-NumID`, `P/C-NumID`, `TPD-NumID`
    FROM Conseillers INNER JOIN ((Compagnies INNER JOIN (`Type Produit` INNER JOIN (Produits INNER JOIN (`Clients et Prospects` AS `Clients et Prospects_1` INNER JOIN ((`Clients et Prospects` INNER JOIN `Produits par Clients` ON `Clients et Prospects`.`CLT-NumID` = `Produits par Clients`.`P/C-NumClient`) INNER JOIN (Relations INNER JOIN `Relations par personne` ON Relations.`REL-Num` = `Relations par personne`.`R/P-Type`) ON `Clients et Prospects`.`CLT-NumID` = `Relations par personne`.`R/P-NumApporteur`) ON `Clients et Prospects_1`.`CLT-NumID` = `Relations par personne`.`R/P-NumReco`) ON Produits.`PDT-NumID` = `Produits par Clients`.`P/C-NumProduit`) ON `Type Produit`.`TPD-NumID` = Produits.`PDT-Type`) ON Compagnies.`CIE-NumID` = Produits.`PDT-Cie`) INNER JOIN `Evenements par Produits` ON `Produits par Clients`.`P/C-NumID` = `Evenements par Produits`.`E/P-NumProduitClient`) ON Conseillers.`CON-NumID` = `Clients et Prospects`.`CLT-Conseiller`
    WHERE (((`Produits par Clients`.`P/C-DossierConcurrent`)=0) ";
    if($_SESSION['Auth']['modeAgence'] == 0){
        $query.="AND ((Conseillers.`CON-NumORIAS`) Like ".$_SESSION['Auth']['orias'].") ";
    }
    $query.="
    AND ((`Relations par personne`.`R/P-Type`)=13) AND ((`Evenements par Produits`.`E/P-DateSignature`) Between '".$_POST['date1']."' And '".$_POST['date2']."'))
    ORDER BY `Clients et Prospects_1`.`CLT-Nom`,`P/C-Type Prescripteur`,`TPD-Nom`,`PDT-Nom`,`Nom2`;
    ";

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $activites = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>

    <div style='position:absolute;top:16;left:34'><h4>Production Comptable</h4></div>
    <div style='position:absolute;top:36;left:219'> De ".date("d/m/Y",strtotime($_POST['date1']))."</div>
    <div style='position:absolute;top:36;left:333'> à ".date("d/m/Y",strtotime($_POST['date2']))."</div>
    ";

    $i = 68;
    $tab_nom = array();
    $tab_type = array();
    $tab_produits = array();
    foreach ($activites as $act) {
        if($i > 1000){
            $content.="</span></page><page backright='10mm'><span style='font-size:12px'>";
            $i = 68;
        }
        if(!in_array($act['CLT-Nom'],$tab_nom)){
            $i = $i + 20;
            array_push($tab_nom,$act['CLT-Nom']);
            $tab_type = array();
            $tab_produits = array();
            $content.="
            <div style='position:absolute;top:".$i.";left:38;border:1px solid black;background:#C8AD7F;padding:3px;'><h4 style='margin:0px;'>".$act['CLT-Nom']." ".$act['CLT-Prénom']."</h4></div>";
            $i = $i + 31;
        }
        if(!in_array($act['P/C-Type Prescripteur'],$tab_type)){
            $i = $i + 10;
            array_push($tab_type,$act['P/C-Type Prescripteur']);
            $content.="
            <b><u><div style='position:absolute;top:".$i.";left:49'>".$act['P/C-Type Prescripteur']."</div>";

            $somme2 = 0;
            foreach ($activites as $act2) {
                if($act2['CLT-NumID'] == $act['CLT-NumID'] && $act2['P/C-Type Prescripteur'] == $act['P/C-Type Prescripteur']){
                    $somme2 = $somme2 + $act2['E/P-MontantPP'];
                }
            }

            $content.="
            <div style='position:absolute;top:".$i.";left:200'> $somme2 €</div></u></b>";
            $i = $i + 19;
            $tab_produits = array();
        } else {
             $i = $i + 10;
        }
        if(!in_array($act['TPD-Nom'],$tab_produits)){
            $i1 = $i;
            array_push($tab_produits,$act['TPD-Nom']);
            $content.="
            <span style='color:#685E43;'><b><div style='position:absolute;top:".$i.";left:50'>".$act['TPD-Nom']."</div>";

            $somme1 = 0;
            foreach ($activites as $act2) {
                if($act2['CLT-NumID'] == $act['CLT-NumID'] && $act2['TPD-NumID'] == $act['TPD-NumID'] && $act2['P/C-Type Prescripteur'] == $act['P/C-Type Prescripteur']){
                    $somme1 = $somme1 + $act2['E/P-MontantPP'];
                }
            }

            $content.="
            <div style='position:absolute;top:".($i).";left:200'> ".sprintf('%.2f &euro;',$somme1)."</div></b></span>";
            $i = $i + 16;
        }
        $content.="
        <div style='position:absolute;top:".$i.";left:69'>".mb_strimwidth($act['Nom2']." ".$act['Prénom2'], 0, 20, "...")."</div>
        <div style='position:absolute;top:".$i.";left:250'> ".date("d/m/Y",strtotime($act['E/P-DateSignature']))." ".mb_strimwidth($act['CIE-Nom'], 0, 20, "...")."</div>
        <div style='position:absolute;top:".$i.";left:520'> ".mb_strimwidth($act['PDT-Nom'], 0, 26, "...")."</div>
        <div style='position:absolute;top:".$i.";left:700'> ".sprintf('%.2f &euro;',$act['E/P-MontantPP'])."</div>
        ";
        $i = $i + 7;
    }  
    $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('ActivitesPartenaires.pdf');


?>