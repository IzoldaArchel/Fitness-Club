<?php
/**
 * @file dossier.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 26 Janvier 2019
 * @brief La page pour l'authentification.
*/

require_once("../inc/connectDB.php");
require_once("../inc/sql.php");      
session_start(); 
if(!isset($_SESSION['identifiant_utilisateur'])) {
if (isset($_POST['envoi'])) {

    $identifiant = trim($_POST['courriel']);
    $mot_de_passe = trim($_POST['motdepass']);
   
    if (sqlControlerUtilisateur($conn, $identifiant, $mot_de_passe) === 1) {
      session_start();
        $_SESSION['identifiant_utilisateur'] = $identifiant;
    
        if(typeRetourne($conn, $identifiant) === '1'){
    
        header('Location: admin.php');
        }
        else if(typeRetourne($conn, $identifiant) === '3')
        header('Location: client.php');
        else if(typeRetourne($conn, $identifiant) === '2')
        header('Location: animateur.php');
    } else {
        $erreur = "Identifiant ou mot de passe incorrect.";
    }
}
}
else{
    $identifiant = $_SESSION['identifiant_utilisateur'];
    if(typeRetourne($conn, $identifiant) === '1' )
         header('Location: admin.php');
    else if(typeRetourne($conn, $identifiant) === '3')
        header('Location: client.php');
    else if(typeRetourne($conn, $identifiant) === '2')
        header('Location: animateur.php');
    
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Club sportif</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- Mobile viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="../css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Michroma" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <header>

        <div class="container">
            <div class="top-container">
                <div class="logo"><a href="../index.php"><img src="../images/logo-min.png" alt="logo" /></a></div>
                <div class="slogan">
                    <a href="registration.php"><input class="registration" id="registration" type="button" name="registration" formaction="registration.php" value="enrégistrez-vous" /> </a>

                    <h1>SENTEZ-<span id="vous"> VOUS</span> <br><span id="bien">BIEN!</span></h1>
                </div>
            </div>

            <div class="nav-container">
                <div class="navigation">
                    <div>
                        <div class="nav">
                            <div><a href="../index.php">ACCEUIL</a></div>
                            <div><a href="dossier.php" class="actif">MON DOSSIER</a></div>
                            <div><a href="apropo.html">A PROPOS</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </header>
    <div class="forms">

        <h1>Connectez-vous :</h1>
        <p>
            <?php echo isset($erreur) ? $erreur : "&nbsp;" ?>
        </p>
        <form action="" method="post" name="dossier">
            <input type="text" name="courriel" placeholder=" courriel" /><br>
            <input type="text" name="motdepass" placeholder=" mot de passe" /><br>
            <input class="envoi" type="submit" name="envoi" value="connectez" />

        </form>

    </div>
    <footer>
        <div class="footer">
            <div>
                <h3>Contactez-nous :</h3>
                <p>3200, rue Decelle</p>
                <p>H4T E5E</p>
                <p>tel : 514 234 5678</p>
            </div>

            <div>
                
             </div>
             <div>
                 <p>
                    <a href="#"><img src="../images/fb.png" alt="fb" /></a>
                    <a href="#"><img src="../images/inst.png" alt="fb" /></a>
                    <a href="#"><img src="../images/twiter.png" alt="fb" /></a></p>
                 <p id="copyright">&copy; E&amp;E</p>
             </div>
        </div>

    </footer>
</body>

</html>
