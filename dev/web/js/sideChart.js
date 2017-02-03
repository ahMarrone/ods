/// TEMPLATE //////////////

/* HOMOGENEIZAR NOMBRES */

_.mixin({
  getColor: getColor
});

function swapInArray(left, right, v) {
    var aux;

    aux = v[left];
    v[left] = v[right];
    v[right] = aux;
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
    '<% if (model.get("layerProperties").value) { %>',
    '<div class="indicador-valor" style="color: <%= _(model.get("layerProperties").value).getColor() %>" >',
    '<%= model.get("layerProperties").value.toFixed(3).replace(".", ",") %></div>',
    '<div class="texto-aclaracion">Al momento sólo se cuenta con datos para el año de referencia</div>',
    '<% } else { %>',
    '<div class="texto-aclaracion">Al momento no se cuenta con datos para el año de referencia</div>',
    '<% } %>',
    '<% } %>',
    '<% if (model.get("indicador").ambito == "N") { %>',
    '<div class="meta">',
    '<% _.each(model.get("indicador").fechasMetas, function(item, i){ %>',
    '<% if (i != 0) { %> - <% } %>',
    'Meta <%= item[0] %>: <%= item[1].toFixed(3).replace(".", ",") %>',
    '<% }); %>',
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
        'layerProperties': [],
        'indicador': [],
        'etiquetas': [],
        'valoresIndicadoresDesgloses': [],
        'idsEtiquetasActuales' : [],
        'idEtiquetaSeleccionada': null,
        'isChartAvailable': false
    }
});

var sideChartView = Backbone.View.extend({
    initialize: function() {
        /*_.bindAll(this, 'render');
        this.model.bind('change', this.render);*/
        this.model.on('change:layerProperties', this.render, this);
    },

    prepare: function() {
        var valoresIndicadoresDesgloses = this.model.get('valoresIndicadoresDesgloses');
        var idsEtiquetasActuales = this.model.get('idsEtiquetasActuales') ;
        var idRefGeograficaActual = this.model.get("layerProperties").id;
        var etiquetas = this.model.get("etiquetas");
        var idEtiquetaSeleccionada = this.model.get("idEtiquetaSeleccionada");

        var chartDataRaw = {};
        var chartData = [];
        var nulosPorAnio = {};
        var aniosDefinidos = 0;
        var indiceEtiquetaSeleccionada = null;
        var i;

        _.each(valoresIndicadoresDesgloses, function(claves, fecha) {
            if (!(fecha in chartDataRaw)) {
                chartDataRaw[fecha] = {};
                nulosPorAnio[fecha] = 0;
            }
            _.each(claves.valoresRefGeografica, function(idsEtiquetas, idRefGeografica) {
                if (idRefGeografica == idRefGeograficaActual) {
                    _.each(idsEtiquetasActuales, function(id) {
                        if (id in idsEtiquetas) {
                            valor = idsEtiquetas[id];
                            if (id == idEtiquetaSeleccionada) {
                                aniosDefinidos += 1;
                            }
                        } else {
                            nulosPorAnio[fecha] += 1;
                            valor = null;
                        }
                        e = etiquetas[id].descripcion;
                        chartDataRaw[fecha][id] = valor;
                    })
                }
            })
        })

        if (aniosDefinidos > 1) {
            this.model.set('isChartAvailable', true);
            /* Inicializar 'chartData' con el formato requerido por c3 */
            chartData = [['x']];
            _.each(idsEtiquetasActuales, function(id, i){
                chartData.push([etiquetas[id].descripcion]);
                if (id == idEtiquetaSeleccionada) {
                    indiceEtiquetaSeleccionada = i + 1;
                }
            });

            _.each(chartDataRaw, function(valoresPorEtiqueta, anio) {
                if (nulosPorAnio[anio] == idsEtiquetasActuales.length) {
                    return;
                }
                chartData[0].push(anio);
                i = 1;
                _.each(valoresPorEtiqueta, function(valor, id){
                    chartData[i].push(valor);
                    i++;
                });
            });            
            swapInArray(indiceEtiquetaSeleccionada, chartData.length - 1, chartData);
        } else {
            this.model.set('isChartAvailable', false);
        }

        return chartData
    },

    render: function() {
        var tpl = _.template(templateSideChart);
        var chartData = this.prepare();
        this.$el.html(tpl({model:this.model}));
        if (this.model.get("isChartAvailable")) {
            var etiquetas = this.model.get("etiquetas");
            var idEtiquetaSeleccionada = this.model.get("idEtiquetaSeleccionada");
            var descripcionEtiquetaSeleccionada = etiquetas[idEtiquetaSeleccionada].descripcion;
            this.plot(chartData, descripcionEtiquetaSeleccionada);    
        }
        return this;
    },

    plot: function(chartData, descripcionEtiquetaSeleccionada) {
        /* Máximo 9 Tonos */
        var colorPattern = ['#800026', '#bd0026', '#e31a1c', '#fc4e2a', '#fd8d3c', '#feb24c', '#fed976', '#ffeda0', '#ffffcc'];
        colorPattern[chartData.length - 2] = '#045a8d';
        var chart = c3.generate({
            bindto: '#infobox-line-chart',
            data: { x: 'x', columns: chartData },
            legend: { show: false },
            color: { pattern: colorPattern },
            tooltip: {
                format: {
                    value: function(value) {
                        return d3.format(",.3f")(value).replace('.', ' ').replace(/,/g, '.').replace(' ', ',')
                    }
                }
            },
            padding: {top: 5, right: 10, /*bottom: 0,*/ left: 20},  
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
});