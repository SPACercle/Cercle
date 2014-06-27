<?php
    session_start();
    include "../BDD.php";
    include "../Auth.php";

    extract($_GET);

    $query = "
    SELECT `Codes Compagnies`.`COD-NumID`, `Codes Compagnies`.`COD-NumConseiller`, Compagnies.`CIE-NumID`, `Codes Compagnies`.`COD-NomCodeMere`, Compagnies.`CIE-Nom`, `Codes Compagnies`.`COD-Détail`, `Codes Compagnies`.`COD-NumCie`, `Codes Compagnies`.`COD-Identifiant`, `Codes Compagnies`.`COD-Code`, `Codes Compagnies`.`COD-TypeCode`, `Codes Compagnies`.`COD-CodeMere`, `Codes Compagnies`.`COD-MP`, `Codes Compagnies`.`COD-MPDir`, `Codes Compagnies`.`COD-Transféré`, `visualisation portefeuilles`.`VIS-NumUtilisateur`, `departements et regions`.`DPT-Nom`, `departements et regions`.`DPT-Région`, `visualisation portefeuilles`.`VIS-NumORIAS`, `visualisation portefeuilles`.`VIS-NumID`, Conseillers.`CON-NumID`, Conseillers.`CON-Couleur`, Conseillers.`CON-Nom`, Conseillers.`CON-Prénom`, Conseillers.`CON-Société`, Conseillers.`CON-NumRCS`, Conseillers.`CON-RCSVille`, Conseillers.`CON-Logo`, Conseillers.`CON-Tel`, Conseillers.`CON-Fax`, Conseillers.`CON-Internet`, Conseillers.`CON-Adresse`, Conseillers.`CON-Adresse2`, Conseillers.`CON-CP`, Conseillers.`CON-VIlle`, Conseillers.`CON-APE`, Conseillers.`CON-CapitalSocial`, Compagnies.`CIE-NumID`
    FROM `visualisation portefeuilles` INNER JOIN ((Conseillers INNER JOIN (Compagnies INNER JOIN `Codes Compagnies` ON Compagnies.`CIE-NumID` = `Codes Compagnies`.`COD-NumCie`) ON Conseillers.`CON-NumID` = `Codes Compagnies`.`COD-NumConseiller`) LEFT JOIN `departements et regions` ON Conseillers.`CON-DptRattachement` = `departements et regions`.`DPT-Num`) ON `visualisation portefeuilles`.`VIS-NumORIAS` = Conseillers.`CON-NumORIAS`
    WHERE (((`visualisation portefeuilles`.`VIS-NumUtilisateur`)=".$_SESSION['Auth']['id'].") AND ((Compagnies.`CIE-NumID`) Like ".$idComp." ";
    if(Auth::getInfo('modeAgence') != 1){
        $query.="AND `visualisation portefeuilles`.`VIS-NumORIAS`=".$_SESSION['Auth']['orias']."";
    }
    $query.="))
    ORDER BY `Codes Compagnies`.`COD-NomCodeMere`, Compagnies.`CIE-Nom`, Conseillers.`CON-NumID` ;
    ";

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $res = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>";

    $i = 22;
    $tab = array();
    foreach ($res as $r) {
        if(!in_array($r['CON-NumID'],$tab)){
            $i = 22;
            if(sizeof($tab) > 0){
                $content.="
                </span>
                </page>
                <page backright='10mm'>
                <span style='font-size:12px'>";
            }
            $content.="
            <div style='position:absolute;top:".$i.";left:20'><h3>Codes Courtage de ".$r['CON-Prénom']." ".$r['CON-Nom']."</h3></div>";
            $content.="
            <div style='position:absolute;top:".($i+20).";left:600'><i>".date("d/m/Y H:i")."</i></div>";
            $i = $i + 63;
        } else {
            $i = $i + 20;
        }
        array_push($tab,$r['CON-NumID']);
        $content.="
        <span style='color:red;'><u>
        <div style='position:absolute;top:".($i+11).";left:550'> Mot Passe </div>";
        $i = $i + 7;
        $content.="
        <div style='position:absolute;top:".$i.";left:30;'><b>".$r['COD-NomCodeMere']."</b></div>";
        $i = $i + 4;
        $content.="
        <div style='position:absolute;top:".$i.";left:470'> Identifiant</div>
        <div style='position:absolute;top:".$i.";left:380'>Code Courtier</div>
        <div style='position:absolute;top:".$i.";left:190'>Code Maître</div>
        <div style='position:absolute;top:".$i.";left:290'> Type</div>";
        $i = $i + 2;
        $content.="
        <div style='position:absolute;top:".($i-2).";left:650'>MP Dirigeant</div></u></span>";
        $i = $i + 23;
        $content.="
        <div style='position:absolute;top:".$i.";left:470'> ".$r['COD-Identifiant']."</div>
        <div style='position:absolute;top:".$i.";left:380'>".$r['COD-Code']."</div>
        <div style='position:absolute;top:".$i.";left:550'> ".$r['COD-MP']."</div>
        <div style='position:absolute;top:".$i.";left:650'> ".$r['COD-MPDir']."</div>
        <div style='position:absolute;top:".$i.";left:57'><b>".$r['CIE-Nom']."</b></div>
        <div style='position:absolute;top:".$i.";left:290'> ".$r['COD-TypeCode']."</div>
        <div style='position:absolute;top:".$i.";left:190'>".$r['COD-CodeMere']."</div>";
        $i = $i + 20;
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