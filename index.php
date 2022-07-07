<?php
/**
 * @file index.php
 * @author Kolomiets Elena et Paireli Elena
 * @version 1.0
 * @date xx Janvier 2019
 * @brief La page d'accueuil.
*/

require_once("inc/connectDB.php");
require_once("inc/sql.php");
session_start();
$liste = listerGenres($conn);
$row = listerToutesActivites($conn);
$inscrit = "";
$complet = "";
$complet_message = "";
$connexion = "connexion";

if(isset($_SESSION['identifiant_utilisateur'])) {
$identifiant = $_SESSION['identifiant_utilisateur'];
$typeUtilisateur = typeRetourne($conn, $identifiant);
$utilisateur_id = chercherUtilisateurId($conn, $identifiant);
$connexion = "déconnexion";
}

if(isset($_POST['envoi']))
{
   
   $act_id = $_POST['activite_id'];
   $_SESSION['id'] = $act_id;
   $act_nom = $_POST['activite_nom'];
   $_SESSION['nom'] = $act_nom;
   
if(!isset($_SESSION['identifiant_utilisateur'])) {
    header('Location: php/dossier.php');
    $connexion = "connexion";
            
 } else{ 
           $identifiant = $_SESSION['identifiant_utilisateur'];
              $utilisateur_id = chercherUtilisateurId($conn, $identifiant);
              $id_activite = activiteParUtilisateur($conn, $utilisateur_id); 
              $nbMax = nombreMaximal($conn, $act_id);
              $nbInscrit = nombreInscrit($conn, $act_id);
           
             if ($nbInscrit<$nbMax) 
              {
                header('Location: php/inscription.php');
                  
              } 
             else {
                 $complet_message =  "<br><span class='complet span_complet'>Le groupe pour cette activité est complet</span>";
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
    <link href="css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Michroma" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>

        <div class="container-head">
            <div class="top-container">
                <div class="logo"><a href="index.php"><img src="images/logo-min.png" alt="logo" /></a></div>
                <div class="slogan">
                    <a href="php/deconnexion.php"><input class="registration" id="registration" type="button" name="registration" formaction="php/registration.php" value="<?php echo $connexion; ?>" /> </a>
                    <a href="php/registration.php"><input class="registration" id="registration" type="button" name="registration" formaction="php/registration.php" value="enrégistrez-vous" /> </a>

                    <h1>SENTEZ-<span id="vous"> VOUS</span> <br><span id="bien">BIEN!</span></h1>
                </div>
            </div>

            <div class="nav-container">
                <div class="navigation">
                    <div>
                        <div class="nav">
                            <div><a class="actif" href="index.php">ACCUEUIL</a></div>
                            <div><a <?php if(isset($_SESSION['identifiant_utilisateur']) && $typeUtilisateur==='3' ) echo 'href="php/client.php"' ; else echo 'href="php/dossier.php"' ; ?>
                                    >MON DOSSIER</a></div>
                            <div><a href="php/apropo.html">A PROPOS</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </header>
    <main>
        <div class="main-container">

            <div>

                <h1 id="err1062">ACTIVITÉS</h1>
                <p>
                    <?php echo $complet ?>
                </p>

                <ul class="categorie">
                    <?php 
                    foreach($liste as $genre){
                        $id = $genre['genre_id'];
                    ?>
                    <br>
                    <li>
                        <?php echo $genre['genre_nom'] ?>

                        <ul class="activite">
                            <?php
                                      $activites = listerActivites($conn, $id);
                 
                                      foreach($activites as $activite){
                            ?>
                            <li>
                                <form method="POST" action='index.php'>
                                    <input type="hidden" name="activite_id" value="<?php echo $activite['activite_id'] ?>">
                                    <input type="hidden" name="activite_nom" value="<?php echo $activite['activite_nom'] ?>">
                                    <label>  
                                    <span id="horaire">
                                            <?php echo $activite['activite_jour'] ?>
                                            <?php echo $activite['activite_heure'] ?>
                                    </span><br>
                                        <?php echo $activite['activite_nom'] ?>
                                       
                                    </label>

                                    <button type="submit" name="envoi" class="inscription">inscription</button>
                                    <span>
                                        <?php 
                                                $act_id=$activite['activite_id'];
                                                $nbMax = nombreMaximal($conn, $act_id);
                                                $nbInscrit = nombreInscrit($conn, $act_id);
                                              
                                      if($nbInscrit>=$nbMax) {
                                           $complet = "<span class='complet'>complet</span>";
                                                  
                                          }
                                          else 
                                            $complet = "";
                                            if(isset($_SESSION['identifiant_utilisateur'])){
                                              
                                            $id_activite = inscriprionParUtilisateur($conn, $utilisateur_id); 
                                            foreach($id_activite as $ligne) {
                                            $id = $ligne['inscription_activite_id'];
                                            if($id == $activite['activite_id']){

                                            $inscrit = "inscrit";
                                            $complet = "";     
                                            echo $inscrit;
                                                 
                                             break;
                                          
                                         }
                                             ?> <span>
                                            <?php      
                                         }
                                               
                                          $act_id=$activite['activite_id'];
                                          $nbMax = nombreMaximal($conn, $act_id);
                                          $nbInscrit = nombreInscrit($conn, $act_id);
                                              
                                          if($nbInscrit>=$nbMax)
                                          if($id == $activite['activite_id']){   
                                              echo $complet_message;   
                                               
                                           }
                                        ?></span>
                                        <?php 
                                         }
                                          echo $complet; ?>
                                    </span>
                                    
                                </form>
                            </li>

                            <?php
                              }
                            ?>
                        </ul>

                    </li>
                    <?php
                      }
                    ?>

                </ul>

            </div>

            <div class="container_bootstrap">
<div id="myCarousel" class="carousel slide " data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner ">
    <div class="item contain_back active">
      <img src="images/swimmers.jpg" alt="natation">
         <div class="article">
             
                <h1>Aquatique chez nous</h1>
                <p>Nullam et elementum lectus, sit amet efficitur nunc. Ut porta pulvinar rutrum. Nulla non mattis odio. Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <p>Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam.</p>
                <p>Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <p>Nullam et elementum lectus, sit amet efficitur nunc. Ut porta pulvinar rutrum. Nulla non mattis odio. Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <ul>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                </ul>
            </div>
    </div>

    <div class="item contain_back">
      <img src="images/yoga.jpg" alt="yoga">
        <div class="article">
             
                <h1>Yoga chez nous</h1>
                <p>Nullam et elementum lectus, sit amet efficitur nunc. Ut porta pulvinar rutrum. Nulla non mattis odio. Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <p>Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam.</p>
                <p>Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <p>Nullam et elementum lectus, sit amet efficitur nunc. Ut porta pulvinar rutrum. Nulla non mattis odio. Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <ul>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                </ul>
        </div>
    </div>

    <div class="item contain_back">
      <img src="images/cardio.jpg" alt="cardio">
        <div class="article">
             
                <h1>Cardio chez nous</h1>
                <p>Nullam et elementum lectus, sit amet efficitur nunc. Ut porta pulvinar rutrum. Nulla non mattis odio. Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <p>Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam.</p>
                <p>Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <p>Nullam et elementum lectus, sit amet efficitur nunc. Ut porta pulvinar rutrum. Nulla non mattis odio. Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <ul>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                </ul>
        </div>
    </div>
      
      <div class="item contain_back">
      <img src="images/football.jpg" alt="football">
          <div class="article">
             
                <h1>Football chez nous</h1>
                <p>Nullam et elementum lectus, sit amet efficitur nunc. Ut porta pulvinar rutrum. Nulla non mattis odio. Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <p>Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam.</p>
                <p>Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <p>Nullam et elementum lectus, sit amet efficitur nunc. Ut porta pulvinar rutrum. Nulla non mattis odio. Quisque convallis malesuada odio. Maecenas vitae congue dolor, in rutrum eros. Nullam molestie sem in massa lacinia, nec blandit libero aliquam. Suspendisse consequat semper mi, quis venenatis mauris aliquam vel. </p>
                <ul>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                    <li><b>Nullam molestie :</b> convallis malesuada odio</li>
                </ul>
        </div>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>            
</div>
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
               
            </div>
            <div>
                <p>
                    <a href="#"><img src="images/fb.png" alt="fb" /></a>
                    <a href="#"><img src="images/inst.png" alt="fb" /></a>
                    <a href="#"><img src="images/twiter.png" alt="fb" /></a></p>
                <p id="copyright">&copy; E&amp;E</p>
            </div>
        </div>

    </footer>
</body>

</html>
