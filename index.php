<?php
require_once("inc/init.inc.php");
require_once("inc/header.inc.php");

//-------------------- AFFICHAGE LA LUDOTHEQUE ---------------------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == "affichage_La_Ludotheque" || !isset($_GET['action']))
{

    $resultat = executeRequete('SELECT image_presentation FROM presentation WHERE id_presentation = "1"');
    $presentation1 = $resultat->fetch_assoc();
    $image_presentation1=$presentation1["image_presentation"];
    echo '<img class="banniere" src=" '. $image_presentation1 .' " alt="Evenement en cours">';
    
echo '<div class="content">';

//-------------------- case 1 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "2"');
$presentation2 = $resultat->fetch_assoc();
$titre_presentation2 = $presentation2["titre_presentation"];
$texte_presentation2 = nl2br($presentation2["texte_presentation"]);
$image_presentation2=$presentation2["image_presentation"];
echo '
            <div class="vert">
                <p style="float:left">
                <img style="max-height:350px; width:auto" src=" '. $image_presentation2 .' "></p>
                <h3>'. $titre_presentation2 .'</h3>
                <p type="text">'. $texte_presentation2 .'</p>
                
            </div>';

//-------------------- case 2 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "3"');
$presentation3 = $resultat->fetch_assoc();
$titre_presentation3 = $presentation3["titre_presentation"];
$texte_presentation3 = nl2br($presentation3["texte_presentation"]);
echo '
            <div class="jaune" style="color:black">
                <h3 style="color:black">'. $titre_presentation3 .'</h3>
                <p type="text">'. $texte_presentation3 .'</p>
            </div>';

//-------------------- case 3 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "4"');
$presentation4 = $resultat->fetch_assoc();
$titre_presentation4 = $presentation4["titre_presentation"];
$texte_presentation4 = nl2br($presentation4["texte_presentation"]);
$image_presentation4=$presentation4["image_presentation"];
echo '
            <div class="bleu">
                <p style="float:top">
                <img style="height:auto; max-width:660px;" src=" '. $image_presentation4 .' "></p>
                <h3>'. $titre_presentation4 .'</h3>
                <p type="text">'. $texte_presentation4 .'</p>
            </div>';

//-------------------- case 4 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "5"');
$presentation5 = $resultat->fetch_assoc();
$titre_presentation5 = $presentation5["titre_presentation"];
$texte_presentation5 = nl2br($presentation5["texte_presentation"]);
$image_presentation5=$presentation5["image_presentation"];
echo '
            <div class="rouge">
                <p style="float:top">
                <h3>'. $titre_presentation5 .'</h3>
                <p type="text">'. $texte_presentation5 .'</p>
                </p>
                <p style="float:bottom; text-align:center"><img style="max-height:350px; width:auto" src=" '. $image_presentation5 .' "></p>
            </div>';        

echo '</div>';
}


//-------------------- AFFICHAGE NOS ACTIONS --------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == "affichage_Nos_Accueils")
{

echo '<div class="content">';

//-------------------- case 1 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "7"');
$presentation7 = $resultat->fetch_assoc();
$titre_presentation7 = $presentation7["titre_presentation"];
$texte_presentation7 = nl2br($presentation7["texte_presentation"]);
$image_presentation7=$presentation7["image_presentation"];
echo '
            <div class="bleu">
                <p style="float:top">
                <h3>'. $titre_presentation7 .'</h3>
                <p type="text">'. $texte_presentation7 .'</p>
                <img style="height:auto; max-width:660px; margin-left:20px" src=" '. $image_presentation7 .' "></p>
            </div>';

//-------------------- case 2 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "8"');
$presentation8 = $resultat->fetch_assoc();
$titre_presentation8 = $presentation8["titre_presentation"];
$texte_presentation8 = nl2br($presentation8["texte_presentation"]);
$image_presentation8=$presentation8["image_presentation"];
echo '
            <div class="rouge">
                <p style="float:right">
                <img style="height:auto; max-height:450px; width:auto" src=" '. $image_presentation8 .' "></p>
                <h3>'. $titre_presentation8 .'</h3>
                <p type="text">'. $texte_presentation8 .'</p>
            </div>';

//-------------------- case 3 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "9"');
$presentation9 = $resultat->fetch_assoc();
$titre_presentation9 = $presentation9["titre_presentation"];
$texte_presentation9 = nl2br($presentation9["texte_presentation"]);
$image_presentation9=$presentation9["image_presentation"];
echo '
            <div class="jaune" style="color:black">
                <p style="float:top">
                <h3 style="color:black">'. $titre_presentation9 .'</h3>
                <p type="text">'. $texte_presentation9 .'</p>
                <img style="height:auto; max-width:660px; margin-left:20px" src=" '. $image_presentation9 .' "></p>
            </div>';

//-------------------- case 4 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "10"');
$presentation10 = $resultat->fetch_assoc();
$titre_presentation10 = $presentation10["titre_presentation"];
$texte_presentation10 = nl2br($presentation10["texte_presentation"]);
$image_presentation10=$presentation10["image_presentation"];
echo '
            <div class="vert">
                <p style="float:top">
                <h3>'. $titre_presentation10 .'</h3>
                <p type="text">'. $texte_presentation10 .'</p>
                <img style="height:auto; max-width:660px; margin-left:20px" src=" '. $image_presentation10 .' "></p>
            </div>';        

echo '</div>';
}

