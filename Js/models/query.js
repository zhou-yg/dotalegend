$(function(){
	var LevelsView,ItemsView;
	var itemIn = ['w','g','g1','b','b1','b2','p','p1','p2','p3','p4','o'];
	(function(){
		var LevelsV = Backbone.View.extend({
			
			initialize:function(){
				this.allHeroesV = new Object();
						
				console.log('levelsV init');
			},
			events : {
				'click li[type=level]':'doSelect'
			},
			doSelect : function(_event){
				
				var target = _event.target;
				var $allLevels = $('.upgrade_levels');
				var len = $allLevels.children().length;
				var ii=0;
				
				if(target == this.currentLi){
					return;
				}
				
				$('.upgrade_levels .selected').removeClass('selected');
				
				for(var i=0;i<len;i++){
					
					var c = $allLevels.children()[i];
					
					if( c == target){
						ii = i;
						break;
					}
				}
				
				for(var k in this.allHeroesV){
					console.log(k);
					this.allHeroesV[k].render(null,ii);
				}
				
				this.currentLi = $allLevels.children()[ii];
				$(this.currentLi).addClass('selected');
			},
			add : function(_key,_heroV){
				
				this.allHeroesV[_key] = _heroV;
			},
			render : function(){

				$(this.el).html($('#all_levels').html());

				this.currentLi = $('.upgrade_levels').children()[0];
			}		
		});
		var itemsV = Backbone.View.extend({
			
			initialize:function(_obj){
				this.isInit = false;
			},
			render:function(_itemDataObj,_i){
			
				if(_itemDataObj && _itemDataObj!=null){
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
				var o = this;
				//第一次加载模板
				if(_i==0){
				
					(function(){
						
						var tempObj = {};
				
						var name     = _itemDataObj.hero.name;
						var avatar   = _itemDataObj.hero.avatar;
						
						var itemsObj = _itemDataObj.items[itemIn[_i]];
						
						var i = 0;

						tempObj.hero_ident = o.heroIdent; 
						tempObj.hero_avatar = avatar;
						tempObj.hero_name   = name;
						
						for(var k in itemsObj){
							if( isNaN(parseInt(k)) ){
								tempObj['item'+(i++)]  = itemsObj[k];
							}
						}

						console.log(tempObj);
						
						var items = _.template($("#hero_one_items").html(), tempObj);
						$(o.el).append(items);
						
					}());

				}else{
					//后续的加载
					(function(){
						
						var tempObj = {};
						var name     = _itemDataObj.hero.name;
						var avatar   = _itemDataObj.hero.avatar;

						var itemsObj = _itemDataObj.items[itemIn[_i]];
						var i = 0;

						tempObj.hero_id = o.heroIdent; 
						tempObj.hero_avatar = avatar;
						tempObj.hero_name   = name;
						
						for(var k in itemsObj){
							if( isNaN(parseInt(k)) ){
								tempObj['item'+(i++)]  = itemsObj[k];
							}
						}	

						console.log(tempObj);
						
						var items = _.template($('#hero_one_items').html(),tempObj);
						$('#'+o.heroIdent).html(items);
						
					}());
				}
			}
		});
		
		ItemsView = itemsV;
		LevelsView = LevelsV;
	}());

	function queryUpgrade(_avatars,_i){
		
		var sendData;
		var objs =  {};
		var iPre = 'h';
		
		for(var i=0;i<_avatars.length;i++){
			var name = _avatars[i].getAttribute('heroName');
			objs[iPre+i] = name;
		}
		sendData = JSON.stringify(objs);
		
		if(sendData[0]=='{' && sendData[1]=='}'){
			console.log('select none');
		}else{

			dotalegendGet.getHero(sendData,function(_data,_result){

				if(_result=='success'){

					if(_data!=null && _data!=''){

						var levelsV = new LevelsView({el:$('.query_window')});
						//levelsV.allHeroesV = new Object();
						//levelsV.$allLevels = $('.upgrade_levels');
						levelsV.render();
						
						var returnDataObj = _data;
						
						console.log(_data);

						for(var k in returnDataObj){
							
							var h = new ItemsView({el:'.query_window'});
							h.heroIdent = k;
							h.render(returnDataObj[k],_i);
							
							levelsV.add(k,h);
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
