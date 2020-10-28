<?php
/*
*singleton qui gère la bdd
*récupère les variables d'environnements
*choisi le driver PDO(par default) ou Mysqli
*/
class DbManager_M extends AbstractDb_M{
    protected const PDO_DRIVER = 'connectPDO';
    protected const MYSQLI_DRIVER = 'connectMysqli';
    static protected object $manager;
    protected static object $db;
    protected string $host;
    protected string $pass;
    protected string $user;
    protected string $db1;

    protected function __construct(){
        $this->host = getenv('HOST');
        $this->pass = getenv('PASS');
        $this->user = getenv('USER');
        $this->db1 = getenv('DB');
        isset($_SESSION['driver']) ? $this->selectDriver($_SESSION['driver']) : $this->setDb($this->connectDb());
    }
    private function __clone(){
    }
    public function connectMysqli(): object {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $_SESSION['driver']='connectMysqli';
            $db = new mysqli($this->host, $this->user, $this->pass, $this->db1);
            $db->set_charset(self::CHARSET);
            return $db;
        } 
        catch(Exception $e){
            error_log($e->getMessage());
            exit('Error connecting to database');
        }
    }
    public function connectPDO(): object {
        try
        {
            $_SESSION['driver']='connectPDO';
            $dsn = "mysql:host=".$this->host.";dbname=".$this->db1.";charset=".self::CHARSET;
            $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $db = new PDO($dsn, $this->user, $this->pass, $options);
            return $db;
        }
        catch(Exception $e){
            error_log($e->getMessage());
            exit('Error connecting to database');
        }    
    }
    public function connectDb(string $method = self::PDO_DRIVER): object{
        if(method_exists($this,$method))
        return $this->$method();
    }
    public static function createDbManager(): object{
        if(!isset(self::$manager)) self::$manager = new self;
        
            return self::$manager;
    }
    public static function getDb(): object{
        return self::$db;
    }
    public function selectDriver(string $driver): void{
        $select= $driver==self::PDO_DRIVER ? $this->connectDb(): $this->connectDb(self::MYSQLI_DRIVER);
        $this->setDb($select);
    }
    public function setDb(object $select): void{
        self::$db = $select;
    }
}
?>