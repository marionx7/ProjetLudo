<?php require_once("inc/init.inc.php");

//--------------------------------- TRAITEMENTS PHP ---------------------------------//

if($_POST)
{
    debug($_POST);
    $verif_caractere = preg_match('#^[a-zA-Z0-9._-]+@$#', $_POST['email']); 
    if(!$verif_caractere && (strlen($_POST['email']) < 1 || strlen($_POST['email']) > 20) ) // 
    {
        $contenu .= "<div class='erreur'>Cet email doit contenir entre 1 et 20 caractères. <br> Caractère accepté : Lettre de A à Z et chiffre de 0 à 9</div>";
    }
    else
    {
        $membre = executeRequete("SELECT * FROM membre WHERE email='$_POST[email]'");
        if($membre->num_rows > 0)
        {
            $contenu .= "<div class='erreur'>Email déjà utilisé. Vous êtes peut être déjà inscrit ? Sinon, veuillez utiliser une autre adresse email.</div>";
        }
        else
        {
            // $_POST['mdp'] = md5($_POST['mdp']);
            foreach($_POST as $indice => $valeur)
            {
                $_POST[$indice] = htmlEntities(addSlashes($valeur));
            }
            executeRequete("INSERT INTO membre (email, mdp, nom, prenom, date_naissance) VALUES ('$_POST[email]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[date_naissance]')");
            $contenu .= "<div class='validation'>Vous êtes inscrit à notre site web. <a href=\"connexion.php\"><u>Cliquez ici pour vous connecter</u></a></div>";
        }
    }
}

//--------------------------------- AFFICHAGE HTML ---------------------------------//


?>
<?php require_once("inc/header.inc.php"); ?>

<div class="content">
    
<body>

<?php echo $contenu; ?>

<form method="post" action="">

    <h4>Inscription</h4>

    <input type="email" id="email" name="email" placeholder="exemple@gmail.com" class="case"><br><br>
    
    <input type="password" id="mdp" name="mdp" required="required" placeholder="mot de passe" class="case"><br><br>
          
    <input type="text" id="nom" name="nom" placeholder="votre nom" class="case"><br><br>
          
    <input type="text" id="prenom" name="prenom" placeholder="votre prénom" class="case"><br><br>  

    <input type="text" id="date_naissance" name="date_naissance" placeholder="aaaa/mm/jj" class="case" pattern="[0-9/]{10}" title="10 carractères requis : 0-9/"><br><br>
 
    <button type="submit" name="inscription" class="envoyer" value="S'inscrire">S'inscrire</button>
</form>

</div>
 
<?php require_once("inc/footer.inc.php"); ?>
