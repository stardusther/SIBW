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

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){ // Si se intenta postear un comentario
            $comment_text = $_POST['comment'];
            if (!empty($comment_text)){
                $comment = [
                    'id_prod' => $idProd,
                    'autor' => $usuario['nombre'],
                    'texto' => $comment_text
                ];
                if (insertComment($comment)){
                    // exito
                } else{
                    //error
                }
            }
            
        }
    }
    # Lanzamos database.php
    $producto = getProduct($idProd);  
    $imagenes = getImages($idProd);
    $comentarios = getComment($idProd);

    //Sólo los admins y gestores pueden ver los productos no publicados
    if (!$producto['publicado'] && !$usuario['admin'] && !$usuario['manage']){
        echo "No tienes permisos para entrar aquí";
        exit();
    }

    echo $twig->render('producto.html', ['usuario' => $usuario, 'producto' => $producto, 'imagenes' => $imagenes, 'comentarios' => $comentarios]);
?>