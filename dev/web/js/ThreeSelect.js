/// TEMPLATE //////////////

var template_select = [
	'<div class="form-group">',
	'<label>Objetivos</label>',
    '<select class="form-control selectOne">',
    '<% _.each(model.get("objetivos"), function( objetivo, i){ %>',
    '<option value="<%= objetivo.id %>" <% if (objetivo.id == model.get("objetivo_selected")) { %> selected<% }  %>><%= objetivo.desc %></option>',
	'<% }); %>',
    '</select>',
    '</div>',
    '<div class="form-group">',
	'<label>Metas</label>',
    '<select id="indicadores_fkidmeta" class="form-control selectTwo" name="indicadores[fkidmeta]">',
    '<% _.each(model.get("metas"), function( meta, i){ %>',
    '<% if ( meta.id_objetivo == model.get("objetivo_selected") ){ %>',
    '<option value="<%= meta.id %>" <% if (meta.id == model.get("meta_selected")) { %> selected<% }  %>><%= meta.desc %></option>',
    '<% } %>',
	'<% }); %>',
    '</select>',
    '</div>',
    '<% if (model.get("indicadores").length ){ %>',
    '<div class="form-group">',
	'<label>Indicadores</label>',
    '<select class="form-control selectThree">',
    '<% _.each(model.get("indicadores"), function( indicador, i){ %>',
    '<% if ( indicador.id_meta == model.get("meta_selected") ){ %>',
    '<option value="<%= indicador.id %>" <% if (indicador.id == model.get("indicador_selected")) { %> selected<% }  %>><%= indicador.desc %></option>',
    '<% } %>',
	'<% }); %>',
    '</select>',
    '</div>',
    '<% } %>',
].join("\n");




var ThreeSelectData = Backbone.Model.extend({
	defaults: {
		'objetivos':[],
		'metas':[],
		'indicadores':[],
	}
});


var ThreeSelectView = Backbone.View.extend({
	initialize: function() {
		this.model.set('objetivo_selected',this.model.get('objetivos')[0].id);
		this.model.set('meta_selected',this.model.get('metas')[0].id);
        if (this.model.get('indicadores').length) {
            this.model.set('indicador_selected',this.model.get('indicadores')[0].id);
        }
		this.model.on('change:objetivo_selected', this.render, this);
        this.model.on('change:meta_selected', this.render, this);
       	this.render();
    },
    events: {
              'change .selectOne': 'objetivoSelected',
              'change .selectTwo': 'metaSelected',
              'change .selectThree': 'indicadorSelected',
    },
    render:function(){
		var tpl = _.template(template_select);
	    this.$el.html(tpl({model:this.model}));
	    return this;
    },
    objetivoSelected: function(e){
    	this.model.set("objetivo_selected",event.target.value); 
        this.metaSelected();
    },
    metaSelected: function(e){
    	this.model.set("meta_selected",$(this.el).find('.selectTwo').val());
        if (this.model.get('indicadores').length){
            this.indicadorSelected();
        }
    },
    indicadorSelected: function(e){
    	this.model.set("indicador_selected",$(this.el).find('.selectThree').val());
    }
})