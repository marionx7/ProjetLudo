<?php
//--------- connexion BDD
$mysqli = new mysqli("localhost", "root", "", "ludotheque");
if ($mysqli->connect_error) die('Un problème est survenu lors de la tentative de connexion à la Base de Données : ' . $mysqli->connect_error);
// $mysqli->set_charset("utf8");
 
//--------- SESSION
session_start();
 
//--------- CHEMIN
define("RACINE_SITE","/ludotheque/");
 
//--------- VARIABLES
$contenu = '';
 
//--------- AUTRES INCLUSIONS
require_once("fonction.inc.php");