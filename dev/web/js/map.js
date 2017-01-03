var map, tiles, selectedPoligonEvent, sideChartModel, sideChartView, ambitoIndicador;
var sideChartModel;
var NACIONAL = 'N',
    PROVINCIAL = 'P',
    DEPARTAMENTAL = 'D';

// var maxBoundsSouthWest = L.latLng(-89.99999999999994, -74.02985395599995),
// maxBoundsNorthEast = L.latLng(-21.786688039999945, -25.02314483699996),

var maxBoundsSouthWest = L.latLng(-89.99999999999994, -80.02985395599995),
    maxBoundsNorthEast = L.latLng(-21.786688039999945, -40.02314483699996),
    centerSouthWest = L.latLng(-53.748710796898976, -107.57812500000001),
    centerNorthEast = L.latLng(-19.642587534013032, -19.687500000000004),
    maxBounds = L.latLngBounds(maxBoundsSouthWest, maxBoundsNorthEast),
    centerBounds = L.latLngBounds(centerSouthWest, centerNorthEast),
    minZoom = 4,
    isPoligonSelected = false,
    isZoomIn = false;

/* En el caso de Tierra del Fuego, Antártida e Islas del Atlántico Sur, se define
un centro específico */
var especialID = 23;
    especialCenterSouthWest = L.latLng(-89.99999999999994, -74.02985395599995),
    especialCenterNorthEast = L.latLng(20.02466692199994, -25.02314483699996),
    especialCenterBounds = L.latLngBounds(especialCenterSouthWest, especialCenterNorthEast)

function swap(indicador, etiquetas, valoresIndicadoresDesgloses) {
    map.removeLayer(tiles[ambitoIndicador]);
    map.addLayer(tiles[indicador.ambito]);
    ambitoIndicador = indicador.ambito;
    sideChartModel.set('indicador', indicador);
    sideChartModel.set('etiquetas', etiquetas);
    sideChartModel.set('valoresIndicadoresDesgloses', valoresIndicadoresDesgloses);
}

function update(data, idEtiquetaSeleccionada, descripcionEtiquetaSeleccionada, idsEtiquetasActuales) {
    sideChartModel.set('idsEtiquetasActuales', idsEtiquetasActuales);
    sideChartModel.set('descripcionEtiquetaSeleccionada', descripcionEtiquetaSeleccionada);
    tiles[ambitoIndicador].eachLayer(function (layer) {
        idRefGeografica = layer.feature.properties.id;
        valor = data[idRefGeografica][idEtiquetaSeleccionada];
        layer.feature.properties['value'] = valor;
        layer.setStyle({fillColor: getColor(valor)})
    });
}

function mapMe(geoJsonNacion, geoJsonProvincias, geoJsonDepartamentos) {
    var base = L.tileLayer.wms('http://wms.ign.gob.ar/geoserver/wms?', {layers: 'ign:capabaseargenmap_gwc', attribution: '<a href="http://www.ign.gob.ar/">IGN</a>'});
    // var base = L.tileLayer.wms('http://wms.ign.gob.ar/geoserver/wms?', {layers: 'capabaseargenmap', attribution: '<a href="http://www.ign.gob.ar/">IGN</a>'});
    var tileNacion = L.geoJson(geoJsonNacion, {onEachFeature: onEachFeature, style: style});
    var tileProvincias = L.geoJson(geoJsonProvincias, {onEachFeature: onEachFeature, style: style});
    var tileDepartamentos = L.geoJson(geoJsonDepartamentos, {onEachFeature: onEachFeature, style: style});

    tiles = {};
    tiles[NACIONAL] = tileNacion;
    tiles[PROVINCIAL] = tileProvincias;
    tiles[DEPARTAMENTAL] = tileDepartamentos;

    /* Capa por defecto al inicializar el mapa */
    ambitoIndicador = NACIONAL;

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
    map.addLayer(tiles[ambitoIndicador]);

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
        click: seleccionarPoligon
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
    if (!isPoligonSelected) {
        var layer = event.target;
        layer.setStyle({
            weight: 3,
            color: '#045a8d',
            dashArray: '',
            fillOpacity: 0.3
        });
      
        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }
        sideChartModel.set('layerProperties', layer.feature.properties);
    }
}

function resetHighlight(event) {
    if (!isPoligonSelected) {
        event.target.setStyle(style(event.target.feature));
    }
}

function zoomIn(event) {
    if (event.target.feature.properties.id == especialID) {
        tileBounds = especialCenterBounds;
    } else {
        tileBounds = event.target.getBounds();
    }
    map.fitBounds(tileBounds, {maxZoom: 5});
}

function zoomOut(event) {
  map.fitBounds(centerBounds);
}

function seleccionarPoligon(event) {
    if (ambitoIndicador != NACIONAL) {
        if (isPoligonSelected) {
            isPoligonSelected = false;
            resetHighlight(selectedPoligonEvent);
            zoomOut(event);
        } else {
            isPoligonSelected = true;
            selectedPoligonEvent = event;
            zoomIn(event);
        }
    }
}

