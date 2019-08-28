<?php
/**
 * @file gererInscriptions.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date xx Janvier 2019
 * @brief La page qui affiche la liste des inscriptions.
*/

require_once("../inc/sessionUtilisateur.php");
require_once("../inc/connectDB.php");
require_once("../inc/sql.php");

$liste = listerInscriptions($conn);

if (isset($_POST['envoi'])) {
    $inscription_id = $_POST['inscription_id'];
    validerInscription($conn, $inscription_id);
    header("Refresh:0");
}

mysqli_close($conn);
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
                            <div><a href="admin.php">ACTIVITÉS</a></div>
                            <div><a href="gererAnimateurs.php">ANIMATEURS</a></div>
                            <div><a class="actif" href="gererInscriptions.php">INSCRIPTIONS</a></div>
                            <div><a href="gererClients.php">CLIENTS</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <main>
        <div class="admin">
            <table>

                <tr>
                    <th>Activité</th>
                    <th>Client</th>
                    <th>Mode paiement</th>
                    <th>Date d'insription</th>
                    <th>Validation</th>
                </tr>
                <?php foreach($liste as $activite) { ?>
                <tr>
                    <form method="POST" action="gererInscriptions.php">
                        <td> <input type="hidden" name="inscription_id" value="<?php echo $activite['inscription_id'] ?>">
                            <?php echo $activite['activite_nom'] ?>
                        </td>
                        <td>
                            <?php echo $activite['utilisateur_nom'] ?>
                        </td>
                        <td>
                            <?php echo $activite['inscription_mode_paiement'] ?>
                        </td>
                        <td>
                            <?php echo $activite['inscription_date'] ?>
                        </td>
                        <td>
                            <?php if(($activite['inscription_validation'])==0) {
                       
                            ?>
                            <button type="submit" name="envoi" class="inscription confirmer">Valider</button>

                            <?php 
                            } ?>
                        </td>

                    </form>

                </tr>
                <?php } ?>
            </table>
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
