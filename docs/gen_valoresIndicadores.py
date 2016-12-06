# -*- coding: iso-8859-15 -*- 
import sys
import random



print "USE indicadores_ods;"

#print "DELETE FROM agrupamientoRefGeografica;"
print "DELETE FROM valoresIndicadores;"

#
# Ejemplo 1 	Indicador 1, año 2013
# 				Sin desglose (etiqueta 0)
#
etiquetasEjemplo1 = [0]
refGeograficaEjemplo1 = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
for etiq in etiquetasEjemplo1:
	for rgeo in refGeograficaEjemplo1:
		valor = '{0:.1f}'.format(random.uniform(10, 50))
		print "INSERT INTO valoresIndicadores VALUES (1, '" + str(etiq) + "', " + str(rgeo) + ", " + str(valor) + ", 1, 1, '');"


#
# Ejemplo 2 	Indicador 1, año 2014
# 				Desglose por sexo y ubicacion (etiquetas 1,2 y 6,7 respectivamente)
#				Sin cruzar
etiquetasEjemplo1 = [1, 2, 6, 7]
refGeograficaEjemplo1 = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
for etiq in etiquetasEjemplo1:
	for rgeo in refGeograficaEjemplo1:
		valor = '{0:.1f}'.format(random.uniform(10, 50))
		print "INSERT INTO valoresIndicadores VALUES (2, '" + str(etiq) + "', " + str(rgeo) + ", " + str(valor) + ", 1, 1, '');"


#
# Ejemplo 3 	Indicador 1, año 2015
# 				Desglose por edad y ubicacion (etiquetas 3,4,5 y 6,7 respectivamente)
#				Sin cruzar
etiquetasEjemplo1 = [3,4,5,6,7]
refGeograficaEjemplo1 = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
for etiq in etiquetasEjemplo1:
	for rgeo in refGeograficaEjemplo1:
		valor = '{0:.1f}'.format(random.uniform(10, 50))
		print "INSERT INTO valoresIndicadores VALUES (3, '" + str(etiq) + "', " + str(rgeo) + ", " + str(valor) + ", 1, 1, '');"



#
# Ejemplo 4 	Indicador 1, año 2016
# 				Desglose por sexo y ubicacion (etiquetas 1,2 y 6,7 respectivamente)
#				Cruzado
etiquetasEjemplo1 = [1, 2]
etiquetasEjemplo2 = [6, 7]
refGeograficaEjemplo1 = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
for etiq1 in etiquetasEjemplo1:
	for etiq2 in etiquetasEjemplo2:
		for rgeo in refGeograficaEjemplo1:
			valor = '{0:.1f}'.format(random.uniform(10, 50))
			print "INSERT INTO valoresIndicadores VALUES (4, '" + str(etiq1)+":"+str(etiq2) + "', " + str(rgeo) + ", " + str(valor) + ", 1, 1, '');"


















sys.exit(0)

















print "INSERT INTO refGeografica (id, descripcion, ambito) VALUES (0, 'PAIS', 'N');"


idg = 0
for pro in sorted(provincias.keys()):
	#print pro, provincias[pro]
	idg = idg + 1
	print "INSERT INTO refGeografica (id, descripcion, ambito) VALUES ("+str(idg)+", '" + pro +"', 'P'); "	


departamentos = {}
for feature in tfile:
	#print feature.properties
	pro = feature.properties["provincia"]
	dep = feature.properties["departamento"].encode('utf8','ignore') 
	idg = idg + 1
	idp = provincias[pro]
	print "INSERT INTO refGeografica (id, descripcion, ambito) VALUES ("+str(idg)+", \"" + dep +"\", 'D'); "
	print "INSERT INTO agrupamientoRefGeografica (id_1, id_2) VALUES ("+str(idg)+", " + str(idp) + "); "
	#provId = provId + 1
	#	provincias[pro] = provId	
#
#
#



