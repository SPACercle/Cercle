<?php
/*
Page qui contient le kit graphique et les éléments fixes
*/

include_once "Auth.php";

if(!(Auth::isLogged())){
  header("Location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Gestion CRM">
  <meta name="author" content="Stratégies d'avenir">

  <title>CERCLE</title>

  <link rel="icon" href="img/favico.ico" />

  <!-- Le Bootstrap -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <!-- Le Kit SB-Admin pour le Bootstrap -->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
</head>

<body>

  <div id="wrapper">

    <!-- Barre portefeuille -->
    <div class="col-lg-12" style="margin-top:20px;">
      <?php
      if(Auth::getInfo('modeAgence') == 1){
        ?>
        <b><i class="fa fa-folder-open"></i> Portefeuille(s) accessible(s) :</b>
        <form style="display:inline;" method="post" action="index.php?action=selectPort">
          <select style="display:inline;" name="portSelect">
            <option></option>
            <?php
            foreach(Auth::getInfo('port') as $port){
              echo "<option value=".$port['CON-NumID'].":".str_replace(' ','-',$port['CON-Nom']).":".$port['CON-Prénom'].">".$port['CON-Nom']." ".$port['CON-Prénom']."</option>";
            }
            ?>
          </select>
          <input type="submit" value="OK"/>
        </form>
        <?php
      } else {
        echo "<b><i class='fa fa-folder-open'></i> Portefeuille selectionné :</b> ".str_replace('-',' ',Auth::getInfo('nomPortSelect'));
      }
      ?>
      &nbsp;&nbsp;&nbsp;
      <?php
      if(Auth::getInfo('modeAgence') == 1){
        echo '<button type="button" class="btn btn-info btn-xs" style="position:absolute;">Mode agence activé</button>';
      } else {
        echo '<form style="display:inline;" action="index.php?action=backAgence" method="post"><button type="submit" class="btn btn-warning btn-xs" style="position:absolute;">Retour en mode agence</button></form>';
      }
      ?>
    </div>

    <!-- Barre du haut -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php" style="margin-right:31px;"><img src="img/logo.png" style="width:30px;height:30px;margin-top:-5px;"/> CERCLE</a>
      </div>
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <!-- Menu du côté -->
        <ul class="nav navbar-nav side-nav">
          <?php if(isset($_SESSION['menu'])){ echo $_SESSION['menu']; unset($_SESSION['menu']); };?>
        </ul>

        <ul class="nav navbar-nav navbar-left navbar-user">
          <li <?php if(!isset($_GET['action'])){ echo "class='active'"; } ?>><a href="index.php"><i class="fa fa-home"></i><b> Accueil</b></a></li>
          <li <?php if(isset($_GET['action']) && preg_match("#[c|C]lient#",$_GET['action'])){ echo "class='active'"; } ?>><a href="index.php?action=client"><i class="fa fa-user"></i><b> Base Clients</b></a></li>
          <li><a href="#"><i class="fa fa-briefcase"></i><b> Bases Partenaires</b></a></li>
          <li><a href="#"><i class="fa fa-globe"></i><b> Compagnies et Produits</b></a></li>
          <li><a href="#"><i class="fa fa-file"></i><b> Procédures</b></a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right navbar-user">
          <li class="dropdown user-dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo " ".$_SESSION['Auth']['nom']." ".$_SESSION['Auth']['prenom']." (".Auth::getInfo('dpt').") ";?><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="index.php?action=droits"><i class="fa fa-lock"></i> Mes droits</a></li>
              <li class="divider"></li>
              <li><a href="index.php?action=logout"><i class="fa fa-power-off"></i> Déconnexion</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Contenu de la page -->
    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12"><hr/>
          <?php 
          echo $contenu;
          ?>
        </div>
      </div>
    </div>

    <!-- Bas de page -->
    <div class="col-lg-12">
      <center>
        2014 © Tous Droits Réservés &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp; Contact : <a href="mailto:savcercle@strategies-avenir.com ">savcercle@strategies-avenir.com </a><img src="img/logo2.bmp" width="145px" height="49px"/>
      </center>
    </div>

  </div>

  <!-- JavaScript -->
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.js"></script>

  <!-- Autres Plugins -->
  <script src="js/tablesorter/jquery.tablesorter.js"></script>
  <script src="js/tablesorter/tables.js"></script>

  <!-- JavaScript Perso -->
  <script src="js/fonctions.js"></script>

</body>
</html>
