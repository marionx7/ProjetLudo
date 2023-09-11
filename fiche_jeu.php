<?php
require_once("inc/init.inc.php");

if(!internauteEstConnecte()) header("location:connexion.php");
// debug($_SESSION);

//--------------------------------- TRAITEMENTS PHP ---------------------------------//
if (isset($_GET['id_jeu'])) {
    $resultat = executeRequete("SELECT * FROM jeu WHERE id_jeu = '$_GET[id_jeu]'");
}
if ($resultat->num_rows <= 0) {
    header("location:collection.php");
    exit();
}

$jeu = $resultat->fetch_assoc();
$contenu .= '<div class="content"><div class="bleu">';
$contenu .= "<h3>$jeu[nom_jeu]</h3><br>";
$contenu .= "<img style='display: block; margin-left: auto; margin-right: auto; border-radius: 20px;' src='$jeu[photo]' ='400' height='400'>";
$contenu .= "<p>Editeur : $jeu[editeur_jeu]</p>";
$contenu .= "<p>Nombre de joueurs : entre $jeu[nbr_mini] et $jeu[nbr_maxi]</p>";
$contenu .= '<p>Description:<i>'. nl2br($jeu["description_jeu"]) .'</i></p>';
$contenu .= "<p>Âge minimum : $jeu[age_mini] ans</p>";


if ($jeu['statut_jeu'] == 'disponible') {

    // Requête pour sélectionner les semaines disponibles pour le jeu spécifique
    $resultatSemaines = executeRequete("SELECT s.nom_semaine 
                                        FROM semaine s
                                        LEFT JOIN reservation r ON s.id_semaine = r.id_semaine AND r.id_jeu = '$_GET[id_jeu]'
                                        WHERE r.id_reservation IS NULL
                                        AND s.statut_semaine = 'emprunt possible'"); // Ajout de la condition de statut de la semaine

    if ($resultatSemaines->num_rows > 0) {
        $contenu .= "<div class='validation'>Le jeu est disponible à l'emprunt !</div>";
        $contenu .= "<form action='' method='post'>";
        $contenu .= "<input type='hidden' name='id_jeu' value='$_GET[id_jeu]'>";
        $contenu .= "<select name='semaine' class='case'>";
        while ($rowSemaines = $resultatSemaines->fetch_assoc()) {
            $contenu .= "<option value='" . $rowSemaines["nom_semaine"] . "'>" . $rowSemaines["nom_semaine"] . "</option>";
        }
        $contenu .= "</select>";
        $contenu .= "<input type='submit' name='reservation' class='envoyer' value='Emprunter' onclick='return confirmReservation();'>";
        $contenu .= "</form>";

        // JavaScript pour la fenêtre de confirmation
        $contenu .= "<script>
                        function confirmReservation() {
                            return confirm('Confirmez-vous la réservation de $jeu[nom_jeu] ?');
                        }
                    </script>";

        // Vérifier si le formulaire de réservation a été soumis
        if (isset($_POST['reservation'])) {
            $nomSemaine = $_POST['semaine'];
            $idJeu = $_POST['id_jeu'];
            $membre = $_SESSION['membre']['id_membre'];

            // Récupérer l'id de la semaine
            $resultatSemaine = executeRequete("SELECT id_semaine FROM semaine WHERE nom_semaine = '$nomSemaine'");
            $semaine = $resultatSemaine->fetch_assoc();
            $idSemaine = $semaine['id_semaine'];

            // Effectuer les actions nécessaires pour valider la réservation
            executeRequete("INSERT INTO reservation (id_semaine, id_jeu, id_membre) 
                            VALUES ('$idSemaine', '$idJeu', '$membre')");

            // Afficher un message de confirmation
            $_SESSION['message_reservation'] = "Réservation confirmée de $jeu[nom_jeu] pour la semaine $nomSemaine.";
            header("location:reservations.php?action=affichage_reservation");
        }
    } else {
        $contenu .= "<div class='erreur'>Aucune semaine disponible pour ce jeu.</div>";
    }
} else {
    $contenu .= "<div class='erreur'>Ce jeu est actuellement indisponible</div>";
}

$contenu .= "<br>'<li class='gestion-nav-item'><a class='footer-social-icon' href='collection.php?action=tout_afficher'>Retourner dans la collection</a><br><br>";

$contenu .= "</div></div>";


//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("inc/header.inc.php");
echo $contenu;
require_once("inc/footer.inc.php"); ?> 