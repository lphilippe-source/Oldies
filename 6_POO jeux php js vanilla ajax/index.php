<?php
session_start();
if (!isset($_SESSION['count'])) {
  $_SESSION['count'] = 0;
} else {
  $_SESSION['count']++;
}
require 'connect.php';
require 'personnagesManager.php';
require_once 'personnage.php';
$manager = new PersonnagesManager($db);
if (isset ($_POST['creer']) && isset($_POST['nom'])){
  if(isset($_POST['magicien'])) {
    $atouts=50;
    $personnage='Magicien';
  }
  else{ $atouts=0;
    $personnage='Guerrier';
  }
  $sommeil = 0;
  $perso1 = new $personnage(array('nom'=>$_POST['nom'],'degats'=>0,'atouts'=>$atouts,'sommeil'=>$sommeil, 'classtype'=>$personnage));
  $manager->add($perso1);
}
if (isset($_POST['utiliser']) && isset($_POST['nom'])){
$manager->recup($_POST['nom']);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TP : Mini jeu de combat</title>
    <meta charset="utf-8" />
    <style>
    tr {
      display:flex;
    }
    td {
      flex:1;
    }
    </style>
  </head>
  <body>
    <p>choisi ton personnage</p>
    <div>
      <input type="checkbox" id="guerrier" name="guerrier"/>
      <label for="guerrier">guerrier</label>
    </div>
    <div>
      <input type="checkbox" id="magicien" name="magicien"/>
      <label for="magicien">magicien</label>
    </div>
    <p>
      Nom : <input id="champ" type="text" name="nom" maxlength="50" />
      <button id="createPerso" type="submit" value="Créer ce personnage" name="creer" >Créer ce personnage</button>
      <button id="usePerso" type="submit" value="Utiliser ce personnage" name="utiliser" >Utiliser ce personnage</button>
    </p>
    
    <button id="sorti" type="submit">Data Serveur</button>

    <div id="text" style="border:1px solid black; width:75%; min-height:200px"></div>
    <div id="console" style="border:1px solid black; width:75%"></div>
    <p>
      <button id="attaque" type="submit" value="attaquer" name="attaque" >attaquer</button><br/>
      <button id="sort" type="submit" value="envoyer un sort" name="sort" >Envoyer un sort</button>
    </p>
    <div id="champsBataille"></div>
    <script src="./ajax.js"></script>
  </body>
</html>