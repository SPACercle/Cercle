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
        ORDER BY `CON-NumID`,`COD-NomCodeMere`, `CIE-Nom`;
        ";
    } else {
        if(isset($all)){
            $query = "
            SELECT * FROM `codes compagnies`, `conseillers`, `compagnies`
            WHERE `CON-NumID` = `COD-NumConseiller` AND `COD-NumCie` = `CIE-NumID`
            ORDER BY `CON-NumID`,`COD-NomCodeMere`,`CIE-Nom`;
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
            ORDER BY `CON-NumID`,`COD-NomCodeMere`,`CIE-Nom` ;
            ";
        }
    }

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $res = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page>

    <span style='font-size:9px'>";

    $i = 0;
    $tab = array();
    $tab_nom_mere = array();
    foreach ($res as $r) {
        if($i > 690){
         $content.="
            </span>
            </page>
            <page>
            <span style='font-size:9px'>";
            $i = 22;
        }
        if(!in_array($r['CON-NumID'],$tab)){
            $logo = explode("\\",$r['CON-Logo']);
            $tab_nom_mere = array();
            $i = 22;
            if(sizeof($tab) > 0){
                $content.="
                </span>
                </page>
                <page backright='9mm'>
                <span style='font-size:9px'>";
            }
            if(isset($logo[3])){
                $content.="<div style='position:absolute;top:-10;left:750;'><img src='../img/logos/".$logo[3]."' ALT=''></div>";
            }
            $content.="
            <div style='position:absolute;top:".$i.";left:20'><h3>Codes Courtage de ".$r['CON-Prénom']." ".$r['CON-Nom']."</h3></div>";
            $content.="
            <div style='position:absolute;top:0;left:0'><i>le ".date("d/m/Y à H:i")."</i></div>";
            $i = $i + 35;
        } else {
            //$i = $i + 5;
        }
        array_push($tab,$r['CON-NumID']);
        $i = $i + 7;
        if(!in_array($r['COD-NomCodeMere'],$tab_nom_mere)){
            $i = $i + 15;
            array_push($tab_nom_mere,$r['COD-NomCodeMere']);
            $content.="
            <u><div style='position:absolute;top:".($i-15).";left:0;'><h3>".$r['COD-NomCodeMere']."</h3></div>";
            $i = $i + 15;
            $content.="</u>";
            $i = $i + 5;
        }
        $content.="
        <b>
        <div style='position:absolute;top:".($i+14).";left:220'>Code Courtier : </div>
        <div style='position:absolute;top:".($i+14).";left:840'>Code Maître : </div>
        <div style='position:absolute;top:".($i+14).";left:740'> Type : </div></b>";
        $i = $i + 2;
        $content.="
        <div style='position:absolute;top:".($i+12).";left:980'><b>MP Dirigeant : </b></div>";
        $i = $i + 12;
        $content.="
        <div style='position:absolute;top:".($i).";left:385'><b>Identifiant :</b> ".$r['COD-Identifiant']."</div>
        <div style='position:absolute;top:".$i.";left:290;color:blue;'><b>".$r['COD-Code']."</b></div>
        <div style='position:absolute;top:".($i).";left:620'><b>MDP :</b> ".$r['COD-MP']."</div>
        <div style='position:absolute;top:".($i).";left:1043'> ".$r['COD-MPDir']."</div>";
        if($r['CON-Couleur'] != null){
            $couleur = $r['CON-Couleur'];
        } else {
            $couleur = "white";
        }
        $content.="
        <div style='position:absolute;top:".$i.";left:0'><div style='display:inline;background-color:".$couleur.";border:1px solid black;width:10px;height:10px;'></div><b> ".$r['CIE-Nom']."</b></div>
        <div style='position:absolute;top:".$i.";left:769'> ".$r['COD-TypeCode']."</div>
        <div style='position:absolute;top:".$i.";left:900'>".$r['COD-CodeMere']."</div>";
        //$i = $i + 10;
    }
    $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('L','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Codes.pdf');


?>