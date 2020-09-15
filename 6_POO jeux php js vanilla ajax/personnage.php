<?php
require_once 'connect.php';
require_once 'personnagesManager.php';
require_once 'personnage.php';
require_once 'ajax.php';
abstract class Personnage {

protected $id;
protected $degats;
protected $nom;
protected $atouts;
protected $sommeil;
protected $classType;

public function __construct(array $donnees){
    $this->hydrate($donnees);
}
public function hydrate(array $donnees)
{
  foreach ($donnees as $key => $value)
  {
    $method = 'set'.ucfirst($key);
    if (method_exists($this, $method))
    {
      $this->$method($value);
    }
  }
}
public function getClassType(){
  return $this->classType;
}
public function setClassType($classValue){
  if(class_exists($classValue))
  $this->classType=$classValue;
}
public function getSommeil(){
  return $this->sommeil;
}
public function setSommeil($value=0){
  if($value>=0 && is_int($value)){
    $this->sommeil=$value;
    return;
  }
}
public function getNom(){
    return $this->nom;
}
public function getAtouts(){
    return $this->atouts;
}
public function getDegats(){
    return $this->degats;
}
public function getId(){
    return $this->id;
}
public function setId($id){
    if(is_int($id)){
        $this->id = $id;
    }
    else{
        $this->id = intval($id);
    }
}
public function setNom($nom){
    if(is_string($nom)){
        $this->nom = $nom;
    }
}
public function setAtouts($value){
    if(is_int($value)){
        $this->atouts = $value;
    }
    else{
        $this->atouts = intval($value);
    }
}
public function setDegats($value){
    if(is_int($value)){
        $this->degats = $value;
    }
    else{
        $this->degats = intval($value);
    }
}
public function setDommage(Personnage $perso){

    if(isset ($perso)){
        if($perso->getNom()!=$this->getNom()){
            $life = $perso->getDegats();
            $attaque=5;
            if($perso->getClassType()=="Guerrier"){
                $perso->parade($attaque);
            }
            if($this->getSommeil()!==NULL && $this->getSommeil()>0){
                $attaque=$attaque-$this->getSommeil();
                AjaxView::setLog('l\'attaque de '.$this->getNom().' est diminuée de '.$this->getSommeil());
            }
            $life+=$attaque;
            $perso->setDegats($life);
            AjaxView::setLog($this->getNom()." attaque ".$perso->getNom()." qui prend ".$attaque." pts de degats!");
            
        }
        else{
           return print($this->getNom()." ne peux s'attaquer lui même!!<br/>");
        }
    }
    if($perso->getDegats()>=100){
        AjaxView::setLog($perso->getNom().' est mort! '.$this->getNom().' gagne le match!');
    }
}
}
class Guerrier extends Magicien{

    public function parade(&$attaque){
        if($this->getAtouts()>=10){
            $ptAtout=$this->getAtouts()-10;
            $this->setAtouts($ptAtout);
            $min=25;
            $max=75;
            $pourParade = random_int( $min,$max);
            $attaque = $attaque- intval($attaque*$pourParade/100);
            // var_dump($attaque);
            AjaxView::setLog($this->getNom().' pare l\'attaque à '.$pourParade.'%');
        }else{
            AjaxView::setLog($this->getNom().' n\'a plus assez d\'atouts pour parer l\'attaque!');
        }
    }
}
class Magicien extends Personnage{

    public function useMagic(Personnage $perso){
        if($this->getNom() == $perso->getNom()){
           return print('vous ne pouvez pas lancer ce sort sur vous-même!');
        }
        else{
            AjaxView::setLog($this->getNom().' lance un sort de sommeil sur '.$perso->getNom());
            if($this->getAtouts() >= 5){
                $value=$this->getAtouts()-5;
                $this->setAtouts($value);
                $sommeil = 3;
                $perso->setSommeil($sommeil);
                AjaxView::setLog($perso->getNom().' est somnolent, son attaque est diminuer de '.$sommeil);
            }else{
                AjaxView::setLog($this->getNom().' n\'a plus assez d\'atouts pour lancer un sort!');
            }
        }
    }
}
?>