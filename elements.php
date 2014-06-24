<?php
/*
Page des gestion des élements préparatoire
*/

include_once "BDD.php";

if(!empty($_POST)){
  extract($_POST);
  if(empty($FichePaieM)){
    $FichePaieM = 0;
  } else {
    $FichePaieM = 1;
  }  
  if(empty($AvisImpots2042M)){
    $AvisImpots2042M = 0;
  } else {
    $AvisImpots2042M = 1;
  } 
  if(empty($Declaration2042M)){
    $Declaration2042M = 0;
  } else {
    $Declaration2042M = 1;
  } 
  if(empty($Declaration2035M)){
    $Declaration2035M = 0;
  } else {
    $Declaration2035M = 1;
  } 
  if(empty($FichePaie)){
    $FichePaie = 0;
  } else {
    $FichePaie = 1;
  } 
  if(empty($AvisImpots2042)){
    $AvisImpots2042 = 0;
  } else {
    $AvisImpots2042 = 1;
  } 
  if(empty($Declaration2042)){
    $Declaration2042 = 0;
  } else {
    $Declaration2042 = 1;
  } 
  if(empty($Declaration2035)){
    $Declaration2035 = 0;
  } else {
    $Declaration2035 = 1;
  } 
  if(empty($RISM)){
    $RISM = 0;
  } else {
    $RISM = 1;
  } 
  if(empty($CRAMM)){
    $CRAMM = 0;
  } else {
    $CRAMM = 1;
  } 
  if(empty($MSAM)){
    $MSAM = 0;
  } else {
    $MSAM = 1;
  } 
  if(empty($ARRCOM)){
    $ARRCOM = 0;
  } else {
    $ARRCOM = 1;
  } 
  if(empty($AGIRCM)){
    $AGIRCM = 0;
  } else {
    $AGIRCM = 1;
  } 
  if(empty($IRCANTECM)){
    $IRCANTECM = 0;
  } else {
    $IRCANTECM = 1;
  } 
  if(empty($RIS)){
    $RIS = 0;
  } else {
    $RIS = 1;
  } 
  if(empty($CRAM)){
    $CRAM = 0;
  } else {
    $CRAM = 1;
  } 
  if(empty($MSA)){
    $MSA = 0;
  } else {
    $MSA = 1;
  } 
  if(empty($ARRCO)){
    $ARRCO = 0;
  } else {
    $ARRCO = 1;
  } 
  if(empty($AGIRC)){
    $AGIRC = 0;
  } else {
    $AGIRC = 1;
  } 
  if(empty($IRCANTEC)){
    $IRCANTEC = 0;
  } else {
    $IRCANTEC = 1;
  } 
  if(empty($CARPIMKOM)){
    $CARPIMKOM = 0;
  } else {
    $CARPIMKOM = 1;
  } 
  if(empty($CARMFM)){
    $CARMFM = 0;
  } else {
    $CARMFM = 1;
  } 
  if(empty($CARMF)){
    $CARMF = 0;
  } else {
    $CARMF = 1;
  } 
  if(empty($CARPVM)){
    $CARPVM = 0;
  } else {
    $CARPVM = 1;
  } 
  if(empty($CAVAMACM)){
    $CAVAMACM = 0;
  } else {
    $CAVAMACM = 1;
  } 
  if(empty($CAVECM)){
    $CAVECM = 0;
  } else {
    $CAVECM = 1;
  } 
  if(empty($CAVOMM)){
    $CAVOMM = 0;
  } else {
    $CAVOMM = 1;
  } 
  if(empty($CIPAVM)){
    $CIPAVM = 0;
  } else {
    $CIPAVM = 1;
  } 
  if(empty($CNBFM)){
    $CNBFM = 0;
  } else {
    $CNBFM = 1;
  } 
  if(empty($CARCDSFM)){
    $CARCDSFM = 0;
  } else {
    $CARCDSFM = 1;
  } 
  if(empty($CRNM)){
    $CRNM = 0;
  } else {
    $CRNM = 1;
  } 
  if(empty($CAVPM)){
    $CAVPM = 0;
  } else {
    $CAVPM = 1;
  } 
  if(empty($RSIM)){
    $RSIM = 0;
  } else {
    $RSIM = 1;
  } 
  if(empty($ORGANICM)){
    $ORGANICM = 0;
  } else {
    $ORGANICM = 1;
  } 
  if(empty($AVAM)){
    $AVAM = 0;
  } else {
    $AVAM = 1;
  } 
  if(empty($CARPIMKO)){
    $CARPIMKO = 0;
  } else {
    $CARPIMKO = 1;
  } 
  if(empty($CARPIMKO)){
    $CARPIMKO = 0;
  } else {
    $CARPIMKO = 1;
  } 
  if(empty($CARPV)){
    $CARPV = 0;
  } else {
    $CARPV = 1;
  } 
  if(empty($CAVAMAC)){
    $CAVAMAC = 0;
  } else {
    $CAVAMAC = 1;
  } 
  if(empty($CAVEC)){
    $CAVEC = 0;
  } else {
    $CAVEC = 1;
  } 
  if(empty($CAVOM)){
    $CAVOM = 0;
  } else {
    $CAVOM = 1;
  } 
  if(empty($CIPAV)){
    $CIPAV = 0;
  } else {
    $CIPAV = 1;
  } 
  if(empty($CNBF)){
    $CNBF = 0;
  } else {
    $CNBF = 1;
  } 
  if(empty($CARCDSF)){
    $CARCDSF = 0;
  } else {
    $CARCDSF = 1;
  } 
  if(empty($CRN)){
    $CRN = 0;
  } else {
    $CRN = 1;
  } 
  if(empty($CAVP)){
    $CAVP = 0;
  } else {
    $CAVP = 1;
  } 
  if(empty($RSI)){
    $RSI = 0;
  } else {
    $RSI = 1;
  } 
  if(empty($ORGANIC)){
    $ORGANIC = 0;
  } else {
    $ORGANIC = 1;
  } 
  if(empty($AVA)){
    $AVA = 0;
  } else {
    $AVA = 1;
  } 
  if(empty($PrevCGM)){
    $PrevCGM = 0;
  } else {
    $PrevCGM = 1;
  } 
  if(empty($PrevCPM)){
    $PrevCPM = 0;
  } else {
    $PrevCPM = 1;
  } 
  if(empty($PrevCotM)){
    $PrevCotM = 0;
  } else {
    $PrevCotM = 1;
  } 
  if(empty($RetCGM)){
    $RetCGM = 0;
  } else {
    $RetCGM = 1;
  } 
  if(empty($RetCPM)){
    $RetCPM = 0;
  } else {
    $RetCPM = 1;
  } 
  if(empty($RetCotM)){
    $RetCotM = 0;
  } else {
    $RetCotM = 1;
  } 
  if(empty($SanteTableauM)){
    $SanteTableauM = 0;
  } else {
    $SanteTableauM = 1;
  } 
  if(empty($SanteCotM)){
    $SanteCotM = 0;
  } else {
    $SanteCotM = 1;
  } 
  if(empty($AutresDossiersM)){
    $AutresDossiersM = 0;
  } else {
    $AutresDossiersM = 1;
  } 
  if(empty($PrevCG)){
    $PrevCG = 0;
  } else {
    $PrevCG = 1;
  } 
  if(empty($PrevCP)){
    $PrevCP = 0;
  } else {
    $PrevCP = 1;
  } 
  if(empty($PrevCot)){
    $PrevCot = 0;
  } else {
    $PrevCot = 1;
  } 
  if(empty($RetCG)){
    $RetCG = 0;
  } else {
    $RetCG = 1;
  } 
  if(empty($RetCP)){
    $RetCP = 0;
  } else {
    $RetCP = 1;
  } 
  if(empty($RetCot)){
    $RetCot = 0;
  } else {
    $RetCot = 1;
  } 
  if(empty($SanteTableau)){
    $SanteTableau = 0;
  } else {
    $SanteTableau = 1;
  } 
  if(empty($SanteCot)){
    $SanteCot = 0;
  } else {
    $SanteCot = 1;
  } 
  if(empty($AutresDossiers)){
    $AutresDossiers = 0;
  } else {
    $AutresDossiers = 1;
  } 
  $query = "UPDATE `elements` 
  SET `ELT-FichePaieM` = ".$FichePaieM.",
  `ELT-AvisImpots2042M` = ".$AvisImpots2042M.",
  `ELT-Declaration2042M` = ".$Declaration2042M.",
  `ELT-Declaration2035M` = ".$Declaration2035M.",
  `ELT-FichePaie` = ".$FichePaie.",
  `ELT-AvisImpots2042` = ".$AvisImpots2042.",
  `ELT-Declaration2042` = ".$Declaration2042.",
  `ELT-Declaration2035` = ".$Declaration2035.",
  `ELT-RISM` = ".$RISM.",
  `ELT-CRAMM` = ".$CRAMM.",
  `ELT-MSAM` = ".$MSAM.",
  `ELT-ARRCOM` = ".$ARRCOM.",
  `ELT-AGIRCM` = ".$AGIRCM.",
  `ELT-IRCANTECM` = ".$IRCANTECM.",
  `ELT-RIS` = ".$RIS.",
  `ELT-CRAM` = ".$CRAM.",
  `ELT-MSA` = ".$MSA.",
  `ELT-ARRCO` = ".$ARRCO.",
  `ELT-AGIRC` = ".$AGIRC.",
  `ELT-IRCANTEC` = ".$IRCANTEC.",
  `ELT-CARPIMKOM` = ".$CARPIMKOM.",
  `ELT-CARMFM` = ".$CARMFM.",
  `ELT-CARPVM` = ".$CARPVM.",
  `ELT-CAVAMACM` = ".$CAVAMACM.",
  `ELT-CAVECM` = ".$CAVECM.",
  `ELT-CAVOMM` = ".$CAVOMM.",
  `ELT-CIPAVM` = ".$CIPAVM.",
  `ELT-CNBFM` = ".$CNBFM.",
  `ELT-CARCDSFM` = ".$CARCDSFM.",
  `ELT-CRNM` = ".$CRNM.",
  `ELT-CAVPM` = ".$CAVPM.",
  `ELT-RSIM` = ".$RSIM.",
  `ELT-ORGANICM` = ".$ORGANICM.",
  `ELT-AVAM` = ".$AVAM.",
  `ELT-CARPIMKO` = ".$CARPIMKO.",
  `ELT-CARMF` = ".$CARMF.",
  `ELT-CARPV` = ".$CARPV.",
  `ELT-CAVAMAC` = ".$CAVAMAC.",
  `ELT-CAVEC` = ".$CAVEC.",
  `ELT-CAVOM` = ".$CAVOM.",
  `ELT-CIPAV` = ".$CIPAV.",
  `ELT-CNBF` = ".$CNBF.",
  `ELT-CARCDSF` = ".$CARCDSF.",
  `ELT-CRN` = ".$CRN.",
  `ELT-CAVP` = ".$CAVP.",
  `ELT-RSI` = ".$RSI.",
  `ELT-ORGANIC` = ".$ORGANIC.",
  `ELT-AVA` = ".$AVA.",
  `ELT-PrevCGM` = ".$PrevCGM.",
  `ELT-PrevCPM` = ".$PrevCPM.",
  `ELT-PrevCotM` = ".$PrevCotM.",
  `ELT-RetCGM` = ".$RetCGM.",
  `ELT-RetCPM` = ".$RetCPM.",
  `ELT-RetCotM` = ".$RetCotM.",
  `ELT-SanteTableauM` = ".$SanteTableauM.",
  `ELT-SanteCotM` = ".$SanteCotM.",
  `ELT-AutresDossiersM` = ".$AutresDossiersM.",
  `ELT-PrevCG` = ".$PrevCG.",
  `ELT-PrevCP` = ".$PrevCP.",
  `ELT-PrevCot` = ".$PrevCot.",
  `ELT-RetCG` = ".$RetCG.",
  `ELT-RetCP` = ".$RetCP.",
  `ELT-RetCot` = ".$RetCot.",
  `ELT-SanteTableau` = ".$SanteTableau.",
  `ELT-SanteCot` = ".$SanteCot.",
  `ELT-AutresDossiers` = ".$AutresDossiers."
  WHERE `ELT-NumClt` = ".$idClient.";
  ";
  $pdo = BDD::getConnection();
  $pdo->exec("SET NAMES UTF8");
  $res = $pdo->exec($query);
}

