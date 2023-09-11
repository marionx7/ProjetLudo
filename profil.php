<?php
require_once("inc/init.inc.php");
require_once("inc/header.inc.php");

//--------------------------------- TRAITEMENTS PHP ---------------------------------//

if(!internauteEstConnecte()) {
    header("location:connexion.php");
    exit();
}

if(isset($_GET['action']) && $_GET['action'] == "affichage_profil") {
    $contenu .= '<div class="content"><div class="bleu">';
    $contenu .= '<p class="centre">Bonjour <strong>' . $_SESSION['membre']['prenom'] . '</strong></p>';
    $contenu .= '<h2 style="color:white;"> Voici vos informations </h2>';
    $contenu .= '<p>Votre Nom est : <b>' . $_SESSION['membre']['nom'] . '</b><br>';
    $contenu .= 'Votre Prénom est : <b>' . $_SESSION['membre']['prenom'] . '</b><br>';
    $contenu .= 'Votre email est : <b>' . $_SESSION['membre']['email'] . '</b><br>';
    $contenu .= 'Votre date de naissance est : <b>' . $_SESSION['membre']['date_naissance'] . '</b></p>';
    $contenu .= '<input type="hidden" id="mdp_actuel" name="mdp_actuel" value="' . $_SESSION['membre']['mdp'] . '">';

    $contenu .= '<li class="gestion-nav-item"><a class="footer-social-icon" href="?action=modifier_mail">Modifier mon Email</a></li>';
    $contenu .= '<li class="gestion-nav-item"><a class="footer-social-icon" href="?action=modifier_mdp">Modifier mon Mot de passe</a></li>';

    $contenu .= '<br></div><br><br></div>';
}

//-------------------------------------- MODIFICATION EMAIL ---------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == 'modifier_mail') {
    if(!empty($_POST)) {
        $email_actuel = isset($_POST['email_actuel']) ? $_POST['email_actuel'] : '';
        $email_nouveau = isset($_POST['email_nouveau']) ? $_POST['email_nouveau'] : '';
        $email_nouveau_confirm = isset($_POST['email_nouveau_confirm']) ? $_POST['email_nouveau_confirm'] : '';

        // Vérifier les confirmations
        if($_SESSION['membre']['email'] != $email_actuel) {
            $contenu .= '<div class="erreur">L\'adresse e-mail actuelle ne correspond pas à votre adresse e-mail enregistrée.</div>';
        } elseif($email_nouveau != $email_nouveau_confirm) {
            $contenu .= '<div class="erreur">Les adresses e-mail de confirmation ne correspondent pas.</div>';
        } else {
            // Mettre à jour l'adresse e-mail
            $email = $_SESSION['membre']['email'];
            $nouvel_email = $_POST['email_nouveau'];
            $requete = "UPDATE membre SET email = '$nouvel_email' WHERE email = '$email'";
            executeRequete($requete);

            $contenu .= '<div class="validation">Votre adresse e-mail a été modifiée avec succès</div>';
            $_SESSION['membre']['email'] = $nouvel_email;
            header("Location: ?action=affichage_profil");
            exit();
        }
    }
    echo '
    <div class="content">
        <form method="post" enctype="multipart/form-data" action="">
            <h4> Modifier mon adresse e-mail </h4></br>    
            <input type="hidden" id="id_membre" name="id_membre" value="' . $_SESSION['membre']['id_membre'] . '">
            <input type="email" id="email_actuel" name="email_actuel" class="case" placeholder="Adresse e-mail actuelle" required><br><br>
            <input type="email" id="email_nouveau" name="email_nouveau" class="case" placeholder="Nouvelle adresse e-mail" required><br><br>
            <input type="email" id="email_nouveau_confirm" name="email_nouveau_confirm" class="case" placeholder="Confirmer la nouvelle adresse e-mail" required><br><br>         
            <input type="submit" class="envoyer" value="Enregistrer l\'adresse e-mail">
        </form>
    </div>';
}

//-------------------------------------- MODIFICATION MDP ---------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == 'modifier_mdp') {
    if(!empty($_POST)) {
        $mdp_actuel = isset($_POST['mdp_actuel']) ? $_POST['mdp_actuel'] : '';
        $mdp_nouveau = isset($_POST['mdp_nouveau']) ? $_POST['mdp_nouveau'] : '';
        $mdp_nouveau_confirm = isset($_POST['mdp_nouveau_confirm']) ? $_POST['mdp_nouveau_confirm'] : '';

        // Vérifier les confirmations
        if($_SESSION['membre']['mdp'] != $mdp_actuel) {
            $contenu .= '<div class="erreur">Le mot de passe actuel ne correspond pas à votre mot de passe enregistré.</div>';
        } elseif($mdp_nouveau != $mdp_nouveau_confirm) {
            $contenu .= '<div class="erreur">Les mots de passe de confirmation ne correspondent pas.</div>';
        } else {
            // Mettre à jour le mdp
            $mdp = $_SESSION['membre']['mdp'];
            $nouvel_mdp = $_POST['mdp_nouveau'];
            $requete = "UPDATE membre SET mdp = '$nouvel_mdp' WHERE mdp = '$mdp'";
            executeRequete($requete);

            $contenu .= '<div class="validation">Votre Mot de passe a été modifié avec succès</div>';
            $_SESSION['membre']['mdp'] = $nouvel_mdp;
            header("Location: ?action=affichage_profil");
            exit();
        }
    }
    echo '
    <div class="content">
        <form method="post" enctype="multipart/form-data" action="">
            <h4> Modifier mon Mot de passe </h4></br>    
            <input type="hidden" id="id_membre" name="id_membre" value="' . $_SESSION['membre']['id_membre'] . '">
            <input type="password" id="mdp_actuel" name="mdp_actuel" class="case" placeholder="Mot de passe actuel" required><br><br>
            <input type="password" id="mdp_nouveau" name="mdp_nouveau" class="case" placeholder="Nouveau Mot de passe" required><br><br>
            <input type="password" id="mdp_nouveau_confirm" name="mdp_nouveau_confirm" class="case" placeholder="Confirmer le nouveau Mot de passe" required><br><br>         
            <input type="submit" class="envoyer" value="Enregistrer le Mot de passe">
        </form>
    </div>';
}

//--------------------------------- AFFICHAGE HTML ---------------------------------//

echo $contenu;
require_once("inc/footer.inc.php");
?>
