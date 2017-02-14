/// TEMPLATE //////////////

var template_select = [
	'<div class="form-group">',
	'	<div class="col-sm-2 control-label">',
	'		<label>Objetivo</label>',
	'	</div>',
	
	'	<div class="col-sm-10">',
    '		<select id="three_select_objetivo" class="form-control selectOne" name="id_objetivo_selected">',
    '			<% _.each(model.get("objetivos"), function( objetivo, i){ %>',
    '			<option value="<%= objetivo.id %>" title="<%= objetivo.code %> - <%= objetivo.desc %>"',
    '                          <% if (objetivo.id == model.get("objetivo_selected")) { %> selected<% }  %>><%= objetivo.code %> - <%= model.trim(objetivo.desc) %></option>',
	'			<% }); %>',
    '		</select>',
    '	</div>',
    '</div>',

    '<% if (model.get("metas").length ){ %>',
        '<div class="form-group">',
      	'	<div class="control-label col-sm-2">',
    	'		<label>Meta</label>',
		'	</div>',   
		'	<div class="col-sm-10">',
        '		<select id="three_select_meta" class="form-control selectTwo" name="id_meta_selected">',
        '			<% _.each(model.get("metas"), function( meta, i){ %>',
        '			<% if ( meta.id_objetivo == model.get("objetivo_selected") ){ %>',
        '			<option value="<%= meta.id %>" title="<%= meta.code_objetivo %>.<%= meta.code %> - <%= meta.desc %>"',
        '                    <% if (meta.id == model.get("meta_selected")) { %> selected<% }  %>><%= meta.code_objetivo %>.<%= meta.code %> - <%= model.trim(meta.desc) %></option>',
        '			<% } %>',
    	'			<% }); %>',
        '		</select>',
        '	</div>',
        '</div>', 
          
        '<% if (model.get("indicadores").length ){ %>',
			'<div class="form-group">',
        '		<div class="col-sm-2 control-label">',
		'			<label>Indicador</label>',
        '		</div>',        
        '		<div class="col-sm-10">',
    	'			<select id="three_select_indicador" class="form-control selectThree" name="id_indicador_selected">',
        '				<% _.each(model.get("indicadores"), function( indicador, i){ %>',
        '				<% if ( indicador.id_meta == model.get("meta_selected") ){ %>',
        '				<option value="<%= indicador.id %>" title="<%= indicador.code_objetivo %>.<%= indicador.code_meta %>.<%= indicador.code %> - <%= indicador.desc %>"',
        '                        <% if (indicador.id == model.get("indicador_selected")) { %> selected<% }  %>><%= indicador.code_objetivo %>.<%= indicador.code_meta %>.<%= indicador.code %> - <%= model.trim(indicador.desc) %></option>',
        '				<% } %>',
    	'				<% }); %>',
        '			</select>',
        '		</div>',
        '	</div>',
        '<% } %>',
    '<% } %>',
].join("\n");




var ThreeSelectData = Backbone.Model.extend({
	defaults: {
        'objetivo_selected': null,
        'meta_selected':null,
		'objetivos':[],
		'metas':[],
		'indicadores':[],
	},
    getMaxTrim: function(){
        return 130;
    },
    trim: function(string) {
        var max = this.getMaxTrim();
        var idx = string.indexOf(' ', 0);
        while ((idx < max) && (idx != -1)) {
          idx = string.indexOf(' ', idx + 1);
        }
        return (idx == -1) ? string : string.substring(0, idx) + '...';
    },
});


var ThreeSelectView = Backbone.View.extend({
	initialize: function(options) {
        if (this.model.get('objetivo_selected') == null){
		  this.model.set('objetivo_selected',this.model.get('objetivos')[0].id);
        }
        if ((this.model.get('meta_selected') == null) && (this.model.get('metas').length)) {
            this.model.set('meta_selected',this.model.get('metas')[0].id);
        }
        if (this.model.get('indicadores').length) {
            this.model.set('indicador_selected',this.model.get('indicadores')[0].id);
        }
		this.model.on('change:objetivo_selected', this.render, this);
        this.model.on('change:meta_selected', this.render, this);
        this.listenObjetivoCallback = options.objetivoChangeCallback;
        this.listenMetaCallback = options.metaChangeCallback;
        this.listenIndicadorCallback = options.indicadorChangeCallback;
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
    	this.model.set("objetivo_selected", e.target.value);
        $('.selectTwo').trigger('change');
        if (this.listenObjetivoCallback){
            this.listenObjetivoCallback();
        }
        //this.metaSelected();
    },
    metaSelected: function(e){
    	this.model.set("meta_selected",$(this.el).find('.selectTwo').val());
        if (this.listenMetaCallback){
            this.listenMetaCallback();
        }
        if (this.model.get('indicadores').length){
            $('.selectThree').trigger('change');
            //this.indicadorSelected();
        }
    },
    indicadorSelected: function(e){
    	this.model.set("indicador_selected",$(this.el).find('.selectThree').val());
        if (this.listenIndicadorCallback){
            this.listenIndicadorCallback();
        }
    },

})
