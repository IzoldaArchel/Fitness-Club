<?php
/**
 * @file client.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 24 Janvier 2019
 * @brief La page du client.
*/

require_once("../inc/connectDB.php");
require_once("../inc/sql.php");

session_start();

$identifiant = $_SESSION['identifiant_utilisateur'];
$utilisateur_id = chercherUtilisateurId($conn, $identifiant);

$liste = activiteParUtilisateur($conn);

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
                            <div><a class="actif" href="client.php">MON DOSSIER</a></div>
                            <div><a href="apropo.html">À PROPOS</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <main>
        <div class="admin">
            <h1>Mes activités :</h1>

            <table>

                <tr>
                    <th>Activité</th>
                    <th>Animateur</th>
                    <th>Jour</th>
                    <th>Heure</th>
                    <th>Statut</th>
                </tr>
                <?php foreach($liste as $row)
                    {
                    if($utilisateur_id == $row['id']) 
                      {?>
                <tr>
                    <td>
                        <?php echo $row['activite_nom'] ?>
                    </td>
                    <td>
                        <?php echo $row['animateur'] ?>
                    </td>
                    <td>
                        <?php echo $row['activite_jour'] ?>
                    </td>
                    <td>
                        <?php echo $row['activite_heure'] ?>
                    </td>
                    <td>
                        <?php if($row['inscription_validation'])
                                    echo "validé";
                                  else
                                    echo "en attente";  
                            
                        ?>
                    </td>

                </tr>
                <?php
                     } }
                ?>
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
