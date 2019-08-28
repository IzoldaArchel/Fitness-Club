<?php
/**
 * @file deconnexion.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 26 Janvier 2019
 * @brief La page de la deconnection.
*/
session_start();
unset($_SESSION['identifiant_utilisateur']); 
session_destroy();
header('Location: dossier.php'); 
?>