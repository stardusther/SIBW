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
      exit('Error connecting to database'); 
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

    $num = 0;

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

    $producto = array('id' => $row['id_prod'], 'nombre' => $row['nombre'], 'marca' => $row['marca'], 'precio' => $row['precio'], 'descripcion' => $row['descripcion'], 'fecha' => $row['fechaPublicacion']);
    
    return $producto;
  } 

  # Función para obtener los comentarios relacionados con un producto
  function getComment($idProd){

    $mysqli = checkCon($mysqli);

    # Por defecto
    $comentarios = [];

    # Realizamos la consulta
    $query= "SELECT autor, DATE_FORMAT(fecha, '%d/%m/%Y, %H:%i') as fechaFormateada, texto FROM comentarios WHERE id_prod=? order by fecha";
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

  # Función para obtener los datos de usuario en función del nombre de usuario
  function getUser($username){
    $mysqli = checkCon($mysqli); # Comprobamos la conexión a la bd

    # Preparamos la sentencia
    if (!($stmt = $mysqli->prepare("SELECT user, email, password, nombre, admin, moderate, manage  FROM usuarios WHERE user=?"))) {
      echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    # Vinculamos los parámetros
    if (!$stmt->bind_param("s", $username)) {
        echo "Falló la vinculación de parámetros: (" . $stmt->errno . ") " . $stmt->error;
    }
    # Ejecutamos la sentencia
    if (!$stmt->execute()) {
        echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
    }

    $res = $stmt->get_result();

    $usuario = array();

    if ($res->num_rows > 0){
        $row = $res->fetch_assoc();
        $user = $row["user"];
        $nombre = $row["nombre"];
        $email = $row["email"];
        $moderate = $row["moderate"];
        $manage = $row["manage"];
        $admin = $row["admin"];

        // cuando sea valido
        $usuario = array('user' => $user, 'nombre' => $nombre, 'email' => $email, 'moderate' => $moderate, 'manage' => $manage, 'admin' => $admin);
    }
    return $usuario;
 }

 // Función para registrar un usuario
 function registerUser($user){
    $mysqli = checkCon($mysqli); # Comprobamos la conexión a la bd

    # Preparamos la sentencia
    if (!($stmt = $mysqli->prepare("INSERT INTO usuarios(user, email, password, nombre, admin, moderate, manage) VALUES (?, ?, ?, ?, 0,0,0)"))) {
      // echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
      return false;
    }

    $pass = password_hash($user['password'], PASSWORD_DEFAULT);
    # Vinculamos los parámetros
    if (!$stmt->bind_param("ssss", $user["user"], $user["email"], $pass, $user["nombre"])) {
        #echo "Falló la vinculación de parámetros: (" . $stmt->errno . ") " . $stmt->error;
        return false;
    }
    # Ejecutamos la sentencia
    if (!$stmt->execute()) {
        # echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
        return false;
    }

    return true;
 }

 // Función para comprobar el login del usuario
 function checkLogin($username, $pass){
    $mysqli = checkCon($mysqli); # Comprobamos la conexión a la bd

    # Preparamos la sentencia
    if (!($stmt = $mysqli->prepare("SELECT user, password FROM usuarios WHERE user=?"))) {
      echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    # Vinculamos los parámetros
    if (!$stmt->bind_param("s", $username)) {
        echo "Falló la vinculación de parámetros: (" . $stmt->errno . ") " . $stmt->error;
    }
    # Ejecutamos la sentencia
    if (!$stmt->execute()) {
        echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
    }

    $res = $stmt->get_result();
    $usuario = array();
    if ($res->num_rows > 0){
        $row = $res->fetch_assoc();
        $user = $row["user"];
        $password = $row["password"];
    }
    
    if (password_verify($pass, $password)){
      return true;
    } else return false;

 }

 // ----------------------------------------------------------------
 // Función para editar la contraseña del usuario 
 function editPassword($username, $pass){
    $mysqli = checkCon($mysqli); # Comprobamos la conexión a la bd

    # Preparamos la sentencia
    if (!($stmt = $mysqli->prepare("UPDATE usuarios SET password=? WHERE user=?"))) {
      #echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
      return false;
    }
    # Vinculamos los parámetros
    if (!$stmt->bind_param("ss", $pass, $username)) {
        #echo "Falló la vinculación de parámetros: (" . $stmt->errno . ") " . $stmt->error;
        return false;
    }
    # Ejecutamos la sentencia
    if (!$stmt->execute()) {
        #echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
        return false;
    }

    return true;  
  }

 // Función para editar los datos del usuario
  function editProfile($user){
    $mysqli = checkCon($mysqli); # Comprobamos la conexión a la bd

    # Preparamos la sentencia
    if (!($stmt = $mysqli->prepare("UPDATE usuarios SET nombre=?, email=? WHERE user=?"))) {
      // echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
      return false;
    }
    # Vinculamos los parámetros
    if (!$stmt->bind_param("sss", $user["nombre"], $user["email"], $user["user"])) {
        // echo "Falló la vinculación de parámetros: (" . $stmt->errno . ") " . $stmt->error;
        return false;
    }
    # Ejecutamos la sentencia
    if (!$stmt->execute()) {
        // echo "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
        return false;
    }
    return true;
  }


?>
