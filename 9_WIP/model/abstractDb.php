<?php
require $_SERVER["CONTEXT_DOCUMENT_ROOT"].'/autoload.php';

abstract class AbstractDb_M{

    
    protected const CHARSET = 'utf8mb4';

    abstract public function connectPDO();
    abstract public function connectMysqli();
    abstract static public function getDb();
    abstract public function connectDb();

}
?>