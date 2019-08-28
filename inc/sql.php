<?php
/**
 * @file sql.php
 * @author Kolomiets Elena
 * @version 1.0
 * @date 06 Fevrier 2019
 * @brief La page avec toutes les fonctions.
*/
    



/**
* Fonction errSQL
* @brief affiche le message d'erreur de la dernière "query" SQL
* @param $conn = contexte de connexion
* @return  aucune valeur
*/
 
function errSQL($conn) {
    ?>
    <p>Erreur de requête : <?php echo mysqli_errno($conn)." – ".mysqli_error($conn) ?></p> 
    <?php 
}



/**
 * Fonction sqlControlerUtilisateur
 * @brief contrôle l'authentification de l'utilisateur dans la            table utilisateurs
 * @param $conn = contexte de connexion
 * @param $identifiant = courriel pour l'authentification
 * @param $mot_de_passe = mot de passe pour l'authentification
 * @return 1 si l'utilisateur avec $identifiant et $mot_de_passe             trouvé
 *         0 si non trouvé
 */
function sqlControlerUtilisateur($conn, $identifiant, $mot_de_passe) {

    $req = "SELECT * FROM utilisateurs
            WHERE utilisateur_courriel='$identifiant' AND utilisateur_motdepass = SHA2('$mot_de_passe', 256)";
    if ($result = mysqli_query($conn, $req)) {
        return mysqli_num_rows($result);
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction typeRetourne
 * @brief contrôle l'authentification de l'utilisateur de certain type(client, admin, animateur) dans la table types_utilisateur
 * @param $conn = contexte de connexion
 * @param $identifiant = le courriel de la personne
 * @return entier = identifiant pour le type d'utilisateur
 */
function typeRetourne($conn, $identifiant) {
    $req = "SELECT types_utilisateur_fk_id
            FROM utilisateurs
            WHERE utilisateur_courriel= '$identifiant'";
    if ($result = mysqli_query($conn, $req)) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row['types_utilisateur_fk_id'];
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction chercherUtilisateurId
 * @brief trouve l'identifiant de l'utilisateur pour creer une inscription
 * @param $conn = contexte de connexion
 * @param $identifiant = le courriel de la personne
 * @return entier = l'identifiant de l'utilisateur 
 */
function chercherUtilisateurId($conn, $identifiant){
     $req = "SELECT utilisateur_id FROM utilisateurs 
             WHERE utilisateur_courriel = '$identifiant'";
    if ($result = mysqli_query($conn, $req)) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row['utilisateur_id'];
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction nombreMaximal
 * @brief trouve le nombre maximal des inscriptions permis pour une activité
 * @param $conn = contexte de connexion
 * @param $act_id = l'identifiant de l'activité
 * @return entier = nombre maximal des inscrits a une activité
 */
function nombreMaximal($conn, $act_id){
     $req = "SELECT activite_max_inscris FROM activites
             WHERE activite_id = '$act_id'";
    if ($result = mysqli_query($conn, $req)) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row['activite_max_inscris'];
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction nombreInscrit
 * @brief compte combiens des personnes sont inscrits a une *activité
 * @param $conn = contexte de connexion
 * @param $act_id = l'identifiant de l'activité
 * @return entier = nombre des inscrits a une activité
 */
function nombreInscrit($conn, $act_id){
     $req = "SELECT COUNT(inscriptions_utilisateur_id) AS nb_inscrit, inscription_activite_id AS act_id
             FROM inscriptions
             GROUP BY inscription_activite_id
             HAVING inscription_activite_id = '$act_id'";
    if ($result = mysqli_query($conn, $req)) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row['nb_inscrit'];
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction listerGenres
 * @brief affiche les catégories des activités 
 * @param $conn = contexte de connexion
 * @return $liste = tableau des catégories 
 */
function listerGenres($conn) {

    $req = "SELECT * FROM genres_activite";

     if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/**
* Fonction listerAnimateurs
 * @brief affiche la liste des animateurs 
 * @param $conn = contexte de connexion
 * @return $liste = tableau des résultats de SELECT
 */
function listerAnimateurs($conn) {

    $req = "SELECT utilisateur_id, utilisateur_nom, utilisateur_prenom, utilisateur_adress, utilisateur_courriel, CONCAT(utilisateur_prenom, ' ', utilisateur_nom) AS animateur FROM utilisateurs WHERE types_utilisateur_fk_id = 2";

     if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction lireUtilisateur
 * @brief affiche les données d'un utilisateur 
 * @param $conn = contexte de connexion
 * @param $id = clé primaire de l'utilisateur
 * @return $row = ligne correspondant à la clé primaire
 *                ligne vide si non trouvée     
 */
function lireUtilisateur($conn, $id) {

    $req = "SELECT * FROM utilisateurs WHERE utilisateur_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}


/**
 * Fonction listerToutesActivites
 * @brief affiche les activités 
 * @param $conn = contexte de connexion
 * @return $liste = tableau des activités
 *                  
 */
function listerToutesActivites($conn) {

    $req = "SELECT * FROM activites";

     if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction listerInscription
 * @brief affiche des informations concernant les inscriptions
 * @param $conn = contexte de connexion
 * @return $liste = tableau des résultats de SELECT 
 */
function listerInscriptions($conn) {

    $req = "SELECT activite_nom, utilisateur_nom, inscription_mode_paiement, 
            inscription_validation, inscription_id, activite_fk_animateur_id, utilisateur_prenom, activite_jour, 
            activite_heure, activite_max_inscris, utilisateur_courriel, activite_id, inscriptions_utilisateur_id, inscription_date
            FROM inscriptions
            INNER JOIN activites ON activite_id=inscription_activite_id
            INNER JOIN utilisateurs ON utilisateur_id=inscriptions_utilisateur_id";

     if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction listerActivites
 * @brief affiche les activites d'une catégories
 * @param $conn = contexte de connexion
 * @param $id = clé primaire de la catégories pour les activités 
 * @return $liste = tableau correspondant à la clé primaire
 *                  tableau vide si non trouvée      
 */
function listerActivites($conn, $id) {

    $req = "SELECT * FROM activites 
            WHERE activite_fk_genre_id=".$id;
    
     if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction detailsActivite
 * @brief affiche les détails d'une activité
 * @param $conn = contexte de connexion
 * @param $id = clé primaire de l'activité choisie
 * @return $row  = ligne correspondant à la clé primaire
 *                 ligne vide si non trouvée 
 */
function detailsActivite($conn, $id) {

    $req = "SELECT activite_nom, activite_id, utilisateur_id,
activite_max_inscris, 
activite_jour,
activite_heure,
genre_nom,
CONCAT(utilisateur_nom,' ', utilisateur_prenom) as animateur
FROM activites
INNER JOIN utilisateurs ON utilisateur_id = activite_fk_animateur_id
INNER JOIN genres_activite ON genre_id = activite_fk_genre_id
WHERE activite_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}


/**
 * Fonction detailsUtilisateur
 * @brief affiche les détails pour un utilisateur
 * @param $conn = contexte de connexion
 * @param $id = clé primaire pour l'utilisateur choisi
 * @return $liste = ligne correspondant à la clé primaire 
 *                  ligne vide si non trouvée  
 */
function detailsUtilisateur($conn, $id) {

    $req = "SELECT utilisateur_id, utilisateur_nom, utilisateur_prenom, utilisateur_adress,
utilisateur_courriel, 
utilisateur_motdepass,
type_role, activite_nom
FROM utilisateurs
INNER JOIN types_utilisateur ON type_id = types_utilisateur_fk_id
INNER JOIN activites ON utilisateur_id = activite_fk_animateur_id
WHERE utilisateur_id=".$id;
    
      if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction inscriprionParUtilisateur
 * @brief affiche les inscriptions pour chaque utilisateur
 * @param $conn = contexte de connexion
 * @param $id = clé primaire de l'utilisateur 
 * @return $liste  = ligne correspondant à la clé primaire
 *                   ligne vide si non trouvée  
 */
function inscriprionParUtilisateur($conn, $id) {

    $req = "SELECT inscription_activite_id, inscription_id
            FROM inscriptions
            WHERE inscriptions_utilisateur_id =".$id;
    
    if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction activiteParUtilisateur
 * @brief affiche toutes les activités d'un utilisateur
 * @param $conn = contexte de connexion
 * @return $liste  = tableau des résultats de SELECT    
 */
function activiteParUtilisateur($conn) {

    $req = "SELECT activite_nom, CONCAT(utilisateur_prenom, ' ', utilisateur_nom) AS animateur, activite_jour, activite_heure,    inscriptions_utilisateur_id as id, inscription_validation
            FROM activites
            INNER JOIN inscriptions ON activite_id=inscription_activite_id
            INNER JOIN utilisateurs ON utilisateur_id=activite_fk_animateur_id";
    
     if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction listerActivitesAdmin
 * @brief affiche les activités par genre
 * @param $conn = contexte de connexion
 * @param $tri_critere = choix de la catégorie
 * @return $liste  = tablesu des activités pour la catégorie sélectionné
 */
function listerActivitesAdmin($conn, $tri_critere) {

    $req = "SELECT activite_nom, activite_jour, activite_heure, activite_id, activite_fk_animateur_id, genre_id 
            FROM activites
            INNER JOIN genres_activite ON genre_id = activite_fk_genre_id
            WHERE genre_nom = '$tri_critere'";

     if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/** 
 * Fonction sqlRegistration
 * @brief ajouter une ligne dans la table des utilisateurs 
 * @param $conn = contexte de connexion
 * @param $utilisateur_nom  = nom de l'utilisateur
 * @param $utilisateur_prenom = prenom de l'utilisateur
 * @param $utilisateur_adres = adresse de l'utilisateur
 * @param $utilisateur_courriel = courriel de l'utilisateur
 * @param $utilisateur_password = mot de passe de l'utilisteur
 * @return  1 si ajout effectuée
 *          0 si aucun ajout
 */
function sqlRegistration($conn, $utilisateur_nom, $utilisateur_prenom, $utilisateur_adress, $utilisateur_courriel, $utilisateur_password) {
    
    $req = "INSERT INTO utilisateurs 
            SET utilisateur_nom ='$utilisateur_nom', utilisateur_prenom='$utilisateur_prenom', utilisateur_adress='$utilisateur_adress', utilisateur_courriel='$utilisateur_courriel', utilisateur_motdepass = SHA2('$utilisateur_password', 256), types_utilisateur_fk_id=3";
    
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction creerInscription
 * @brief ajouter une ligne dans la table inscriptions 
 * @param $conn = contexte de connexion
 * @param $act_id  = identifiant de l'activité choisie
 * @param $utilisateur_id = identifiant de l'utilisateur inscrit
 * @param $paiement = mode de paiement
 * @return  1 si inscription effectuée
 *          0 si aucun inscription
 */

function creerInscription($conn, $act_id,  $utilisateur_id, $paiement){
    $req = "INSERT INTO inscriptions (inscription_activite_id, inscriptions_utilisateur_id, 	inscription_mode_paiement, inscription_date)
            VALUES('$act_id', '$utilisateur_id', '$paiement', CURDATE())
            ";
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else { 
        if(mysqli_errno($conn) == 1062)
          echo "<h1 id='err1062'>Vous etes déja inscrit à cette activité<br></h1>";
        else if(mysqli_errno($conn) == 1366)
          echo "<h1 id='err1062'>Courriel saisi est incorrect.<br></h1>";
        else
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction ajoutActivite
 * @brief créer une nouvelle ligne dans la table des activités
 * @param $conn = contexte de connexion
 * @param $activite_nom  = nom pour la nouvelle activité
 * @param $activite_max_inscris  = nombre maximal des inscrits
 * @param $activite_fk_genre_id  = identifiant du genre 
 * @param $activite_fk_animateur_id  = identifiant de l'animateur
 * @param $activite_jour  = le jour de l'activité
 * @param $activite_heure  = l'heure de l'activité 
 * @return  1 si ajout effectuée
 *          0 si aucun ajout
 */
function ajoutActivite($conn, $activite_nom, $activite_max_inscris,  $activite_fk_genre_id, $activite_fk_animateur_id, $activite_jour, $activite_heure){
    $req = "INSERT INTO activites (activite_nom, activite_max_inscris, 	activite_fk_genre_id, activite_fk_animateur_id, activite_jour, activite_heure)
            VALUES('$activite_nom', '$activite_max_inscris', '$activite_fk_genre_id', '$activite_fk_animateur_id', '$activite_jour', '$activite_heure')
            ";
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else { 
        if(mysqli_errno($conn) == 1062)
          echo "<h1 id='err1062'>Vous etes déja inscrit à cette activité<br></h1>";
        else if(mysqli_errno($conn) == 1366)
          echo "<h1 id='err1062'>Courriel saisi est incorrect.<br></h1>";
        else
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction ajoutAnimateur
 * @brief créer une nouvelle ligne dans a table des utilisateurs
 * @param $conn = contexte de connexion
 * @param $utilisateur_nom  = nom du nouveau animateur
 * @param $utilisateur_prenom  = prénom du nouveau animateur
 * @param $utilisateur_adress  = adresse du nouveau animateur
 * @param $utilisateur_courriel  = courriel du nouveau animateur
 * @param $utilisateur_motdepass  = mot de passe de nouveau animateur
 * @return  1 si ajout effectué
 *          0 si aucun ajout
 */
function ajoutAnimateur($conn, $utilisateur_nom, $utilisateur_prenom,  $utilisateur_adress, $utilisateur_courriel, $utilisateur_motdepass){
    $req = "INSERT INTO utilisateurs (utilisateur_nom, utilisateur_prenom, utilisateur_adress, utilisateur_courriel, utilisateur_motdepass,types_utilisateur_fk_id)
            VALUES('$utilisateur_nom', '$utilisateur_prenom', '$utilisateur_adress', '$utilisateur_courriel', SHA2('$utilisateur_motdepass', 256), '2')";
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else { 
        if(mysqli_errno($conn) == 1062)
          echo "<h1 id='err1062'>Vous etes déja inscrit à cette activité<br></h1>";
        else if(mysqli_errno($conn) == 1366)
          echo "<h1 id='err1062'>Courriel saisi est incorrect.<br></h1>";
        else
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction validerInscription
 * @brief donne la possibilité de valider une inscription
 * @param $conn = contexte de connexion
 * @param $inscription_id  = identifiant de l'inscription choisie
 * @return  1 si validation effectuée 
 *          0 si aucun validation
 */

function validerInscription($conn, $inscription_id){
    $req = "UPDATE inscriptions SET inscription_validation=1 WHERE inscription_id=
            ".$inscription_id;
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else { 
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction chercherClient
 * @brief affiche la liste des utilisateurs
 * @param $conn = contexte de connexion
 * @return  $liste  = tableau des utilisateurs
 *                  tableau vide si non trouvé      
 */
function chercherClient($conn) {

    $req = "SELECT * FROM utilisateurs";
    
     if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction listerClients
 * @brief affiche la liste des utilisateurs avec certains données
 * @param $conn = contexte de connexion
 * @return  $liste  = tableau avec les résultats du SELECT    
 */
function listerClients($conn) {

    $req = "SELECT * FROM utilisateurs 
            WHERE types_utilisateur_fk_id='3'
            ORDER BY utilisateur_nom ASC";
    
     if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $liste[] = $row;
            }
        }
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction chercherInscription
 * @brief affiche la ligne d'une inscription
 * @param $conn = contexte de connexion
 * @param $id = clé primaire de l'inscription 
 * @return  $row  = ligne correspondant à la clé primaire
 *                  ligne vide si non trouvée     
 */
function chercherInscription($conn, $id) {

    $req = "SELECT * FROM inscriptions WHERE inscription_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}



/** 
* Fonction modifierActivite
 * @brief modifier une ligne dans la table des activités
 * @param $conn = contexte de connexion
 * @param $id = clé primaire de l'activité
 * @param $activite_nom = nom modifié
 * @param $animateur_id = identifiant du nouveau animateur
 * @param $activite_max_inscris = nombre maximal des inscrits
 * @param $activite_jour = jour modifié de l'activité
 * @param $activite_heure = heure modifiée de l'activité 
 * @return  1 si modification effectuée
 *          0 si aucune modification
 */
function modifierActivite($conn, $id, $activite_nom, $animateur_id, $activite_max_inscris, $activite_jour, $activite_heure) {
    
    $req = "UPDATE activites SET activite_nom='$activite_nom', activite_fk_animateur_id = '$animateur_id', activite_max_inscris = '$activite_max_inscris', activite_jour = '$activite_jour', activite_heure = '$activite_heure' WHERE activite_id =".$id;
 
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}



/** 
 * Fonction modifierUtilisateur
 * @brief modifier une ligne dans la table utilisateurs
 * @param $conn = contexte de connexion
 * @param $id = clé primaire de l'utilisateur
 * @param $utilisateur_nom = nom modifié
 * @param $utilisateur_prenom = prénom modifié
 * @param $utilisateur_adress = adresse modifié
 * @param $utilisateur_courriel = courriel modifié
 * @param $utilisateur_motdepass = mot de passe modifié  
 * @return 1 si modification effectuée
 *         0 si aucune modification 
 */
function modifierUtilisateur($conn, $id, $utilisateur_nom, $utilisateur_prenom, $utilisateur_adress, $utilisateur_courriel, $utilisateur_motdepass) {
    
    $req = "UPDATE utilisateurs SET utilisateur_nom='$utilisateur_nom', utilisateur_prenom = '$utilisateur_prenom', utilisateur_adress = '$utilisateur_adress', utilisateur_courriel = '$utilisateur_courriel', utilisateur_motdepass = SHA2('$utilisateur_motdepass', 256) WHERE utilisateur_id =".$id;
 
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction supprimerInscription
 * @brief supprimer une ligne de la table inscriptions
 * @param $conn = contexte de connexion
 * @param $id   = valeur de la clé primaire 
 * @return  1 si suppression effectuée
 *          0 si aucune suppression 
 */
function supprimerInscription($conn, $id) {
    
    $req = "DELETE FROM inscriptions WHERE inscription_id=".$id;

    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction supprimerActivite
 * @brief supprimer une ligne de la table activités
 * @param $conn = contexte de connexion
 * @param $id   = clé primaire de l'activité
 * @return  1 si suppression effectuée
 *          0 si aucune suppression 
 */
function supprimerActivite($conn, $id) {
    
    $req = "DELETE FROM activites WHERE activite_id=".$id;

    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}



/**
 * Fonction supprimerUtilisateur
 * @brief supprimer une ligne de la table utilisateurs
 * @param $conn = contexte de connexion
 * @param $id   = clé primaire de l'utilisateur
 * @return  1 si suppression effectuée
 *          0 si aucune suppression 
 */
function supprimerUtilisateur($conn, $id) {
    
    $req = "DELETE FROM utilisateurs WHERE utilisateur_id=".$id;

    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}

?>