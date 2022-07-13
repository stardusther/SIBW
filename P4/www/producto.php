<?php
    header('Content-type: text/html; charset=utf-8');
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    if (isset($_GET['prod'])) {
        $idProd = $_GET['prod'];
    } else {
        $idProd = -1;
    }
    
    session_start();

    if (isset($_SESSION['username'])){
        $usuario = getUser($_SESSION['username']);
    } else {
        echo "Debes iniciar sesión primero";
        exit();
    }

    # Lanzamos database.php
    $producto = getProduct($idProd);  
    $imagenes = getImages($idProd);
    $comentarios = getComment($idProd);
  
    echo $twig->render('producto.html', ['usuario' => $usuario, 'producto' => $producto, 'imagenes' => $imagenes, 'comentarios' => $comentarios]);
?>