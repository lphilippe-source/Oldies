<?php
spl_autoload_register(function (string $class): void {
    $className = lcfirst ($class);
    require $className.'.php';
});
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>