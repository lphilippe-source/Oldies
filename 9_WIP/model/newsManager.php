<?php
require $_SERVER["CONTEXT_DOCUMENT_ROOT"].'/autoload.php';

/*
*sigleton qui gère les news
*/
class NewsManager_M{

    private static object $manager;

    private function __construct(){
    }
    private function __clone(){
    }
    public static function createNewsManager(): object{
        if(!isset(self::$manager)) self::$manager = new self;
        
            return self::$manager;
    }
    /*
    *appel d'une requête en fonction du driver
    */
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
        return DbManager_M::getDb();
    }
    public function setDateTime(): string{
        return date("Y-m-d H:i:s");
    }
    /*
    *Mysqli ajout d'une news
    */
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
    /*
    *PDO ajout d'une news
    */
    public function addNews1(array $newsData): void{
        try{
            $q = $this->getDb()->prepare('INSERT INTO news(auteur, titre, contenu ) VALUES(:auteur, :titre, :contenu)');
            $q-> execute(array(
                'auteur' => $newsData['auteur'],
                'titre'=> $newsData['titre'],
                'contenu' =>$newsData['contenu']
                
            ));
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    /*
    *Mysqli affichage d'une news
    */
    public function showOneNews0(string $dataId): array{
        try{
            $arr=[];
            $q2 = $this->getDb()->prepare('SELECT * FROM news WHERE id =?');
            $q2->bind_param("s", $dataId);

            $q2->execute();
            $result = $q2->get_result();
            while($row = $result->fetch_object('News_M')) {
                $arr[] = $row;
              }
            return $arr;
        }catch(Exception $e){
            error_log($e->getMessage());
            exit('Error connecting to database');
        } 
    }
    /*
    *PDO affichage d'une news
    */
    public function showOneNews1(string $dataId): array{
        try{
            $q2 = $this->getDb()->prepare('SELECT id, auteur, titre, contenu FROM news WHERE id =:id');
            $q2->execute(array(
                'id' => $dataId
            ));
            $result = $q2->fetchAll(PDO::FETCH_CLASS, 'News_M');
            return $result;
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    /*
    *Mysqli affichage de toutes les news
    */
    public function showAllNews0(): array{
        try{
            $arr=[];
            $q2 = $this->getDb()->prepare('SELECT * FROM news ORDER BY id ASC;');
            $q2->execute();
            $result = $q2->get_result();
            while($row = $result->fetch_object('News_M')) {
                $arr[] = $row;
              }
            return $arr;
        }catch(Exception $e){
            error_log($e->getMessage());
            exit('Error connecting to database');
        } 
    } 
    /*
    *PDO affichage de toutes les news
    */
    public function showAllNews1(): array{
        try{
            $q2 = $this->getDb()->prepare('SELECT * FROM news ORDER BY id ASC');
            $q2->execute();

            $result = $q2->fetchAll(PDO::FETCH_CLASS, 'News_M');
            return $result;
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    /*
    *PDO Edition d'une news
    */
    public function updateNews1(array $data): void{
        try{
            $q2 = $this->getDb()->prepare('UPDATE news SET auteur=:auteur, titre=:titre, contenu=:contenu, dateModif=:dateModif WHERE id =:id');
            $q2->execute(array(
                'auteur' => $data[1],
                'titre' => $data[2],
                'contenu' => $data[3],
                'id' => $data[0],
                'dateModif'=>$this->setDatetime()
            ));
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    /*
    *Mysqli Edition d'une news
    */
    public function updateNews0(array $data): void{
        try{
            $q2 = $this->getDb()->prepare('UPDATE news SET auteur= ?, titre= ?, contenu= ?, dateModif=? WHERE id = ?');
            $q2->bind_param("sssss", $data[1], $data[2], $data[3],$this->setDateTime(), $data[0]);

            $q2->execute();
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    /*
    *PDO Suppression d'une news
    */
    public function deleteNews1(int $idData): void{
        try{
            $q2 = $this->getDb()->prepare('DELETE FROM news WHERE id = :id ');
            $q2->execute(array(
                'id' => $idData
            ));
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
    /*
    *Mysqli Suppression d'une news
    */
    public function deleteNews0(int $idData): void{
        try{
            $q2 = $this->getDb()->prepare('DELETE FROM news WHERE id = ? ');
            $q2->bind_param("i", $idData);
            $q2->execute();
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }
}