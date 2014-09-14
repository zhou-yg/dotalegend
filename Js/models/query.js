$(function(){
	var HeroView;
	var itemIn = ['w','g','g1','b','b1','b2','p','p1','p2','p3','p4','o'];
	(function(){
		var HeroV = Backbone.View.extend({
			
			initialize:function(_obj){
				
			},
			events : {
				'click li[type=level]':'doSelect'
			},
			doSelect : function(_event){
				
				var target = _event.target;
				
				if(this.currentLevel!=target){

					$(this.currentLevel).removeClass('selected');

					$(_event.target).addClass('selected');
					
					var ii;
					var levelArr = document.querySelector('.upgrade_levels').children;
					
					for (var i=0; i < levelArr.length; i++) {
						if(levelArr[i]==target){
							ii=i;
							break;
						}
					};
					
					this.render(null,ii);
					
					console.log($(this.currentLevel).html());
				}
			},
			render:function(_itemDataObj,_i){
			
				if(_itemDataObj){
					this.itemDataObj = _itemDataObj;
				}else{
					_itemDataObj = this.itemDataObj;
				}

				if(!_itemDataObj){
					throw new Error('render arg is null');
				}
				if(!_itemDataObj.hero && !_arg.items){
					throw new Error('arg obj is null');
				}				
				
				var tempObj = {};
				
				var avatar   = _itemDataObj.hero.avatar;
				var itemsObj = _itemDataObj.items[itemIn[_i]];
				var i = 0;
				for(var k in itemsObj){
					if( isNaN(parseInt(k)) ){
						tempObj['item'+(i++)] = itemsObj[k];
					}
				}
				tempObj['heroAvatar'] = avatar;
				
				var t = _.template($("#hero_one").html(), tempObj);
				
				$(this.el).append(t);
				
				this.currentLevel = $('.upgrade_levels .selected')[0];
				
				console.log(tempObj);
			}
		});
		
		HeroView = HeroV;
	}());

	function queryUpgrade(_avatars,_i){
		
		var sendData;
		var objs =  {};
		var iPre = 'h';
		
		for(var i=0;i<_avatars.length;i++){
			var name = _avatars[i].attr('heroName');
			objs[iPre+i] = name;
		}
		sendData = JSON.stringify(objs);
		console.log(sendData);
		
		if(sendData[0]=='{' && sendData[1]=='}'){
			console.log('select none');
		}else{
			$.get('http://localhost/dotalegend/phps2/getHero.php?heroNamesJson='+sendData,function(_data,_info){

				if(_info=='success'){
					console.log(_data);
					if(_data!=null && _data!=''){
						var returnDataObj = JSON.parse(_data);
						for(var k in returnDataObj){
							var h = new HeroView({el:$('.query_window')});
							h.render(returnDataObj[k],_i);
						}
					}
				}else{
					console.log('queryUpgrade fail');
				}
			});
		}
	}
	
	var queryDoes = {
		upgrade:queryUpgrade
	};
	
	var Query = Backbone.Model.extend({

		defaults : {
			main  :null,
			name  : 'query',
			$obj  : $('.query'),
			$objTitle : $('.query .query_title'),
			$window   : $('.query .query_window'),
			$leftto   : $('.query .leftto'),
			fromLeft  : '100%',
			toLeft    : 0
		},
		initialize : function() {
			
			var o = this;

			var $obj      = o.get('$obj');
			var $objTitle = o.get('$objTitle');
			var $window   = o.get('$window');
			var $leftto   = o.get('$leftto');
			
			$window.height($obj.height() - $objTitle.height() - $leftto.height());
			
			console.log($obj.height(),$objTitle.height(),$leftto.height());
			
			$leftto.click(function(){
				o.hide();
			});
			
		},
		queryData:function(){
			
			var $window = this.get('$window');
			var type    = this.get('type');
			var data    = this.get('main').get('heroSelected');
			
			if(queryDoes[type]!=undefined){
				
				$window.html('');
				var p = queryDoes[type].call(this,data,0);
				
			}else{
				throw new Error('queryDoes this type is null');
			}
		},
		show : function(_type){

			var $Obj = this.get('$obj');
			var toLeft = this.get('toLeft');
			
			var p;
			
			this.set({'type':_type});
			
			p = $Obj.animate({
				left:toLeft
			},1000).promise();
			
			p.done(function(){
				
			});
			
			this.queryData();
		},
		hide:function(){

			var $Obj     = this.get('$obj');
			var $window  = this.get('$window'); 
			var fromLeft = this.get('fromLeft');

			$Obj.animate({
				left:fromLeft
			},1000);			
		},
	});
	var q = new Query();
	mainModelObj.add(q,'.ops_test','upgrade');
});
