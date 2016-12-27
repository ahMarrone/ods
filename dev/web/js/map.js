var map, tiles, sideChartModel, sideChartView, current;
var sideChartModel;

var maxBoundsSouthWest = L.latLng(-89.99999999999994, -74.02985395599995),
    maxBoundsNorthEast = L.latLng(-21.786688039999945, -25.02314483699996),
    centerSouthWest = L.latLng(-53.748710796898976, -107.57812500000001),
    centerNorthEast = L.latLng(-19.642587534013032, -19.687500000000004),
    maxBounds = L.latLngBounds(maxBoundsSouthWest, maxBoundsNorthEast),
    centerBounds = L.latLngBounds(centerSouthWest, centerNorthEast),
    minZoom = 4;

function swap(indicador, etiquetas, valoresIndicadoresDesgloses) {
    map.removeLayer(tiles[current]);
    map.addLayer(tiles[indicador.ambito]);
    current = indicador.ambito;
    sideChartModel.set('indicador', indicador);
    sideChartModel.set('etiquetas', etiquetas);
    sideChartModel.set('valoresIndicadoresDesgloses', valoresIndicadoresDesgloses);
}

function update(data, idEtiquetaSeleccionada, descripcionEtiquetaSeleccionada, idsEtiquetasActuales) {
    sideChartModel.set('idsEtiquetasActuales', idsEtiquetasActuales);
    sideChartModel.set('descripcionEtiquetaSeleccionada', descripcionEtiquetaSeleccionada);
    tiles[current].eachLayer(function (layer) {
        idRefGeografica = layer.feature.properties.id;
        valor = data[idRefGeografica][idEtiquetaSeleccionada];
        layer.feature.properties['value'] = valor;
        layer.setStyle({fillColor: getColor(valor)})
    });
}

function mapMe(geoJsonNacion, geoJsonProvincias, geoJsonDepartamentos) {
    var base = L.tileLayer.wms('http://wms.ign.gob.ar/geoserver/wms?', {layers: 'ign:capabaseargenmap_gwc'});
    var tileNacion = L.geoJson(geoJsonNacion, {onEachFeature: onEachFeature, style: style});
    var tileProvincias = L.geoJson(geoJsonProvincias, {onEachFeature: onEachFeature, style: style});
    var tileDepartamentos = L.geoJson(geoJsonNacion, {onEachFeature: onEachFeature, style: style});

    tiles = {
        'N': tileNacion,
        'P': tileProvincias,
        'D': tileDepartamentos
    };

    /* Capa por defecto al inicializar el mapa */
    current = 'N';

    /* Crear 'Objeto Mapa' */
    map = L.map(document.getElementById('mapCanvas'), {doubleClickZoom: false});
    /* Agregar Mapa de Base */
    base.addTo(map);

    /* Controles sobre el Mapa */
    sideChartControl = L.control({position: 'topright'});
    sideChartControl.onAdd = addDivSideChart;

    /* Definir centro de mapa a partir de capa definida */
    map.fitBounds(centerBounds);
    map.setMaxBounds(maxBounds);
    map.setMinZoom(minZoom);

    /* Agregar capas y otros */
    sideChartControl.addTo(map);
    map.addLayer(tiles[current]);

    sideChartModel = new sideChartModel({});
    sideChartView = new sideChartView({el: $('.infobox'),model:sideChartModel});
}

function addDivSideChart(map) {
    this._div = L.DomUtil.create('div', 'infobox'); // create a div with a class "info"
    return this._div;
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
           i > 20 ? '#a6bddb' :
                    '#d0d1e6' ;
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
    // sideChart.update(layer.feature.properties);
    sideChartModel.set('layerProperties', layer.feature.properties);
}

function resetHighlight(event) {
    var layer = event.target;
    event.target.setStyle(style(event.target.feature));
    // sideChart.update();
}

function zoomToFeature(event) {
    map.fitBounds(event.target.getBounds());
}

function zoomOut(event) {
  map.fitBounds(centerBounds);
}