<?php
    session_start();
    include "../BDD.php";

    if($_SESSION['Auth']['modeAgence'] == 0){
        $query ="
        SELECT DISTINCT `Clients et Prospects`.`CLT-NumID` AS ExpertNumID, `Clients et Prospects`.`CLT-Nom` AS ExpertNom, `Clients et Prospects`.`CLT-Prénom` AS ExpertPrénom, Relations_1.`REL-Nom` AS LienExpertClient, `Clients et Prospects_1`.`CLT-Nom` AS ClientNom, `Clients et Prospects_1`.`CLT-Prénom` AS ClientPrénom, Professions.`PRO-Nom` AS ClientProfession, `Clients et Prospects_1`.`CLT-Ville` AS ClientVille, `Type Client`.`TYP-Nom`, Conseillers.`CON-Nom`, Conseillers.`CON-Prénom`, Conseillers.`CON-NumORIAS`
        FROM Conseillers INNER JOIN (`Type Client` INNER JOIN (Professions RIGHT JOIN (`Clients et Prospects` INNER JOIN (Relations AS Relations_1 INNER JOIN (`Clients et Prospects` AS `Clients et Prospects_1` INNER JOIN `Relations par personne` AS `Relations par personne_1` ON `Clients et Prospects_1`.`CLT-NumID` = `Relations par personne_1`.`R/P-NumReco`) ON Relations_1.`REL-Num` = `Relations par personne_1`.`R/P-Type`) ON `Clients et Prospects`.`CLT-NumID` = `Relations par personne_1`.`R/P-NumApporteur`) ON Professions.`PRO-NumID` = `Clients et Prospects_1`.`CLT-Profession`) ON `Type Client`.`TYP-NumID` = `Clients et Prospects_1`.`CLT-Type`) ON Conseillers.`CON-NumID` = `Clients et Prospects_1`.`CLT-Conseiller`
        WHERE (((Relations_1.`REL-Nom`)='est expert comptable de') AND ((Conseillers.`CON-NumORIAS`) Like ".$_SESSION['Auth']['orias']."))
        ORDER BY `ExpertNom`;";
    } else {
        $query ="
        SELECT DISTINCT `Clients et Prospects`.`CLT-NumID` AS ExpertNumID, `Clients et Prospects`.`CLT-Nom` AS ExpertNom, `Clients et Prospects`.`CLT-Prénom` AS ExpertPrénom, Relations_1.`REL-Nom` AS LienExpertClient, `Clients et Prospects_1`.`CLT-Nom` AS ClientNom, `Clients et Prospects_1`.`CLT-Prénom` AS ClientPrénom, Professions.`PRO-Nom` AS ClientProfession, `Clients et Prospects_1`.`CLT-Ville` AS ClientVille, `Type Client`.`TYP-Nom`, Conseillers.`CON-Nom`, Conseillers.`CON-Prénom`, Conseillers.`CON-NumORIAS`
        FROM Conseillers INNER JOIN (`Type Client` INNER JOIN (Professions RIGHT JOIN (`Clients et Prospects` INNER JOIN (Relations AS Relations_1 INNER JOIN (`Clients et Prospects` AS `Clients et Prospects_1` INNER JOIN `Relations par personne` AS `Relations par personne_1` ON `Clients et Prospects_1`.`CLT-NumID` = `Relations par personne_1`.`R/P-NumReco`) ON Relations_1.`REL-Num` = `Relations par personne_1`.`R/P-Type`) ON `Clients et Prospects`.`CLT-NumID` = `Relations par personne_1`.`R/P-NumApporteur`) ON Professions.`PRO-NumID` = `Clients et Prospects_1`.`CLT-Profession`) ON `Type Client`.`TYP-NumID` = `Clients et Prospects_1`.`CLT-Type`) ON Conseillers.`CON-NumID` = `Clients et Prospects_1`.`CLT-Conseiller`
        WHERE (((Relations_1.`REL-Nom`)='est expert comptable de'))
        ORDER BY `ExpertNom`;";
    }

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $liste = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>
        <div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
        <div style='position:absolute;top:10;left:0'><h3>Liste des Clients par Expert-comptables</h3></div>";

        $tab = array();
        $i = 78;
        foreach ($liste as $l) {
            if($i > 1000){
                $content.=" </span></page><page backright='10mm'><span style='font-size:12px'>";
                $i = 78;
            }
            if(!in_array($l['ExpertNumID'],$tab)){
                array_push($tab,$l['ExpertNumID']);
                $content.="
                <div style='position:absolute;top:".$i.";left:0;width:100%'><hr/></div>
                <div style='position:absolute;top:".$i.";left:0'><h4>".$l['ExpertNom']." ".$l['ExpertPrénom']."</h4></div>
                ";
                $i = $i + 40;
            }
            
            $content.="
            <span style='font-size:11px'><i>
            <span style='color:#462E01'>
           <div style='position:absolute;top:".$i.";left:0'>".$l['LienExpertClient']."</div>
        <div style='position:absolute;top:".$i.";left:130'>".$l['ClientNom']." ".$l['ClientPrénom']."</div>
        <div style='position:absolute;top:".$i.";left:315'>".mb_strimwidth($l['ClientProfession'], 0, 26, "...")."</div>";
        if(ctype_upper(str_replace(' ', '',$l['ClientVille']))){
            $content.="<div style='position:absolute;top:".$i.";left:460'>".mb_strimwidth($l['ClientVille'], 0, 15, "...")."</div>";
        } else {
            $content.="<div style='position:absolute;top:".$i.";left:460'>".mb_strimwidth($l['ClientVille'], 0, 20, "...")."</div>";
        }
        //$i = $i + 15;
        
        $content.="
        <span style='color:#856D4D;'>
        <div style='position:absolute;top:".$i.";left:575'>".$l['TYP-Nom']." ".$l['CON-Nom']." ".$l['CON-Prénom']."</div>
        </span>
            </span>
            </i></span>
            ";
            $i = $i + 17;
        }

    $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('ListeClientsExperts.pdf');


?>