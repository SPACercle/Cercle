<?php
    session_start();
    include "../BDD.php";
    include "../Auth.php";

    extract($_GET);

    if(isset($idComp)){
    $query = "
    SELECT conseillers.`CON-NumORIAS`, Compagnies.`CIE-NumID`, conseillers.`CON-NumID`, `type evenements contrat`.`EVE-Nom`, Compagnies.`CIE-Nom`, `type evenements contrat`.`EVE-Nom`, `Type Historique Anomalie`.`HIA-Nom`, `CLT-Nom`, `CLT-Prénom`, `Clients et Prospects`.`CLT-Nom`, `Clients et Prospects`.`CLT-Prénom`, Produits.`PDT-Nom`, `Type Situations Contrats`.`TSC-Nom`, `Anomalies par Produits`.`A/P-NumAnomalie`, `Type Historique Anomalie`.`HIA-Nom`, `Anomalies par Produits`.`A/P-Date`, `Anomalies par Produits`.`A/P-Cloture`, `Anomalies par Produits`.`A/P-DateCloture`, `Anomalies par Produits`.`A/P-Commentaire`, `evenements par produits`.`E/P-MontantPP`, `evenements par produits`.`E/P-MontantPU`, `evenements par produits`.`E/P-AcceptMedicale`, `evenements par produits`.`E/P-DateSignature`, `departements et regions`.`DPT-Nom`, `departements et regions`.`DPT-Région`, conseillers.*,`visualisation portefeuilles`.*,`CLT-NumID`,`HIA-NumID` 
    FROM (`type evenements contrat` INNER JOIN ((`Type Historique Anomalie` INNER JOIN ((`Type Situations Contrats` INNER JOIN (`Clients et Prospects` INNER JOIN ((Compagnies INNER JOIN Produits ON Compagnies.`CIE-NumID` = Produits.`PDT-Cie`) INNER JOIN `Produits par Clients` ON Produits.`PDT-NumID` = `Produits par Clients`.`P/C-NumProduit`) ON `Clients et Prospects`.`CLT-NumID` = `Produits par Clients`.`P/C-NumClient`) ON (`Type Situations Contrats`.`TSC-NumID` = `Produits par Clients`.`P/C-SituationContrat`) AND (`Type Situations Contrats`.`TSC-NumID` = `Produits par Clients`.`P/C-SituationContrat`)) INNER JOIN `Anomalies par Produits` ON `Produits par Clients`.`P/C-NumID` = `Anomalies par Produits`.`A/P-NumDossier`) ON `Type Historique Anomalie`.`HIA-NumID` = `Anomalies par Produits`.`A/P-NumAnomalie`) INNER JOIN `evenements par produits` ON `Produits par Clients`.`P/C-NumID` = `evenements par produits`.`E/P-NumProduitClient`) ON `type evenements contrat`.`EVE-NumID` = `evenements par produits`.`E/P-NumEvenement`) INNER JOIN (conseillers LEFT JOIN `departements et regions` ON conseillers.`CON-DptRattachement` = `departements et regions`.`DPT-Num`) ON `Clients et Prospects`.`CLT-Conseiller` = conseillers.`CON-NumID`
    , `visualisation portefeuilles` WHERE (((`visualisation portefeuilles`.`VIS-NumORIAS`=".$_SESSION['Auth']['orias'].") AND ((Compagnies.`CIE-NumID`) Like ".$idComp.") AND (`visualisation portefeuilles`.`VIS-NumUtilisateur`)=".$_SESSION['Auth']['id'].") AND ((`Anomalies par Produits`.`A/P-DateCloture`) Is Null))";
    if(Auth::getInfo('modeAgence') != 1){
        $query.="AND `CON-NumID`=".$_SESSION['Auth']['id']."";
    }
    $query.="
    ORDER BY `CIE-Nom`, Conseillers.`CON-Nom`,Conseillers.`CON-NumID`;";
    } else {
         $query = "
        SELECT conseillers.`CON-NumORIAS`, Compagnies.`CIE-NumID`, conseillers.`CON-NumID`, `type evenements contrat`.`EVE-Nom`, Compagnies.`CIE-Nom`, `type evenements contrat`.`EVE-Nom`, `Type Historique Anomalie`.`HIA-Nom`, `CLT-Nom`, `CLT-Prénom`, `Clients et Prospects`.`CLT-Nom`, `Clients et Prospects`.`CLT-Prénom`, Produits.`PDT-Nom`, `Type Situations Contrats`.`TSC-Nom`, `Anomalies par Produits`.`A/P-NumAnomalie`, `Type Historique Anomalie`.`HIA-Nom`, `Anomalies par Produits`.`A/P-Date`, `Anomalies par Produits`.`A/P-Cloture`, `Anomalies par Produits`.`A/P-DateCloture`, `Anomalies par Produits`.`A/P-Commentaire`, `evenements par produits`.`E/P-MontantPP`, `evenements par produits`.`E/P-MontantPU`, `evenements par produits`.`E/P-AcceptMedicale`, `evenements par produits`.`E/P-DateSignature`, `departements et regions`.`DPT-Nom`, `departements et regions`.`DPT-Région`, conseillers.*,`visualisation portefeuilles`.*,`CLT-NumID`,`HIA-NumID` 
        FROM (`type evenements contrat` INNER JOIN ((`Type Historique Anomalie` INNER JOIN ((`Type Situations Contrats` INNER JOIN (`Clients et Prospects` INNER JOIN ((Compagnies INNER JOIN Produits ON Compagnies.`CIE-NumID` = Produits.`PDT-Cie`) INNER JOIN `Produits par Clients` ON Produits.`PDT-NumID` = `Produits par Clients`.`P/C-NumProduit`) ON `Clients et Prospects`.`CLT-NumID` = `Produits par Clients`.`P/C-NumClient`) ON (`Type Situations Contrats`.`TSC-NumID` = `Produits par Clients`.`P/C-SituationContrat`) AND (`Type Situations Contrats`.`TSC-NumID` = `Produits par Clients`.`P/C-SituationContrat`)) INNER JOIN `Anomalies par Produits` ON `Produits par Clients`.`P/C-NumID` = `Anomalies par Produits`.`A/P-NumDossier`) ON `Type Historique Anomalie`.`HIA-NumID` = `Anomalies par Produits`.`A/P-NumAnomalie`) INNER JOIN `evenements par produits` ON `Produits par Clients`.`P/C-NumID` = `evenements par produits`.`E/P-NumProduitClient`) ON `type evenements contrat`.`EVE-NumID` = `evenements par produits`.`E/P-NumEvenement`) INNER JOIN (conseillers LEFT JOIN `departements et regions` ON conseillers.`CON-DptRattachement` = `departements et regions`.`DPT-Num`) ON `Clients et Prospects`.`CLT-Conseiller` = conseillers.`CON-NumID`
        , `visualisation portefeuilles` WHERE (((`visualisation portefeuilles`.`VIS-NumORIAS`=".$_SESSION['Auth']['orias'].") AND (`visualisation portefeuilles`.`VIS-NumUtilisateur`)=".$_SESSION['Auth']['id'].") AND ((`Anomalies par Produits`.`A/P-DateCloture`) Is Null))";
        if(Auth::getInfo('modeAgence') != 1){
            $query.="AND `CON-NumID`=".$_SESSION['Auth']['id']."";
        }
        $query.="
        ORDER BY `CIE-Nom`, Conseillers.`CON-Nom`,Conseillers.`CON-NumID`;";
    }

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $res = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>

        <div style='position:absolute;top:26;left:160'><h3 style='color:#BA1419;'>Liste des Dossiers en anomalie Non Cloturés</h3></div>";

        $i = 90;
        $tab_cie = array();
        $tab_cons = array();
        $tab_anom = array();
        $tab_anom2 = array();
        foreach ($res as $r) {
            if($i > 850){
                $content.="</span></page><page backright='10mm'><span style='font-size:12px'>";
                $i=20;
            }
            if(!in_array($r['CIE-NumID'],$tab_cie)){
                $i = $i + 20;
                $content.="
                <div style='position:absolute;top:".$i.";left:20;border:1px solid black;background-color:#BA1419;color:white;padding:7px;'><b>".$r['CIE-Nom']."</b></div>";
                $i = $i + 40;
                $tab_cons = array();
                $tab_anom = array();

            } else {
                $i = $i + 10;
            }
            array_push($tab_cie,$r['CIE-NumID']);
            if(!in_array($r['CON-NumID'],$tab_cons)){
                $i = $i + 10;
                $content.="
                <div style='position:absolute;top:".($i-20).";left:20;color:#BA1419;'><h4>".$r['CON-Nom']." ".$r['CON-Prénom']."</h4></div>
                ";
                array_push($tab_cons,$r['CON-NumID']);
                $content.="
                <i><span style='color:#03495C;'>
                <div style='position:absolute;top:".$i.";left:611'>Montant PP &nbsp;&nbsp;&nbsp;&nbsp; Versement</div></span></i>";
                 $i = $i + 11;
            }
            if(!in_array($r['CLT-NumID'],$tab_anom)){
                array_push($tab_anom,$r['CLT-NumID']);
                $tab_anom2 = array();
                $content.="
                <i><span style='color:#03495C;'>
                <div style='position:absolute;top:".$i.";left:0'><ul><li>".$r['CLT-Nom']." ".$r['CLT-Prénom']."</li></ul></div></span></i>";
                $i = $i + 33;
            }
            if(!in_array($r['A/P-Date'],$tab_anom2)){
                array_push($tab_anom2,$r['A/P-Date']);
                $content.="
                <i><span style='color:#03495C;'>
                <div style='position:absolute;top:".$i.";left:53'><u>".$r['HIA-Nom']."</u></div>

                <div style='position:absolute;top:".$i.";left:267'>".date("d/m/Y",strtotime($r['A/P-Date']))."</div>

                <div style='position:absolute;top:".($i+15).";left:53;'><b>Commentaire : </b>".$r['A/P-Commentaire']."</div>
                </span></i>";
                if(strlen($r['A/P-Commentaire'])>100){
                    $i = $i + 46;
                } else {
                     $i = $i + 31;
                }
            }
            $content.="
            <i><div style='position:absolute;top:".($i+15).";left:300'>".$r['EVE-Nom']."</div>
            <div style='position:absolute;top:".$i.";left:70'>- ".$r['PDT-Nom']."</div>
            <div style='position:absolute;top:".($i+15).";left:76'>".$r['TSC-Nom']."</div>
            <div style='position:absolute;top:".$i.";left:632'>".sprintf('%.2f &euro;',$r['E/P-MontantPP'])."</div>
            <div style='position:absolute;top:".$i.";left:710'>".sprintf('%.2f &euro;',$r['E/P-MontantPU'])."</div>
            <div style='position:absolute;top:".$i.";left:500'>".date("d/m/Y",strtotime($r['E/P-DateSignature']))."</div>
            </i>";
            $i = $i + 25;
        }
        $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Procédure Traitement.pdf');


?>