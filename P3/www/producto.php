<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    $nombreProducto = "Nombre por defecto";
    $precioProducto = "0,00";
    $marcaProducto = "Dora la exploradora";
    $descripcionProducto = "Una descripción extrañamente corta";
    $foto1 = "../images/imagen1.jpg";
    $foto2 = "../images/imagen1.jpg";
  
    echo $twig->render('producto.html', ['nombre' => $nombreProducto, 'precio' => $precioProducto, 'marca' => $marcaProducto, 'descripcion' => $descripcionProducto, 'foto1' => $foto1, 'foto2' => $foto2]);
?>