extract($_GET);
$query = "SELECT cli.`CLT-NumID`, cli.`CLT-Nom`, cli.`CLT-Prénom`, el.* FROM `clients et prospects` cli, `elements` el WHERE cli.`CLT-NumID`=$idClient AND el.`ELT-NumClt`=$idClient";
$pdo = BDD::getConnection();
$pdo->exec("SET NAMES UTF8");
$res = $pdo->query($query);
$res = $res->fetchALL(PDO::FETCH_ASSOC);
//Si la ligne du client existe déjà dans la base
if(isset($res[0])){
    $res = $res[0];
//Sinon on la créé
} else {
  $query = "INSERT INTO `elements` (`ELT-NumClt`) VALUES (".$idClient.")";
  $pdo = BDD::getConnection();
  $pdo->exec("SET NAMES UTF8");
  $res = $pdo->exec($query);

  $query = "SELECT cli.`CLT-NumID`, cli.`CLT-Nom`, cli.`CLT-Prénom`, el.* FROM `clients et prospects` cli, `elements` el WHERE cli.`CLT-NumID`=$idClient AND el.`ELT-NumClt`=$idClient";
  $pdo->exec("SET NAMES UTF8");
  $res = $pdo->query($query);
  $res = $res->fetchALL(PDO::FETCH_ASSOC);
  $res = $res[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Gestion CRM">
  <meta name="author" content="Stratégies d'avenir">

  <title>Elements Préparatoires</title>

  <link rel="icon" href="img/favico.ico" />

  <!-- Le Bootstrap -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <!-- Le Kit SB-Admin pour le Bootstrap -->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

  <!-- Pour le drag and drop -->
  <link rel="stylesheet" type="text/css" href="css/styleDragDrop.css" />
  <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
  
</head>

<body style="background-color:#F6F6F6;margin:0px;">

  <!-- Contenu de la page -->
  <div class="col-lg-12">
    <h2 style="display:inline;float:left;">Elements Préparatoires</h2><br/><span style="float:right"><a type="button" onClick="impr()" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Impression</a></span><br/><br/>
    <?php
    echo "<script>
      function impr() {
          window.open('pdf/elements.php?idClient=".$res['CLT-NumID']."');
      }
    </script>";?>
    <br/>
    <h4 style="text-align:left;"><i><b><?php echo $res['CLT-Prénom']." ".$res['CLT-Nom'];?></b></i></h4>
    <hr/>
    <?php 
      echo '<form action="elements.php?idClient='.$res['CLT-NumID'].'" method="post">
       <div class="table-responsive">
          <table class="table table-hover table-striped tablesorter">
            <thead>
              <tr>
                <th></th>
                <th><center>Monsieur</center></th>
                <th><center>Madame</center></th>
              </tr>
            </thead>
            <tbody>
               <tr>
                <td><span style="font-color:#7E3300;border:1px solid black;padding:2px;background-color:#BBAE98;"><b>Situation Retraite</b></span></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><b>Relevé Individuel de Situation Retraite</b></td>
                <td><center><input type="checkbox" name="RISM"';
                if($res['ELT-RISM'] == 1){
                  echo "checked";
                }
                echo '
                /></center></td>
                <td><center><input type="checkbox" name="RIS"';
                if($res['ELT-RIS'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
              <tr>
                <td><span style="font-color:#7E3300;border:1px solid black;padding:2px;background-color:#BBAE98;"><b>Salariés</b></span></td>
                <td></td>
                <td></td>
              </tr>
               <tr>
                <td><b>CRAM Relevé de Carrière</b></td>
                <td><center><input type="checkbox" name="CRAMM"';
                if($res['ELT-CRAMM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CRAM"';
                if($res['ELT-CRAM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>MSA Relevé de Carrière</b></td>
                <td><center><input type="checkbox" name="MSAM"';
                if($res['ELT-MSAM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="MSA"';
                if($res['ELT-MSA'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>ARRCO Relevé de Points</b></td>
                <td><center><input type="checkbox" name="ARRCOM"';
                if($res['ELT-ARRCOM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="ARRCO"';
                if($res['ELT-ARRCO'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>AGIRC Relevé de Points</b></td>
                <td><center><input type="checkbox" name="AGIRCM"';
                if($res['ELT-AGIRCM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="AGIRC"';
                if($res['ELT-AGIRC'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>IRCANTEC Relevé de Points</b></td>
                <td><center><input type="checkbox" name="IRCANTECM"';
                if($res['ELT-IRCANTECM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="IRCANTEC"';
                if($res['ELT-IRCANTEC'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
              <tr>
                <td><span style="font-color:#7E3300;border:1px solid black;padding:2px;background-color:#BBAE98;"><b>Professions Libérales</b></span></td>
                <td></td>
                <td></td>
              </tr>
               <tr>
                <td><b>CARPIMKO Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CARPIMKOM"';
                if($res['ELT-CARPIMKOM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CARPIMKO"';
                if($res['ELT-CARPIMKO'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>CARMF Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CARMFM"';
                if($res['ELT-CARMFM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CARMF"';
                if($res['ELT-CARMF'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>CARPV Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CARPVM"';
                if($res['ELT-CARPVM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CARPV"';
                if($res['ELT-CARPV'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>CAVAMAC Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CAVAMACM"';
                if($res['ELT-CAVAMACM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CAVAMAC"';
                if($res['ELT-CAVAMAC'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>CAVEC Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CAVECM"';
                if($res['ELT-CAVECM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CAVEC"';
                if($res['ELT-CAVEC'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>CAVOM Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CAVOMM"';
                if($res['ELT-CAVOMM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CAVOM"';
                if($res['ELT-CAVOM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>CIPAV Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CIPAVM"';
                if($res['ELT-CIPAVM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CIPAV"';
                if($res['ELT-CIPAV'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>CNBF Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CNBFM"';
                if($res['ELT-CNBFM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CNBF"';
                if($res['ELT-CNBF'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>CARCDSF Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CARCDSFM"';
                if($res['ELT-CARCDSFM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CARCDSF"';
                if($res['ELT-CARCDSF'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>CRN Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CRNM"';
                if($res['ELT-CRNM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CRN"';
                if($res['ELT-CRN'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>CAVP Appel de cotisations et Relevé de points</b></td>
                <td><center><input type="checkbox" name="CAVPM"';
                if($res['ELT-CAVPM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="CAVP"';
                if($res['ELT-CAVP'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
              <tr>
                <td><span style="font-color:#7E3300;border:1px solid black;padding:2px;background-color:#BBAE98;"><b>Indépendants</b></span></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><b>RSI Relevé de Carrière</b></td>
                <td><center><input type="checkbox" name="RSIM"';
                if($res['ELT-RSIM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="RSI"';
                if($res['ELT-RSI'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>ORGANIC Relevé de Points</b></td>
                <td><center><input type="checkbox" name="ORGANICM"';
                if($res['ELT-ORGANICM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="ORGANIC"';
                if($res['ELT-ORGANIC'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>AVA Relevé de Points</b></td>
                <td><center><input type="checkbox" name="AVAM"';
                if($res['ELT-AVAM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="AVA"';
                if($res['ELT-AVA'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>Dernier Bulletin Salaire (Année N et N-1)</b></td>
                <td><center><input type="checkbox" name="FichePaieM"';
                if($res['ELT-FichePaieM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="FichePaie"';
                if($res['ELT-FichePaie'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
              <tr>
                <td><span style="font-color:#7E3300;border:1px solid black;padding:2px;background-color:#BBAE98;"><b>Informations Fiscales</b></span></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><b>Avis Imposition (2042)</b></td>
                <td><center><input type="checkbox" name="AvisImpots2042M"';
                if($res['ELT-AvisImpots2042M'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="AvisImpots2042"';
                if($res['ELT-AvisImpots2042'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>Déclaration Impôts (2042)</b></td>
                <td><center><input type="checkbox" name="Declaration2042M"';
                if($res['ELT-Declaration2042M'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="Declaration2042"';
                if($res['ELT-Declaration2042'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>Déclaration (2035)</b></td>
                <td><center><input type="checkbox" name="Declaration2035M"';
                if($res['ELT-Declaration2035M'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="Declaration2035"';
                if($res['ELT-Declaration2035'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
              <tr>
                <td><i><b><u>Dossier Complémentaires</u></b></i></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><span style="font-color:#7E3300;border:1px solid black;padding:2px;background-color:#BBAE98;"><b>Contrats Retraite</b></span></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><b>Conditions Générales</b></td>
                <td><center><input type="checkbox" name="RetCGM"';
                if($res['ELT-RetCGM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="RetCG"';
                if($res['ELT-RetCG'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>Conditions Particulières</b></td>
                <td><center><input type="checkbox" name="RetCPM"';
                if($res['ELT-RetCPM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="RetCP"';
                if($res['ELT-RetCP'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>Appel de cotisations</b></td>
                <td><center><input type="checkbox" name="RetCotM"';
                if($res['ELT-RetCotM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="RetCot"';
                if($res['ELT-RetCot'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
              <tr>
                <td><span style="font-color:#7E3300;border:1px solid black;padding:2px;background-color:#BBAE98;"><b>Contrats Santé</b></span></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><b>Tableau des Garanties</b></td>
                <td><center><input type="checkbox" name="SanteTableauM"';
                if($res['ELT-SanteTableauM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="SanteTableau"';
                if($res['ELT-SanteTableau'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>Appel de cotisations</b></td>
                <td><center><input type="checkbox" name="SanteCotM"';
                if($res['ELT-SanteCotM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="SanteCot"';
                if($res['ELT-SanteCot'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
              <tr>
                <td><span style="font-color:#7E3300;border:1px solid black;padding:2px;background-color:#BBAE98;"><b>Contrats Prévoyance</b></span></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><b>Condiations Générales</b></td>
                <td><center><input type="checkbox" name="PrevCGM"';
                if($res['ELT-PrevCGM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="PrevCG"';
                if($res['ELT-PrevCG'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>Conditions Particulières</b></td>
                <td><center><input type="checkbox" name="PrevCPM"';
                if($res['ELT-PrevCPM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="PrevCP"';
                if($res['ELT-PrevCP'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
               <tr>
                <td><b>Appel de cotisations</b></td>
                <td><center><input type="checkbox" name="PrevCotM"';
                if($res['ELT-PrevCotM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="PrevCot"';
                if($res['ELT-PrevCot'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><b>Autres Dossiers</b></td>
                <td><center><input type="checkbox" name="AutresDossiersM"';
                if($res['ELT-AutresDossiersM'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
                <td><center><input type="checkbox" name="AutresDossiers"';
                if($res['ELT-AutresDossiers'] == 1){
                  echo "checked";
                }
                echo '/></center></td>
              </tr>
            </tbody>
          </table>
        </div>
      <input type="hidden" name="idClient" value="'.$res['CLT-NumID'].'"/>
      <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Valider Modifications</button></form><br/><br/><br/>
      ';
    ?>
  </div>


  <!-- JavaScript -->
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.js"></script>

  <!-- Autres Plugins -->
  <script src="js/tablesorter/jquery.tablesorter.js"></script>
  <script src="js/tablesorter/tables.js"></script>

  <!-- Perso -->
  <script src="js/fonctions.js"></script>

  <!-- Pour le drag and drop -->
  <script src="js/jquery-ui.js"></script>
  <script src="js/fieldChooser.js"></script>

</body>
</html>
