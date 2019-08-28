<?php
/**
 * @file animateur.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 23 Janvier 2019
 * @brief La page pour le dossier de l'animateur.
*/

require_once("../inc/sessionUtilisateur.php");
require_once("../inc/connectDB.php");
require_once("../inc/sql.php");

$identifiant = $_SESSION['identifiant_utilisateur'];
$utilisateur_id = chercherUtilisateurId($conn, $identifiant);
$activites = listerToutesActivites($conn);
$liste = listerInscriptions($conn);

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
               <div class="logo"><a href="../index.php"><img src="../images/logo-min.png" alt="logo"/></a></div>
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
            <h1>Liste des inscrits :</h1>
            <?php foreach($activites as $activite){
    if($activite['activite_fk_animateur_id']==$utilisateur_id){
       
    ?>
             <form method="POST" action='animateur.php'>     
            <h2><?php echo $activite['activite_nom'] ?></h2>
            <h3><?php echo $activite['activite_jour'] ?> <?php echo $activite['activite_heure'] ?> Nombre maximal : <?php echo $activite['activite_max_inscris'] ?> </h3>
             <input type="hidden" name="activite_id" value="<?php echo $activite['activite_id'] ?>">
            <table>

                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Mode de paiement</th>
                        <th>Date d'inscription</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
           
               <?php 
                    foreach($liste as $row) 
                        if($activite['activite_nom']==$row['activite_nom'])
                              {
                  ?>      
                
                    <tr>
                        <td><?php echo $row['utilisateur_nom'] ?></td>
                        <td><?php echo $row['utilisateur_prenom'] ?></td>
                        <td><?php echo $row['inscription_mode_paiement'] ?></td>
                        <td><?php echo $row['inscription_date'] ?></td>
                        <td><?php if($row['inscription_validation'])
                                    echo "validé";
                                  else
                                    echo "en attente";  
                            
                            ?></td>
                        <td><a href="suppressionParAnimateur.php?id=<?php echo $row['inscription_id'] ?>">supprimer</a></td>
                     
                    </tr>
                   
                    <?php     }
        $act_id = $activite['activite_id']; 
                               ?>
                </table>
                <a href="ajoutParAnimateur.php?id=<?php echo $act_id ?>"><input class="ajout" type="button" name="ajout" value="ajouter" /></a>
            </form><br><br><br><br><br>
               <?php  
    } } ?>
            
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
