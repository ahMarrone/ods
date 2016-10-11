use indicadores_ods;
SET SESSION sql_mode='NO_AUTO_VALUE_ON_ZERO';
INSERT INTO objetivos (descripcion) VALUES ("Probreza Cero");
INSERT INTO metas (descripcion, fkIdObjetivo) VALUES ("De aquí a 2030", 1);
INSERT INTO indicadores (descripcion, fkIdMeta, tipo, valMin, valMax, ambito, visibleNacional, visibleProvincial, visibleMunicipal) VALUES ("Porcentaje de la población bajo umbral probreza", 1, "porcentual", 0, 100, "M", '1', '1', '1');
INSERT INTO indicadores (descripcion, fkIdMeta, tipo, valMin, valMax, ambito, visibleNacional, visibleProvincial, visibleMunicipal) VALUES ("Porcentaje de la población con agua", 1, "porcentual", 0, 100, "M", '1', '1', '1');
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
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, 1, 3, '2010-06-01', 32, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, 2, 3, '2010-06-01', 68, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, 3, 5, '2010-06-01', 10, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (1, 5, 5, '2010-06-01', 90, 0);
INSERT INTO valoresIndicadores (idIndicador, idEtiqueta, idRefGeografica, fecha, valor, aprobado) VALUES (2, 0, 3, '2010-06-01', 33, 1);