//-------------------- AFFICHAGE EVENEMENTS --------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == "affichage_Evenements")
{

    $resultat = executeRequete('SELECT image_presentation FROM presentation WHERE id_presentation = "11"');
    $presentation11 = $resultat->fetch_assoc();
    $image_presentation11=$presentation11["image_presentation"];
    echo '<img class="banniere" src=" '. $image_presentation11 .' " alt="Evenement en cours">';

echo '<div class="content">';

//-------------------- case 1 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "12"');
$presentation12 = $resultat->fetch_assoc();
$titre_presentation12 = $presentation12["titre_presentation"];
$texte_presentation12 = nl2br($presentation12["texte_presentation"]);
$image_presentation12=$presentation12["image_presentation"];
echo '
            <div class="bleu">
                <p style="float:top"><img style="height:auto; max-width:660px" src= '. $image_presentation12 .' "></p>
                <p type="text"><b>'. $texte_presentation12 .'</b></p>
            </div>';

//-------------------- case 2 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "13"');
$presentation13 = $resultat->fetch_assoc();
$titre_presentation13 = $presentation13["titre_presentation"];
$texte_presentation13 = nl2br($presentation13["texte_presentation"]);
$image_presentation13=$presentation13["image_presentation"];
echo '
            <div class="jaune" style="color:black">
                <p style="float:top"><img style="height:auto; max-width:660px" src=" '. $image_presentation13 .' "></p>
                <p type="text"><b>'. $texte_presentation13 .'</b></p>
            </div>';

//-------------------- case 3 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "14"');
$presentation14 = $resultat->fetch_assoc();
$titre_presentation14 = $presentation14["titre_presentation"];
$texte_presentation14 = nl2br($presentation14["texte_presentation"]);
$image_presentation14=$presentation14["image_presentation"];
echo '
            <div class="rouge">
                <p style="float:top"><img style="height:auto; max-width:660px" src=" '. $image_presentation14 .' "></p>
                <p type="text"><b>'. $texte_presentation14 .'</b></p>
            </div>';

//-------------------- case 4 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "15"');
$presentation15 = $resultat->fetch_assoc();
$titre_presentation15 = $presentation15["titre_presentation"];
$texte_presentation15 = nl2br($presentation15["texte_presentation"]);
$image_presentation15=$presentation15["image_presentation"];
echo '
            <div class="vert">
            <p style="float:right">
                <img style="height:auto; max-height:450px; width:auto" src=" '. $image_presentation15 .' "></p>
                <h3>'. $titre_presentation15 .'</h3>
                <p type="text">'. $texte_presentation15 .'</p>
            </div>';        

//-------------------- case 5 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "16"');
$presentation16 = $resultat->fetch_assoc();
$titre_presentation16 = $presentation16["titre_presentation"];
$texte_presentation16 = nl2br($presentation16["texte_presentation"]);
$image_presentation16=$presentation16["image_presentation"];
echo '
            <div class="bleu">
                <p style="float:top"><img style="height:auto; max-width:660px" src=" '. $image_presentation16 .' "></p>
                <p type="text"><b>'. $texte_presentation16 .'</b></p>
            </div>';   
            
//-------------------- case 6 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "17"');
$presentation17 = $resultat->fetch_assoc();
$titre_presentation17 = $presentation17["titre_presentation"];
$texte_presentation17 = nl2br($presentation17["texte_presentation"]);
$image_presentation17=$presentation17["image_presentation"];
echo '
            <div class="jaune" style="color:black">
                <p style="float:top"><img style="height:auto; max-width:660px" src=" '. $image_presentation17 .' "></p>
                <p type="text"><b>'. $texte_presentation17 .'</b></p>
            </div>';        

echo '</div>';
}

