<?php
/**
 * @file registration.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 27 Janvier 2019
 * @brief La page qui permet à un client de s'enregistrer sur le site.
*/

require_once("../inc/connectDB.php");
require_once("../inc/sql.php");
session_start();
if (isset($_POST['envoi'])) {
    
    // contrôles des champs saisis
    
    $erreurs = array();
    
    $utilisateur_nom = trim($_POST['nom']); //user name
    if (!preg_match('/^[a-z àéèêô]+$/i', $utilisateur_nom)) {
        $erreurs['$utilisateur_nom'] = "Nom incorrect.";
    }
    $utilisateur_prenom = trim($_POST['prenom']);
    if (!preg_match('/^[a-z àéèêô]+$/i', $utilisateur_prenom)) {
        $erreurs['$utilisateur_prenom'] = "Prenom incorrect.";
    }
    
    $utilisateur_adress = trim($_POST['adresse']);
    
    $utilisateur_courriel = trim($_POST['courriel']);
    if (!filter_var($utilisateur_courriel, FILTER_VALIDATE_EMAIL)) {
       $erreurs['utilisateur_courriel'] = "Courriel incorrect.";
    }
    $_SESSION['identifiant_utilisateur'] = $utilisateur_courriel;
    $utilisateur_password = trim($_POST['motdepass']);
    
    
    if (count($erreurs) === 0) {
        if (sqlRegistration($conn, $utilisateur_nom, $utilisateur_prenom, $utilisateur_adress, $utilisateur_courriel,    $utilisateur_password) === 1) {
           
          $retSQL="<h1>Enrégistration effectué.</h1><br><a href='../index.php'>Retour vers la page d'accueuil</a>";
         
        } else {
             $retSQL ="Enrégistration non effectué.";    
        }
        
        $utilisateur_nom = ""; // réinit pour une nouvelle saisie
        $utilisateur_prenom = "";
        $utilisateur_adress = "";
        $utilisateur_courriel = "";
        $utilisateur_password = "";
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
                <div class="logo"><a href="../index.html"><img src="../images/logo-min.png" alt="logo" /></a></div>
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
                            <div><a class='actif' href="dossier.php">MON DOSSIER</a></div>
                            <div><a href="apropo.html">A PROPOS</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <div class="admin">

        <p>
            <?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?>
        </p>
        <br><br>

        <h1>Régistration :</h1>

        <form action="registration.php" method="post">
            <label>Nom</label><input type="text" name="nom" value="<?php echo isset($utilisateur_nom) ? $utilisateur_nom : "" ?>" required placeholder=" Nom"><br>
            <label>Prénom</label><input type="text" name="prenom" value="<?php echo isset($utilisateur_prenom) ? $utilisateur_prenom : "" ?>" required placeholder=" Prénom"><br>
            <label>Adresse</label><input type="text" name="adresse" value="<?php echo isset($utilisateur_adress) ? $utilisateur_adress : "" ?>" required placeholder="1111 rue Lavoie app 4 Montreal "><br>
            <label>Courriel</label><input type="text" name="courriel" value="<?php echo isset($utilisateur_courriel) ? $utilisateur_courriel : "" ?>" required placeholder="xxx@gmail.com"><br>
            <label>Mot de passe</label><input type="text" name="motdepass" value="<?php echo isset($utilisateur_password) ? $utilisateur_password : "" ?>" required placeholder="chiffres et lettres"><br>
            <br>
            <input class="envoi" type="submit" name="envoi" value="envoyer">

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
