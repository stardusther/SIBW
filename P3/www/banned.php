<?php

    include ("database.php");

    # Función que permite consultar la BD de palabras banneadas
    function getBannedWords(){
        $mysqli = checkCon($mysqli); # Comprobamos la conexión a la bd

        $palabras = [];
        $stmt = "SELECT * FROM palabras";
        $result = $mysqli->query($stmt);

        if ($result->num_rows > 0) { # si nos devuelve alguna fila (la consulta no está vacía)
            while($row = $result->fetch_assoc()){
                array_push($palabras, $row['palabra']);
            }
        }

        return $palabras;
    }

    $palabras = getBannedWords();

    $encodedWords = json_encode($palabras, JSON_UNESCAPED_UNICODE); # JSON_UNESCAPED Para que no salgan los /uXXXX

     echo  $encodedWords



    /*echo ' <script> 
    
    let banned = "'.$palabras.'";
    let fname = null;
    let fcomment = null;

    window.onload = function() {
        fcomment.addEventListener("keyup", censor(fcomment));
        fname.addEventListener("keyup", censor(fname));
        fname = document.forms["form"]["fname"];
        fcomment = document.forms["form"]["fcomment"];
    }
    
    function censor (palabra){ // Se podría hacer con un regex
    
        for(var aux of banned){ // que ponga tantos * como letras tiene la palabra
            palabra.value = palabra.value.replace(aux, "*".repeat(aux.length));
        }
    }
    
    </script>;
    '*/

    /*header('Content-type: text/html; charset=utf-8');
    $conn = mysqli_connect("mysql", "esther", "7028", "SIBW");

    if (isset($_POST["post_comment"]))
    {
        $name = mysqli_real_escape_string($conn, $_POST["fname"]);
        $email = mysqli_real_escape_string($conn, $_POST["femail"]);
        $comment = mysqli_real_escape_string($conn, $_POST["fcomment"]);
        $post_id = mysqli_real_escape_string($conn, $_POST["post_id"]);
        $reply_of = 0;
     
        mysqli_query($conn, "INSERT INTO comments(name, email, comment, post_id, created_at) VALUES ('" . $name . "', '" . $email . "', '" . $comment . "', '" . $post_id . "', NOW())");
    }*/
     
?>