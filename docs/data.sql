use indicadores_ods;
SET SESSION sql_mode='NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `objetivos` VALUES  (1,'Probreza Cero + infinito'),
								(2,'Mejorar medioambiente'),
								(3,'Distribuir mejor la riqueza'),
								(4,'Ganar el mundial de Rusia');

INSERT INTO `metas` VALUES  (1,'De aquí a 2030',1),
							(2,'Mucho mas adelante...',1),
							(3,'Traer a Robin Hood',3),
							(4,'Contratar un arquero',4),
							(5,'Contratar un 11',4),
							(6,'Sanear el Riachuelo',2),
							(7,'Controlar a las mineras',2);

INSERT INTO `indicadores` VALUES (1,'Porcentaje de la población bajo umbral probreza',1,'porcentual',0,100,'M',0,1,1),
                                 (2,'Porcentaje de la población con agua',1,'porcentual',0,100,'M',1,1,1),
                                 (3,'Este es el indicador favorito',1,'porcentual',0,100,'N',1,1,1),
                                 (4,'Distancia del pueblo a BsAs',4,'real',2,3,'P',0,1,0),
                                 (5,'goles/partido',5,'porcentual',0,100,'N',0,0,0),
                                 (6,'% impuestos a los ricos',3,'porcentual',0,100,'N',1,0,0);
INSERT INTO desgloces (id, descripcion) VALUES (0, "Sin desgloce");
INSERT INTO desgloces (descripcion) VALUES ("Sexo");
INSERT INTO desgloces (descripcion) VALUES ("Raza");
INSERT INTO etiquetas (id, descripcion, fkIdDesgloce) VALUES (0, "Sin etiqueta", 0);
INSERT INTO etiquetas (descripcion, fkIdDesgloce) VALUES ("Femenino", 1);
INSERT INTO etiquetas (descripcion, fkIdDesgloce) VALUES ("Masculino", 1);
INSERT INTO etiquetas (descripcion, fkIdDesgloce) VALUES ("Aria", 2);
INSERT INTO etiquetas (descripcion, fkIdDesgloce) VALUES ("Mestizo", 2);
INSERT INTO etiquetas (descripcion, fkIdDesgloce) VALUES ("Amarillo", 2);
INSERT INTO etiquetas (descripcion, fkIdDesgloce) VALUES ("Morocho", 2);
INSERT INTO refGeografica (descripcion, ambito, agrupa) VALUES ("BsAs", "P", 0);
INSERT INTO refGeografica (descripcion, ambito, agrupa) VALUES ("La Pampa", "P", 0);
INSERT INTO refGeografica (descripcion, ambito, agrupa) VALUES ("Chivilcoy", "P", 1);
INSERT INTO refGeografica (descripcion, ambito, agrupa) VALUES ("Luján", "P", 1);
INSERT INTO refGeografica (descripcion, ambito, agrupa) VALUES ("Sta. Rosa", "P", 2);
INSERT INTO refGeografica (descripcion, ambito, agrupa) VALUES ("Macachín", "P", 2);
INSERT INTO refGeografica (descripcion, ambito, agrupa) VALUES ("Gral. Pico", "P", 2);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, "1:3", 3, '2010-06-01', 30, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, "1:4", 3, '2010-06-01', 40, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, "1:5", 3, '2010-06-01', 20, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, "1:6", 3, '2010-06-01', 10, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, "2:3", 3, '2010-06-01', 25, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, "2:4", 3, '2010-06-01', 25, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, "2:5", 3, '2010-06-01', 30, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, "1:3", 5, '2010-06-01', 10, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, "2:3", 5, '2010-06-01', 90, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (2, "0", 3, '2010-06-01', 33, 1);
