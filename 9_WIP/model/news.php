<?php
require $_SERVER["CONTEXT_DOCUMENT_ROOT"].'/autoload.php';
/*
*class auto-instancié par NewsManager
*/
class News_M{

    protected int $id;
    protected string $auteur;
    protected string $titre;
    protected string $contenu;
    protected string $dateAjout;
    protected string $dateModif;
    
    public function __construct($data=NULL){
    }
    public function formatDate($date): string{
        $date = new DateTime($date);
        return $date->format('d-m-Y H:i');
    }
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
    public function getDateAjout(): string{
        return $this->formatDate($this->dateAjout);
    }
    public function getDateModif(): string{
        return $this->formatDate($this->dateModif);
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