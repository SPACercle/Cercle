<?php
    include "../BDD.php";

    $query ="SELECT con.*, com.`CIE-Nom` FROM `compagnies contacts` con, `compagnies` com WHERE con.`C/C-Num` = ".$_GET['idComp']." AND com.`CIE-NumID` = ".$_GET['idComp']." ORDER BY `C/C-Nom`;";

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $contacts = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:10px'>
        <div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
        <div style='position:absolute;top:18;left:26'><h2>Compagnies Contacts Nationaux</h2></div>

        <div style='position:absolute;top:89;left:30'><h4><u>".$contacts[0]['CIE-Nom']."</u></h4></div>";

        $i = 150;

        foreach ($contacts as $cont) {
            if($i > 1000){
                $content.="</span></page><page backright='10mm'><span style='font-size:10px'>";
                $i = 80;
            }
            $content.="
                <i><span style='color:#17657D;'><b><div style='position:absolute;top:".$i.";left:20'>Nom/Service</div>
                <div style='position:absolute;top:".$i.";left:200'>Prénom</div>
                <div style='position:absolute;top:".$i.";left:280'>TelBureau</div>
                <div style='position:absolute;top:".$i.";left:360'>Mail</div>
                <div style='position:absolute;top:".$i.";left:600'>TelPortable</div></b>";

                $i = $i + 35;

                $content.="
                <b><div style='position:absolute;top:".$i.";left:20'>Fonction</div>
                <div style='position:absolute;top:".$i.";left:100'>Horaires Ouverture</div>
                <div style='position:absolute;top:".$i.";left:250'>Commentaire</div>
                <div style='position:absolute;top:".$i.";left:600'>Fax</div></b></span></i>";

                $i =$i - 20;

                $content.="
                <div style='position:absolute;top:".$i.";left:20'><b>".$cont['C/C-Nom']."</b></div>
                <div style='position:absolute;top:".$i.";left:200'>".$cont['C/C-Prénom']."</div>
                <div style='position:absolute;top:".$i.";left:280'>".$cont['C/C-TelBureau']."</div>
                <div style='position:absolute;top:".$i.";left:360'>".$cont['C/C-Mail']."</div>
                <div style='position:absolute;top:".$i.";left:600'>".$cont['C/C-TelPortable']."</div>";
                $i = $i + 33;
                $content.="
                <div style='position:absolute;top:".$i.";left:20'>".$cont['C/C-Fonction']."</div>
                <div style='position:absolute;top:".$i.";left:100'>".$cont['C/C-HorairesOuverture']."</div>
                <div style='position:absolute;top:".$i.";left:250'>".$cont['C/C-Commentaire']."</div>
                <div style='position:absolute;top:".$i.";left:600'>".$cont['C/C-Fax']."</div>
                <div style='position:absolute;top:".($i+8).";left:18px;width:100%;'><hr/></div>
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
    $html2pdf->Output('ContactCompagnie.pdf');


?>