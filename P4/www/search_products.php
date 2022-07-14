<?php
    include("database.php");
    session_start();

    if (isset($_SESSION['username'])){
        $usuario = getUser($_SESSION['username']);
    }

    if (isset($_GET['search_query'])){
        $search_query = $_GET['search_query'];
    } else {
        $search_query = '';
    }

    if (!empty($search_query)){
        echo(json_encode(searchProducts($usuario, $search_query)));
    }


?>