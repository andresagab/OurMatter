/**
  Script de creación de tablas y base de datos ourmatter
 */

/*CREATE DATABASE IF NOT EXISTS ourmatter DEFAULT CHARACTER SET UTF8;*/
CREATE DATABASE IF NOT EXISTS ourmatter;
USE ourmatter;

CREATE TABLE usuario(
    usuario varchar(20) PRIMARY KEY,
    contrasena varchar(32) not null,
    estado boolean not null
);

CREATE TABLE estudiante(
    id int AUTO_INCREMENT PRIMARY KEY,
    nombres varchar(30) not null,
    apellidos varchar(30) not null,
    usuario varchar(20) not null unique,
    INDEX(usuario),
    FOREIGN KEY (usuario) REFERENCES usuario(usuario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE sitio(
    id int AUTO_INCREMENT PRIMARY KEY,
    name_materia varchar(20) not null unique,
    descripcion_materia text not null,
    img_materia varchar(100) not null unique,
    img_materiaInformacion varchar(100) not null unique,
    name_institucion varchar(50) not null unique,
    grado varchar(2) not null unique,
    name_docente varchar(50) not null unique,
    email_docente varchar(50) not null unique,
    cel_docente varchar(15) not null unique,
    foto_docente varchar (100) not null unique,
    usuario varchar(10) unique,
    INDEX (usuario),
    FOREIGN KEY (usuario) REFERENCES usuario(usuario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE tema(
    id int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar (200) not null,
    descripcion text not null,
    img varchar (100) not null,
    FULLTEXT (descripcion)
);

CREATE TABLE sub_tema(
    id int AUTO_INCREMENT PRIMARY KEY,
    id_tema int not null,
    nombre varchar (200) not null,
    contenido text not null,
    img varchar(100),
    INDEX (id_tema),
    FOREIGN KEY (id_tema) REFERENCES tema(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE recurso(
    id int AUTO_INCREMENT PRIMARY KEY,
    id_subtema int not null,
    nombre varchar (50) not null,
    file boolean not null,
    ruta varchar (500) not null,
    INDEX (id_subtema),
    FOREIGN KEY (id_subtema) REFERENCES sub_tema(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE evaluacion(
    id int AUTO_INCREMENT PRIMARY KEY,
    id_tema int not null,
    nombre varchar(100) not null,
    descripcion varchar(300),
    fechaInicio datetime not null,
    fechaFin datetime not null,
    INDEX (id_tema),
    FOREIGN KEY (id_tema) REFERENCES tema(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE evaluacion_pregunta(
    id int AUTO_INCREMENT PRIMARY KEY,
    id_evaluacion int not null,
    pregunta text not null,
    INDEX (id_evaluacion),
    FOREIGN KEY (id_evaluacion) REFERENCES evaluacion(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE evaluacion_opcion(
    id int AUTO_INCREMENT PRIMARY KEY,
    id_evaluacionPregunta int not null,
    opcion text not null,
    correcta boolean not null,
    INDEX (id_evaluacionPregunta),
    FOREIGN KEY (id_evaluacionPregunta) REFERENCES evaluacion_pregunta(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE evaluacion_ejecucion(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_evaluacion INT NOT NULL,
    id_estudiante INT NOT NULL,
    fechaInicio DATETIME NOT NULL,
    fechaFin DATETIME,
    INDEX (id_evaluacion),
    INDEX (id_estudiante),
    FOREIGN KEY (id_evaluacion) REFERENCES evaluacion(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_estudiante) REFERENCES estudiante(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE evaluacion_respuesta(
    id int AUTO_INCREMENT PRIMARY KEY,
    id_evaluacionEjecucion int not null,
    id_evaluacionOpcion int not null,
    fecha datetime not null,
    INDEX (id_evaluacionEjecucion),
    INDEX (id_evaluacionOpcion),
    FOREIGN KEY (id_evaluacionEjecucion) REFERENCES evaluacion_ejecucion(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_evaluacionOpcion) REFERENCES evaluacion_opcion(id) ON DELETE RESTRICT ON UPDATE CASCADE
);