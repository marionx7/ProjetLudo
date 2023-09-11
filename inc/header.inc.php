<!Doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Ludothèque de Chatillon</title>
        <link rel="stylesheet" href="<?php echo RACINE_SITE; ?>inc/css/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo RACINE_SITE; ?>inc/css/app.css">
    </head>

<body>    
 
<div class="header">

<!-- Logo ludotheque -->

    <img class="Logo Ludotheque" width="200" height=auto src="<?php echo RACINE_SITE; ?>./inc/img/ludo_logo.jpg">

<!-- menu de navigation -->

    <nav role="navigation" class="header-navigation">
        <ul>
            <li class="header-navigation-item"><a href="<?php echo RACINE_SITE; ?>index.php?action=affichage_La_Ludotheque">La Ludothèque</a></li>
            <li class="header-navigation-item"><a href="<?php echo RACINE_SITE; ?>index.php?action=affichage_Nos_Accueils">Nos accueils</a></li>
            <li class="header-navigation-item"><a href="<?php echo RACINE_SITE; ?>index.php?action=affichage_Evenements">Evénements</a></li>
            <li class="header-navigation-item"><a href="<?php echo RACINE_SITE; ?>collection.php?action=tout_afficher">Emprunter</a></li>
        </ul>
    </nav>

<!-- menu de connexion -->

    <div class="header-dropdown">
        <div class="header-dropdown-icon-wrapper">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
        </svg>
        </div>
        <p>
            <a class="header-dropdown-link" aria-haspopup="true" aria-expanded="false" href="#">
                <span class="header-dropdown-link-content">
                    Mon Compte
                </span>
                <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1.33447L8.00465 8.13311L14.5973 1.33447" stroke="#E9E9E9" stroke-width="2"/>
                </svg>
            </a>
        </p>
        <ul class="dropdown">
        <?php
                    if(internauteEstConnecteEtEstAdmin())
                    {
                        echo '<a href="' . RACINE_SITE . 'admin/gestion_presentation.php?action=affichage_presentation">Gestion Présentation</a>';
                        echo '<a href="' . RACINE_SITE . 'admin/gestion_collection.php?action=affichage_jeu">Gestion Collection</a>';
                        echo '<a href="' . RACINE_SITE . 'admin/gestion_membre.php?action=affichage_membre">Gestion Membres</a>';
                        echo '<a href="' . RACINE_SITE . 'admin/gestion_reservation.php?action=affichage_reservation">Gestion Réservations</a>';
                        echo '<a href="' . RACINE_SITE . 'admin/gestion_semaine.php?action=affichage_semaine">Gestion Semaines</a>';
                    }
                    if(internauteEstConnecte())
                    {
                        echo '<a href="' . RACINE_SITE . 'profil.php?action=affichage_profil">Mon profil</a>';
                        echo '<a href="' . RACINE_SITE . 'reservations.php?action=affichage_reservation">Mes réservations</a>';
                        echo '<b><a href="' . RACINE_SITE . 'connexion.php?action=deconnexion">Me déconnecter</a></b>';
                    }
                    else
                    {
                        echo '<a href="' . RACINE_SITE . 'inscription.php">Inscription</a>';
                        echo '<a href="' . RACINE_SITE . 'connexion.php">Connexion</a>';
                    }
                    ?>
        </ul>

<!-- javascript -->
        
        <script src="<?php echo RACINE_SITE; ?>./inc/js/app.js"></script>

    </div>

</div>

<div style="min-height:535px">



