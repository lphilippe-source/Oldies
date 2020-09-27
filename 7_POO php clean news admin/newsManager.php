<?php

require 'autoload.php';
class NewsManager{

    private static object $manager;

    private function __construct(){
    }
    private function __clone(){
    }
    public static function createNewsManager(): object{
        if(!isset(self::$manager)) self::$manager = new self;
        
            return self::$manager;
    }
    public function __call(string $method,array $arguments){
        $nbPDO=1;
        $nbMYSQLI=0;
        if(strrpos($_SESSION['driver'],"PDO")!=false) 
            $func = $method.$nbPDO;
        if(strrpos($_SESSION['driver'],"Mysqli")!=false) 
            $func = $method.$nbMYSQLI;

        if(method_exists($this,$func))
            return $this->$func($arguments[0]);
    }
    public function getDb(): object{
        return DbManager::getDb();
    }
    public function addNews0(array $newsData): void{
        try{
            $q = $this->getDb()->prepare("INSERT INTO news (auteur, titre, contenu ) VALUES (?, ?, ?)");
            $q->bind_param("sss", $newsData['auteur'], $newsData['titre'], $newsData['contenu']);
            $q->execute();
            $q->close();
        }catch(Exception $e){
            error_log($e->getMessage());
            exit('Error connecting to database');
        } 
    }  
    public function addNews1(array $newsData): void{
        try{
            $q = $this->getDb()->prepare('INSERT INTO news(auteur, titre, contenu ) VALUES(:auteur, :titre, :contenu)');
            $q-> execute(array(
                'auteur' => $newsData['auteur'],
                'titre'=> $newsData['titre'],
                'contenu' =>$newsData['contenu'],
            ));
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    public function showNews0(string $dataId): array{
        try{
            $arr=[];
            $q2 = $this->getDb()->prepare('SELECT * FROM news WHERE id =?');
            $q2->bind_param("s", $dataId);

            $q2->execute();
            $result = $q2->get_result();
            while($row = $result->fetch_object('News')) {
                $arr[] = $row;
              }
            return $arr;
        }catch(Exception $e){
            error_log($e->getMessage());
            exit('Error connecting to database');
        } 
    }
    public function showNews1(string $dataId): array{
        try{
            $q2 = $this->getDb()->prepare('SELECT id, auteur, titre, contenu FROM news WHERE id =:id');
            $q2->execute(array(
                'id' => $dataId
            ));
            $result = $q2->fetchAll(PDO::FETCH_CLASS, 'News');
            return $result;
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    public function showAllNews0(): array{
        try{
            $arr=[];
            $q2 = $this->getDb()->prepare('SELECT * FROM news ORDER BY id ASC;');
            $q2->execute();
            $result = $q2->get_result();
            while($row = $result->fetch_object('News')) {
                $arr[] = $row;
              }
            return $arr;
        }catch(Exception $e){
            error_log($e->getMessage());
            exit('Error connecting to database');
        } 
    } 
    public function showAllNews1(): array{
        try{
            $q2 = $this->getDb()->prepare('SELECT * FROM news ORDER BY id ASC');
            $q2->execute();

            $result = $q2->fetchAll(PDO::FETCH_CLASS, 'News');
            return $result;
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    public function updateNews1(array $data): void{
        try{
            $q2 = $this->getDb()->prepare('UPDATE news SET auteur=:auteur, titre=:titre, contenu=:contenu WHERE id =:id');
            $q2->execute(array(
                'auteur' => $data[1],
                'titre' => $data[2],
                'contenu' => $data[3],
                'id' => $data[0]
            ));
            // $result = $q2->fetchAll(PDO::FETCH_CLASS, 'News');
            // return $result;
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    public function updateNews0(array $data): void{
        try{
            $q2 = $this->getDb()->prepare('UPDATE news SET auteur= ?, titre= ?, contenu= ? WHERE id = ?');
            $q2->bind_param("ssss", $data[1], $data[2], $data[3], $data[0]);

            $q2->execute();
            // $result = $q2->fetchAll(PDO::FETCH_CLASS, 'News');
            // return $result;
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    

}