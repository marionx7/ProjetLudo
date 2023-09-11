<?php require_once("inc/init.inc.php");

//--------------------------------- TRAITEMENTS PHP ---------------------------------//

if(isset($_GET['action']) && $_GET['action'] == "deconnexion")
{
    session_destroy();
}
if(internauteEstConnecte())
{
    header("location:profil.php");
}

if($_POST)
{
    $resultat = executeRequete("SELECT * FROM membre WHERE email='$_POST[email]'");
    if($resultat->num_rows != 0)
    {
        $membre = $resultat->fetch_assoc();
        if($membre['mdp'] == $_POST['mdp'])
        {
            foreach($membre as $indice => $element)
            {
                $_SESSION['membre'][$indice] = $element;
            }
            $_SESSION['membre']['mdp'] = $_POST['mdp'];

            header("location:profil.php?action=affichage_profil");
        }
        else
        {
            $contenu .= '<div class="erreur">Erreur de Mot de passe</div>';
        }       
    }
    else
    {
        $contenu .= '<div class="erreur">Erreur d\'adresse Email</div>';
    }
}
//--------------------------------- AFFICHAGE HTML ---------------------------------//

?>
<?php require_once("inc/header.inc.php"); ?>

<div class="body">

<?php echo $contenu; ?>

<div class="content">

<body>
 
<form method="post" action="">

    <h4>Connexion</h4>

    <input type="text" id="email" name="email" placeholder="email" class="case"><br> <br>
         
    <input type="password" id="mdp" name="mdp" placeholder="mot de passe" class="case"><br><br>
 
    <button type="submit" class="envoyer" value="Se connecter">Se connecter</button>
</form>

</div>
 
<?php require_once("inc/footer.inc.php"); ?>
