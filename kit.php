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

  <title>CERCLE - 
    <?php 
    echo $_SESSION['Auth']['page']; 
    ?>
  </title>

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
    <nav class="navbar navbar-inverse navbar-fixed-top" style="height:60px;" role="navigation">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php" style="margin-right:21px;"><img src="img/logo.png" style="width:40px;height:40px;margin-top:-5px;padding:0px"/> CERCLE</a>
      </div>
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <!-- Menu du côté -->
        <ul class="nav navbar-nav side-nav" style="margin-top:9px;">
          <hr style="margin:0px;margin-top:1px;"/>
          <?php if(isset($_SESSION['menu'])){ echo $_SESSION['menu']; unset($_SESSION['menu']); };?>
        </ul>

        <ul class="nav navbar-nav navbar-left navbar-user">
          <li <?php if(!isset($_GET['action'])){ echo "class='active'"; } ?>><a href="index.php"><b><img src="img/home.png" style="width:40px;height:40px;margin:-5px;padding:0px"/>&nbsp;&nbsp;&nbsp;Accueil</b></a></li>
          <li <?php if(isset($_GET['action']) && preg_match("#[c|C]lient#",$_GET['action'])){ echo "class='active'"; } ?>><a href="index.php?action=client" onclick="$('#myModal').modal('show')"><b><img src="img/client.png" style="width:40px;height:40px;margin:-5px;padding:0px"/>&nbsp;&nbsp;&nbsp; Base Clients</b></a></li>
          <li><a href="#"><b><img src="img/partenaire.png" style="width:40px;height:40px;margin:-5px;padding:0px"/>&nbsp;&nbsp;&nbsp; Bases Partenaires</b></a></li>
          <li><a href="#"><b><img src="img/produit.png" style="width:40px;height:40px;margin:-5px;padding:0px"/>&nbsp;&nbsp;&nbsp; Compagnies et Produits</b></a></li>
          <li><a href="#"><img src="img/procedure.png" style="width:40px;height:40px;margin:-5px;padding:0px"/>&nbsp;&nbsp;&nbsp;<b> Procédures</b></a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right navbar-user">
          <li class="dropdown user-dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="img/user.png" style="width:40px;height:40px;margin:-5px;padding:0px"/>&nbsp;&nbsp;&nbsp;<?php echo " ".$_SESSION['Auth']['nom']." ".$_SESSION['Auth']['prenom']." (".Auth::getInfo('dpt').") ";?><b class="caret"></b></a>
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

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <center><h4 class="modal-title" id="myModalLabel">Chargement des clients</h4></center>
              </div>
              <div class="modal-body">
                <center><img src="img/load.gif"/></center>
              </div>

            </div>
          </div>
        </div>


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
