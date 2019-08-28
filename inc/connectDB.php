<?php
/**
 * @file connectDB.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 25 Janvier 2019
 * @brief La page qui permet la connexion a la base des données.
*/
  
require_once("paramConnectDB.php");

$conn = mysqli_connect(HOST, USER, PASSWORD, DBNAME);
// for messaging connexion error
if (!$conn) {
?>
   <p>Erreur de connexion :
      <?php echo mysqli_connect_errno()." – ".utf8_encode(mysqli_connect_error()) ?>
   </p> 
<?php 
   exit;
}

mysqli_set_charset($conn, "utf8");
