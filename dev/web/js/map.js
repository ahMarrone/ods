var map, tiles, selectedPoligonEvent, sideChartModel, sideChartView, 
sideChartControl, isSideChartAvailable, ambitoIndicador, escalaColores;
var NACIONAL = 'N',
    PROVINCIAL = 'P',
    DEPARTAMENTAL = 'D';

// var maxBoundsSouthWest = L.latLng(-89.99999999999994, -74.02985395599995),
// maxBoundsNorthEast = L.latLng(-21.786688039999945, -25.02314483699996),

var maxBoundsSouthWest = L.latLng(-89.99999999999994, -80.02985395599995),
    maxBoundsNorthEast = L.latLng(-21.786688039999945, -27.02314483699996),
    centerSouthWest = L.latLng(-56.5, -10.57812500000001),
    centerNorthEast = L.latLng(-19.642587534013032, -89.687500000000004),
    maxBounds = L.latLngBounds(maxBoundsSouthWest, maxBoundsNorthEast),
    centerBounds = L.latLngBounds(centerSouthWest, centerNorthEast),
    minZoom = 4,
    isPoligonSelected = false,
    isZoomIn = false;
    escalaColores = [];

/* En el caso de Tierra del Fuego, Antártida e Islas del Atlántico Sur, se define
un centro específico */
var especialID = 23;
    especialCenterSouthWest = L.latLng(-89.99999999999994, -74.02985395599995),
    especialCenterNorthEast = L.latLng(20.02466692199994, -25.02314483699996),
    especialCenterBounds = L.latLngBounds(especialCenterSouthWest, especialCenterNorthEast)

function swap(indicador={}, etiquetas={}, valoresIndicadoresDesgloses={}) {
    /* Indicador No Definido: Asignar ámbito 'NACIONAL' */
    map.removeLayer(tiles[ambitoIndicador]);
    ambitoIndicador = ($.isEmptyObject(indicador)) ? NACIONAL : indicador.ambito;
    isSideChartAvailable = ($.isEmptyObject(valoresIndicadoresDesgloses)) ? false : true;
    map.addLayer(tiles[ambitoIndicador]);
    escalaColores = indicador.escala;
    sideChartModel.set('indicador', indicador);
    sideChartModel.set('etiquetas', etiquetas);
    sideChartModel.set('valoresIndicadoresDesgloses', valoresIndicadoresDesgloses);
}

