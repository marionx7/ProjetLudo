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
$contenu .= '<li class="gestion-nav-item"><a href="?action=affichage_membre">Afficher tous les membres</a></li>';

$contenu .= '<li class="gestion-nav-item"><form class="search-bar" method="GET" style="background-color:#c23e63; padding:0px" action="" role="search">
<label class="sr-only" for="search">Recherche</label>
<input type="search" id="search" name="search" placeholder="Rechercher..." />&nbsp
<button  type="submit">
    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="white" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
</button>
</form></li>';

$contenu .= '<li class="gestion-nav-item"><form class="search-bar" method="GET" style="background-color:#c23e63; padding:0px" >
<label class="sr-only" for="order">Organiser par</label>
<select type="order" id="order" name="order" >
        <option value="nom" style="background-color:#c23e63; padding:0px"  selected>Organiser par Nom</option>
        <option value="prenom" style="background-color:#c23e63; padding:0px" >Organiser par Prénom</option>
		<option value="id_membre" style="background-color:#c23e63; padding:0px" >Organiser par ID</option>
		<option value="statut_membre" style="background-color:#c23e63; padding:0px" >Organiser par Statut</option>
</select>&nbsp
<button  type="submit">
    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="white" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
</button>
</form></li>';


$contenu .= '</u1></nav></div>';

$contenu .= '<body>';

//------------- MODIFICATION MEMBRE ---------------------------------------------//
if(!empty($_POST))
{   // debug($_POST);
    foreach($_POST as $indice => $valeur)
    {
        $_POST[$indice] = htmlEntities(addSlashes($valeur));
    }
    executeRequete("UPDATE membre
    SET statut_membre = '$_POST[statut_membre]' WHERE id_membre = '$_POST[id_membre]'");
    
    $contenu .= '<div class="validation">Le statut du membre a été mis à jour</div>';
    $_GET['action'] = 'affichage_membre';
}

//-------------------- AFFICHAGE jEUX --------------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "affichage_membre")
{
    $resultat = executeRequete("SELECT id_membre, email, nom, prenom, date_naissance, statut_membre FROM membre ORDER BY id_membre ASC");
    require_once("../inc/tableau/tableau.membre.inc.php");
}

//-------------------- AFFICHAGE RESULTAT RECHERCHE --------------------------------------------------------------//

if(isset($_GET['search']) AND !empty($_GET['search']) == "affichage_recherche")
{
    $search = htmlspecialchars($_GET['search']);
    $resultat = executeRequete("SELECT id_membre, email, nom, prenom, date_naissance, statut_membre FROM membre WHERE CONCAT(email, nom, prenom) LIKE '%$search%' ORDER BY nom ASC");
    require_once("../inc/tableau/tableau.membre.inc.php");
}

//-------------------- AFFICHAGE MEMBRES ORGANISE PAR --------------------------------------------------------------//
if(isset($_GET['order']) && $_GET['order'] == "nom") {
    $resultat = executeRequete("SELECT id_membre, email, nom, prenom, date_naissance, statut_membre FROM membre ORDER BY nom ASC");
    require_once("../inc/tableau/tableau.membre.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "prenom") {
    $resultat = executeRequete("SELECT id_membre, email, nom, prenom, date_naissance, statut_membre FROM membre ORDER BY prenom ASC");
    require_once("../inc/tableau/tableau.membre.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "id_membre") {
    $resultat = executeRequete("SELECT id_membre, email, nom, prenom, date_naissance, statut_membre FROM membre ORDER BY id_membre ASC");
    require_once("../inc/tableau/tableau.membre.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "statut_membre") {
    $resultat = executeRequete("SELECT id_membre, email, nom, prenom, date_naissance, statut_membre FROM membre ORDER BY statut_membre DESC");
    require_once("../inc/tableau/tableau.membre.inc.php");
}
//--------------------------------- AFFICHAGE FORM MODIFICATION STATUT MEMBRE ---------------------------------//

echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'modification_membre'))
{
    if(isset($_GET['id_membre']))
    {
        $resultat = executeRequete("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]");
        $membre_actuel = $resultat->fetch_assoc();
    }
    echo '
    <div class="content">
        <form method="post" enctype="multipart/form-data" action="">

            <h4> Modifier un membre </h4>
     
            <input type="hidden" id="id_membre" name="id_membre" value="'; if(isset($membre_actuel['id_membre'])) echo $membre_actuel['id_membre']; echo '">
             
            <p style="color:#000000">'; echo $membre_actuel['nom']; echo'&nbsp;'; echo $membre_actuel['prenom']; echo '</p><br>

            <p style="color:#000000">'; echo $membre_actuel['email']; echo '</p><br>

            <p style="color:#000000">'; echo $membre_actuel['date_naissance']; echo '</p><br>

            <select type="order" id="statut_membre" name="statut_membre" class="case"  value="'; if(isset($membre_actuel['statut_membre'])) echo $jmembre_actuel['statut_membre']; echo '" >
                <option value="0">Membre</option>
                <option value="1">Administrateur</option>
            </select><br><br>

            <input type="submit" class="envoyer" value="Modifier le statut">
        </form>
    </div>';
}

$contenu .= "</body>";

require_once("../inc/footer.inc.php"); ?>