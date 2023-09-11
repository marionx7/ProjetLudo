<?php
require_once("inc/init.inc.php");

require_once("inc/header.inc.php");

//------------------------------------------ TRAITEMENTS PHP ---------------------------------//

if(!internauteEstConnecte()) header("location:connexion.php");
// debug($_SESSION);

//----------------------- BARRE NAVIGATION -----------------------------------------------------//
echo '
<div class="gestion-header">
    <nav class="gestion-nav">
    <u1>
        <li class="gestion-nav-item"><a href="?action=affichage_reservation">Afficher toutes les réservations</a></li>
        <li class="gestion-nav-item"><form class="search-bar" method="GET" style="background-color:#c23e63; padding:0px" action="" role="search">
            <input type="search" id="search" name="search" placeholder="Rechercher..." />&nbsp
            <button  type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="white" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
            </button>
        </form></li>
        <li class="gestion-nav-item"><form class="search-bar" method="GET" style="background-color:#c23e63; padding:0px" >
            <select type="order" id="order" name="order" >
                <option value="en_attente" style="background-color:#c23e63; padding:0px"  selected>En Attente</option>
                <option value="validee" style="background-color:#c23e63; padding:0px" >Validées</option>
		        <option value="rejetee" style="background-color:#c23e63; padding:0px" >Rejetées</option>
            </select>&nbsp
            <button  type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="white" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
            </button>
        </form></li>
    </u1></nav></div>';

//------------------------------------- texte ----------------------------------------------------------------------//

if (isset($_SESSION['message_reservation'])) {
    echo "<div class='validation'>{$_SESSION['message_reservation']}</div>";
    unset($_SESSION['message_reservation']); // Supprimer le message de la session après l'avoir affiché
}


$contenu .= '</br><div style="width: 920px; margin:auto; border: 3px solid #ffff;">Pensez à vérifier le statut de vos réservations : </br>
    - <b><font color="#535294">En attente</font></b> : votre réservation n\'a pas encore été traitée par nos ludothèquaires </br>
    - <b><font color="#669933">Validée</font></b> : votre réservation a été acceptée, votre jeu vous attendra à la ludothèque le jour demandé</br>
    - <b><font color="#b90000">Refusée</font></b> : votre réservation n\'a pas été acceptée. Si vous souhaitez en connaître la raison, n\'hésitez pas à contacter la ludothèque
    </div><br>';

//------------------------------------- SUPPRESSION RESERVATION -------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "suppression_reservation")
{   
    $resultat = executeRequete("SELECT * FROM reservation WHERE id_reservation=$_GET[id_reservation]");
    $reservation_a_supprimer = $resultat->fetch_assoc();
    $contenu .= '<div class="validation" style="width: 920px; margin:auto; border: 3px solid #ffff; text-align: center;">Suppression de la réservation</div>';
    executeRequete("DELETE FROM reservation WHERE id_reservation=$_GET[id_reservation]");
}

