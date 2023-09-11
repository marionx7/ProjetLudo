<?php
require_once("inc/init.inc.php");
require_once("inc/header.inc.php");

$contenu .= '<div class="emprunt">';

//------------------------- AFFICHAGE DES OPTIONS DE RECHERCHE ------------------------------------------------------------------------//

$contenu .= '<div class="aside">';

//------ afficher tous les jeux ----------//
$contenu .= '</br></br></br></br><a href="?action=tout_afficher" style="color:#ffff; text-decoration:none">Afficher tous les jeux</a></br></br></br></br>';

//------ recherche ----------------------//
$contenu .= '<form class="search-bar" method="GET" style="background-color:#c23e63; padding:0px" action="" role="search">
<label class="sr-only" for="search">Recherche</label>
<input type="search" id="search" name="search" placeholder="Rechercher..." />&nbsp
<button  type="submit">
    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="white" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
</button>
</form></br></br></br></br>';

//------ recherche avancée ----------//
$contenu .= '<form class="search-bar" method="GET" style="background-color:#c23e63; padding:0px" action="'.$_SERVER['PHP_SELF'].'" role="recherche_avancee">';
$contenu .= '<label><b>Recherche avancée :</b></label><br><br>';
// Récupération des noms d'éditeur existants dans la base de données
$resultat_editeurs = executeRequete("SELECT DISTINCT editeur_jeu FROM jeu");
// liste déroulante noms d'éditeur
$contenu .= '<select type="order" name="nom_editeur" id="nom_editeur">';
$contenu .= '<option value="" style="background-color:#c23e63; padding:0px">Tous les éditeurs</option>'; // Option par défaut pour afficher tous les éditeurs
    while ($editeur = $resultat_editeurs->fetch_assoc()) {
        $nom_editeur = $editeur['editeur_jeu'];
        $contenu .= "<option style='background-color:#c23e63; padding:0px' value=\"$nom_editeur\" >$nom_editeur</option>";
    }
$contenu .= '</select><br><br>';
// choix du nombre de joueurs
$contenu .= '<label for="nbr_joueurs">Nombre de joueurs :</label>';
$contenu .= '<input type="number" id="nbr_joueurs" name="nbr_joueurs" style="width: 70px; background: transparent; font-size: 20px; margin: 10px; border-radius: 5px;"><br>';
// age du joueur le plus jeune
$contenu .= '<label for="age_joueur">Age plus jeune joueur :</label>';
$contenu .= '<input type="number" id="age_joueur" name="age_joueur" style="width: 50px; background: transparent; font-size: 20px; margin: 10px; border-radius: 5px;"><br><br>';
// option jeux dispo uniquement
$contenu .= '<input type="checkbox" id="disponibilite" name="disponibilite">';
$contenu .= '<label for="disponibilite">&nbsp;&nbsp;Jeux disponibles uniquement</label>';
// validation du formulaire        
$contenu .= '<br><br><button type="submit">';
$contenu .= '<svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="white" class="bi bi-search" viewBox="0 0 16 16">';
$contenu .= '<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>';
$contenu .= '</svg>';
$contenu .= '</button>';
$contenu .= '</form>';

$contenu .= '</br></br></br></br>';
$contenu .= '</div>';

//------------- AFFICHAGE TOUS LES JEUx -----------------------------------------------------------------------------------//

if(isset($_GET['action']) == "tout_afficher")
{
    $contenu .= '<div class="collection">';
    $donnees = executeRequete("SELECT id_jeu,nom_jeu,editeur_jeu,description_jeu,photo,age_mini,nbr_mini,nbr_maxi,statut_jeu from jeu ORDER BY nom_jeu ASC");  
    while($jeu = $donnees->fetch_assoc())
    {
        $contenu .= '<a style="text-decoration:none;" href="fiche_jeu.php?id_jeu=' . $jeu['id_jeu'] . '"><div class="collection-jeu">';
        $contenu .= "<h style='color:#535294; '>$jeu[nom_jeu]</h></br></br>";
        $contenu .= "<a href=\"fiche_jeu.php?id_jeu=$jeu[id_jeu]\"><img src=\"$jeu[photo]\" =\"130\" height=\"100\"></a>";
        $contenu .= "<p>$jeu[editeur_jeu]</p>";
        $contenu .= "<p>de $jeu[nbr_mini] à $jeu[nbr_maxi] joueurs</p>";
        $contenu .= "<p>A partir de $jeu[age_mini] ans</p>";
        // Condition pour le statut du jeu
        if ($jeu['statut_jeu'] == 'indisponible') {
            $contenu .= '<p style="color: #b90000;"><b>' . $jeu['statut_jeu'] . '</b></p>';
        } elseif ($jeu['statut_jeu'] == 'disponible') {
            $contenu .= '<p style="color: #669933;"><b>' . $jeu['statut_jeu'] . '</b></p>';
        } else {
            $contenu .= '<p>' . $jeu['statut_jeu'] . '</p>';
        }
        $contenu .= '</div></a>';
    }
    $contenu .= '</div>';
} 
//------------- AFFICHAGE RECHERCHE -----------------------------------------------------------------------------------//

