
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
$contenu .= '<li class="gestion-nav-item"><a href="?action=affichage_semaine">Afficher toutes les semaines</a></li>';

$contenu .= '<li class="gestion-nav-item"><form class="search-bar" method="GET" style="background-color:#c23e63; padding:0px" action="" role="search">
<label class="sr-only" for="search">Recherche</label>
<input type="search" id="search" name="search" placeholder="Rechercher..." />&nbsp
<button  type="submit">
    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="white" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
</button>
</form></li>';

$contenu .= '<li class="gestion-nav-item"><a class="footer-social-icon" href="?action=ajout_semaine">
<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
</svg>&nbsp&nbspAjouter une semaine</a></li>';

$contenu .= '</u1></nav></div>';

$contenu .= '<body>';

//---------------------- SUPPRESSION SEMAINE -------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "suppression_semaine")
{   
    $resultat = executeRequete("SELECT * FROM semaine WHERE id_semaine=$_GET[id_semaine]");
    $semaine_a_supprimer = $resultat->fetch_assoc();
    $contenu .= '<div class="validation">Suppression du jeu : ' . $_GET['id_semaine'] . '</div>';
    executeRequete("DELETE FROM semaine WHERE id_semaine=$_GET[id_semaine]");
    $_GET['action'] = 'affichage_semaine';
}

//------------- ENREGISTREMENT OU MODIFICATION SEMAINE ---------------------------------------------//
if(!empty($_POST))
{   // debug($_POST);
    $photo_bdd = ""; 
    if(isset($_GET['action']) && $_GET['action'] == 'modification_semaine')
    foreach($_POST as $indice => $valeur)
    {
        $_POST[$indice] = htmlEntities(addSlashes($valeur));
    }
    executeRequete("INSERT INTO semaine (nom_semaine, date_debut, date_fin, statut_semaine) 
    values ('$_POST[nom_semaine]', '$_POST[date_debut]', '$_POST[date_fin]',  '$_POST[statut_semaine]')
    ON DUPLICATE KEY UPDATE nom_semaine = '$_POST[nom_semaine]', date_debut = '$_POST[date_debut]', date_fin = '$_POST[date_fin]', statut_semaine = '$_POST[statut_semaine]'");
    
    $contenu .= '<div class="validation">La semaine a été enregistrée dans la liste</div>';
    $_GET['action'] = 'affichage_semaine';
}

//-------------------- AFFICHAGE SEMAINE --------------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "affichage_semaine")
{
    $resultat = executeRequete("SELECT * FROM semaine ORDER BY date_debut DESC");
    require_once("../inc/tableau/tableau.semaine.inc.php");
}

//-------------------- AFFICHAGE RESULTAT RECHERCHE --------------------------------------------------------------//

if(isset($_GET['search']) AND !empty($_GET['search']) == "affichage_recherche")
{
    $search = htmlspecialchars($_GET['search']);
    $resultat = executeRequete("SELECT * FROM semaine WHERE CONCAT(nom_semaine, date_debut, date_fin, statut_semaine) LIKE '%$search%' ORDER BY date_debut DESC");
    require_once("../inc/tableau/tableau.semaine.inc.php");
}

//--------------------------------- AFFICHAGE FORM AJOUT SEMAINE ---------------------------------//

echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'ajout_semaine' || $_GET['action'] == 'modification_semaine'))
{
    if(isset($_GET['id_semaine']))
    {
        $resultat = executeRequete("SELECT * FROM semaine WHERE id_semaine=$_GET[id_semaine]");
        $semaine_actuelle = $resultat->fetch_assoc();
    }
    echo '
    <div class="content">
        <form method="post" enctype="multipart/form-data" action="">

            <h4> Enregistrer une semaine </h4></br>
     
            <input type="hidden" id="id_semaine" name="id_semaine" value="'; if(isset($semaine_actuelle['id_semaine'])) echo $semaine_actuelle['id_semaine']; echo '">

            <input type="text" id="nom_semaine" name="nom_semaine" placeholder="du samedi 29 avril au samedi 6 mai 2023" class="case" value="'; if(isset($semaine_actuelle['nom_semaine'])) echo $semaine_actuelle['nom_semaine']; echo '"><br><br>

            <input type="date" id="date_debut" name="date_debut" class="case"  value="'; if(isset($semaine_actuelle['date_debut'])) echo $semaine_actuelle['date_debut']; echo '" min="2023-04-29"><br><br>

            <input type="date" id="date_fin" name="date_fin" class="case"  value="'; if(isset($semaine_actuelle['date_fin'])) echo $semaine_actuelle['date_fin']; echo '" min="2023-05-06"><br><br>

            <select type="order" id="statut_semaine" name="statut_semaine" class="case"  value="'; if(isset($semaine_actuelle['statut_semaine'])) echo $semaine_actuelle['statut_semaine']; echo '" >
                <option value="emprunt possible">Emprunt possible</option>
                <option value="emprunt impossible">Emprunt impossible</option>
            </select><br><br>
         
            <input type="submit" class="envoyer" value="Enregistrer la semaine">
        </form>
    </div>';
}

$contenu .= "</body>";

require_once("../inc/footer.inc.php"); ?>