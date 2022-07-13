<?php
    header('Content-type: text/html; charset=utf-8');
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
  

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $user = array(
            'user' => $_POST['username'],
            'password' => $_POST['password'],
            'email' => $_POST['email'],
            'nombre' => $_POST['nombre']
        );

        if (!empty($user['user']) &&
            !empty($user['password']) &&
            !empty($user['email']) &&
            !empty($user['nombre'])
        ) {
            if (registerUser($user)){
                session_start();
                $_SESSION['username'] = $user['user'];
                header("Location: index.php");
                exit();
            }
        }
    }

    echo $twig->render('register.html', []);
?>