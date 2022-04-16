<?php

# Función para conectar con la base de datos ------------------------
  function conectar(){ #falta comprobar que no se cree una conexión cada vez que hacemos una consulta
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
      $mysqli = new mysqli("mysql", "esther", "7028", "SIBW");
      $mysqli->set_charset("utf8mb4");
    } catch(Exception $e) {
      error_log($e->getMessage());
      exit('Error connecting to database'); //Should be a message a typical user could understand
    }

    return $mysqli;
  }

# Función para comprobar conexión con la BD ------------------------
  function checkCon($bd){
    if($bd == null)
      $bd = conectar();
    else if ($bd->ping() == false) {
      printf("Conectando a MYSQL");
      $bd = conectar();
    } else {
      printf ("¡La conexión está bien!\n");
    }
    
    return $bd;
  }

  # Función para obtener el número de productos de la base de datos ------------------------
  function getNumProd(){
    $mysqli = checkCon($mysqli);

    #$result = $mysqli->query("SELECT COUNT(*) FROM productos;");
    $result = $mysqli->query("SELECT id_prod FROM productos");

    if ($result->num_rows > 0) # si nos devuelve alguna fila (la consulta no está vacía)
      $num = $result->num_rows;

    return $num;
  }

  #Me gusta más esta pero no me funciona ------------------------
  function getNumProd2(){
    $mysqli = checkCon($mysqli);

    $result = $mysqli->query("SELECT COUNT(*) FROM productos;");

    if ($result->num_rows > 0){ # si nos devuelve alguna fila (la consulta no está vacía)
      $row = $result->fetch_assoc();
      $num = $row['Count(*)'];
    }

    return $num;
  }

  function queryStmt($idProd, $conn, $tabla, $isordered, $order){
    # Realizamos la consulta
    if($isordered == false)
      $query= "SELECT * FROM $tabla WHERE id_prod=?";
    else
      $query= "SELECT * FROM $tabla WHERE id_prod=? ORDER BY $order";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idProd);
    $stmt->execute();
    $result = $stmt->get_result();

    #$stmt->close();
    
    return $result;
  }

  # Función para obtener el producto ------------------------
  function getProduct($idProd) {
  
    $mysqli = checkCon($mysqli);

    # Por defecto
    $producto = array('nombre' => 'Nombre por defecto', 'marca' => 'Marca por defecto', 'precio' => '0.0', 'descripcion' => 'Descripcion por defecto'); # No les pongo atributos por defecto a las imágenes porque son nullable

    # Realizamos la consulta --
    $result = queryStmt($idProd, $mysqli, "productos", false, 0);

    if ($result->num_rows > 0) { # si nos devuelve alguna fila (la consulta no está vacía)
      $row = $result->fetch_assoc();
    }
    
    #$producto = array('nombre' => $row['nombre'], 'marca' => $row['marca'], 'precio' => $row['precio'], 'descripcion' => $row['descripcion'], 'rutaimagen1' => $row['rutaimagen1'], 'rutaimagen2' => $row['rutaimagen2']);

    $producto = array('nombre' => $row['nombre'], 'marca' => $row['marca'], 'precio' => $row['precio'], 'descripcion' => $row['descripcion'], 'fecha' => $row['fechaPublicacion']);
    
    return $producto;
  } 

  # Función para obtener los comentarios relacionados con un producto
  function getComment($idProd){

    $mysqli = checkCon($mysqli);
    # Por defecto
    $comentarios = [];

    # Realizamos la consulta
    $result = queryStmt($idProd, $mysqli, "comentarios", true, "fecha");

    if ($result->num_rows > 0) { # si nos devuelve alguna fila (la consulta no está vacía)
      while($row = $result->fetch_assoc()){ #Recogemos las respuestas
        array_push($comentarios, $row);
      }
    }

    #$comentarios = array('texto' => $row['texto'], 'autor' => $row['autor'], 'fecha' => $row['fecha']);
    
    return $comentarios;
  }

  # Función para obtener las imágenes relacionadas con un producto
  function getImages($idProd){

    $mysqli = checkCon($mysqli);
    # Por defecto
    $imagenes = [];

    # Realizamos la consulta
    $result = queryStmt($idProd, $mysqli, "imagenes", false, 0);

    if ($result->num_rows > 0) { # si nos devuelve alguna fila (la consulta no está vacía)
      while($row = $result->fetch_assoc()){
        array_push($imagenes, $row);
      }
    }

    #Recogemos las respuestas
    #$imagenes = array('ruta' => $row['ruta'], 'caption' => $row['caption']);
    
    return $imagenes;
  }


  # Función que permite 
  function getBannedWords(){
    $mysqli = checkCon($mysqli);

    $palabras = [];
    $stmt = "SELECT * FROM palabras";
    $result = $mysqli->query($stmt);

    if ($result->num_rows > 0) { # si nos devuelve alguna fila (la consulta no está vacía)
      while($row = $result->fetch_assoc()){
        array_push($palabras, $row);
      }
      
    }

    return $palabras;
  }

  function insertComment($autor, $fecha, $texto){
    $mysqli = checkCon($mysqli);

    $palabras = [];
    $stmt = "INSERT INTO comentarios(autor, fecha, texto) VALUES ($autor, $fecha, $texto)";
    $result = $mysqli->query($stmt);

  }

?>
