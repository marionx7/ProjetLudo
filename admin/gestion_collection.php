
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
$contenu .= '<li class="gestion-nav-item"><a href="?action=affichage_jeu">Afficher tous les jeux</a></li>';

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
        <option value="nom_jeu" style="background-color:#c23e63; padding:0px"  selected>Organiser par Nom</option>
        <option value="id_jeu" style="background-color:#c23e63; padding:0px" >Organiser par ID</option>
		<option value="editeur_jeu" style="background-color:#c23e63; padding:0px" >Organiser par Editeur</option>
		<option value="age_mini" style="background-color:#c23e63; padding:0px" >Organiser par Age</option>
</select>&nbsp
<button  type="submit">
    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="white" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
</button>
</form></li>';

$contenu .= '<li class="gestion-nav-item"><a class="footer-social-icon" href="?action=ajout_jeu">
<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
</svg>&nbsp&nbspAjouter un jeu</a></li>';

$contenu .= '</u1></nav></div>';

$contenu .= '<body>';

//---------------------- SUPPRESSION JEU -------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "suppression_jeu")
{   // $contenu .= $_GET['id_jeu']
    $resultat = executeRequete("SELECT * FROM jeu WHERE id_jeu=$_GET[id_jeu]");
    $jeu_a_supprimer = $resultat->fetch_assoc();
    $chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . $jeu_a_supprimer['photo'];
    if(!empty($jeu_a_supprimer['photo']) && file_exists($chemin_photo_a_supprimer)) unlink($chemin_photo_a_supprimer);
    $contenu .= '<div class="validation">Suppression du jeu : ' . $_GET['id_jeu'] . '</div>';
    executeRequete("DELETE FROM jeu WHERE id_jeu=$_GET[id_jeu]");
    $_GET['action'] = 'affichage_jeu';
}

