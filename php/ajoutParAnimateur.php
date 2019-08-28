<?php
/**
 * @file ajoutParAnimateur.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 23 Janvier 2019
 * @brief La page qui permet a l'animateur d'ajouter des personnes a son groupe.
*/

require_once("../inc/connectDB.php");
require_once("../inc/sql.php");
     
session_start();
$act_id = $_GET['id'];
$paiement = isset($_POST['envoi']) ? trim($_POST['paiement']) : "Cash";

if (isset($_POST['envoi'])) {
    
    // check form text fields
    $erreurs = array();
    
    $utilisateur_nom = trim($_POST['utilisateur_nom']);
    if (!preg_match('/^[a-z àéèêô]+$/i', $utilisateur_nom)) {
        $erreurs['utilisateur_nom'] = "Nom incorrect.";
    }
    
       $utilisateur_prenom = trim($_POST['utilisateur_prenom']);
    if (!preg_match('/^[a-z àéèêô]+$/i', $utilisateur_prenom)) {
        $erreurs['utilisateur_prenom'] = "Nom incorrect.";
    }
    
    $courriel = trim($_POST['courriel']);
     $utilisateur_id = chercherUtilisateurId($conn, $courriel);
    
    if (count($erreurs) === 0) {
        if (creerInscription($conn, $act_id, $utilisateur_id, $paiement) === 1) {
            $retSQL="Ajout effectué.<br>Vous pouvez ajouter un nouveau participant.";    
        } else {
            $retSQL ="Ajout non effectué.";  
            
        }
        $utilisateur_nom = "";
        $utilisateur_prenom = ""; // restart with empty fields
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
                            <div><a href="../index.php">ACCUEUIL</a></div>
                            <div><a class="actif" href="animateur.php">MON DOSSIER</a></div>
                            <div><a href="apropo.html">À PROPOS</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </header>
    <main>
        <div class="admin">
            <h1>Ajout d'un participant</h1>
            <p>Vous pouvez ajouter seulement les clients déjà enregistrés</p>

            <p>
                <?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?>
            </p>

            <form action="" method="post">
                <label>Courriel</label>
                <input type="text" name="courriel" value="<?php echo isset($courriel) ? $courriel : "" ?>" required><br>
                <label>Nom de nouveau participant</label>
                <input type="text" name="utilisateur_nom" value="<?php echo isset($utilisateur_nom) ? $utilisateur_nom : "" ?>" required><br>
                <label>Prénom de nouveau participant</label>
                <input type="text" name="utilisateur_prenom" value="<?php echo isset($utilisateur_prenom) ? $utilisateur_prenom : "" ?>" required><br>
                <label class="select">Chosissez la catégorie</label>
                <select class="tri_critere" name="paiement">
                    <option value="cash" <?php echo $paiement==="cash" ? "selected" : "" ?>>Cash</option>
                    <option value="visa" <?php echo $paiement==="visa" ? "selected" : "" ?>>Visa</option>
                    <option value="mastercard" <?php echo $paiement==="mastercard" ? "selected" : "" ?>>Mastercard</option>
                </select><br>

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
