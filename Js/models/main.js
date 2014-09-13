(function(){
	var Main = Backbone.Model.extend({
		defaults:{
			obj : $('.main'),
			$windowOps : $('.window_ops'),
			opBaseClassName:'ops_one',
			objs : {}
		},
		initialize:function(_obj,_direction,_v){
			
		},
		add:function(_model,_emitter){
			
			var objs = this.get('objs');
			var opBaseClassName = this.get('opBaseClassName');
			var $emitter;
			
			if(typeof _emitter=='string'){
				
				if(_emitter[0]!='.'){
					_emitter = '.' + _emitter;
				}
				$emitter = $(_emitter);
				
			}else if(typeof _emitter=='object'){
				
			}else{
				
			}
			$emitter.click(function(){
				_model.show();
			});

			objs[_model.get('name')] = _model;
		}
	});	
	var m = new Main();
	window.mainObj = m;
}());