/// TEMPLATE //////////////

_.mixin({
  getColor: getColor
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
        'etiquetasActuales' : []
    }
});

var sideChartView = Backbone.View.extend({
    initialize: function() {
        _.bindAll(this, "render");
        this.model.bind('change', this.render);
    },

    render:function(){
        var tpl = _.template(templateSideChart);
        this.$el.html(tpl({model:this.model}));
        return this;
    }
});

function plot(refGeoId){
  var chartData = [''];




  $.each(valoresIndicadoresDesgloces, function(id, claves) {
        $.each(claves['valoresRefGeografica'], function(idEtiqueta, value)){
            chartData[idEtiqueta]
          chartData.push(value[selected]);
        });
    });

  var chart = c3.generate({
    bindto: '#infobox-line-chart',
    data: {
      x: 'x',
      columns: [
        ['x', '2014', '2015'],
        chartData
      ]
    },
    legend: {
        show: false
    }
});
}