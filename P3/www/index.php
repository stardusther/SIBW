<?php
    header('Content-type: text/html; charset=utf-8');
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");
    
    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $num = getNumProd();
  
    echo $twig->render('index.html', ['numprod' => $num]);
?>