var map, tiles, current;

var maxBoundsSouthWest = L.latLng(-89.99999999999994, -74.02985395599995),
    maxBoundsNorthEast = L.latLng(-21.786688039999945, -25.02314483699996),
    centerSouthWest = L.latLng(-53.748710796898976, -107.57812500000001),
    centerNorthEast = L.latLng(-19.642587534013032, -19.687500000000004),
    maxBounds = L.latLngBounds(maxBoundsSouthWest, maxBoundsNorthEast),
    centerBounds = L.latLngBounds(centerSouthWest, centerNorthEast),
    minZoom = 4;

function swap(ambito) {
    map.removeLayer(tiles[current]);
    map.addLayer(tiles[ambito]);
    current = ambito;
}

function update(data, etiqueta) {
    tiles[current].eachLayer(function (layer) {
        idRefGeografica = layer.feature.properties.id;
        valor = data[idRefGeografica][etiqueta];
        layer.feature.properties['value'] = valor;
        layer.setStyle({fillColor: getColor(valor)})
    });
}

function mapMe(geoJsonNacion, geoJsonProvincias) {
    var base = L.tileLayer.wms('http://wms.ign.gob.ar/geoserver/wms?', {layers: 'ign:capabaseargenmap_gwc'});
    var tileNacion = L.geoJson(geoJsonNacion, {onEachFeature: onEachFeature, style: style});
    var tileProvincias = L.geoJson(geoJsonProvincias, {onEachFeature: onEachFeature, style: style});
    // var capaDepartamentos = L.geoJson(geoJsonNacion, {onEachFeature: onEachFeature, style: style});

    tiles = {
        'N': tileNacion,
        'P': tileProvincias
    };

    /* Capa por defecto al inicializar el mapa */
    current = 'N';

    /* Crear 'Objeto Mapa' */
    map = L.map(document.getElementById('mapCanvas'), {doubleClickZoom: false});
    /* Agregar Mapa de Base */
    base.addTo(map);

    /* Controles sobre el Mapa */
    // info = L.control({position: 'topright'});
    // info.onAdd = addDivInfo;
    // info.update = updateDivInfo;

    /* Definir centro de mapa a partir de capa definida */
    map.fitBounds(centerBounds);
    map.setMaxBounds(maxBounds);
    map.setMinZoom(minZoom);

    /* Agregar capas y otros */
    // info.addTo(map);
    map.addLayer(tiles[current]);
}

function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: zoomToFeature,
        dblclick: zoomOut
    });
}

function style(feature) {
return {
    fillColor: getColor(feature.properties.value),
    weight: 2,
    opacity: 1,
    color: 'white',
    dashArray: '3',
    fillOpacity: 0.7
    };
}

function getColor(i) {
    return i > 80 ? '#045a8d' :
           i > 60 ? '#2b8cbe' :
           i > 40 ? '#74a9cf' :
           i > 20 ? '#bdc9e1' :
                    '#f1eef6' ;
}

function highlightFeature(event) {
    var layer = event.target;
    layer.setStyle({
        weight: 1,
        color: '#646',
        dashArray: '',
        fillOpacity: 0.3
    });
  
    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }
    /*info.update(layer.feature.properties);*/
}

function resetHighlight(event) {
    var layer = event.target;
    event.target.setStyle(style(event.target.feature));
    /*info.update();*/
}

function zoomToFeature(event) {
    map.fitBounds(event.target.getBounds());
}

function zoomOut(event) {
  map.fitBounds(bounds);
}