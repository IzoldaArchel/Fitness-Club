<?php
/**
 * @file detailsAnimateur.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 26 Janvier 2019
 * @brief La page qui permet à l'administrateur de voir les détails d'un animateur.
*/

require_once("../inc/connectDB.php");
require_once("../inc/sql.php");

session_start();

$utilisateur_id = $_GET['id'];

$row = detailsUtilisateur($conn, $utilisateur_id);

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
                            <div><a class="actif" href="gererAnimateurs.php">ANIMATEURS</a></div>
                            <div><a href="gererInscriptions.php">INSCRIPTIONS</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <main>
        <div class="admin">

            <h1>Animateur :</h1>

            <table>

                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Adresse</th>
                    <th>Courriel</th>
                    <th>Role</th>

                </tr>
                <?php foreach($row as $animateur) {  ?>

                <tr>
                    <td>
                        <?php echo $animateur['utilisateur_nom'] ?>
                    </td>
                    <td>
                        <?php echo $animateur['utilisateur_prenom'] ?>
                    </td>
                    <td>
                        <?php echo $animateur['utilisateur_adress'] ?>
                    </td>
                    <td>
                        <?php echo $animateur['utilisateur_courriel'] ?>
                    </td>
                    <td>
                        <?php echo $animateur['type_role']; break; ?>
                    </td>


                </tr>
                <?php } ?>

            </table>
            <br><br>
            <h1>Ses activités :</h1>

            <table>
                <?php foreach($row as $animateur) {  ?>
                <tr>
                    <td>
                        <?php echo $animateur['activite_nom'] ?>
                    </td>

                </tr>

                <?php }  ?>
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
