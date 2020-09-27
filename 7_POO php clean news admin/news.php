<?php

require 'autoload.php';

class News{

    protected int $id;
    protected string $auteur;
    protected string $titre;
    protected string $contenu;
    protected string $dateAjout;
    protected string $dateModif;
    
    public function __construct($data=NULL){
        // $this->hydrate($data);
        // echo $this->id;
        // var_dump($data);
        // giveMeNewsData($this);
    }
    // public function giveMeNewsData($obj){

    // }

    // public function hydrate(object $data){
    //     foreach($data as $key => $value){
    //         $method= "set".ucfirst($key);
    //         if(method_exists($this, $method)){
    //             $this->$method($value);
    //         }
    //     }
    // }
    public function getId(): int{
        return $this->id;
    }
    public function getAuteur(): string{
        return $this->auteur;
    }
    public function getTitre(): string{
        return $this->titre;
    }
    public function getContenu(): string{
        return $this->contenu;
    }
    public function getDateAjout(){
        return $this->dateAjout;
    }
    public function getDateModif(){
        return $this->dateModif;
    }
    public function setId(int $value): void{
        $this->id=$value;
    }
    public function setAuteur(string $value): void{
        $this->auteur=$value;
    }
    public function setTitre(string $value): void{
        $this->titre=$value;
    }
    public function setContenu(string $value): void{
        $this->contenu=$value;
    }
    public function setDateAjout($value): void{
        $this->dateAjout=$value;
    }
    public function setDateModif($value): void{
        $this->dateModif=$value;
    }
}