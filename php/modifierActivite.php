<?php
/**
 * @file modifierActivite.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date xx Janvier 2019
 * @brief La page qui permet à l'administrateur de modifier une activité.
*/

require_once("../inc/connectDB.php");
require_once("../inc/sql.php");
  
session_start();
$succes = 0;
$activite_id = $_GET['id'];
$row = detailsActivite($conn, $activite_id);
$tri_critere = $row['utilisateur_id'];

$animateurs = listerAnimateurs($conn);
$genres = listerGenres($conn);

if (isset($_POST['envoi'])) {
    $erreurs = array();
    $activite_jour = trim($_POST['activite_jour']);
    $activite_heure = trim($_POST['activite_heure']);
    $tri_critere = trim($_POST['tri_critere']);
    $activite_nom = trim($_POST['activite_nom']);
    $activite_max_inscris = ($_POST['nb_max']);
     
    if (count($erreurs) === 0) {
        if (modifierActivite($conn, $activite_id, $activite_nom, $tri_critere, $activite_max_inscris, $activite_jour,           $activite_heure) === 1) {
            $retSQL="Modification effectué.<br><h2>Pour effectuer une nouvelle modification veiller retourner aux <a href='admin.php'>activités</a></h2>";
            $succes = 1;
            
        } else {
            $retSQL ="Modification non effectué.";
            $succes = 1;
        }
        
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
                    <a href="deconnexion.php"><input class="registration" id="registration" type="button" name="registration" formaction="registration.php" value="déconnexion" /> </a>
                    <h1>BIENVENUE!</h1>
                </div>
            </div>

            <div class="nav-container">
                <div class="navigation">
                    <div>
                        <div class="nav">
                            <div><a href="../index.php">ACCUEUIL</a></div>
                            <div><a class="actif" href="admin.php">ACTIVITÉS</a></div>
                            <div><a href="gererAnimateurs.php">ANIMATEURS</a></div>
                            <div><a href="gererClients.php">CLIENTS</a></div>
                            <div><a href="gererInscriptions.php">INSCRIPTIONS</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </header>
    <main>
        <div class="admin">
            <h1>Modifier l'activité
                <?php echo $row['activite_nom'] ?> :</h1>

            <p>
                <?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?>
            </p>
            <?php if(!$succes) : ?>
            <form action="" method="post">
                <label class="select">Chosissez un animateur</label>

                <select class="tri_critere" name="tri_critere">
                    <?php foreach($animateurs as $entraineur) { ?>
                    <option value="<?php echo $entraineur['utilisateur_id'] ?>" <?php echo $tri_critere===$entraineur['utilisateur_id'] ? "selected" : "" ?>>
                        <?php echo $entraineur['animateur'] ?>
                    </option>
                    <?php } ?>
                </select><br>

                <label>Activité : </label>
                <input type="text" name="activite_nom" value="<?php echo $row['activite_nom'] ?>" required><br>
                <label>Nombre maximum de participants : </label>
                <input type="number" name="nb_max" value="<?php echo $row['activite_max_inscris'] ?>" required><br>
                <label>Jour d'activité : </label>
                <input type="text" name="activite_jour" value="<?php echo $row['activite_jour'] ?>" required><br>
                <label>Heure d'activité : </label>
                <input type="text" name="activite_heure" value="<?php echo $row['activite_heure'] ?>" required><br>
                <br>
                <span>
                    <?php echo isset($erreurs['utilisateur_nom']) ? $erreurs['utilisateur_nom'] : "&nbsp;"  ?></span>
                <span>
                    <?php echo isset($erreurs['utilisateur_prenom']) ? $erreurs['utilisateur_prenom'] : "&nbsp;"  ?></span>
                <input class="envoi" type="submit" name="envoi" value="modifier" />
            </form>
            <?php endif; ?>
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
