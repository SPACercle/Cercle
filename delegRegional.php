<?php
/*
Page des gestion des délégations régionales d'un inspecteur
*/

include_once "BDD.php";

if(!empty($_POST)){
  //Si c'est un ajout
  if(!empty($_POST['idAdd'])){
    extract($_POST);
    $query = "INSERT INTO `contacts par inspecteur` VALUES (null,$idAdd,'$nom','$prenom','$tel','$mail','$port','$fax','$fonction','$horaire','$com');";
    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->exec($query);
  }
  //Si c'est une suppression
  if(!empty($_POST['idSup'])){
    extract($_POST);
    $query = "DELETE FROM `contacts par inspecteur` WHERE `C/I-NumID` = $idSup";
    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->exec($query);
  }
  //Si c'est une modif
  if(!empty($_POST['idModif'])){
    extract($_POST);
    $query = "UPDATE `contacts par inspecteur` 
          SET `C/I-Nom`= '$nom',
              `C/I-Prénom`= '$prenom',
              `C/I-TelBureau`= '$tel',
              `C/I-Mail`= '$mail', 
              `C/I-TelPortable`= '$port',
              `C/I-Fax`= '$fax',
              `C/I-Fonction`= '$fonction',
              `C/I-HorairesOuverture`= '$horaire',
              `C/I-Commentaire`= '$com'
          WHERE `C/I-NumID` = $idModif;
    ";
    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->exec($query);
  }
}

//La délégation de l'inspecteur
extract($_GET);
$query = "
SELECT `Contacts par Inspecteur`.`C/I-NumID`, `Contacts par Inspecteur`.`C/I-NumInspecteur`, `Contacts par Inspecteur`.`C/I-Nom`, `Contacts par Inspecteur`.`C/I-Prénom`, `Contacts par Inspecteur`.`C/I-TelBureau`, `Contacts par Inspecteur`.`C/I-Mail`, `Contacts par Inspecteur`.`C/I-TelPortable`, `Contacts par Inspecteur`.`C/I-Fax`, `Contacts par Inspecteur`.`C/I-Fonction`, `Contacts par Inspecteur`.`C/I-HorairesOuverture`, `Contacts par Inspecteur`.`C/I-Commentaire`, `Compagnies Inspecteurs`.`INS-Nom`, `Compagnies Inspecteurs`.`INS-NumID`, `Compagnies Inspecteurs`.`INS-Prénom`, Compagnies.`CIE-Nom`
FROM Compagnies INNER JOIN (`Compagnies Inspecteurs` INNER JOIN `Contacts par Inspecteur` ON `Compagnies Inspecteurs`.`INS-NumID` = `Contacts par Inspecteur`.`C/I-NumInspecteur`) ON Compagnies.`CIE-NumID` = `Compagnies Inspecteurs`.`INS-NumCie`
WHERE (((`Contacts par Inspecteur`.`C/I-NumInspecteur`)=".$_GET['idIns']."));

";
$pdo = BDD::getConnection();
$pdo->exec("SET NAMES UTF8");
$res = $pdo->query($query);
$contacts = $res->fetchALL(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Gestion CRM">
  <meta name="author" content="Stratégies d'avenir">

  <title>Délégation Régionale</title>

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
    <h2 style="display:inline;float:left;">Délégation Régionale</h2><br/><br/><br/><br/><br/>
        <div class='table-responsive'>
        <table class='table table-hover tablesorter'>
        <thead>
        <tr>
        <th>Nom/Service</th>
        <th>Prénom</th>
        <th>Tel Bureau</i></th>
        <th>Mail</th>
        <th>Tel Portable</th>
        <th>Fax</th>
        <th>Fonction</th>
        <th>Horaires Ouverture</th>
        <th>Commentaire</th>
        <th></th>
        <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($contacts as $cont){
          echo'<tr><form action="delegRegional.php?idIns='.$_GET['idIns'].'" method="post">
                <input type="hidden" name="idModif" value="'.$cont['C/I-NumID'].'"/>
          ';
          echo"
            <td><input type='text' name='nom' value='".$cont['C/I-Nom']."' required/></td>
            <td><input type='text' name='prenom' value='".$cont['C/I-Prénom']."' /></td>
            <td><input type='text' name='tel' style='width:95px;' class='phone' value='".$cont['C/I-TelBureau']."'/></td>
            <td><input type='text' name='mail' value='".$cont['C/I-Mail']."'/></td>
            <td><input type='text' name='port' style='width:95px;' class='phone' value='".$cont['C/I-TelPortable']."'/></td>
            <td><input type='text' name='fax' style='width:95px;' class='phone' value='".$cont['C/I-Fax']."'/></td>
            <td><input type='text' style='width:200px;' name='fonction' value='".$cont['C/I-Fonction']."'/></td>
            <td><input type='text' name='horaire' value='".$cont['C/I-HorairesOuverture']."'/></td>
            <td><textarea name='com'>".$cont['INS-Commentaire']."</textarea></td>
            <td><button type='submit' class='btn btn-warning btn-xs'><i class='fa fa-save'></i> Enregistrer</button></form></td>
            <td>
              <form action='delegRegional.php?idIns=".$_GET['idIns']."' method='post'>
                <input type='hidden' name='idSup' value='".$cont['C/I-NumID']."'/>
                <button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i> Suprimmer</button>
              </form>
            </td>           
          ";
          echo"</form></tr>";
        }
        echo"
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        <td><form action='delegRegional.php?idIns=".$_GET['idIns']."' method='post'><input type='text' name='nom' required/></td>
        <td><input type='text' name='prenom' /></td>
        <td><input type='text' style='width:95px;' class='phone' name='tel'/></td>
        <td><input type='text' name='mail'/></td>
        <td><input type='text' style='width:95px;' class='phone' name='port'/></td>
        <td><input type='text' style='width:95px;' class='phone' name='fax'/></td>
        <td><input type='text' style='width:200px;' name='fonction'/></td>
        <td><input type='text' name='horaire'/></td>
        <td><textarea name='com'></textarea></td>
        <td><input type='hidden' name='idAdd' value='".$_GET['idIns']."'/><button type='submit' class='btn btn-success btn-xs'><i class='fa fa-plus fa-lg'></i> Ajouter</button></form></td>
        ";
        echo "</tbody></table></div>";
      ?>
  </div>


  <!-- JavaScript -->
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.js"></script>

  <!-- Autres Plugins -->
  <script src="js/tablesorter/jquery.tablesorter.js"></script>
  <script src="js/tablesorter/tables.js"></script>
  <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>

  <!-- Perso -->
  <script src="js/fonctions.js"></script>

  <!-- Pour le drag and drop -->
  <script src="js/jquery-ui.js"></script>
  <script src="js/fieldChooser.js"></script>

</body>
</html>
