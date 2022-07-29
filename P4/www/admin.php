<?php

    header('Content-type: text/html; charset=utf-8');
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include ("database.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    session_start();

    if (isset($_SESSION['username'])){
        $usuario = getUser($_SESSION['username']);

        if (!$usuario['admin']){ // si no es admin
            echo "Para editar permisos deber ser administrador";
            exit();
        }
    } else {
        echo "Debes iniciar sesión primero";
        exit();
    }

    $usuarios = getUsers();
    $msg = "";

    // Si el usuario es administrador puede editar permisos de otros usuarios (pero no el suyo)
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if($usuario['admin']){
            for ($i=0; $i < count($usuarios); $i++){ // Por cada usuario
                $isMod = $usuarios[$i]['user'].'-moderate';
                $isManager = $usuarios[$i]['user'].'-manage';
                $isAdmin = $usuarios[$i]['user'].'-admin';
            
                if (isset($_POST[$isMod])){
                    $usuarios[$i]['moderate'] = 1;
                } else {
                    $usuarios[$i]['moderate'] = 0;
                }

                if (isset($_POST[$isManager])){
                    $usuarios[$i]['manage'] = 1;
                } else {
                    $usuarios[$i]['manage'] = 0;
                }

                if (isset($_POST[$isAdmin])){
                    $usuarios[$i]['admin'] = 1;
                } else {
                    $usuarios[$i]['admin'] = 0;
                }

                // Para que siempre haya un admin (por si lo ha cambiado)
                if ($usuarios[$i]['user'] === $usuario['user']){
                    $usuarios[$i]['admin'] = 1;
                }

                if(editPermissions($usuarios[$i]['user'], $usuarios[$i]))
                    $msg = "Permisos actualizados correctamente";
                else
                    $msg = "Error al actualizar los permisos";
                
            }
        } else {
            echo "No tienes permisos para acceder a esta página";
            exit();
        }
        
    }

        $usuarios = getUsers(); // actualizamos permisos

        echo $twig->render('admin.html', ['usuario' => $usuario, 'usuarios' => $usuarios, 'msg' => $msg]);
    
    ?>