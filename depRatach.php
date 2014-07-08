<?php
/*
Page des gestion des départements attachés à un inspecteur
*/

include_once "BDD.php";

if(!empty($_POST)){
  //Si c'est un ajout
  if(!empty($_POST['idAdd'])){
      extract($_POST);
      $query = "INSERT INTO `Regions par Inspecteurs` VALUES (null,".$_GET['idIns'].",$idAdd);";
      $pdo = BDD::getConnection();
      $pdo->exec("SET NAMES UTF8");
      $res = $pdo->exec($query);
  }
  //Si c'est une suppression
  if(!empty($_POST['idSup'])){
      extract($_POST);
      $query = "DELETE FROM `Regions par Inspecteurs` WHERE `R/I-NumID` = $idSup;";
      $pdo = BDD::getConnection();
      $pdo->exec("SET NAMES UTF8");
      $res = $pdo->exec($query);
  }
}

//Les rattachements de l'inspecteur
extract($_GET);
$query = "SELECT `Regions par Inspecteurs`.`R/I-NumID`, `Regions par Inspecteurs`.`R/I-NumInspecteur`, `Regions par Inspecteurs`.`R/I-NumDptRattachement`, `Departements et Regions`.`DPT-Région`, `Departements et Regions`.`DPT-Nom`, `Departements et Regions`.`DPT-Num`
FROM `Departements et Regions` INNER JOIN `Regions par Inspecteurs` ON `Departements et Regions`.`DPT-Num` = `Regions par Inspecteurs`.`R/I-NumDptRattachement`
WHERE (((`Regions par Inspecteurs`.`R/I-NumInspecteur`)=".$_GET['idIns']."));
";
$pdo = BDD::getConnection();
$pdo->exec("SET NAMES UTF8");
$res = $pdo->query($query);
$res = $res->fetchALL(PDO::FETCH_ASSOC);

//Liste déroulante des départements pour ajouter
$query = "SELECT * FROM `Departements et Regions` ORDER BY CAST(`DPT-Num` AS SIGNED)";
$pdo = BDD::getConnection();
$pdo->exec("SET NAMES UTF8");
$res_dep = $pdo->query($query);
$departements = $res_dep->fetchALL(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Gestion CRM">
  <meta name="author" content="Stratégies d'avenir">

  <title>Départements rattachés</title>

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
    <h2 style="display:inline;float:left;">Départements rattachés</h2><br/><br/><br/><br/><br/>
      <?php
        foreach ($res as $dep) {
          $num = $dep['DPT-Num'];
          if($num < 10){
            $num = "0".$num;
          }
          echo "<b>".$dep['DPT-Nom']."</b>&nbsp;&nbsp;<i>(".$num.", ".$dep['DPT-Région'].")</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <form action='depRatach.php?idIns=".$_GET['idIns']."' method='post' style='display:inline;'>
          <input type='hidden' name='idSup' value='".$dep['R/I-NumID']."'/>
          <button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i> Suprimmer</button>
          </form><br/><br/>";
        }
        echo "
          <form action='depRatach.php?idIns=".$_GET['idIns']."' method='post' style='display:inline;'>
          <select name='idAdd'>";
          foreach ($departements as $departement) {
            $num = $departement['DPT-Num'];
            if($num < 10){
              $num = "0".$num;
            }
            echo "<option value='".$departement['DPT-Num']."'>".$departement['DPT-Nom']." (".$num.") - ".$departement['DPT-Région']."</option>";
          }
        echo "
          </select>
          <button type='submit' class='btn btn-success btn-xs'><i class='fa fa-plus'></i> Ajouter</button>
          </form>
        ";
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
