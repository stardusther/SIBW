<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    if (isset($_SESSION['username'])){
        $usuario = getUser($_SESSION['username']);

        if (!($usuario['manage'] || $usuario['admin'])){
            echo "Para editar un comentario debes iniciar sesión como gestor o administrador";
            exit();
        }
    } else {
        echo "Debes iniciar sesión primero";
        exit();
    }
    
    $productos = getProducts();
    
    echo $twig->render('manager.html', ['usuario' => $usuario, 'products' => $productos]);
?>