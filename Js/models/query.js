(function(){
	var Query = Backbone.Model.extend({

		defaults : {
			name : 'query',
			obj : $('.query'),
			$query_leftto : $('.query .leftto'),
			fromLeft:'100%',
			toLeft:0
		},
		initialize : function() {

		},
		show : function(){
			var $Obj = this.get('obj');
			var toLeft = this.get('toLeft');

			$Obj.animate({
				left:toLeft
			},1000);
		},
		hide:function(){
			var $Obj = this.get('obj');
			var fromLeft = this.get('fromLeft');

			$Obj.animate({
				left:fromLeft
			},1000);			
		},
	});
	var q = new Query();
	mainObj.add(q,'.ops_test');
}());
