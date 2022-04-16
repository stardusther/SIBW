<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    if (isset($_GET['prod'])) {
        $idProd = $_GET['prod'];
    } else {
        $idProd = -1;
    }
    
    # Lanzamos database.php
    $producto = getProduct($idProd);  
    $imagenes = getImages($idProd);
    $comentarios = getComment($idProd);
  
    echo $twig->render('producto.html', ['producto' => $producto, 'imagenes' => $imagenes, 'comentarios' => $comentarios]);
?>