//------------------------------------- AFFICHAGE RESERVATIONS --------------------------------------------------------//
if (isset($_GET['action']) && $_GET['action'] == "affichage_reservation") {
    $resultat = executeRequete("SELECT id_reservation, nom_semaine, id_jeu, nom_jeu, date_enregistrement, statut_reservation FROM vue_reservation WHERE id_membre = {$_SESSION['membre']['id_membre']} ORDER BY date_enregistrement DESC");
    //-------tableau  
    $contenu .= '<div style="width: 980px; margin:auto; border: 3px solid #dddd; text-align: center;"><table class="table"><tr class="table-header">';
    $colonnes = $resultat->fetch_fields();
    foreach ($colonnes as $colonne) {
        // Vérifier si la colonne n'est pas "id_reservation" ou "id_jeu"
        if ($colonne->name !== "id_reservation" && $colonne->name !== "id_jeu") {
            $contenu .= '<th class="header__item"><a id="' . $colonne->name . '" class="filter__link" href="#">' . $colonne->name . '</a></th>';
        }
    }
    $contenu .= '<th class="header__item">Voir Fiche</th>';
    $contenu .= '<th class="header__item">Supprimer</th>';
    $contenu .= '</tr>';
    $contenu .= '<div class="table-content">';
    while ($ligne = $resultat->fetch_assoc()) {
        $contenu .= '<tr class="table-row">';
        foreach ($ligne as $indice => $information) {
            // Vérifier si l'indice n'est pas "id_reservation" ou "id_jeu"
            if ($indice !== 'id_reservation' && $indice !== 'id_jeu') {
                if ($indice === 'statut_reservation') {
                    switch ($information) {
                        case '0':
                            $information = '<p style="color:#535294;"><b>En attente</b></p>';
                            break;
                        case '1':
                            $information = '<p style="color:#669933;"><b>Validée</b></p>';
                            break;
                        case '2':
                            $information = '<p style="color:#b90000;"><b>Rejetée</b></p>';
                            break;
                        default:
                            $information = '';
                            break;
                    }
                }
                $contenu .= '<td class="table-data">' . $information . '</td>';
            }
        }
        $contenu .= '<td><a class="footer-social-icon" href="fiche_jeu.php?id_jeu=' . $ligne['id_jeu'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="blue" class="bi bi-eye-fill" viewBox="0 0 16 16">
        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
        </svg></a></td>';
        $contenu .= '<td><a class="footer-social-icon" href="?action=suppression_reservation&id_reservation=' . $ligne['id_reservation'] .'" OnClick="return(confirm(\'En êtes-vous certain ?\'));"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-trash-fill" viewBox="0 0 16 16">
            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
        </svg></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</div>';
    $contenu .= '</table></div><br>';
}


//-------------------- AFFICHAGE RESULTAT RECHERCHE --------------------------------------------------------------//

if(isset($_GET['search']) AND !empty($_GET['search']) == "affichage_recherche")
{
    $search = htmlspecialchars($_GET['search']);
    $resultat = executeRequete("SELECT id_reservation, nom_semaine, id_jeu, nom_jeu, date_enregistrement, statut_reservation FROM vue_reservation WHERE id_membre = {$_SESSION['membre']['id_membre']} AND CONCAT(nom_semaine, nom, prenom, email, nom_jeu, statut_reservation) LIKE '%$search%' ORDER BY date_enregistrement DESC");
//-------tableau  
$contenu .= '<div style="width: 980px; margin:auto; border: 3px solid #dddd; text-align: center;"><table class="table"><tr class="table-header">';
$colonnes = $resultat->fetch_fields();
foreach ($colonnes as $colonne) {
    // Vérifier si la colonne n'est pas "id_reservation" ou "id_jeu"
    if ($colonne->name !== "id_reservation" && $colonne->name !== "id_jeu") {
        $contenu .= '<th class="header__item"><a id="' . $colonne->name . '" class="filter__link" href="#">' . $colonne->name . '</a></th>';
    }
}
$contenu .= '<th class="header__item">Voir Fiche</th>';
$contenu .= '<th class="header__item">Supprimer</th>';
$contenu .= '</tr>';
$contenu .= '<div class="table-content">';
while ($ligne = $resultat->fetch_assoc()) {
    $contenu .= '<tr class="table-row">';
    foreach ($ligne as $indice => $information) {
        // Vérifier si l'indice n'est pas "id_reservation" ou "id_jeu"
        if ($indice !== 'id_reservation' && $indice !== 'id_jeu') {
            if ($indice === 'statut_reservation') {
                switch ($information) {
                    case '0':
                        $information = '<p style="color:#535294;"><b>En attente</b></p>';
                        break;
                    case '1':
                        $information = '<p style="color:#669933;"><b>Validée</b></p>';
                        break;
                    case '2':
                        $information = '<p style="color:#b90000;"><b>Rejetée</b></p>';
                        break;
                    default:
                        $information = '';
                        break;
                }
            }
            $contenu .= '<td class="table-data">' . $information . '</td>';
        }
    }
    $contenu .= '<td><a class="footer-social-icon" href="fiche_jeu.php?id_jeu=' . $ligne['id_jeu'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="blue" class="bi bi-eye-fill" viewBox="0 0 16 16">
    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
    </svg></a></td>';
    $contenu .= '<td><a class="footer-social-icon" href="?action=suppression_reservation&id_reservation=' . $ligne['id_reservation'] .'" OnClick="return(confirm(\'En êtes-vous certain ?\'));"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
    </svg></a></td>';
    $contenu .= '</tr>';
}
$contenu .= '</div>';
$contenu .= '</table></div><br>';
}


//-------------------- AFFICHAGE reservation par statut --------------------------------------------------------------//
if(isset($_GET['order']) && $_GET['order'] == "en_attente") {
    $resultat = executeRequete("SELECT id_reservation, nom_semaine, id_jeu, nom_jeu, date_enregistrement, statut_reservation FROM vue_reservation WHERE id_membre = {$_SESSION['membre']['id_membre']} AND statut_reservation = '0' ORDER BY date_enregistrement DESC");
//-------tableau  
$contenu .= '<div style="width: 980px; margin:auto; border: 3px solid #dddd; text-align: center;"><table class="table"><tr class="table-header">';
$colonnes = $resultat->fetch_fields();
foreach ($colonnes as $colonne) {
    // Vérifier si la colonne n'est pas "id_reservation" ou "id_jeu"
    if ($colonne->name !== "id_reservation" && $colonne->name !== "id_jeu") {
        $contenu .= '<th class="header__item"><a id="' . $colonne->name . '" class="filter__link" href="#">' . $colonne->name . '</a></th>';
    }
}
$contenu .= '<th class="header__item">Voir Fiche</th>';
$contenu .= '<th class="header__item">Supprimer</th>';
$contenu .= '</tr>';
$contenu .= '<div class="table-content">';
while ($ligne = $resultat->fetch_assoc()) {
    $contenu .= '<tr class="table-row">';
    foreach ($ligne as $indice => $information) {
        // Vérifier si l'indice n'est pas "id_reservation" ou "id_jeu"
        if ($indice !== 'id_reservation' && $indice !== 'id_jeu') {
            if ($indice === 'statut_reservation') {
                switch ($information) {
                    case '0':
                        $information = '<p style="color:#535294;"><b>En attente</b></p>';
                        break;
                    case '1':
                        $information = '<p style="color:#669933;"><b>Validée</b></p>';
                        break;
                    case '2':
                        $information = '<p style="color:#b90000;"><b>Rejetée</b></p>';
                        break;
                    default:
                        $information = '';
                        break;
                }
            }
            $contenu .= '<td class="table-data">' . $information . '</td>';
        }
    }
    $contenu .= '<td><a class="footer-social-icon" href="fiche_jeu.php?id_jeu=' . $ligne['id_jeu'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="blue" class="bi bi-eye-fill" viewBox="0 0 16 16">
    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
    </svg></a></td>';
    $contenu .= '<td><a class="footer-social-icon" href="?action=suppression_reservation&id_reservation=' . $ligne['id_reservation'] .'" OnClick="return(confirm(\'En êtes-vous certain ?\'));"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
    </svg></a></td>';
    $contenu .= '</tr>';
}
$contenu .= '</div>';
$contenu .= '</table></div><br>';
}

if(isset($_GET['order']) && $_GET['order'] == "validee") {
    $resultat = executeRequete("SELECT id_reservation, nom_semaine, id_jeu, nom_jeu, date_enregistrement, statut_reservation FROM vue_reservation WHERE id_membre = {$_SESSION['membre']['id_membre']} AND statut_reservation = '1' ORDER BY date_enregistrement DESC");
//-------tableau  
$contenu .= '<div style="width: 980px; margin:auto; border: 3px solid #dddd; text-align: center;"><table class="table"><tr class="table-header">';
$colonnes = $resultat->fetch_fields();
foreach ($colonnes as $colonne) {
    // Vérifier si la colonne n'est pas "id_reservation" ou "id_jeu"
    if ($colonne->name !== "id_reservation" && $colonne->name !== "id_jeu") {
        $contenu .= '<th class="header__item"><a id="' . $colonne->name . '" class="filter__link" href="#">' . $colonne->name . '</a></th>';
    }
}
$contenu .= '<th class="header__item">Voir Fiche</th>';
$contenu .= '<th class="header__item">Supprimer</th>';
$contenu .= '</tr>';
$contenu .= '<div class="table-content">';
while ($ligne = $resultat->fetch_assoc()) {
    $contenu .= '<tr class="table-row">';
    foreach ($ligne as $indice => $information) {
        // Vérifier si l'indice n'est pas "id_reservation" ou "id_jeu"
        if ($indice !== 'id_reservation' && $indice !== 'id_jeu') {
            if ($indice === 'statut_reservation') {
                switch ($information) {
                    case '0':
                        $information = '<p style="color:#535294;"><b>En attente</b></p>';
                        break;
                    case '1':
                        $information = '<p style="color:#669933;"><b>Validée</b></p>';
                        break;
                    case '2':
                        $information = '<p style="color:#b90000;"><b>Rejetée</b></p>';
                        break;
                    default:
                        $information = '';
                        break;
                }
            }
            $contenu .= '<td class="table-data">' . $information . '</td>';
        }
    }
    $contenu .= '<td><a class="footer-social-icon" href="fiche_jeu.php?id_jeu=' . $ligne['id_jeu'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="blue" class="bi bi-eye-fill" viewBox="0 0 16 16">
    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
    </svg></a></td>';
    $contenu .= '<td><a class="footer-social-icon" href="?action=suppression_reservation&id_reservation=' . $ligne['id_reservation'] .'" OnClick="return(confirm(\'En êtes-vous certain ?\'));"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
    </svg></a></td>';
    $contenu .= '</tr>';
}
$contenu .= '</div>';
$contenu .= '</table></div><br>';
}


if(isset($_GET['order']) && $_GET['order'] == "rejetee") {
    $resultat = executeRequete("SELECT id_reservation, nom_semaine, id_jeu, nom_jeu, date_enregistrement, statut_reservation FROM vue_reservation WHERE id_membre = {$_SESSION['membre']['id_membre']} AND statut_reservation = '2' ORDER BY date_enregistrement DESC");
    //-------tableau  
    $contenu .= '<div style="width: 980px; margin:auto; border: 3px solid #dddd; text-align: center;"><table class="table"><tr class="table-header">';
    $colonnes = $resultat->fetch_fields();
    foreach ($colonnes as $colonne) {
        // Vérifier si la colonne n'est pas "id_reservation" ou "id_jeu"
        if ($colonne->name !== "id_reservation" && $colonne->name !== "id_jeu") {
            $contenu .= '<th class="header__item"><a id="' . $colonne->name . '" class="filter__link" href="#">' . $colonne->name . '</a></th>';
        }
    }
    $contenu .= '<th class="header__item">Voir Fiche</th>';
    $contenu .= '<th class="header__item">Supprimer</th>';
    $contenu .= '</tr>';
    $contenu .= '<div class="table-content">';
    while ($ligne = $resultat->fetch_assoc()) {
        $contenu .= '<tr class="table-row">';
        foreach ($ligne as $indice => $information) {
            // Vérifier si l'indice n'est pas "id_reservation" ou "id_jeu"
            if ($indice !== 'id_reservation' && $indice !== 'id_jeu') {
                if ($indice === 'statut_reservation') {
                    switch ($information) {
                        case '0':
                            $information = '<p style="color:#535294;"><b>En attente</b></p>';
                            break;
                        case '1':
                            $information = '<p style="color:#669933;"><b>Validée</b></p>';
                            break;
                        case '2':
                            $information = '<p style="color:#b90000;"><b>Rejetée</b></p>';
                            break;
                        default:
                            $information = '';
                            break;
                    }
                }
                $contenu .= '<td class="table-data">' . $information . '</td>';
            }
        }
        $contenu .= '<td><a class="footer-social-icon" href="fiche_jeu.php?id_jeu=' . $ligne['id_jeu'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="blue" class="bi bi-eye-fill" viewBox="0 0 16 16">
        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
        </svg></a></td>';
        $contenu .= '<td><a class="footer-social-icon" href="?action=suppression_reservation&id_reservation=' . $ligne['id_reservation'] .'" OnClick="return(confirm(\'En êtes-vous certain ?\'));"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-trash-fill" viewBox="0 0 16 16">
            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
        </svg></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</div>';
    $contenu .= '</table></div><br>';
}

//--------------------------------- AFFICHAGE HTML ---------------------------------//

echo $contenu;
require_once("inc/footer.inc.php");