//-------------------- AFFICHAGE NOUS TROUVER-------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == "affichage_Nous_Trouver")
{

echo '<div class="content">';

//-------------------- case 1 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "18"');
$presentation18 = $resultat->fetch_assoc();
$titre_presentation18 = $presentation18["titre_presentation"];
$texte_presentation18 = nl2br($presentation18["texte_presentation"]);
$image_presentation18=$presentation18["image_presentation"];
echo '
            <div class="rouge">
                <p style="float:right"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2628.073114551644!2d2.28802721590854!3d48.79958317928184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e670943303d36f%3A0xda9c89663b6e014e!2s1%20Imp.%20Samson%2C%2092320%20Ch%C3%A2tillon!5e0!3m2!1sfr!2sfr!4v1678722551046!5m2!1sfr!2sfr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>
                <h3>'. $titre_presentation18 .'</h3>
                <p type="text">'. $texte_presentation18 .'</p>
            </div>';

//-------------------- case 2 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "19"');
$presentation19 = $resultat->fetch_assoc();
$titre_presentation19 = $presentation19["titre_presentation"];
$texte_presentation19 = nl2br($presentation19["texte_presentation"]);
$image_presentation19=$presentation19["image_presentation"];
echo '
            <div class="vert">
                <p style="float:right"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2627.757516136268!2d2.2895729333208683!3d48.80560641301695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6716bb3b34287%3A0x128e62d74b65db9d!2sLudoth%C3%A8que%20Chatillon%20kid%20club!5e0!3m2!1sfr!2sfr!4v1678722672465!5m2!1sfr!2sfr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>
                <h3>'. $titre_presentation19 .'</h3>
                <p type="text">'. $texte_presentation19 .'</p>
            </div>';

//-------------------- case 3 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "20"');
$presentation20 = $resultat->fetch_assoc();
$titre_presentation20 = $presentation20["titre_presentation"];
$texte_presentation20 = nl2br($presentation20["texte_presentation"]);
$image_presentation20=$presentation20["image_presentation"];
echo '
            <div class="jaune" style="color:black">
                <p style="float:right"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2627.537276782301!2d2.291531315908883!3d48.80980937928283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6708cfb7821b1%3A0x3d1c12130e687f0!2sCentre%20Socio-Culturel%20de%20Ch%C3%A2tillon%20Guynemer!5e0!3m2!1sfr!2sfr!4v1678722604592!5m2!1sfr!2sfr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>
                <h3 style="color:black">'. $titre_presentation20 .'</h3>
                <p type="text">'. $texte_presentation20 .'</p>
            </div>';

//-------------------- case 4 -------------------------------//

$resultat = executeRequete('SELECT titre_presentation, texte_presentation, image_presentation FROM presentation WHERE id_presentation = "21"');
$presentation21 = $resultat->fetch_assoc();
$titre_presentation21 = $presentation21["titre_presentation"];
$texte_presentation21 = nl2br($presentation21["texte_presentation"]);
$image_presentation21=$presentation21["image_presentation"];
echo '
            <div class="bleu">
                <p style="float:right"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5255.992416120808!2d2.286541!3d48.801051!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6709721583d71%3A0x64cd53e779e68613!2zTcOpZGlhdGjDqHF1ZSBkZSBDaMOidGlsbG9u!5e0!3m2!1sfr!2sfr!4v1678722346030!5m2!1sfr!2sfr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>
                <h3>'. $titre_presentation21 .'</h3>
                <p type="text">'. $texte_presentation21 .'</p>
            </div>';    

echo '</div>';
}




require_once("inc/footer.inc.php"); ?>
