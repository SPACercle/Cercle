<?php
    session_start();
    include "../BDD.php";

    $query ="
    SELECT DISTINCT Relations.`REL-Nom` AS LienCabinetExpert, `Clients et Prospects`.`CLT-NumID` AS ExpertNumID, `Clients et Prospects`.`CLT-Nom` AS ExpertNom, `Clients et Prospects`.`CLT-Prénom` AS ExpertPrénom, Relations_1.`REL-Nom` AS LienExpertClient, `Clients et Prospects_1`.`CLT-Nom` AS ClientNom, `Clients et Prospects_1`.`CLT-Prénom` AS ClientPrénom, Professions.`PRO-Nom` AS ClientProfession, `Clients et Prospects_1`.`CLT-Ville` AS ClientVille, `Type Client`.`TYP-Nom`, Conseillers.`CON-Nom`, Conseillers.`CON-Prénom`, Conseillers.`CON-NumORIAS`, `Clients et Prospects_2`.`CLT-NumID` AS GroupeNumID, `Clients et Prospects_2`.`CLT-Nom` AS GroupeNom, professions_1.`PRO-Nom`, Relations_2.`REL-Nom`, `Clients et Prospects_3`.`CLT-NumID` AS CabinetNumID, `Clients et Prospects_3`.`CLT-Nom`, professions_1.`PRO-Conseil`, `Clients et Prospects_2`.`CLT-PrsMorale`, `Clients et Prospects_3`.`CLT-PrsMorale`
    FROM ((((`clients et prospects` AS `Clients et Prospects_2` INNER JOIN professions AS professions_1 ON `Clients et Prospects_2`.`CLT-Profession` = professions_1.`PRO-NumID`) INNER JOIN `relations par personne` AS `Relations par personne_2` ON `Clients et Prospects_2`.`CLT-NumID` = `Relations par personne_2`.`R/P-NumApporteur`) INNER JOIN relations AS Relations_2 ON `Relations par personne_2`.`R/P-Type` = Relations_2.`REL-Num`) INNER JOIN `clients et prospects` AS `Clients et Prospects_3` ON `Relations par personne_2`.`R/P-NumReco` = `Clients et Prospects_3`.`CLT-NumID`) INNER JOIN (Conseillers INNER JOIN (`Type Client` INNER JOIN (Professions INNER JOIN ((`Clients et Prospects` INNER JOIN (Relations INNER JOIN `Relations par personne` ON Relations.`REL-Num` = `Relations par personne`.`R/P-Type`) ON `Clients et Prospects`.`CLT-NumID` = `Relations par personne`.`R/P-NumReco`) INNER JOIN (Relations AS Relations_1 INNER JOIN (`Clients et Prospects` AS `Clients et Prospects_1` INNER JOIN `Relations par personne` AS `Relations par personne_1` ON `Clients et Prospects_1`.`CLT-NumID` = `Relations par personne_1`.`R/P-NumReco`) ON Relations_1.`REL-Num` = `Relations par personne_1`.`R/P-Type`) ON `Clients et Prospects`.`CLT-NumID` = `Relations par personne_1`.`R/P-NumApporteur`) ON Professions.`PRO-NumID` = `Clients et Prospects_1`.`CLT-Profession`) ON `Type Client`.`TYP-NumID` = `Clients et Prospects_1`.`CLT-Type`) ON Conseillers.`CON-NumID` = `Clients et Prospects_1`.`CLT-Conseiller`) ON `Clients et Prospects_3`.`CLT-NumID` = `Relations par personne`.`R/P-NumApporteur`
    WHERE (((Relations.`REL-Nom`)='a pour associé(e)') AND ((Relations_1.`REL-Nom`)='est expert comptable de') ";
    if($_SESSION['Auth']['modeAgence'] == 0){
        $query.="AND ((Conseillers.`CON-NumORIAS`) Like ".$_SESSION['Auth']['orias'].") ";
    }
    $query.="AND ((Relations_2.`REL-Nom`)='a pour membre') AND ((professions_1.`PRO-Conseil`)=1) AND ((`Clients et Prospects_2`.`CLT-PrsMorale`)=1) AND ((`Clients et Prospects_3`.`CLT-PrsMorale`)=1));
    ";

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $liste = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>";

    $i = 19;
    $tab_groupe = array();
    $tab_cab = array();
    $tab_exp = array();
    foreach ($liste as $l) {
        if($i > 950){
            $content.=" </span></page><page backright='10mm'><span style='font-size:12px'>";
            $i = 19;
        }
        if(!in_array($l['GroupeNom'],$tab_groupe)){
            $tab_cab = array();
            $tab_exp = array();
            array_push($tab_groupe,$l['GroupeNom']);
            $content.="
            <div style='position:absolute;top:".$i.";left:270'><h2>".$l['GroupeNom']."</h2></div>";
            $i = $i + 59;
        }
        
        if(!in_array($l['CLT-Nom'],$tab_cab)){
            $tab_exp = array();
            array_push($tab_cab,$l['CLT-Nom']);
            $content.="
            <div style='position:absolute;top:".$i.";left:37'><h3><u>".$l['CLT-Nom']."</u></h3></div>";
            $i = $i + 44;
        }
        
        if(!in_array($l['ExpertNom'],$tab_exp)){
            array_push($tab_exp,$l['ExpertNom']);
            $content.="
            <div style='position:absolute;top:".$i.";left:37'><h4>".$l['ExpertNom']." ".$l['ExpertPrénom']."</h4></div>";

            $query2="
            SELECT DISTINCT `Type Responsable`.`R/A-Type`, Conseillers.`CON-Nom`, Conseillers.`CON-Prénom`, `Accords Partenaires`.`ACC-NumPartenaire` AS ExpertNumID
            FROM `Type Responsable` INNER JOIN (Conseillers INNER JOIN `Accords Partenaires` ON Conseillers.`CON-NumID` = `Accords Partenaires`.`ACC-NumConseiller`) ON `Type Responsable`.`R/A-NumID` = `Accords Partenaires`.`ACC-NumType`
            WHERE `ACC-NumPartenaire` = ".$l['ExpertNumID']."
            ORDER BY `Type Responsable`.`R/A-Type` DESC;
            ";
            $pdo->exec("SET NAMES UTF8");
            $res = $pdo->query($query2);
            $titSup = $res->fetchALL(PDO::FETCH_ASSOC);

            if($res->rowCount() > 0){
                $i = $i + 40;
                $content.='
                <span style="color:#685E43;"><i><u><b><div style="position:absolute;top:'.$i.';left:53">Titulaire</div></b></u>
                <div style="position:absolute;top:'.$i.';left:297">'.$titSup[0]['CON-Nom'].'</div>
                <div style="position:absolute;top:'.$i.';left:175">'.$titSup[0]['CON-Prénom'].'</div>';
                $i = $i + 16;       
                $content.='
                <u><b><div style="position:absolute;top:'.$i.';left:53">Suppléant</div></b></u>
                <div style="position:absolute;top:'.$i.';left:297">'.$titSup[1]['CON-Nom'].'</div>
                <div style="position:absolute;top:'.$i.';left:175">'.$titSup[1]['CON-Prénom'].'</div></i></span>
                ';
            } else {
                $i = $i + 20;
            }

            $i = $i + 18;
        }
       
        $content.="
        <i>
        <div style='position:absolute;top:".$i.";left:61'>".$l['LienExpertClient']."</div>
        <div style='position:absolute;top:".$i.";left:200'>".$l['ClientNom']."</div>
        <div style='position:absolute;top:".$i.";left:305'>".$l['ClientPrénom']."</div>
        <div style='position:absolute;top:".$i.";left:427'>".mb_strimwidth($l['ClientProfession'], 0, 30, "...")."</div>
        <div style='position:absolute;top:".$i.";left:600'>".$l['ClientVille']."</div>";
        $i = $i + 15;
        
        $content.="
        <span style='color:#856D4D;'>
        <div style='position:absolute;top:".$i.";left:89'>".$l['TYP-Nom']."</div>
        <div style='position:absolute;top:".$i.";left:207'>".$l['CON-Nom']."</div>
        <div style='position:absolute;top:".$i.";left:325'>".$l['CON-Prénom']."</div>
        </span>
        </i>
        ";
        $i = $i + 20;
    }

    $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('ListeClientsParGroupeCabinet.pdf');


?>