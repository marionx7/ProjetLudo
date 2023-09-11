<?php
require_once("inc/init.inc.php");

require_once("inc/header.inc.php");

echo '
    <body style="text-align: center;">
	<div style="position: relative; width: 600px; margin-left: auto; margin-right: auto; text-align: left;">
    	<div class="content">
			<form method="post" action="mailto:marion.lhuillier1@cnam.fr">
			<h1 style="line-height: 90px; margin-top: 0px; padding-top: 20px; padding-bottom: 0px; color: #000000">Contactez-nous</h1>
				<input type="text" name="nom" placeholder="Nom" class="case" required="">
				<input type="text" name="prenom" placeholder="Prénom" class="case" required="">
				<input type="text" name="email" placeholder="monadresse@exemple.com" class="case" required="">
                <select id="motif" name="motif" size="1" class="envoyer">
			        <option Value="renseignements" selected>Demande de renseignements</option>
			        <option Value="inscription">Inscription à un événement</option>
			        <option Value="03ans">Inscription à l\'accueil 0-3 ans</option>
			        <option Value="autre">Autre motif</option>
			        </select>
				<textarea placeholder="Votre message" class="case" style="height: 300px"required=""></textarea>
				<button type="submit" class="envoyer">Envoyer</button>
			</form>
			</br>
		</div>
    </div>';

require_once("inc/footer.inc.php"); ?>