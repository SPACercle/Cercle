<?php
/*
Page de connexion
*/

session_start();

include_once "Auth.php";

if(Auth::isLogged()){
   header("Location:index.php");
}

if(isset($_POST) && !empty($_POST['identifiant']) && !empty($_POST['mdp'])){
    extract($_POST);
    $identifiant = addslashes($identifiant);
    $mdp = addslashes($mdp);
    
    $conect_query = "SELECT * FROM conseillers WHERE `CON-Identifiant`='$identifiant' AND `CON-MotPasse`='$mdp'";
    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($conect_query);
    
    if($res->rowCount() > 0){
        $trow = $res->fetchALL(PDO::FETCH_ASSOC);
        foreach($trow as $row){
            $nom = $row['CON-Nom']; 
            $prenom = $row['CON-Prénom'];
            $dpt = $row['CON-DptRattachement'];
            $numId =  $row['CON-NumID'];
            $orias = $row['CON-NumORIAS'];
        }
        $port_query ="SELECT * FROM `visualisation portefeuilles` v, `conseillers` c WHERE v.`VIS-NumUtilisateur` = ".$numId." AND v.`VIS-NumORIAS` = c.`CON-NumORIAS`"; 
        $res_port = $pdo->query($port_query);
        $trow = $res_port->fetchALL(PDO::FETCH_ASSOC);

        $_SESSION['Auth'] = array(
            'identifiant' => $identifiant,
            'mdp' => $mdp,
            'nom' => $nom,
            'prenom' => $prenom,
            'dpt' => $dpt,
            'port' => $trow,
            'id' => $numId,
            'orias' => $orias,
            'modeAgence' => 1,
            'portSelect' => null,
            'nomPortSelect' => null,
            'portsRestreint' => array()
            );
        
        header("Location:index.php");
    } else {
        $error = "Mauvais identifiants";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CERCLE</title>
    <link rel="icon" href="img/favico.ico" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Veuillez vous connecter</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="login.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Identifiant" name="identifiant" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Mot de passe" name="mdp" type="password" required>
                                </div>
                                <center><button type="submit" class="btn btn-info">Se connecter</button></center>
                            </fieldset>
                            <?php if(isset($error)){echo "<br/><div class='alert alert-danger'><center>".$error."</center></div>";}?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/sb-admin.js"></script>
</body>
</html>