function update(data={}, idEtiquetaSeleccionada=null, idsEtiquetasActuales=[]) {
    if (map.hasDivSideChart()) {
        map.removeControl(sideChartControl);
    }
    if (typeof selectedPoligonEvent !== 'undefined') {
        isPoligonSelected = false;
        resetHighlight(selectedPoligonEvent);
        zoomOut();
    }
    sideChartModel.set('idsEtiquetasActuales', idsEtiquetasActuales);
    sideChartModel.set('idEtiquetaSeleccionada', idEtiquetaSeleccionada);
    sideChartModel.set('layerProperties', []);
    tiles[ambitoIndicador].eachLayer(function (layer) {
        idRefGeografica = layer.feature.properties.id;
        valor = undefined;
        if (data[idRefGeografica]) {
            if (data[idRefGeografica][idEtiquetaSeleccionada])
                valor = data[idRefGeografica][idEtiquetaSeleccionada];
        }
        layer.feature.properties['value'] = valor;
        layer.setStyle({fillColor: getColor(valor, escalaColores)});
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

    var exportarButton = L.easyButton({
      id: 'exportButton',       // an id for the generated button
      position: 'topleft',      // inherited from L.Control -- the corner it goes in
      type: 'replace',          // set to animate when you're comfy with css
      leafletClasses: true,     // use leaflet classes to style the button?
      states:[{                 // specify different icons and responses for your button
        stateName: 'export',
        onClick: function(button, map){
            $('#exportarModal').modal('show')
        },
        title: 'Exportar',
        icon: 'fa-download'
      }]
    });

    /*var buttons = [ L.easyButton(options),
                    L.easyButton(options2),
                    L.easyButton(options3)];*/

    /* Capa por defecto al inicializar el mapa */
    ambitoIndicador = NACIONAL;

    /* Crear 'Objeto Mapa' */
    map = L.map(document.getElementById('mapCanvas'), {doubleClickZoom: false});
    /* Agregar Mapa de Base */
    base.addTo(map);

    /* Controles sobre el Mapa */
    sideChartControl = L.control({position: 'topright'});

    /* Definir centro de mapa a partir de capa definida */
    map.fitBounds(centerBounds);
    map.setMaxBounds(maxBounds);
    map.setMinZoom(minZoom);

    /* Agregar capas y otros */
    map.addLayer(tiles[ambitoIndicador]);
    map.divSideChart = false;
    L.Map.include({
        hasDivSideChart: function () {
            return (this.divSideChart);
        }
    });

    var centerButton = L.easyButton('fa-globe', function(btn, map) {
        // map.fitBounds(centerBounds);
        zoomOut();
    }).addTo(map);
    exportarButton.addTo(map);

    /*L.easyBar(buttons).addTo(map);*/

    sideChartModel = new sideChartModel({});
    sideChartView = new sideChartView({model:sideChartModel});
    // sideChartView = new sideChartView({el: $('.infobox'), model:sideChartModel});
}

function addDivSideChart(map) {
    map.divSideChart = true;
    this._div = L.DomUtil.create('div', 'infobox'); // create a div with a class "info"
    return this._div;
}

function removeDivSideChart(map) {
    map.divSideChart = false;
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
    fillColor: getColor(feature.properties.value, escalaColores),
    weight: 2,
    opacity: 1,
    color: 'white',
    dashArray: '3',
    fillOpacity: 0.7
    };
}

function getColor(v, e=[]) {
    /* Color Scale */
    var colors = ['#d0d1e6', '#a6bddb', '#74a9cf', '#2b8cbe', '#045a8d'];

    if (v === undefined) {
        // color = '#dcdbdb';
        // color = '#ffffff';
        color = '#eeeeee';
    } else {
        color = v > e[4] ? colors[4] :
        color = v > e[3] ? colors[3] :
        color = v > e[2] ? colors[2] :
        color = v > e[1] ? colors[1] :
                           colors[0] ;
        // color = v > 80 ? '#045a8d' :
        //         v > 60 ? '#2b8cbe' : 
        //         v > 40 ? '#74a9cf' :
        //         v > 20 ? '#a6bddb' :
        //                  '#d0d1e6' ;
    }
    return color;
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

        if (!(map.hasDivSideChart()) && isSideChartAvailable) {
            sideChartControl.onAdd = addDivSideChart;
            sideChartControl.onRemove = removeDivSideChart;
            map.addControl(sideChartControl);
            sideChartView.setElement($('.infobox'));
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
    if (ambitoIndicador == PROVINCIAL) {
        if (event.target.feature.properties.id == especialID) {
            tileBounds = especialCenterBounds;
        } else {
            tileBounds = event.target.getBounds();
        }
        map.fitBounds(tileBounds, {maxZoom: 5});
    } else /* ambitoIndicador == DEPARTAMENTAL */ {
        tileBounds = event.target.getBounds();
        map.fitBounds(tileBounds, {maxZoom: 6});
    }    
}

function zoomOut() {
  map.fitBounds(centerBounds);
}

function seleccionarPoligon(event) {
    if (ambitoIndicador != NACIONAL) {
        if (isPoligonSelected) {
            isPoligonSelected = false;
            resetHighlight(selectedPoligonEvent);
            if (ambitoIndicador == PROVINCIAL) {
                zoomOut();
            }
        } else {
            isPoligonSelected = true;
            selectedPoligonEvent = event;
            zoomIn(event);
        }
    }
}

