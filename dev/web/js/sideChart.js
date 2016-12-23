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
    '<% _.plot(model.get("valoresIndicadoresDesgloces"), model.get("idsEtiquetasActuales"), model.get("etiquetas"))%>',
    '<div id="infobox-line-chart" class="c3" style="max-height: 160px; max-width: 250px; position: relative;">',
    '</div>',
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
    '</tbody></table>'
].join("\n");

var sideChartModel = Backbone.Model.extend({
    defaults: {
        'layerProperties':[],
        'indicador': [],
        'valoresIndicadoresDesgloces': [],
        'idsEtiquetasActuales' : [],
        'etiquetas': [],
    }
});

var sideChartView = Backbone.View.extend({
    initialize: function() {
        _.bindAll(this, "render");
        this.model.bind('change', this.render);
    },

    render:function(){
        console.log(this.model.get("valoresIndicadoresDesgloces"));
        // console.log(this.model.get("idsEtiquetasActuales"));
        // console.log(this.model.get("etiquetas"));
        var tpl = _.template(templateSideChart);
        this.$el.html(tpl({model:this.model}));
        return this;
    }
});

function plot(valoresIndicadoresDesgloces, idsEtiquetasActuales, etiquetas){
    // console.log("entro");
    // console.log(valoresIndicadoresDesgloces);
    // console.log(idsEtiquetas);
    // console.log(etiquetas);
    var chartData = [];
    var e;
    var anios = ['x'];

    for (var i = 0; i < idsEtiquetasActuales.length(); i++) {
        id = etiquetasActuales[i];
        e = etiquetas[id];
        chartData[e] = [];
    }

    $.each(idsEtiquetasActuales, function() {} );
    $.each(valoresIndicadoresDesgloces, function(idValoresIndicadoresDesgloces, claves) {
        anio.push(claves.fecha);
        $.each(claves.valoresRefGeografica, function(idRefGeografica, idsEtiquetas) {
            $.each(idsEtiquetas, function(id, value){
                if (idsEtiquetasActuales.indexOf(id) != -1) {
                    e = etiquetas[id];
                    chartData[e].push(value);
                }
            });
        });
    });

  var chart = c3.generate({
    bindto: '#infobox-line-chart',
    data: {
      x: 'x',
      columns: [
        anios,
        chartData
      ]
    },
    legend: {
        show: false
    }
});
}
/*http://stackoverflow.com/questions/9589768/using-an-associative-array-as-data-for-d3*/