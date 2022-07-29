<?php

    header('Content-type: text/html; charset=utf-8');
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] >= 0)){ // obtenemos el id del producto
        $id = $_GET['id'];
    } else{
        $id = -1;
        header("Location: 404.php");
    }

    $codigo_error = 0;

    session_start();

    if (isset($_SESSION['username'])){
        $usuario = getUser($_SESSION['username']);

        if (!($usuario['moderate'] || $usuario['admin'])){
            echo "Para editar un comentario debes iniciar sesión como moderador o administrador";
            exit();
        }
    } else {
        echo "Debes iniciar sesión primero";
        exit();
    }

    $oldText = "";

    // SI le damos al botón y no había intentado editar nada antes
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $oldText = $_POST['newText'];

        if(!empty($oldText)){
            $newText = "[Editado por un moderador] ".$oldText;
            if (!editComment($id, $newText)){
                header("Location: 404.php");
            } else {
                $_SESSION['codigo_error'] = 1;
            }
        } else {
            $_SESSION['codigo_error']= 3;
        }
    } else {
        $_SESSION['codigo_error'] = 2;
    }

    $comment = getComment($id);
    echo $twig->render('edit_comment.html', ['usuario' => $usuario, 'oldText' => $oldCommentText, 'comment' => $comment, 'codigo_error' => $_SESSION['codigo_error']]);

    if ($_SESSION['codigo_error'] != 0){
        $_SESSION['codigo_error'] = 0;
    }
?>