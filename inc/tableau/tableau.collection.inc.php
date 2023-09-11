<?php

$contenu .= '<p style="color:#404041"; float:right>';
$contenu .= '</br></br></br>Nombre de jeu(x) dans la collection : ' . $resultat->num_rows;
$contenu .= '</p>';

//-------tableau  
$contenu .= '<table class="table"><tr class="table-header">';    
    while($colonne = $resultat->fetch_field())         
    {         
        $contenu .= '<th class="header__item"><a id="' . $colonne->name . '" class="filter__link" href="#">' . $colonne->name . '</a></th>';    
    }
$contenu .= '<th class="header__item">Modification</th>';
$contenu .= '<th class="header__item">Supression</th>';
$contenu .= '</tr>';

$contenu .= '<div class="table-content">';
    while ($ligne = $resultat->fetch_assoc())
    {
        $contenu .= '<tr class="table-row">';
        foreach ($ligne as $indice => $information)
        {
            if($indice == "photo")
            {
                $contenu .= '<td><img src="' . $information . '" ="70" height="70"></td>';
            }
            else
            {
                $contenu .= '<td class="table-data">' . $information . '</td>';
            }
        }
        $contenu .= '<td><a class="footer-social-icon" href="?action=modification_jeu&id_jeu=' . $ligne['id_jeu'] .'"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="green" class="bi bi-pencil-fill" viewBox="0 0 16 16">
            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
            </svg></a></td>';
        $contenu .= '<td><a class="footer-social-icon" href="?action=suppression_jeu&id_jeu=' . $ligne['id_jeu'] .'" OnClick="return(confirm(\'En êtes vous certain ?\'));"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-trash-fill" viewBox="0 0 16 16">
            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
            </svg></a></td>';
        $contenu .= '</tr></div>';
    }
$contenu .= '</div>';
$contenu .= '</table><br>';

    ?>