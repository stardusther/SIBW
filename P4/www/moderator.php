<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    session_start();

    $usuario = []; // valor por defecto

    if (isset($_SESSION['username'])){
        $usuario = getUser($_SESSION['username']);

        if (!($usuario['moderate'] || $usuario['admin'])){
            echo "Para editar o borrar un comentario debes iniciar sesión como moderador o administrador";
            exit();
        }
    } else {
        echo "Debes iniciar sesión primero";
        exit();
    }
    
    $comments = getComments();

   echo $twig->render('moderator.html', ['usuario' => $usuario, 'comments' => $comments]);

?>