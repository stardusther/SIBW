<?php

    header('Content-type: text/html; charset=utf-8');
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    if (isset($_SESSION['username'])){
        $usuario = getUser($_SESSION['username']);
    } else {
        echo "Debes iniciar sesión primero";
        exit();
    }

    $codigo_error = 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $user = array(
            'password' => $_POST['password'],
            'email' => $_POST['email'],
            'nombre' => $_POST['nombre'],
            'user' => $_SESSION['username']
        );    
        # si hay contraseña nueva
        if (!empty($user['password'])){
            $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
            if (editPassword($_SESSION['username'], $user['password'])){
                $codigo_error = 1;
                // echo $twig->render('success.html', ['usuario' => $usuario]);                exit();
            } else {
                $codigo_error = 2;
                // echo $twig->render('failure.html', ['usuario' => $usuario]);                exit();
            }
        } else {
            if (editProfile($user)){
                $codigo_error = 1;
                // echo $twig->render('success.html', ['usuario' => $usuario]);                exit();
            } else {
                $codigo_error = 2;
                // echo $twig->render('failure.html', ['usuario' => $usuario]);                exit();
            }
        }
    } /*else {
        echo "No has enviado datos";
    }*/

    echo $twig->render('edit_user.html', ['usuario' => $usuario, 'codigo_error' => $codigo_error]);
?>