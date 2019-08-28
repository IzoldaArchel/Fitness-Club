<?php
/**
 * @file admin.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 23 Janvier 2019
 * @brief La page avec le dossier de l'administrateur et la liste des activités.
*/

require_once("../inc/sessionUtilisateur.php");
require_once("../inc/connectDB.php");
require_once("../inc/sql.php");

$identifiant = $_SESSION['identifiant_utilisateur'];
$typeUtilisateur = typeRetourne($conn, $identifiant);
if($typeUtilisateur!=='1')
header('Location: dossier.php');

$tri_critere = isset($_POST['tri']) ? trim($_POST['tri_critere']) : "Aquatique";

$liste = listerActivitesAdmin($conn, $tri_critere);

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
            <h1>Vous pouvez ajouter, modifier, supprimer ou voir les détails d'une activité.</h1>
            <form id="tri" action="admin.php" method="post">
                <label id="choisir" class="select">Chosissez la catégorie :</label>
                <select class="tri_critere" name="tri_critere">
                    <option value="Aquatique" <?php echo $tri_critere==="Aquatique" ? "selected" : "" ?>>Aquatique</option>
                    <option value="Yoga" <?php echo $tri_critere==="Yoga" ? "selected" : "" ?>>Yoga</option>
                    <option value="Cardio" <?php echo $tri_critere==="Cardio" ? "selected" : "" ?>>Cardio</option>
                    <option value="Football" <?php echo $tri_critere==="Football" ? "selected" : "" ?>>Football</option>
                </select>

                <input class="choisir" type="submit" name="tri" value="Chosir">
            </form>
            <table>

                <tr>
                    <th>Activité</th>
                    <th>Jour</th>
                    <th>Heure</th>
                    <th>Actions</th>
                </tr>
                <?php foreach($liste as $activite) { ?>
                <tr>
                    <td>
                        <?php echo $activite['activite_nom'] ?>
                    </td>
                    <td>
                        <?php echo $activite['activite_jour'] ?>
                    </td>
                    <td>
                        <?php echo $activite['activite_heure'] ?>
                    </td>
                    <td><a href="detailsActivite.php?id=<?php echo $activite['activite_id'] ?>">détails</a></td>
                    <td><a href="modifierActivite.php?id=<?php echo $activite['activite_id'] ?>">modifier</a></td>
                    <td><a href="supressionActivite.php?id=<?php echo $activite['activite_id'] ?>">supprimer</a></td>
                    <input type="hidden" name="genre_id" value="<?php echo $activite['genre_id'] ?>">
                    <?php  $act_id = $activite['activite_id']; ?>
                </tr>
                <?php
                    $categorie_id = $activite['genre_id'];
                    
                } ?>
            </table>
            <form action="admin.php" method="post">
                <a href="ajoutActivite.php?id=<?php echo $categorie_id ?>"><input class="ajout" type="button" name="ajout" value="ajouter" /></a>
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
