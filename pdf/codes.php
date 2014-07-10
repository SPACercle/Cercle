<?php
    session_start();
    include "../BDD.php";
    include "../Auth.php";

    extract($_GET);

    //Si on vient du bouton "Mes Codes"
    if(isset($idUser)){
        $query = "
        SELECT * FROM `codes compagnies`, `conseillers`, `compagnies`
        WHERE `COD-NumConseiller` = ".$idUser." AND `CON-NumID` = `COD-NumConseiller` AND `COD-NumCie` = `CIE-NumID`
        ORDER BY `COD-NomCodeMere`, `CIE-Nom`, `CON-NumID`,`Codes Compagnies`.`COD-NomCodeMere`;
        ";
    } else {
        if(isset($all)){
            $query = "
            SELECT * FROM `codes compagnies`, `conseillers`, `compagnies`
            WHERE `CON-NumID` = `COD-NumConseiller` AND `COD-NumCie` = `CIE-NumID`
            ORDER BY `CON-NumID`,`Codes Compagnies`.`COD-NomCodeMere`,`CIE-Nom`;
            ";
        } else {
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
        }
    }

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $res = $res->fetchALL(PDO::FETCH_ASSOC);

    //print_r($res);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>";

    $i = 0;
    $tab = array();
    $tab_nom_mere = array();
    foreach ($res as $r) {
        if($i > 1000){
         $content.="
            </span>
            </page>
            <page backright='10mm'>
            <span style='font-size:12px'>";
            $i = 22;
        }
        if(!in_array($r['CON-NumID'],$tab)){
            $tab_nom_mere = array();
            $i = 22;
            if(sizeof($tab) > 0){
                $content.="
                </span>
                </page>
                <page backright='10mm'>
                <span style='font-size:12px'>";
            }
            $content.="
            <div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
            <div style='position:absolute;top:".$i.";left:20'><h3>Codes Courtage de ".$r['CON-Prénom']." ".$r['CON-Nom']."</h3></div>";
            $content.="
            <div style='position:absolute;top:0;left:0'><i>le ".date("d/m/Y à H:i")."</i></div>";
            $i = $i + 33;
        } else {
            $i = $i + 20;
        }
        array_push($tab,$r['CON-NumID']);
        $content.="
        <span style='color:red;'>";
        $i = $i + 7;
        if(!in_array($r['COD-NomCodeMere'],$tab_nom_mere)){
            $i = $i + 15;
            array_push($tab_nom_mere,$r['COD-NomCodeMere']);
            $content.="
            <u><div style='position:absolute;top:".($i-15).";left:0;'><h3>".$r['COD-NomCodeMere']."</h3></div>";
            $i = $i + 15;
            $content.="<div style='position:absolute;top:".($i-25).";left:0px;width:770px;'><hr/></div></u>";
            $i = $i + 5;
        }
        $content.="
        <b>
        <div style='position:absolute;top:".($i+14).";left:570'>Code Courtier : </div>
        <div style='position:absolute;top:".($i+14).";left:270'>Code Maître : </div>
        <div style='position:absolute;top:".($i+14).";left:470'> Type : </div></b>";
        $i = $i + 2;
        $content.="
        <div style='position:absolute;top:".($i+28).";left:480'><span style='color:red;'><b>MP Dirigeant : </b></span></div></span>";
        $i = $i + 12;
        $content.="
        <div style='position:absolute;top:".($i+15).";left:0'><span style='color:red;'><b>Identifiant :</b></span> ".$r['COD-Identifiant']."</div>
        <div style='position:absolute;top:".$i.";left:660'>".$r['COD-Code']."</div>
        <div style='position:absolute;top:".($i+15).";left:320'><span style='color:red;'><b>MDP :</b></span> ".$r['COD-MP']."</div>
        <div style='position:absolute;top:".($i+15).";left:585'> ".$r['COD-MPDir']."</div>";
        if($r['CON-Couleur'] != null){
            $couleur = $r['CON-Couleur'];
        } else {
            $couleur = "white";
        }
        $content.="
        <div style='position:absolute;top:".$i.";left:0'><div style='display:inline;background-color:".$couleur.";border:1px solid black;width:10px;height:10px;'></div><b> ".$r['CIE-Nom']."</b></div>
        <div style='position:absolute;top:".$i.";left:508'> ".$r['COD-TypeCode']."</div>
        <div style='position:absolute;top:".$i.";left:350'>".$r['COD-CodeMere']."</div>";
        //$i = $i + 10;
    }
    $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Codes.pdf');


?>