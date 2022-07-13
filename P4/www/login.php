<?php
    header('Content-type: text/html; charset=utf-8');
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");


    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
  

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if (!empty($username) && !empty($password)){
            if (checkLogin($username, $password)){
                session_start();
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            }
        }
    }


    echo $twig->render('login.html', []);
?>