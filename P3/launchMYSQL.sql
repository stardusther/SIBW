-- Para lanzar mysql en mac m1:
docker exec -it mysql mysql -u esther -p

-- Crear la base de datos con la que vamos a trabajar
create database SIBW;

-- crear usuario y dar permisos
create user 'usuario'@'%' identified by 'contraseña';
grant create, delete, drop, index, insert, select, update on sibw.* to 'esther'@'%';

-- Sentencias para las tablas

CREATE TABLE productos(
  id_prod INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  marca VARCHAR(100) NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  fechaPublicacion DATE NOT NULL,
  descripcion VARCHAR(500)
)CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ;

CREATE TABLE imagenes(
  ruta VARCHAR(500) PRIMARY KEY,
  caption VARCHAR (100),
  id_prod INT NOT NULL REFERENCES productos
)CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ;

CREATE TABLE comentarios(
  autor VARCHAR(100),
  fecha DATETIME, 
  texto VARCHAR(500),
  id_prod INT NOT NULL REFERENCES productos,
  PRIMARY KEY (autor,fecha)
) CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ;

CREATE TABLE palabras(
  palabra VARCHAR(500) PRIMARY KEY
) CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci ;

drop table productos, imagenes, comentarios, palabras;
delete from imagenes;

-- INSERT INTO productos (nombre, marca, precio, descripcion, rutaimagen1, rutaimagen2) VALUES ('Lapiz amarillo', 'Stabilus', 2.50, 'Es un lapiz normal y corriente... tal vez demasiado corriente', '../images/imagen1.jpg', '../images/imagen1.jpg');
---INSERT INTO productos (nombre, marca, precio, descripcion) VALUES ('Escultura de Hasbulla', 'China', 10.99, 'Esta escultura del famoso Hasbulla ha pasado por muchas manos antes de llegar a nosotros, no sabemos como de limpias estaban pero eso no importa...');

INSERT INTO productos (nombre, marca, precio, descripcion, fechaPublicacion) VALUES ('Rotulador lettering', 'Tomboy', 3.0, 'Un bonito rotulador azul muy aclamado por la crítica, aunque con un precio elevado', CURDATE());
INSERT INTO productos (nombre, marca, precio, descripcion, fechaPublicacion) VALUES ('Lapiz amarillo', 'Staedler', 2.50, 'Es un lápiz normal y corriente... tal vez demasiado corriente', CURDATE());

INSERT INTO productos (nombre, marca, precio, descripcion, fechaPublicacion) VALUES ('Pincel despeluchado', 'artsy', 1.99, 'Si tienes que pintar los pelos que se le quedan a tu gato tras rozarse con un globo este es tu pincel', CURDATE());
INSERT INTO productos (nombre, marca, precio, descripcion, fechaPublicacion) VALUES ('Caballete del caballero', 'OldWest', 5.99, 'Un caballete con un divertido sombrero que evoca un pasado turbulento (el sombrero no esta incluido)', CURDATE());

INSERT INTO productos (nombre, marca, precio, descripcion, fechaPublicacion) VALUES ('Pintura blanco marfil', 'Chiguagua', 19.99, 'El por qué este bote de pintura es tan caro es un misterio, a lo mejor esta hecho de marfil de verdad', CURDATE());
INSERT INTO productos (nombre, marca, precio, descripcion, fechaPublicacion) VALUES ('Pintura rojo sangre', 'Draculaura', 2.99, 'Un bote de color rojizo que recuerda a la sangre... tal vez es por eso que se vende tan bien en Halloween', CURDATE());


INSERT INTO imagenes (ruta, caption, id_prod) VALUES ('../images/imagen1.jpg','Apuntes', 1);
INSERT INTO imagenes (ruta, caption, id_prod) VALUES ('../images/imagen6.jpeg','Lápices amarillos', 2);
INSERT INTO imagenes (ruta, caption, id_prod) VALUES ('../images/imagen7.jpeg','Lápices amarillos', 2);
INSERT INTO imagenes (ruta, caption, id_prod) VALUES ('../images/imagen8.jpeg','Lápiz staedler', 2);
INSERT INTO imagenes (ruta, caption, id_prod) VALUES ('../images/imagen2.webp','Pincel', 3);
INSERT INTO imagenes (ruta, caption, id_prod) VALUES ('../images/imagen5.jpeg','Pinceles rotos', 3);
INSERT INTO imagenes (ruta, caption, id_prod) VALUES ('../images/imagen3.jpg','Caballete', 4);
INSERT INTO imagenes (ruta, caption, id_prod) VALUES ('../images/imagen4.jpeg','Caballete pequeñito', 4);


INSERT INTO comentarios (autor, fecha, texto, id_prod) VALUES ('Rosa Mª Gallego Calvente', '2022-01-4 16:43', 'Producto horrible, lo dejé abierto un par de horas y se secó completamente. No lo recomiendo.', 1);
INSERT INTO comentarios (autor, fecha, texto, id_prod) VALUES ('Juan Alberto Martinez', '2022-01-31 10:50', '¿En esta web no se pueden poner tildes o qué?', 1);
INSERT INTO comentarios (autor, fecha, texto, id_prod) VALUES ('Abel Rios Gonzalez', '2022-3-17 05:43', 'No se puede porque la base de datos no lo admite, pero probemos: ¿Quiénes somos, de dónde venimos?', 1);


INSERT INTO palabras (palabra) VALUES ("coño");
INSERT INTO palabras (palabra) VALUES ("puta");
INSERT INTO palabras (palabra) VALUES ("polla");
INSERT INTO palabras (palabra) VALUES ("joder");
INSERT INTO palabras (palabra) VALUES ("subnormal");
INSERT INTO palabras (palabra) VALUES ("cabrón");
INSERT INTO palabras (palabra) VALUES ("follar");
INSERT INTO palabras (palabra) VALUES ("imbécil");
INSERT INTO palabras (palabra) VALUES ("zorra");