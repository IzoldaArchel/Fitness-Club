<?php
/**
 * @file ajoutAnimateur.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 23 Janvier 2019
 * @brief La page qui permet d'ajouter des animateurs.
*/

require_once("../inc/connectDB.php");
require_once("../inc/sql.php");
   
session_start();

if (isset($_POST['envoi'])) {
    $erreurs = array();
    $utilisateur_nom = $_POST['utilisateur_nom'];
    $utilisateur_prenom = trim($_POST['utilisateur_prenom']);
    $utilisateur_adress = trim($_POST['utilisateur_adress']);
    $utilisateur_courriel = trim($_POST['utilisateur_courriel']);
    $utilisateur_nom = $_POST['utilisateur_nom'];
    $utilisateur_motdepass = ($_POST['utilisateur_motdepass']);
   
    if (count($erreurs) === 0) {
        //tester si l'ajout est effectué
        if (ajoutAnimateur($conn, $utilisateur_nom, $utilisateur_prenom,  $utilisateur_adress, $utilisateur_courriel, $utilisateur_motdepass) === 1) {
             $retSQL="Ajout effectué.";
        } else {
            $retSQL ="Ajout non effectué.";    
        }
        //réinitialiser nouveaux saisies
        $utilisateur_nom = "";
        $utilisateur_prenom = "";
        $utilisateur_adress = "";
        $utilisateur_courriel = "";
        $utilisateur_motdepass = "";
        
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
                    <a href="deconnexion.php"><input class="registration" id="registration" type="button" name="registration" formaction="registration.php" value="déconnexion" /> </a>
                    <h1>BIENVENUE!</h1>
                </div>
            </div>

            <div class="nav-container">
                <div class="navigation">
                    <div>
                        <div class="nav">
                            <div><a href="../index.php">ACCEUIL</a></div>
                            <div><a class="" href="admin.php">ACTIVITÉS</a></div>
                            <div><a href="gererAnimateurs.php">ANIMATEURS</a></div>
                            <div><a href="gererInscriptions.php">INSCRIPTIONS</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </header>
    <main>
        <div class="admin">
            <h1>Ajout d'un animateur</h1>

            <p>
                <?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?>
            </p>

            <form action="" method="post">
                <label>Nom : </label>
                <input type="text" name="utilisateur_nom" value="<?php echo isset($utilisateur_nom) ? $utilisateur_nom : " " ?>" required><br>
                <label>Prénom : </label>
                <input type="text" name="utilisateur_prenom" value="<?php echo isset($utilisateur_prenom) ? $utilisateur_prenom: " " ?>" required><br>
                <label>Adresse : </label>
                <input type="text" name="utilisateur_adress" value="<?php echo isset($utilisateur_adress) ? $utilisateur_adress : " " ?>" required><br>
                <label>Courriel : </label>
                <input type="text" name="utilisateur_courriel" value="<?php echo isset($utilisateur_courriel) ? $utilisateur_courriel : " " ?>" required><br>
                <label>Mot de passe : </label>
                <input type="text" name="utilisateur_motdepass" value="<?php echo isset($utilisateur_motdepass) ? $utilisateur_motdepass : " " ?>" required><br>
                <br>

                <span>
                    <?php echo isset($erreurs['utilisateur_nom']) ? $erreurs['utilisateur_nom'] : "&nbsp;"  ?></span>
                <span>
                    <?php echo isset($erreurs['utilisateur_prenom']) ? $erreurs['utilisateur_prenom'] : "&nbsp;"  ?></span>
                <input class="envoi" type="submit" name="envoi" value="ajouter" />
            </form>

        </div>

    </main>
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
