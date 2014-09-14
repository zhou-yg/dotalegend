$(function(){
	var Main = Backbone.Model.extend({
		defaults:{
			obj : $('.main'),
			$windowOps : $('.window_ops'),
			opBaseClassName:'ops_one',
			objs : {},
			heroSelected:{}
		},
		initialize:function(_obj,_direction,_v){
			
		},
		add:function(_model,_emitter,_type){
			
			var o = this;
			var objs = o.get('objs');
			var opBaseClassName = o.get('opBaseClassName');
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
				_model.show(_type);
			});
			
			_model.set({'main':o});
			
			objs[_model.get('name')] = _model;
			
			this.set({obj:objs});
		}
	});	
	var m = new Main();
	window.mainModelObj = m;
});