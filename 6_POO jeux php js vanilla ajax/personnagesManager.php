<?php
require_once 'connect.php';
// session_start();
class PersonnagesManager{

//on cré un manager qui va gerer la bdd des personnages et verifier l'integrité des données
  protected $db;
  protected static array $log;
  public function __construct($db){

      $this->setDb($db);
  }
  public function setDb($db){
    
      $this->db = $db;
  }
  public static function getLog(){
    $key=array_keys(self::$log);
    // $arr=array_combine($key,self::$log);
    // foreach(self::$log as $key => &$value){
      // array_keys(self::$log);
    // }
    return array_combine($key,self::$log);
  }
  public static function setLog($str='log'){
    self::$log[]=$str;
  }
  // public function recup($nom){
  // try{
  //   $q2 = $this->db->prepare('SELECT id, nom, degats, atouts, sommeil, classtype FROM personnages WHERE nom =:nom');
  //     $q2->execute(array(
  //       'nom' => $nom
  //     ));
  //     $result = $q2->fetch(PDO::FETCH_ASSOC);
  // }
  // catch(Exception $e){
  //   die('Erreur : '.$e->getMessage());
  // }
  // }
  // public function add(Personnage $perso){
      
  //     $q = $this->db->prepare('INSERT INTO personnages(nom,degats,atouts,sommeil,classtype) VALUES(:nom, :degats, :atouts,:sommeil,:classtype)');
  //     $q-> execute(array(
  //         'nom' => $perso->getNom(),
  //         'degats'=>$perso->getDegats(),
  //         'atouts' =>$perso->getAtouts(),
  //         'sommeil' => $perso->getSommeil(),
  //         'classtype' => $perso->getClassType()
  //     ));
  // }
  // public function endTurn(Personnage $perso){
  //   try{
  
  //     $q3-> $this->db->prepare('UPDATE personnages SET nom=:nom, degats=:degats, atouts=:atouts, sommeil=:sommeil, classtype=:classtype WHERE id=:id');
  //     $q3->execute(array(
  //       'id' => $perso->getId(),
  //       'nom' => $perso->getNom(),
  //       'degats'=>$perso->getDegats(),
  //       'atouts' =>$perso->getAtouts(),
  //       'sommeil' => $perso->getSommeil(),
  //       'classtype' => $perso->getClassType()
  //     ));
  //   }
  //   catch(Exception $e){
  //     die('Erreur : '.$e->getMessage());
  //   }
  // }
}
?>