<?php
/**
 * @file inscription.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 28 Janvier 2019
 * @brief La page qui permet à un client de s'inscrire a une activité.
*/

require_once("../inc/connectDB.php");
require_once("../inc/sql.php");
  
session_start(); 
$succes = 0;
$paiement = isset($_POST['envoi']) ? trim($_POST['paiement']) : "Cash";

$act_id = $_SESSION['id'];
$act_nom = $_SESSION['nom'];
$message = "";

if (isset($_POST['envoi'])) {

 $identifiant = $_POST['courriel'];
 $utilisateur_id = chercherUtilisateurId($conn, $identifiant);

 if(creerInscription($conn, $act_id,  $utilisateur_id, $paiement)===1){
    $message = "Vous êtes inscrit à l'activité $act_nom";
    $succes = 1;
        
 }
    
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
                    <input class="registration" id="registration" type="button" name="registration" value="enrégistrez-vous" />

                    <h1>SENTEZ-<span id="vous"> VOUS</span> <br><span id="bien">BIEN!</span></h1>
                </div>
            </div>

            <div class="nav-container">
                <div class="navigation">
                    <div>
                        <div class="nav">
                            <div><a href="../index.php">ACCUEUIL</a></div>
                            <div><a href="dossier.php">MON DOSSIER</a></div>
                            <div><a href="apropo.html">CONTACTS</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <div class="forms">
        <?php if(!$succes) : ?>
        <h1>Inscrivez-vous :</h1>
        <form action="inscription.php" method="post" name="inscription">
            <input type="text" name="nom" required placeholder=" nom" /><br>
            <input type="text" name="adresse" required placeholder=" adresse" /><br>
            <input type="text" name="courriel" required placeholder=" courriel" /><br>
            <label class="select">Mode de paiement</label>
            <select class="tri_critere" name="paiement">
                <option value="cash" <?php echo $paiement==="cash" ? "selected" : "" ?>>Cash</option>
                <option value="visa" <?php echo $paiement==="visa" ? "selected" : "" ?>>Visa</option>
                <option value="mastercard" <?php echo $paiement==="mastercard" ? "selected" : "" ?>>Mastercard</option>
            </select><br>
            <input class="envoi" type="submit" name="envoi" value="envoyez" />

        </form>
        <?php endif; ?>
        <h1>
        <?php echo $message ?>
        </h1>
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
                 <h3>Crédits :</h3>
                <p><a href="https://www.pexels.com/photo/grass-sport-game-match-47730/" target="_blank">Image entête</a></p>
                <p><a href="https://pixabay.com/en/social-icons-enjoy-2412656/" target="_blank">Images réseau sociaux</a></p>
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
