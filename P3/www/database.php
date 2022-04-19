<?php

  header('Content-type: text/html; charset=utf-8');
   
# Función para conectar con la base de datos ------------------------
  function conectar(){ #falta comprobar que no se cree una conexión cada vez que hacemos una consulta
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    #$mysqli->charset('utf8');
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

    $result = $mysqli->query("SELECT COUNT(*) as total FROM productos;");

    if ($result->num_rows > 0){ # si nos devuelve alguna fila (la consulta no está vacía)
      $row = $result->fetch_assoc();
      $num = $row['total'];
    }

    return $num;
  }

  function queryStmt($mysqli, $query, $idProd){
    # Realizamos la consulta

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $idProd);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();
    
    return $result;
  }

  # Función para obtener el producto ------------------------
  function getProduct($idProd) {
  
    $mysqli = checkCon($mysqli);

    # Por defecto
    $producto = array('nombre' => 'Nombre por defecto', 'marca' => 'Marca por defecto', 'precio' => '0.0', 'descripcion' => 'Descripcion por defecto'); # No les pongo atributos por defecto a las imágenes porque son nullable

    # Realizamos la consulta --
    $query= "SELECT * FROM productos WHERE id_prod=?";
    $result = queryStmt($mysqli, $query, $idProd);

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
    $query= "SELECT autor, DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') as fechaFormateada, texto FROM comentarios WHERE id_prod=? order by fecha";
    $result = queryStmt($mysqli, $query, $idProd);

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
    $query= "SELECT * FROM imagenes WHERE id_prod=?";
    $result = queryStmt($mysqli, $query, $idProd);

    if ($result->num_rows > 0) { # si nos devuelve alguna fila (la consulta no está vacía)
      while($row = $result->fetch_assoc()){
        array_push($imagenes, $row);
      }
    }

    #Recogemos las respuestas
    #$imagenes = array('ruta' => $row['ruta'], 'caption' => $row['caption']);
    
    return $imagenes;
  }

  function insertComment($autor, $fecha, $texto){
    $mysqli = checkCon($mysqli);

    $palabras = [];
    $stmt = "INSERT INTO comentarios(autor, fecha, texto) VALUES ($autor, $fecha, $texto)";
    $result = $mysqli->query($stmt);

  }

?>
