<?php
spl_autoload_register(function (string $class): void {
    $className = lcfirst ($class);
    require $className.'.php';
});
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


?>
<br/>
<h2 class="h2 blockquote-footer">Ajout d'une news</h2><br/>

        <form method='POST' action=''>
        <div class="row">
            
            <div class="col">
            <input type="text" class="form-control" placeholder="Auteur" name="auteur">
            </div>
        </div>
        <div class="row">
            <div class="col">
            <input type="text" class="form-control" placeholder="Titre" name="titre">
            </div>
        </div>
        <div class="row">
            <div class="col">
            <textarea type="text" class="form-control" placeholder="Contenu" row="10" name="contenu">
            </textarea>
            </div>
        </div>
        <div class="row">
            <div class="col">
            <input type="text" class="form-control" placeholder="Date d'Ajout" name="dateAjout">
            </div>
            <div class="col">
            <input type="text" class="form-control" placeholder="Date de Modification" name="dateModif">
            </div>
        </div>
        <input class="btn btn-primary" type="submit" name="upAddNews" />
        </form>