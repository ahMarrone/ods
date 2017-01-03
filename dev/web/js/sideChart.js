/// TEMPLATE //////////////

_.mixin({
  getColor: getColor,
  plot: plot
});

function getColor (v){
    return v > 80 ? '#045a8d' :
           v > 60 ? '#2b8cbe' :
           v > 40 ? '#74a9cf' :
           v > 20 ? '#a6bddb' :
                    '#d0d1e6' ;
}

var templateSideChart = [
    '<div style="margin-bottom: 8px;" class="row">',
    '<div class="col-xs-9">',
    '<div class="unit-name">',
    '<%= model.get("layerProperties").descripcion %></div>',
    '<div class="edo-name"></div>',
    '</div>',
    '</div>',
    '<div class="row values-row">',
    '<table><tbody>',
    '<tr>',
    '<td class="col-xs-8 indicador-nombre"><%= model.get("indicador").descripcion %></td>',
    '</tr>',
    '</tbody></table>',
    '</div>',
    '<% if (_.isEmpty(model.get("layerProperties"))) { %>',
    '<div class="texto-aclaracion">Bienvenido a Explora</div>',
    '<% } else { %>',
    '<% if ( model.get("isChartAvailable") ) { %>',
    '<div id="infobox-line-chart" class="c3" style="max-height: 160px; max-width: 250px; position: relative;">',
    '</div>',
    '<% } else { %>',
    '<div class="indicador-valor" style="color: <%= _(model.get("layerProperties").value).getColor() %>" >',
    '<%= model.get("layerProperties").value.toFixed(2).replace(".", ",") %></div>',
    '<div class="texto-aclaracion">Al momento sólo se cuenta con datos para el año de referencia</div>',
    '</div>',
    '</div>',
    '<% } %>',
    '<% if (model.get("indicador").ambito == "N") { %>',
    '<div class="row values-row-metas">',
    '<table><tbody>',
    '<tr>',
    '<td class="col-xs-2 meta"></td>',
    '<td class="col-xs-4 meta">Meta 2019 20.00</td>',
    '<td class="col-xs-4 meta">Meta 2030 15.00</td>',
    '</tr>',
    '</tbody></table>',
    '</div>',
    '<% } %>',
    '<div class="map-legend">',
    '<table id="legend-colors"><tbody>',
    '<tr>',
    '<% _.each(model.get("indicador").escala, function(value, i){ %>',
    '<td class="legend-color" style="background-color:<%= _(value + 1).getColor() %>',
    ';"></td>',
    '<% }); %>',
    '<tr>',
    '<% _.each(model.get("indicador").escala, function(value, i){ %>',
    '<td class="legend-breaks"> <%= value %>',
    '</td>',
    '<% }); %>',
    '</tbody></table>',
    '<% } %>'
].join("\n");

var sideChartModel = Backbone.Model.extend({
    defaults: {
        'layerProperties':[],
        'indicador': [],
        'valoresIndicadoresDesgloses': [],
        'descripcionEtiquetaSeleccionada': '',
        'indiceColorEtiqueta': 0,
        'idsEtiquetasActuales' : [],
        'etiquetas': [],
        'isChartAvailable': false
    }
});

var sideChartView = Backbone.View.extend({
    initialize: function() {
        _.bindAll(this, 'render');
        this.model.bind('change', this.render);
    },

    prepare: function() {
        var valoresIndicadoresDesgloses = this.model.get('valoresIndicadoresDesgloses');
        var idsEtiquetasActuales = this.model.get('idsEtiquetasActuales') ;
        var etiquetas = this.model.get('etiquetas');
        var idRefGeograficaActual = this.model.get("layerProperties").id;
        var descripcionEtiquetaSeleccionada = this.model.get("descripcionEtiquetaSeleccionada");

        var chartDataRaw = {};
        var e;
        var anios = ['x'];
        var indiceColorEtiqueta = 0;

        _.each(idsEtiquetasActuales, function(id) {
            e = etiquetas[id].descripcion;
            chartDataRaw[e] = [];
        })

        _.each(valoresIndicadoresDesgloses, function(claves, fecha) {
            _.each(claves.valoresRefGeografica, function(idsEtiquetas, idRefGeografica) {
                if (idRefGeografica == idRefGeograficaActual) {
                    _.each(idsEtiquetas, function(valor, idStr) {
                        /* HACK - VERIFICAR TIPO */
                        id = parseInt(idStr);
                        /* CAMBIAR A FUNCIÓN DE UNDERSCORE */
                        if (idsEtiquetasActuales.indexOf(id) != -1) {
                            e = etiquetas[id].descripcion;
                            anios.push(fecha);
                            chartDataRaw[e].push(valor);
                        }
                    })
                }
            })
        })

        anios = _.uniq(anios);
        var chartData = [anios];
        var i = 1;

        _.each(chartDataRaw, function(valores, etiqueta){
            chartData.push([etiqueta]);
            if (etiqueta == descripcionEtiquetaSeleccionada) {
                indiceColorEtiqueta = i;
            }
            for (var j = 0 ; j < valores.length ; j++) {
                chartData[i].push(valores[j]);
            }
            i++;
        })
        
        if (anios.length > 2) {
            this.model.set('isChartAvailable', true);
        } else {
            this.model.set('isChartAvailable', false);
        }

        this.model.set('indiceColorEtiqueta', indiceColorEtiqueta - 1);

        return chartData
    },

    render: function() {
        // console.log(this.model.get("layerProperties"));
        var descripcionEtiquetaSeleccionada = this.model.get('descripcionEtiquetaSeleccionada');
        var tpl = _.template(templateSideChart);
        var chartData = this.prepare();
        var indiceColorEtiqueta = this.model.get('indiceColorEtiqueta');
        this.$el.html(tpl({model:this.model}));
        _.plot(chartData, descripcionEtiquetaSeleccionada, indiceColorEtiqueta);
        return this;
    }
});


function plot(chartData, descripcionEtiquetaSeleccionada, indiceColorEtiqueta) {
    /* Máximo 9 Tonos */
    colorPattern = ['#800026', '#bd0026', '#e31a1c', '#fc4e2a', '#fd8d3c', '#feb24c', '#fed976', '#ffeda0', '#ffffcc'];
    colorPattern[indiceColorEtiqueta] = '#045a8d';
    var chart = c3.generate({
        bindto: '#infobox-line-chart',
        data: {
          x: 'x',
          columns: chartData
        },
        legend: {
            show: false
        },
        color: {
            pattern: colorPattern
        },
        tooltip: {
            format: {
                value: function(value) {
                    return d3.format(",.2f")(value).replace('.', ' ').replace(/,/g, '.').replace(' ', ',')
                }
            }
        },
        padding: {
            top: 5,
            right: 10,
            // bottom: 0,
            left: 20,
        },  
    });

    descripcionEtiquetaSeleccionada = descripcionEtiquetaSeleccionada.replace(" ", "-");
    // console.log('#infobox-line-chart2 .c3-line-'.concat(descripcionEtiquetaSeleccionada));

    /* Estilo de las Líneas */
    $('.c3-line').css('stroke-dasharray', '5,5'); /* Línea Punteada */

    /* VERIFICAR SI FUNCIONA CORRECTAMENTE */
    $('.c3-line-'.concat(descripcionEtiquetaSeleccionada)).css("stroke-width","2px");
    $('.c3-line-'.concat(descripcionEtiquetaSeleccionada)).css("stroke-dasharray","0,0");
    
    $('.c3 svg').css("font","8px sans-serif");
}