<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    if (isset($_SESSION['username'])){
        $usuario = getUser($_SESSION['username']);

        if (!($usuario['manage'] || $usuario['admin'])){
            echo "Para borrar un producto debes iniciar sesión como gestor o administrador";
            exit();
        }
    } else {
        echo "Debes iniciar sesión primero";
        exit();
    }

    if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] >= 0)){ // obtenemos el id del producto
        $id = $_GET['id'];
    } else{
        $id = -1;
        header("Location: 404.php");
    }

    if($id == -1){
        header("Location: 404.php");
    } else{
       if(deleteProduct($id)){
           header("Location: manager.php");
       } else{
           header("Location: 404.php");
       } 
    }

   
?>