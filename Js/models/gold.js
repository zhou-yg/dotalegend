$(function(){
	
	
	var GoldPlus = Backbone.Model.extend({
		
		defaults : {
		},
		initialize : function() {
			
			var o = this;

			var $obj      = o.get('$obj');
			var $objTitle = o.get('$objTitle');
			var $window   = o.get('$window');
			var $leftto   = o.get('$leftto');
			
			$window.height($obj.height() - $objTitle.height() - $leftto.height());
			
			$leftto.click(function(){
				o.hide();
			});
		},
	});
});
