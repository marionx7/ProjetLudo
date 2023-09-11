
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
$contenu .= '<li class="gestion-nav-item"><a href="?action=affichage_presentation">Afficher tout</a></li>';

$contenu .= '<li class="gestion-nav-item"><form class="search-bar" method="GET" style="background-color:#c23e63; padding:0px" >
<label class="sr-only" for="order">Afficher</label>
<select type="order" id="order" name="order" >
        <option value="la_ludotheque" style="background-color:#c23e63; padding:0px"  selected>Afficher La Ludothèque</option>
        <option value="nos_accueils" style="background-color:#c23e63; padding:0px" >Afficher Nos Accueils</option>
		<option value="evenements" style="background-color:#c23e63; padding:0px" >Afficher Evénements</option>
		<option value="nous_trouver" style="background-color:#c23e63; padding:0px" >Afficher Nous Trouver</option>
</select>&nbsp
<button  type="submit">
    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="white" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
</button>
</form></li>';

$contenu .= '</u1></nav></div>';

$contenu .= '<body>';


//------------- ENREGISTREMENT OU MODIFICATION presentation ---------------------------------------------//
if(!empty($_POST))
{   // debug($_POST);
    $image_bdd = ""; 
    if(isset($_GET['action']) && $_GET['action'] == 'modification_presentation')
    {
        $image_bdd = $_POST['image_actuelle'];
    }
    if(!empty($_FILES['image_presentation']['name']))
    {   // debug($_FILES);
        $nom_image = $_POST['id_presentation'] . '_' .$_FILES['image_presentation']['name'];
        $image_bdd = RACINE_SITE . "image/$nom_image";
        $image_dossier = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . "/image/$nom_image"; 
        copy($_FILES['image_presentation']['tmp_name'],$image_dossier);
    }
    foreach($_POST as $indice => $valeur)
    {
        $_POST[$indice] = htmlEntities(addSlashes($valeur));
    }
    
    executeRequete("UPDATE presentation
    SET titre_presentation = '$_POST[titre_presentation]', texte_presentation = '$_POST[texte_presentation]', image_presentation = '$image_bdd'
    WHERE id_presentation = '$_POST[id_presentation]'");
    
    $contenu .= '<div class="validation">La présentation a été modifiée</div>';
    $_GET['action'] = 'affichage_presentation';
}

//-------------------- AFFICHAGE presentation --------------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "affichage_presentation")
{
    $resultat = executeRequete("SELECT * FROM presentation ORDER BY id_presentation ASC");
    require_once("../inc/tableau/tableau.presentation.inc.php");
}

//-------------------- AFFICHAGE presentation ORGANISE PAR --------------------------------------------------------------//
if(isset($_GET['order']) && $_GET['order'] == "la_ludotheque") {
    $resultat = executeRequete("SELECT * FROM presentation WHERE page_presentation = 'La Ludotheque'");
    require_once("../inc/tableau/tableau.presentation.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "nos_accueils") {
    $resultat = executeRequete("SELECT * FROM presentation WHERE page_presentation = 'Nos Accueils'");
    require_once("../inc/tableau/tableau.presentation.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "evenements") {
    $resultat = executeRequete("SELECT * FROM presentation WHERE page_presentation = 'Evenements'");
    require_once("../inc/tableau/tableau.presentation.inc.php");
}

if(isset($_GET['order']) && $_GET['order'] == "nous_trouver") {
    $resultat = executeRequete("SELECT * FROM presentation WHERE page_presentation = 'Nous Trouver'");
    require_once("../inc/tableau/tableau.presentation.inc.php");
}
//--------------------------------- AFFICHAGE FORM AJOUT presentation ---------------------------------//

echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'modification_presentation'))
{
    if(isset($_GET['id_presentation']))
    {
        $resultat = executeRequete("SELECT * FROM presentation WHERE id_presentation=$_GET[id_presentation]");
        $presentation_actuel = $resultat->fetch_assoc();
    }
    echo '
    <div class="content">
        <form method="post" enctype="multipart/form-data" action="">

            <h4> Modifier la présentation</h4></br>
     
            <input type="hidden" id="id_presentation" name="id_presentation" value="'; if(isset($presentation_actuel['id_presentation'])) echo $presentation_actuel['id_presentation']; echo '">

            <textarea name="titre_presentation" id="titre_presentation" placeholder="Le titre" class="case" style="height:20px">'; if(isset($presentation_actuel['titre_presentation'])) echo $presentation_actuel['titre_presentation']; echo '</textarea><br><br>
         
            <textarea name="texte_presentation" id="texte_presentation" placeholder="Le texte" class="case" style="height:300px">'; if(isset($presentation_actuel['texte_presentation'])) echo $presentation_actuel['texte_presentation']; echo '</textarea><br><br>
         
            <input type="file" id="image_presentation" name="image_presentation" class="envoyer"><br><br>';
            if(isset($presentation_actuel))
            {
                echo '<i>Vous pouvez uplaoder une nouvelle image si vous souhaitez la changer</i><br>';
                echo '<img src="' . $presentation_actuel['image_presentation'] . '"  ="90" height="90"><br>';
                echo '<input type="hidden" name="image_actuelle" value="' . $presentation_actuel['image_presentation'] . '"><br>';
            }
         
            echo '
            <input type="submit" class="envoyer" value="Enregistrer la présentation">
        </form>
    </div>';
}

$contenu .= "</body>";

require_once("../inc/footer.inc.php"); ?>