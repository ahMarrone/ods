import sys
import pygeoj


gfile = sys.argv[1]
tfile = pygeoj.load(gfile)



provincias = {
	"BUENOS AIRES" : 1, 
	"CATAMARCA" : 2,  
	"CHACO" : 3, 
	"CHUBUT" : 4, 
	"CIUDAD AUTONOMA DE BUENOS AIRES": 5,
	"CORDOBA" : 6,
	"CORRIENTES" : 7,
	"ENTRE RIOS" : 8,
	"FORMOSA" : 9,
	"JUJUY" : 10,
	"LA PAMPA" : 11,
	"LA RIOJA" : 12, 
	"MENDOZA" : 13, 
	"MISIONES" : 14,
	"NEUQUEN" : 15,
	"RIO NEGRO" : 16, 
	"SALTA" : 17, 
	"SAN JUAN" : 18,
	"SAN LUIS" : 19,
	"SANTA CRUZ" : 20,
	"SANTA FE" : 21,
	"SANTIAGO DEL ESTERO" : 22,
	"TIERRA DEL FUEGO" : 23,
	"TUCUMAN" : 24
	}



print "USE indicadores_ods;"
print "DELETE FROM agrupamientoRefGeografica;"
print "DELETE FROM refGeografica;"
print "ALTER TABLE refGeografica AUTO_INCREMENT=0;"

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



