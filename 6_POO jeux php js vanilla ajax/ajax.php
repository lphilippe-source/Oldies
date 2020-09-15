<?php
require_once 'connect.php';
require_once 'personnagesManager.php';
require_once 'personnage.php';
// session_status() === PHP_SESSION_ACTIVE ? 0 : session_start();
session_start();
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
  } else {
    $_SESSION['count']++;
  }
// unset($_SESSION['perso']);
class AjaxView extends PersonnagesManager{
    public function __construct($db){
        parent::__construct($db);
        if($_GET['params']==1)
            $this->dataRequest();
        if($_GET['params']==2 && isset($_GET['nom']))
            $this->recup($_GET['nom']);
        if($_GET['params']==3 && isset($_GET['nom']) && isset($_GET['checkC']))
            $this->add($_GET['nom'],$_GET['checkC']);
        if($_GET['params']==4){
            $fighter = explode(',',$_GET['cons']);
            $attaquant = $fighter[0];
            $defensseur = $fighter[1];
            if(isset($_SESSION[$attaquant])&& isset($_SESSION[$defensseur])){
                $_SESSION[$attaquant]->setDommage($_SESSION[$defensseur]);
                if($_SESSION[$defensseur]->getDegats()<100){
                    $_SESSION[$defensseur]->setDommage($_SESSION[$attaquant]);
                }
                if($_SESSION[$defensseur]->getDegats()>=100 ||$_SESSION[$attaquant]->getDegats()>=100){
                    $donnees=array('degats'=>0,'atouts'=>50,'sommeil'=>0,);
                    $_SESSION[$defensseur]->__construct($donnees);
                    $_SESSION[$attaquant]->__construct($donnees);
                }
                $this->endTurn($_SESSION[$attaquant]);
                $this->endTurn($_SESSION[$defensseur]);
                header('Content-type: application/json');
                echo json_encode(AjaxView::getLog(),JSON_FORCE_OBJECT);
            }
        }
        if($_GET['params']==5){
            $fighter = explode(',',$_GET['cons']);
            $attaquant = $fighter[0];
            $defensseur = $fighter[1];
            if(isset($_SESSION[$attaquant])&& isset($_SESSION[$defensseur])){
                $_SESSION[$attaquant]->useMagic($_SESSION[$defensseur]);
                if($_SESSION[$defensseur]->getDegats()<100){
                    $_SESSION[$defensseur]->setDommage($_SESSION[$attaquant]);
                }
                if($_SESSION[$defensseur]->getDegats()>=100 ||$_SESSION[$attaquant]->getDegats()>=100){
                    $donnees=array('degats'=>0,'atouts'=>50,'sommeil'=>0,);
                    $_SESSION[$defensseur]->__construct($donnees);
                    $_SESSION[$attaquant]->__construct($donnees);
                }
                
                $this->endTurn($_SESSION[$attaquant]);
                $this->endTurn($_SESSION[$defensseur]);
                header('Content-type: application/json');
                echo json_encode(AjaxView::getLog(),JSON_FORCE_OBJECT);
            }
        }
    }
    public function recup($nom){
        try{
            $q2 = $this->db->prepare('SELECT id, nom, degats, atouts, sommeil, classtype FROM personnages WHERE nom =:nom');
            $q2->execute(array(
                'nom' => $nom
            ));
            $result = $q2->fetch(PDO::FETCH_ASSOC);
            $sorcOrWar = $result['classtype'];
            $perso = new $sorcOrWar($result);
            
            $_SESSION[$nom]=$perso;
            header('Content-type: application/json');
            echo json_encode($result);
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    public function dataRequest(){
        try{
            $q4 = $this->db->prepare('SELECT * FROM personnages ORDER BY id ASC;');
            $q4->execute();
            $result = $q4->fetchAll(PDO::FETCH_ASSOC);
            header('Content-type: application/json');
            echo json_encode($result);
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    public function add($nom,$checkC){
        $checkC = ucfirst($checkC);
        $atouts=50;
        $sommeil = 0;
        $perso = new $checkC(array('nom'=>$nom,'degats'=>0,'atouts'=>$atouts,'sommeil'=>$sommeil, 'classtype'=>$checkC));
        $_SESSION[$nom]=$perso;
        try{
            $q = $this->db->prepare('INSERT INTO personnages(nom,degats,atouts,sommeil,classtype) VALUES(:nom, :degats, :atouts,:sommeil,:classtype)');
            $q-> execute(array(
                'nom' => $perso->getNom(),
                'degats'=>$perso->getDegats(),
                'atouts' =>$perso->getAtouts(),
                'sommeil' => $perso->getSommeil(),
                'classtype' => $perso->getClassType()
            ));
        }
        catch(Exeption $e){
            die('Erreur : '.$e->getMessage());
        }
        header('Content-Type: text/plain');
        echo 'le personnage '.$nom.' a bien été créer!';
    }
    public function endTurn($perso){
        if($perso->getSommeil()!== NULL && $perso->getSommeil()>0){
            $perso->setSommeil($perso->getSommeil()-1);
        }
        try{
      
          $q3 = $this->db->prepare('UPDATE personnages SET nom=:nom, degats=:degats, atouts=:atouts, sommeil=:sommeil, classtype=:classtype WHERE id=:id');
          $q3->execute(array(
            'id' => $perso->getId(),
            'nom' => $perso->getNom(),
            'degats'=>$perso->getDegats(),
            'atouts' =>$perso->getAtouts(),
            'sommeil' => $perso->getSommeil(),
            'classtype' => $perso->getClassType()
          ));
        }
        catch(Exception $e){
          die('Erreur : '.$e->getMessage());
        }
        $result= [$perso->getNom(),$perso->getDegats()];
        AjaxView::setLog($result);
      }
}
$ajax = new AjaxView($db);
?>