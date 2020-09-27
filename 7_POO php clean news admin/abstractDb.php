<?php
require 'autoload.php';

abstract class AbstractDb{

    protected const HOST = '127.0.0.1';
    protected const DB1 = 'test';
    protected const USER = 'root';
    protected const PASS = '';
    protected const CHARSET = 'utf8mb4';

    abstract public function connectPDO();
    abstract public function connectMysqli();
    abstract static public function getDb();
    abstract public function connectDb();

}
?>
