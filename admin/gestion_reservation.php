
<?php
require_once("../inc/init.inc.php");

//----------------------- TRAITEMENTS PHP -----------------------------------------------------//

//--- VERIFICATION ADMIN ---//
if(!internauteEstConnecteEtEstAdmin())
{
    header("location:../connexion.php");
    exit();
}
 
require_once("../inc/header.inc.php");

//----------------------- BARRE NAVIGATION -----------------------------------------------------//
$contenu .= '<div class="gestion-header">';
$contenu .= '<nav class="gestion-nav">';
$contenu .= '<u1>';
$contenu .= '<li class="gestion-nav-item"><a href="?action=affichage_reservation">Afficher toutes les réservations</a></li>';

$contenu .= '<li class="gestion-nav-item"><form class="search-bar" method="GET" style="background-color:#c23e63; padding:0px" action="" role="search">
<input type="search" id="search" name="search" placeholder="Rechercher..." />&nbsp
<button  type="submit">
    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="white" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
</button>
</form></li>';

$contenu .= '<li class="gestion-nav-item"><form class="search-bar" method="GET" style="background-color:#c23e63; padding:0px" >
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
</form></li>';

$contenu .= '</u1></nav></div>';

$contenu .= '<body>';


//------------- MODIFICATION RESERVATION ---------------------------------------------//
if(!empty($_POST))
{   // debug($_POST);
    if(isset($_GET['action']) && $_GET['action'] == 'modification_reservation')
    foreach($_POST as $indice => $valeur)
    {
        $_POST[$indice] = htmlEntities(addSlashes($valeur));
    }
    executeRequete("INSERT INTO reservation (id_reservation, id_semaine, id_jeu, id_membre, statut_reservation)
    VALUES ('$_POST[id_reservation]', '$_POST[id_semaine]', '$_POST[id_jeu]', '$_POST[id_membre]', '$_POST[statut_reservation]')
    ON DUPLICATE KEY UPDATE statut_reservation = '$_POST[statut_reservation]'");
    
    $contenu .= '<div class="validation">Le statut de la réservation a été mis à jour</div>';
    $_GET['action'] = 'affichage_reservation';
}

//-------------------- AFFICHAGE RESERVATION --------------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "affichage_reservation")
{
    $resultat = executeRequete("SELECT id_reservation, nom_semaine, nom, prenom, email, nom_jeu, statut_jeu, date_enregistrement, statut_reservation FROM vue_reservation ORDER BY date_enregistrement DESC");
    require_once("../inc/tableau/tableau.reservation.inc.php");
}

//-------------------- AFFICHAGE RESULTAT RECHERCHE --------------------------------------------------------------//

if(isset($_GET['search']) AND !empty($_GET['search']) == "affichage_recherche")
{
    $search = htmlspecialchars($_GET['search']);
    $resultat = executeRequete("SELECT id_reservation, nom_semaine, nom, prenom, email, nom_jeu, statut_jeu, date_enregistrement, statut_reservation FROM vue_reservation WHERE CONCAT(nom_semaine, nom, prenom, email, nom_jeu, statut_reservation) LIKE '%$search%' ORDER BY date_enregistrement DESC");
    require_once("../inc/tableau/tableau.reservation.inc.php");
}

//-------------------- AFFICHAGE reservation par statut --------------------------------------------------------------//
if(isset($_GET['order']) && $_GET['order'] == "en_attente") {
    $resultat = executeRequete("SELECT id_reservation, nom_semaine, nom, prenom, email, nom_jeu, statut_jeu, date_enregistrement, statut_reservation FROM vue_reservation WHERE statut_reservation = '0'");
    require_once("../inc/tableau/tableau.reservation.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "validee") {
    $resultat = executeRequete("SELECT id_reservation, nom_semaine, nom, prenom, email, nom_jeu, statut_jeu, date_enregistrement, statut_reservation FROM vue_reservation WHERE statut_reservation = '1'");
    require_once("../inc/tableau/tableau.reservation.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "rejetee") {
    $resultat = executeRequete("SELECT id_reservation, nom_semaine, nom, prenom, email, nom_jeu, statut_jeu, date_enregistrement, statut_reservation FROM vue_reservation WHERE statut_reservation = '2'");
    require_once("../inc/tableau/tableau.reservation.inc.php");
}

//--------------------------------- AFFICHAGE FORM MODIF RESERVATION ---------------------------------//

echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'modification_reservation'))
{
    if(isset($_GET['id_reservation']))
    {
        $resultat = executeRequete("SELECT * FROM vue_reservation WHERE id_reservation=$_GET[id_reservation]");
        $reservation_actuelle = $resultat->fetch_assoc();
    }
    echo '
    <div class="content">
        <form method="post" enctype="multipart/form-data" action="">

            <h4> Modifier la réservation </h4></br>
     
            <input type="hidden" id="id_reservation" name="id_reservation" value="'; if(isset($reservation_actuelle['id_reservation'])) echo $reservation_actuelle['id_reservation']; echo '">
            <input type="hidden" id="id_semaine" name="id_semaine" value="'; if(isset($reservation_actuelle['id_semaine'])) echo $reservation_actuelle['id_semaine']; echo '">
            <input type="hidden" id="id_jeu" name="id_jeu" value="'; if(isset($reservation_actuelle['id_jeu'])) echo $reservation_actuelle['id_jeu']; echo '">
            <input type="hidden" id="id_membre" name="id_membre" value="'; if(isset($reservation_actuelle['id_membre'])) echo $reservation_actuelle['id_membre']; echo '">

            <p style="color:#000000">'; echo $reservation_actuelle['nom']; echo'&nbsp;'; echo $reservation_actuelle['prenom']; echo '</p><br>

            <p style="color:#000000">'; echo $reservation_actuelle['email']; echo '</p><br>

            <p style="color:#000000">'; echo $reservation_actuelle['nom_jeu']; echo '</p><br>

            <p style="color:#000000">'; echo $reservation_actuelle['nom_semaine']; echo '</p><br>

            <select id="statut_reservation" name="statut_reservation" class="case">
                <option value="0"'; if(isset($reservation_actuelle['statut_reservation']) && $reservation_actuelle['statut_reservation'] == '0') echo ' selected'; echo '>En attente</option>
                <option value="1"'; if(isset($reservation_actuelle['statut_reservation']) && $reservation_actuelle['statut_reservation'] == '1') echo ' selected'; echo '>Validée</option>
                <option value="2"'; if(isset($reservation_actuelle['statut_reservation']) && $reservation_actuelle['statut_reservation'] == '2') echo ' selected'; echo '>Rejetée</option>
            </select><br><br>
         
            <input type="submit" class="envoyer" value="Modifier le statut de la réservation">
        </form>
    </div>';
}

$contenu .= "</body>";

require_once("../inc/footer.inc.php"); ?>