//------------- ENREGISTREMENT OU MODIFICATION JEU ---------------------------------------------//
if(!empty($_POST))
{   // debug($_POST);
    $photo_bdd = ""; 
    if(isset($_GET['action']) && $_GET['action'] == 'modification_jeu')
    {
        $photo_bdd = $_POST['photo_actuelle'];
    }
    if(!empty($_FILES['photo']['name']))
    {   // debug($_FILES);
        $nom_photo = $_POST['nom_jeu'] . '_' .$_FILES['photo']['name'];
        $photo_bdd = RACINE_SITE . "photo/$nom_photo";
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . "/photo/$nom_photo"; 
        copy($_FILES['photo']['tmp_name'],$photo_dossier);
    }
    foreach($_POST as $indice => $valeur)
    {
        $_POST[$indice] = htmlEntities(addSlashes($valeur));
    }
    executeRequete("INSERT INTO jeu (nom_jeu, editeur_jeu, description_jeu, photo, age_mini, nbr_mini, nbr_maxi, statut_jeu) 
    values ('$_POST[nom_jeu]', '$_POST[editeur_jeu]', '$_POST[description_jeu]',  '$photo_bdd',  '$_POST[age_mini]',  '$_POST[nbr_mini]',  '$_POST[nbr_maxi]',  '$_POST[statut_jeu]')
    ON DUPLICATE KEY UPDATE editeur_jeu = '$_POST[editeur_jeu]', description_jeu = '$_POST[description_jeu]', photo = '$photo_bdd', age_mini = '$_POST[age_mini]', nbr_mini = '$_POST[nbr_mini]', nbr_maxi = '$_POST[nbr_maxi]', statut_jeu = '$_POST[statut_jeu]'");
    
    $contenu .= '<div class="validation">Le jeu a été enregistré dans la collection</div>';
    $_GET['action'] = 'affichage_jeu';
}

//-------------------- AFFICHAGE jEUX --------------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "affichage_jeu" )
{
    $resultat = executeRequete("SELECT * FROM jeu ORDER BY nom_jeu ASC");
    require_once("../inc/tableau/tableau.collection.inc.php");
}

//-------------------- AFFICHAGE RESULTAT RECHERCHE --------------------------------------------------------------//

if(isset($_GET['search']) AND !empty($_GET['search']) == "affichage_recherche")
{
    $search = htmlspecialchars($_GET['search']);
    $resultat = executeRequete("SELECT * FROM jeu WHERE CONCAT(nom_jeu, editeur_jeu, statut_jeu) LIKE '%$search%' ORDER BY nom_jeu ASC");
    require_once("../inc/tableau/tableau.collection.inc.php");
}


//-------------------- AFFICHAGE jEUX ORGANISE PAR --------------------------------------------------------------//
if(isset($_GET['order']) && $_GET['order'] == "nom_jeu") {
    $resultat = executeRequete("SELECT * FROM jeu ORDER BY nom_jeu ASC");
    require_once("../inc/tableau/tableau.collection.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "id_jeu") {
    $resultat = executeRequete("SELECT * FROM jeu ORDER BY id_jeu ASC");
    require_once("../inc/tableau/tableau.collection.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "editeur_jeu") {
    $resultat = executeRequete("SELECT * FROM jeu ORDER BY editeur_jeu ASC");
    require_once("../inc/tableau/tableau.collection.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "age_mini") {
    $resultat = executeRequete("SELECT * FROM jeu ORDER BY age_mini ASC");
    require_once("../inc/tableau/tableau.collection.inc.php");
}
//--------------------------------- AFFICHAGE FORM AJOUT JEU ---------------------------------//

echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'ajout_jeu' || $_GET['action'] == 'modification_jeu'))
{
    if(isset($_GET['id_jeu']))
    {
        $resultat = executeRequete("SELECT * FROM jeu WHERE id_jeu=$_GET[id_jeu]");
        $jeu_actuel = $resultat->fetch_assoc();
    }
    echo '
    <div class="content">
        <form method="post" enctype="multipart/form-data" action="">

            <h4> Ajouter un jeu </h4></br>
     
            <input type="hidden" id="id_jeu" name="id_jeu" value="'; if(isset($jeu_actuel['id_jeu'])) echo $jeu_actuel['id_jeu']; echo '">
             
            <input type="text" id="nom_jeu" name="nom_jeu" placeholder="le nom du jeu" class="case" value="'; if(isset($jeu_actuel['nom_jeu'])) echo $jeu_actuel['nom_jeu']; echo '"><br><br>

            <input type="text" id="editeur_jeu" name="editeur_jeu" placeholder="l\'éditeur du jeu" class="case" value="'; if(isset($jeu_actuel['editeur_jeu'])) echo $jeu_actuel['editeur_jeu']; echo '" ><br><br>

            <textarea name="description_jeu" id="description_jeu" placeholder="la description du jeu" class="case" style="height:200px">'; if(isset($jeu_actuel['description_jeu'])) echo $jeu_actuel['description_jeu']; echo '</textarea><br><br>
         
            <input type="file" id="photo" name="photo" class="envoyer"><br><br>';
            if(isset($jeu_actuel))
            {
                echo '<i>Vous pouvez uplaoder une nouvelle photo si vous souhaitez la changer</i><br>';
                echo '<img src="' . $jeu_actuel['photo'] . '"  ="90" height="90"><br>';
                echo '<input type="hidden" name="photo_actuelle" value="' . $jeu_actuel['photo'] . '"><br>';
            }
         
            echo '
            <input type="number" id="age_mini" name="age_mini" placeholder="Age minimum" class="case"  value="'; if(isset($jeu_actuel['age_mini'])) echo $jeu_actuel['age_mini']; echo '"><br><br>

            <input type="number" id="nbr_mini" name="nbr_mini" placeholder="Nombre minimum de joueurs" class="case"  value="'; if(isset($jeu_actuel['nbr_mini'])) echo $jeu_actuel['nbr_mini']; echo '"><br><br>

            <input type="number" id="nbr_maxi" name="nbr_maxi" placeholder="Nombre maximum de joueurs" class="case"  value="'; if(isset($jeu_actuel['nbr_maxi'])) echo $jeu_actuel['nbr_maxi']; echo '"><br><br>
         
            <select type="order" id="statut_jeu" name="statut_jeu" class="case"  value="'; if(isset($jeu_actuel['statut_jeu'])) echo $jeu_actuel['statut_jeu']; echo '" >
                <option value="disponible">Disponible</option>
                <option value="indisponible">Indisponible</option>
            </select><br><br>
            
            <input type="submit" class="envoyer" value="Enregistrer le jeu">
        </form>
    </div>';
}

$contenu .= "</body>";

require_once("../inc/footer.inc.php"); ?>