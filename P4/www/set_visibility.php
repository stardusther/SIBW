<?php

    header('Content-type: text/html; charset=utf-8');
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    if (isset($_SESSION['username'])){
        $usuario = getUser($_SESSION['username']);

        if (!($usuario['moderate'] || $usuario['admin'])){
            echo "Para establecer la visibilidad debes iniciar sesión como moderador o administrador";
            exit();
        }
    } else {
        echo "Debes iniciar sesión primero";
        exit();
    }

    if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] >= 0)){ // obtenemos el id del producto
        $id = $_GET['id'];
        if(toggleVisible($id)){
            header("Location: manager.php");
        }
    } else{
        $id = -1;
        header("Location: 404.php");
    }


?>
