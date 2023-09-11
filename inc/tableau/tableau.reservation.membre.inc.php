<?php

//-------tableau  
$contenu .= '<div style="width: 920px; margin:auto; border: 3px solid #ffff; text-align: center;"><table class="table"><tr class="table-header">';
$colonnes = $resultat->fetch_fields();
foreach ($colonnes as $colonne) {
    // Vérifier si la colonne n'est pas "id_reservation"
    if ($colonne->name !== "id_reservation") {
        $contenu .= '<th class="header__item"><a id="' . $colonne->name . '" class="filter__link" href="#">' . $colonne->name . '</a></th>';
    }
}
$contenu .= '<th class="header__item">Supprimer</th>';
$contenu .= '</tr>';
$contenu .= '<div class="table-content">';
while ($ligne = $resultat->fetch_assoc()) {
    $contenu .= '<tr class="table-row">';
    foreach ($ligne as $indice => $information) {
        // Vérifier si l'indice n'est pas "id_reservation"
        if ($indice !== 'id_reservation') {
            if ($indice === 'statut_reservation') {
                switch ($information) {
                    case '0':
                        $information = '<p style="color:#535294;"><b>En attente</b></p>';
                        break;
                    case '1':
                        $information = '<p style="color:#669933;"><b>Validée</b></p>';
                        break;
                    case '2':
                        $information = '<p style="color:#b90000;"><b>Rejetée</b></p>';
                        break;
                    default:
                        $information = '';
                        break;
                }
            }
            $contenu .= '<td class="table-data">' . $information . '</td>';
        }
    }
    $contenu .= '<td><a class="footer-social-icon" href="?action=suppression_reservation&id_reservation=' . $ligne['id_reservation'] .'" OnClick="return(confirm(\'En êtes-vous certain ?\'));"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
    </svg></a></td>';
    $contenu .= '</tr>';
}
$contenu .= '</div>';
$contenu .= '</table></div><br>';
    ?>

