--Script creation tables and init data

CREATE DATABASE ourMatter;
USE ourmatter;

CREATE TABLE usuario(
    usuario varchar(10) PRIMARY KEY,
    contrasena varchar(32) not null,
    estado boolean not null
);

CREATE TABLE estudiante(
    id int AUTO_INCREMENT PRIMARY KEY,
    nombres varchar(30) not null,
    apellidos varchar(30) not null,
    usuario varchar(10) not null unique,
    INDEX(usuario),
    FOREIGN KEY (usuario) REFERENCES usuario(usuario) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE sitio(
    id int AUTO_INCREMENT PRIMARY KEY,
    name_materia varchar(20) not null unique,
    descripcion_materia varchar(1000) not null unique,
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
    nombre varchar (50) not null,
    descripcion varchar (1000) not null,
    img varchar (100) not null
);

CREATE TABLE sub_tema(
    id int AUTO_INCREMENT PRIMARY KEY,
    id_tema int not null,
    nombre varchar (100) not null,
    contenido text not null,
    img varchar(100),
    FULLTEXT (contenido),
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
    nombre varchar(100),
    descripcion varchar(300),
    fechaInicio datetime,
    fechaFin datetime,
    INDEX (id_tema),
    FOREIGN KEY (id_tema) REFERENCES tema(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE evaluacion_pregunta(
    id int AUTO_INCREMENT PRIMARY KEY,
    id_evaluacion int not null,
    pregunta varchar(1000) not null,
    INDEX (id_evaluacion),
    FOREIGN KEY (id_evaluacion) REFERENCES evaluacion(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE evaluacion_opcion(
    id int AUTO_INCREMENT PRIMARY KEY,
    id_evaluacionPregunta int not null,
    opcion varchar(500) not null,
    correcta boolean not null,
    INDEX (id_evaluacionPregunta),
    FOREIGN KEY (id_evaluacionPregunta) REFERENCES evaluacion_pregunta(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE evaluacion_respuesta(
    id int AUTO_INCREMENT PRIMARY KEY,
    id_evaluacionOpcion int not null,
    id_estudiante int not null,
    fecha datetime not null,
    INDEX (id_evaluacionOpcion),
    INDEX (id_estudiante),
    FOREIGN KEY (id_evaluacionOpcion) REFERENCES evaluacion_opcion(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_estudiante) REFERENCES estudiante(id) ON DELETE RESTRICT ON UPDATE CASCADE
);