
var template_highlight_dates = [
    '<div class="form-group">',
            '<label class="control-label required">Fechas destacadas (hitos)</label>',
        '<div class="row">',
            '<div id="highlightDatesCalendar" class="col-md-3" name="highlight_dates">',
            '</div>',
            '<div class="alert alert-info col-md-9" role="alert"><b>Fechas destacadas (máx. 5): </b>',
            '<ul>',
            '<% _.each(model.get("dates"), function( date, i){ %>',
                '<li><%= date %></li>',
            '<% }); %>',
            '</ul>',
             '</div>',
        '<div>',
    '</div>',
].join("\n");

var HighlightDates = Backbone.Model.extend({
	defaults: {
        'dates':[]
	},
    getFormattedDates: function(){
        return this.get('dates').join(";");
    },
});


var HighlightDatesView = Backbone.View.extend({
	initialize: function() {
       	this.render();
    },
    events: {
    },
    initDatePicker: function(){
        $('#highlightDatesCalendar').datepicker({
            format: "yyyy-mm-dd",
            minViewMode: 2,
            multidate: true,
            multidateSeparator: ";",
            autoclose: true
        });
    },
    updateDatesSelected: function(){
        if (this.model.get('dates').length){
            $('#highlightDatesCalendar').datepicker('setDates',this.model.get('dates'));
        }
    },
    formatDates: function(year){
        return year + "-01-01";
    },
    listenChangeDate: function(){
        var that = this;
        $('#highlightDatesCalendar').datepicker().on('changeDate', function(e) {
                var newDates = [];
                that.model.set('dates',[]);
                for (k in e.dates){
                    if (k < 5){
                        newDates.push(that.formatDates(e.dates[k].getFullYear()));
                    }
                }
                that.model.set('dates', newDates);
                that.render();
        });
    },
    render:function(){
		var tpl = _.template(template_highlight_dates);
	    this.$el.html(tpl({model:this.model}));
        this.initDatePicker();
        this.updateDatesSelected();
        this.listenChangeDate();
	    return this;
    }
})