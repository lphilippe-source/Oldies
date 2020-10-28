<?php
/*
*autocharge les fichiers et met à jour la session
*
*/
$autoload = (new class{

    private const M = 'model';
    private const V = 'views';
    private const C = 'controller';

    public function __construct(){
        if (session_status() == PHP_SESSION_NONE) session_start();
        spl_autoload_register(array($this,'load'));
    }
    private function load(string $class): void{
        $folder = explode('_',$class);
        require constant('self::'.$folder[1]).'/'.lcfirst($folder[0]).'.php';
    }
});
?>