$(function(){
	var LevelsView,ItemsView;
	var GoldView,AdjustAction;
	var itemIn = ['w','g','g1','b','b1','b2','p','p1','p2','p3','p4','o'];
	//进阶的查询View
	(function(){
		var LevelsV = Backbone.View.extend({
			
			initialize:function(){
				this.allHeroesV = new Object();
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
			createItemImg:function(_src){
				return '<img src='+_src+' width="100%">';
			}
			,
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
				
				(function(){

					var tempObj = {};
				
					var name     = _itemDataObj.hero.name;
					var avatar   = _itemDataObj.hero.avatar;

					var itemsObj;
					
					var i = 0;
					
					if(_i==-1){
						//第一次加载模板
						container = $(o.el);
						itemsObj = _itemDataObj.items[itemIn[_i+1]];

					}else{
						//后续的加载
						container = $('#'+o.heroIdent);
						itemsObj = _itemDataObj.items[itemIn[_i]];
					}

					tempObj.hero_ident = o.heroIdent; 
					tempObj.hero_avatar = avatar;
					tempObj.hero_name   = name;
						
					for(var k in itemsObj){
						if( isNaN(parseInt(k)) ){
							tempObj['item'+(i++)]  = itemsObj[k]?o.createItemImg(itemsObj[k]):null;
						}
					}

					var items = _.template($("#hero_one_items").html(), tempObj);					
					
					if(_i==-1){
						$(o.el).append(items);
					}else{
						$('#'+o.heroIdent).html(items);
					}
				}());
			}
		});
		
		ItemsView = itemsV;
		LevelsView = LevelsV;
	}());
	//金币的查询View
	(function(){

		var GoldV = Backbone.View.extend({
			initialize:function(){
			},
			events : {
				'mousedown .ability_one_bar,.ability_one_bar_button':'downBtn',
				'mousemove .ability_one_bar,.ability_one_bar_button':'moveBtn',
			},
			downBtn:function(_e){
				if(this.containerId === _e.target.parentNode.id || this.containerId === _e.target.parentNode.parentNode.id){

					this.preX = _e.pageX - this.barLeft;
					
					this.isDown = true;
				}
			},
			moveBtn:function(_e){
				
				if( this.containerId === _e.target.parentNode.id && this.isDown ){
					
					var currentX = _e.pageX - this.barLeft;

					this.goTolvl(currentX);
				
				}else if(this.containerId === _e.target.parentNode.parentNode.id && this.isDown){

					var currentX = _e.pageX - this.barLeft;

					this.goTolvl(currentX);
				}
			},
			goTolvl:function(_currentX,_lvl){
				
				if(!this.singleWidth){
					
					var btnW = this.$btn.width();
					var barW = $(this.$btn.parents()[0]).width();
					
					this.singleWidth = (barW-btnW)/90;
				}
				var lvlNum,btnX;
				var basiclvl = parseInt($('.ab_basiclvl').text());

				if(_lvl){
					lvlNum = _lvl;
				}else{
					lvlNum = parseInt(_currentX/this.singleWidth);
				}
				btnX   = lvlNum*this.singleWidth;

				if(lvlNum<=90 && lvlNum>=basiclvl){
					
					this.$btn.text(lvlNum);
					this.$btn.css('left',btnX);
				}
			}
			,
			remove : function(){
				$('#'+this.containerId).remove();
			}
			,
			render : function(_i){
				var temp;
				var id = 'a'+_i;
				
				this.containerId = id;
				
				if(_i==0){
					temp = _.template($("#hero_ability_header").html(), {ability_nums:this.nums});
					$(this.el).append(temp);
				}
				temp = _.template($("#hero_ability_one").html(), {ability_id:id});
				$(this.el).append(temp);
				
				this.$btn = $('#'+id+' '+'.ability_one_bar_button');
			}				
		});
		var AdjustAbilityR = Backbone.Router.extend({
			initialize:function(){
			},
			routes:{
				'ability/:id/:dir':'clickOn',
				'basiclvl':'setBasiclvl',
				'numReduce':'setNumReduce',
				'numAdd':'setNumAdd'
			},
			clickOn:function(_id,_dir){

				var btn = $('#'+_id+' '+'.ability_one_bar_button');
				
				if(_dir==='plus'){
					this.abilityAdjust(btn,1);
				}
				if(_dir==='reduce'){
					this.abilityAdjust(btn,-1);
				}
			},
			setBasiclvl:function(){
				
				var toBasiclvl = prompt('设定一个起始等级');
				
				if(toBasiclvl!==null||toBasiclvl!==""){
					
					toBasiclvl = parseInt(toBasiclvl);
					if(!isNaN(toBasiclvl)){
						
						this.goldBarArr.forEach(function(_el){
							_el.goTolvl(null,toBasiclvl);
						});

						$('.gold_request_nums').text(0);
					}
					
					$('.ab_basiclvl').text(toBasiclvl);
						
				}else{

				}
				location.href = location.href+'#';
			}
			,
			setNumReduce:function(){
				
				var obj = this.goldBarArr.pop();
				if(obj){
					
					obj.remove();
					$('.gold_ops span').text(this.goldBarArr.length);
					
					var currentGold = parseInt($('.gold_request_nums').text());
					
					var basiclvl = parseInt($('.ab_basiclvl').text());
				}
				location.href = location.href+'#';
			}
			,
			setNumAdd:function(){

				var basiclvl = parseInt($('.ab_basiclvl').text());
				
				var abilityOne = new GoldView({el:'.query_window'});
			
				abilityOne.render(this.goldBarArr.length+1);
				
				if(this.goldBarArr[0]){
					abilityOne.barLeft = this.goldBarArr[0].barLeft;
				}else{
					abilityOne.barLeft = $('.ability_one_bar').offset().left;
				}
				
				this.goldBarArr.push(abilityOne);
				
				abilityOne.goTolvl(null,basiclvl);
				
				$('.gold_ops span').text(this.goldBarArr.length);
				
				location.href = location.href+'#';
			}
			,
			abilityAdjust:function(_btn,_direction){
				
				var btnW = _btn.width();
				var barW = $(_btn.parents()[0]).width();
				var left = parseInt(_btn.css('left').substring(0,_btn.css('left').length-2));
				var singleWidth = (barW-btnW)/90;

				var lvl = parseInt(_btn.text())+1*_direction;
				var basiclvl = parseInt($('.ab_basiclvl').text());

				var gold;

	
				location.href = location.href+'#';
	
				if(lvl<basiclvl){
					return;
				}

				if(_direction>0){
					gold = setGold(lvl);
				}else{
					gold = setGold(lvl+1);
				}
				
				var currentGold = parseInt($('.gold_request_nums').text());

				if(_direction==1){
					if(left+btnW<barW ){
						_btn.css('left','+='+singleWidth+'px');
					}
				}
				if(_direction==-1){
					if(left>0 ){
						_btn.css('left','-='+singleWidth+'px');
					}
				}
				_btn.text(lvl);
				
				$('.gold_request_nums').text(currentGold+gold*_direction);
			},
		});
		
		AdjustAction = AdjustAbilityR;
		GoldView = GoldV;
		
	}());
	function setGold(_lvl,_isInit){
		var i,gold=0;
		if(_isInit){
			i=1;
		}else{
			i=_lvl;
		}
		for(;i<=_lvl;i++){
			var everyG;
			if(i<=1){
				everyG = 100;
			}else if(i<=41){
				everyG = (i-1)*500;
			}else{
				everyG = 20000 + (i-40)*1000;
			}
			gold += everyG;
		}
		return gold;
	}
	function queryUpgrade(_selectedHeroes,_i){
		
		var sendData;
		var objs =  {};
		var iPre = 'h';
		
		$('.query .query_title').text('英雄进阶');
		
		for(var i=0;i<_selectedHeroes.length;i++){
			var name = _selectedHeroes[i].getAttribute('heroName');
			objs[iPre+i] = name;
		}
		sendData = JSON.stringify(objs);
		
		if(sendData[0]=='{' && sendData[1]=='}'){
			throw new Error('select none');
		}else{
			//进阶等级选择
			var levelsV = new LevelsView({el:$('.query_window')});
			levelsV.render();
			
			dotalegendGet.getHero(sendData,function(_data,_result){

				if(_result=='success'){

					if(_data!=null && _data!=''){

						$('.upgrade_levels .heroes_loading').hide();

						var returnDataObj = _data;
						
						for(var k in returnDataObj){
							
							var h = new ItemsView({el:'.query_window'});
							h.heroIdent = k;
							h.render(returnDataObj[k],_i);
							
							levelsV.add(k,h);
						}
					}
				}else{
					throw new Error('queryUpgrade fail');
				}
			});
		}
	}
	function goldPlus(_heroes,_i){

		var goldBarArr = [];
		
		$('.query .query_title').text('金币');
		
		for(var i=0,len=_heroes.length?_heroes.length:1;i<len;i++){
			
			var abilityOne = new GoldView({el:'.query_window'});
			if(i==0){
				abilityOne.nums = len;
			}
			
			abilityOne.render(i);
			abilityOne.barLeft = $('.ability_one_bar').offset().left;
			
			goldBarArr.push(abilityOne);
		}
		
		$('.query').on('mouseup',function(){

			var basiclvl = parseInt($('.ab_basiclvl').text());
			var basicGold = setGold(basiclvl,true);
			var currentAllGold = 0;
			
			goldBarArr.forEach(function(_el){
				
				if(_el.$btn){
					
					var lvl = parseInt(_el.$btn.text());
					if(!isNaN(lvl)){
						
						currentAllGold += (setGold(lvl,true) - basicGold);
						
					}else{
						throw new Error('lvl is not a number');
					}
				}
				_el.isDown = false;
			});
			
			$('.gold_request_nums').text(currentAllGold);
		});
		
		$('.query_window h3 span').text(len);
		
		var aa = new AdjustAction();
		aa.goldBarArr = goldBarArr;
		Backbone.history.start();
		
	};
	var queryDoes = {
		upgrade:queryUpgrade,
		goldplus:goldPlus
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
				var p = queryDoes[type].call(this,data,-1);
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
	mainModelObj.add(q,'.ops_equipment','upgrade');
	mainModelObj.add(q,'.ops_gold','goldplus');
});