if(isset($_GET['search']) AND !empty($_GET['search']) == "affichage_recherche")
{
    $contenu .= '<div class="collection">';
    $search = htmlspecialchars($_GET['search']);
    $resultat = executeRequete("SELECT id_jeu,nom_jeu,editeur_jeu,description_jeu,photo,age_mini,nbr_mini,nbr_maxi,statut_jeu from jeu WHERE CONCAT(nom_jeu, editeur_jeu) LIKE '%$search%' ORDER BY nom_jeu ASC");  
    if ($resultat->num_rows > 0) {
    while($jeu = $resultat->fetch_assoc())
    {
        $contenu .= '<a style="text-decoration:none;" href="fiche_jeu.php?id_jeu=' . $jeu['id_jeu'] . '"><div class="collection-jeu">';
        $contenu .= "<h style='color:#535294; '>$jeu[nom_jeu]</h></br></br>";
        $contenu .= "<a href=\"fiche_jeu.php?id_jeu=$jeu[id_jeu]\"><img src=\"$jeu[photo]\" =\"130\" height=\"100\"></a>";
        $contenu .= "<p>$jeu[editeur_jeu]</p>";
        $contenu .= "<p>de $jeu[nbr_mini] à $jeu[nbr_maxi] joueurs</p>";
        $contenu .= "<p>A partir de $jeu[age_mini] ans</p>";
        // Condition pour le statut du jeu
        if ($jeu['statut_jeu'] == 'indisponible') {
            $contenu .= '<p style="color: #b90000;"><b>' . $jeu['statut_jeu'] . '</b></p>';
        } elseif ($jeu['statut_jeu'] == 'disponible') {
            $contenu .= '<p style="color: #669933;"><b>' . $jeu['statut_jeu'] . '</b></p>';
        } else {
            $contenu .= '<p>' . $jeu['statut_jeu'] . '</p>';
        }
        $contenu .= '</div></a>';
    }
    $contenu .= '</div>';
    }
    else {
    $contenu .= '<div class="collection-jeu">Acun résultat trouvé</div>';
    }
}

//-------------------- AFFICHAGE RECHERCHE AVANCEE ----------------------------------------------------------------//
if (isset($_GET['nom_editeur']) || isset($_GET['nbr_joueurs'])) {
    $contenu .= '<div class="collection">';
    $recherche_avancee = true;
    $nbr_joueurs = isset($_GET['nbr_joueurs']) && !empty($_GET['nbr_joueurs']) ? $_GET['nbr_joueurs'] : null;
    $nom_editeur = $_GET['nom_editeur'];
    $age_joueur = isset($_GET['age_joueur']) && !empty($_GET['age_joueur']) ? $_GET['age_joueur'] : null;
    // Construction de la requête SQL
    $requete = "SELECT id_jeu, nom_jeu, editeur_jeu, description_jeu, photo, age_mini, nbr_mini, nbr_maxi, statut_jeu
            FROM jeu
            WHERE 1";
                if ($nbr_joueurs !== null) {
                    $requete .= " AND nbr_mini <= $nbr_joueurs AND nbr_maxi >= $nbr_joueurs";
                }
                if (!empty($nom_editeur)) {
                    $requete .= " AND editeur_jeu = '$nom_editeur'";
                }
                if ($age_joueur !== null) {
                    $requete .= " AND age_mini <= $age_joueur";
                }
                if (isset($_GET['disponibilite']) && $_GET['disponibilite'] == 'on') {
                    $requete .= " AND statut_jeu = 'disponible'";
                }
    $requete .= " ORDER BY nom_jeu ASC";

    $resultat = executeRequete($requete);

    if ($resultat->num_rows > 0) {
        while ($jeu = $resultat->fetch_assoc()) {
            $contenu .= '<a style="text-decoration:none;" href="fiche_jeu.php?id_jeu=' . $jeu['id_jeu'] . '"><div class="collection-jeu">';
            $contenu .= "<h style='color:#535294; '>$jeu[nom_jeu]</h></br></br>";
            $contenu .= "<a href=\"fiche_jeu.php?id_jeu=$jeu[id_jeu]\"><img src=\"$jeu[photo]\" =\"130\" height=\"100\"></a>";
            $contenu .= "<p>$jeu[editeur_jeu]</p>";
            $contenu .= "<p>de $jeu[nbr_mini] à $jeu[nbr_maxi] joueurs</p>";
            $contenu .= "<p>A partir de $jeu[age_mini] ans</p>";
            // Condition pour le statut du jeu
            if ($jeu['statut_jeu'] == 'indisponible') {
                $contenu .= '<p style="color: #b90000;"><b>' . $jeu['statut_jeu'] . '</b></p>';
            } elseif ($jeu['statut_jeu'] == 'disponible') {
                $contenu .= '<p style="color: #669933;"><b>' . $jeu['statut_jeu'] . '</b></p>';
            } else {
                $contenu .= '<p>' . $jeu['statut_jeu'] . '</p>';
            }
            $contenu .= '</div></a>';
        }
        $contenu .= '</div>';
    } else {
        $contenu .= '<div class="collection-jeu">Aucun résultat trouvé</div>';
    }
}

//--------------------------------- AFFICHAGE HTML ---------------------------------//

echo $contenu;
$contenu .= '</div>';

require_once("inc/footer.inc.php"); 
?>