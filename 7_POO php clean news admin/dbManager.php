<?php
require 'autoload.php';

class DbManager extends AbstractDb{
    protected const PDO_DRIVER = 'connectPDO';
    protected const MYSQLI_DRIVER = 'connectMysqli';
    static protected $manager;
    protected static object $db;

    protected function __construct(){
        isset($_SESSION['driver']) ? $this->selectDriver($_SESSION['driver']) : $this->setDb($this->connectDb());
    }
    private function __clone(){
    }
    public function connectMysqli(): object {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $_SESSION['driver']='connectMysqli';
            $db = new mysqli(self::HOST, self::USER, self::PASS, self::DB1);
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
            $dsn = "mysql:host=".self::HOST.";dbname=".self::DB1.";charset=".self::CHARSET;
            $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $db = new PDO($dsn, self::USER, self::PASS, $options);
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