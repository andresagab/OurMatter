--Data of start app for first time

INSERT INTO usuario VALUES ("R00T", md5("OurR00TMatter2019"), true);

INSERT INTO sitio VALUES (
null,
"Química",
"El Área de Ciencias Naturales y educación Ambiental, ofrece al estudiante la posibilidad de aprender a comprender en mundo en que vivimos, de que se aproxime al conocimiento
 partiendo de preguntas, conjeturas o hipótesis que inicialmente surgen de su curiosidad ante la observación de su entorno y de su capacidad de analizar lo que observa. Se busca que los
 estudiantes hallen habilidades científicas y las actitudes requeridas para explorar fenómenos y resolver problemas en forma crítica, ética, tolerante con la diversidad y comprometida con el
 medio ambiente; se busca crear condiciones para que nuestros estudiantes sepan que son las ciencias naturales , para que puedan comprenderlas, comunicarlas, y compartir sus
 experiencias y sus hallazgos, actuar con ellas en la vida real y hacer aportes a la construcción y al mejoramiento de su entorno.",
"not_image",
"not_image",
"I.E.M ESCUELA NORMAL SUPERIOR DE PASTO",
"11",
"Andres Geovanny Angulo Botina",
"andrescabj981@gmail.com",
"3123334534",
"not_image",
"R00T");

INSERT INTO usuario VALUE
("valentina-5", md5("estudiante_v5"), true),
("leidy-4", md5("estudiante_l4"), true),
("julieth-3", md5("estudiante_j3"), true),
("luis-2", md5("estudiante_l2"), true),
("juan-1", md5("estudiante_j1"), true);

INSERT INTO estudiante values
(null, 'Valentina', 'Pantoja Angulo', 'valentina-5'),
(null, 'Leidy Stephania', 'Angulo Botina', 'leidy-4'),
(null, 'Julieth Veronica', 'Benavides Ortega', 'julieth-3'),
(null, 'Luis Daniel', 'Rosero Peñafiel', 'luis-2'),
(null, 'Juan Carlos', 'Gonzalez Montero', 'juan-1');