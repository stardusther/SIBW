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

     
?>
