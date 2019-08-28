<?php
  /**
 * @file sessionUtilisateur.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 23 Janvier 2019
 * @brief La page qui permet l'ouverture de la session.
*/
  
session_start();

if (!isset($_SESSION['identifiant_utilisateur'])) {
    // redirection to the page authentification.php
    header('Location: dossier.php'); }

?>