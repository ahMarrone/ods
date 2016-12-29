/// TEMPLATE //////////////

_.mixin({
  getColor: getColor,
  plot: plot,
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
    '<% } else {%>',
    '<% if ( model.get("isChartAvailable") ) { %>',
    '<div id="infobox-line-chart" class="c3" style="max-height: 160px; max-width: 250px; position: relative;">',
    '</div>',
    '<% } else { %>',
    '<div class="indicador-valor">',
    '<%= model.get("layerProperties").value %></div>',
    '<div class="texto-aclaracion">Al momento sólo se cuenta con datos para el año de referencia</div>',
    '</div>',
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

        var chartDataRaw = {};
        var e;
        var anios = ['x'];

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
            chartData.push([etiqueta])
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

        return chartData
    },

    render: function() {
        // console.log(this.model.get("layerProperties"));
        var descripcionEtiquetaSeleccionada = this.model.get('descripcionEtiquetaSeleccionada');
        var tpl = _.template(templateSideChart);
        var chartData = this.prepare();
        var ambito = this.model.get('indicador').ambito;
        this.$el.html(tpl({model:this.model}));
        _.plot(chartData, descripcionEtiquetaSeleccionada, ambito);
        return this;
    }
});


function plot(chartData, descripcionEtiquetaSeleccionada, ambito) {
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
            pattern: ['#045a8d', '#2b8cbe', '#74a9cf', '#a6bddb', '#d0d1e6']
        },
        grid: {
            y: {
                lines: [{value: 20, text: 'Meta 2019', class: 'meta1'}, {value: 15, text: 'Meta 2030', class: 'meta2'}]
            }
        }
    });

    $('.c3-ygrid-line.meta1 text').css("font","8px sans-serif");
    $('.c3-ygrid-line.meta1 text').css('stroke', 'green');
    $('.c3-ygrid-line.meta1 line').css('stroke', 'green');
    $('.c3-ygrid-line.meta2 text').css("font","8px sans-serif");
    $('.c3-ygrid-line.meta2 text').css('stroke', 'green');
    $('.c3-ygrid-line.meta2 line').css('stroke', 'green');


    if (ambito != 'N') {
        $('.c3-ygrid-line.meta1 text').css('visibility', 'hidden');
        $('.c3-ygrid-line.meta1 line').css('visibility', 'hidden');
        $('.c3-ygrid-line.meta2 text').css('visibility', 'hidden');
        $('.c3-ygrid-line.meta2 line').css('visibility', 'hidden');
    }


    descripcionEtiquetaSeleccionada = descripcionEtiquetaSeleccionada.replace(" ", "-");
    // console.log('#infobox-line-chart2 .c3-line-'.concat(descripcionEtiquetaSeleccionada));

    /* Estilo de las Líneas */
    $('.c3-line').css('stroke-dasharray', '5,5'); /* Línea Punteada */

    /* VERIFICAR SI FUNCIONA CORRECTAMENTE */
    $('.c3-line-'.concat(descripcionEtiquetaSeleccionada)).css("stroke-width","2px");
    $('.c3-line-'.concat(descripcionEtiquetaSeleccionada)).css("stroke-dasharray","0,0");
    $('.c3 svg').css("font","8px sans-serif");
    

}