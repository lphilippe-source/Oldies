<?php
include $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/views/header.php';

  Route_C::add('/submit-add-news',function(){
    $dbManager = DbManager_M::createDbManager();
    $newsManager = NewsManager_M::createNewsManager();
    $newsManager->addNews(array(
      'auteur'=>$_POST['auteur'],
      'titre'=>$_POST['titre'],
      'contenu'=>$_POST['contenu']
    ));
    header('Location:'.$_SERVER["CONTEXT_PREFIX"].'/admin');
  },'post');

  Route_C::add('/update-news',function(){
    $dbManager = DbManager_M::createDbManager();
    $newsManager = NewsManager_M::createNewsManager();
    if(!isset($_POST['updateThisNews'])){
      header('location:'.$_SERVER["CONTEXT_PREFIX"].'/admin');
    }else{
      $dataNews = $newsManager->updateNews(array($_POST['id'], $_POST['auteur'],$_POST['titre'],$_POST['contenu']));
      header('location:'.$_SERVER["CONTEXT_PREFIX"].'/admin');
    }
  },'post');

  Route_C::add('/submit-delete-news',function(){
    $dbManager = DbManager_M::createDbManager();
    $newsManager = NewsManager_M::createNewsManager();
    if (isset($_POST['del'])){
      $newsManager->deleteNews($_POST['id3']);
      header('Location:'.$_SERVER["CONTEXT_PREFIX"].'/admin');
    }else{
      $dataNews = $newsManager->showOneNews($_POST['id']);
      echo '<h1 class="h1 text-center">//ADMIN</h1>';
      include $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/views/oneNews.php';
      include $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/views/table.php';
    }
  },'post');

  Route_C::add('/admin',function(){
    echo '<h1 class="h1 text-center">//ADMIN</h1>';
    $dbManager = DbManager_M::createDbManager();
    $newsManager = NewsManager_M::createNewsManager();
    include $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/views/pdo_mysqli.php';
    include $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/views/newsform.php';
    include $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/views/table.php';
  });

  Route_C::add('/pdo-sqli',function(){
    $dbManager = DbManager_M::createDbManager();
    $newsManager = NewsManager_M::createNewsManager();
    $dbManager->selectDriver($_POST['PDOorMSQL']);
    header('location:'.$_SERVER["CONTEXT_PREFIX"].'/admin');
  },'post');

  Route_C::add('/',function(){ 
    $dbManager = DbManager_M::createDbManager();
    $newsManager = NewsManager_M::createNewsManager();
    $data = $newsManager->showAllNews();
    $data = array_reverse($data);
    $dCount = count($data);
    include $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/views/home.php';
    include $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/views/footer.php';
  });

  Route_C::run($_SERVER["CONTEXT_PREFIX"]);
?>