$(function() {
	
	var heroNames = ["船长", "小黑", "火女", "宙斯", "电魂", "恶魔巫师", "痛苦女王", "全能骑士", "修补匠", "火枪", "风行", "冰女", "小娜迦", "大鱼人", "潮汐", "美杜莎", "骨弓", "骨法", "骷髅王", "死灵法师", "黑鸟", "暗牧", "影魔", "熊喵酒仙", "小鹿", "拍拍熊", "蓝胖", "复仇", "神牛", "小小", "月骑", "剑圣", "斧王", "沉默", "白虎", "巫妖", "神灵武士", "双头龙", "亚龙", "光法", "直升机", "死骑", "死亡先知", "敌法", "巨魔", "刚背猪", "术士", "机枪兵", "人马", "圣堂刺客", "凤凰", "召唤师", "猴子"];
	
	var Setting = Backbone.Model.extend({

		defaults : {
			main:null,
			name : 'setting',
			obj : $('.setting'),
			$set_title : $('.main_title'),
			$set_select : $('.setting .set_select'),
			$set_heroes : $('.setting .heroes'),
			$set_upto : $('.setting .set_upto'),
			fromTop:0,
			toTop:-$(window).height()
		},
		initialize : function() {

			var o = this;
			var $set_title = o.get('$set_title');
			var $set_select = o.get('$set_select');
			var $set_heroes = o.get('$set_heroes');
			var $set_upto = o.get('$set_upto');

			var dfd = new $.Deferred();
			dotalegendGet.getAllHeroes(function(_data, _result){
				
				console.log(_data,_result);

				if (_result == 'success') {
					
					var allHeroObj = _data;
					
					var isSelected  = false;
					var selectedArr = new Array();
					var i=0;

					$set_heroes.height(allHeight - $set_title.height() - $set_select.height() - $set_upto.height());
			
					for (var one in allHeroObj) {

						var obj = allHeroObj[one];

						var $avatar_li = $('<li></li>').attr('l_name', obj.avatar);
						var $avatar_img = $('<img>').attr('heroName',heroNames[i++]).attr('src', obj.pre + obj.avatar).attr('width', '100%').attr('height', '100%');
						$avatar_li.append($avatar_img);

						$set_heroes.append($avatar_li);
					}
					$($set_heroes.children()).click(function() {

						var img = this.children[0];
						var l   = img.parentElement;
						
						img = $(img);
						
						if (!l.style.backgroundColor || l.style.backgroundColor == '') {
							selectedArr.push(img);
							l.style.backgroundColor = '#7EE67E';
						} else {
							var i;
							l.style.backgroundColor = '';
							i =selectedArr.indexOf(img);
							
							if(i!=-1){
								selectedArr.splice(i,1);
							}
						}
						if (!isSelected) {
							$('.set_upto').css('backgroundImage', 'url(Public/image/up.png)');
							isSelected = !isSelected;
						}
						if (selectedArr.length == 0) {
							$('.set_upto').css('backgroundImage', 'url(Public/image/cancel.png)');
							isSelected = false;
						}
					});
					$set_upto.click(function(){
						o.hide(selectedArr);
					});
					dfd.resolve();
				} else {
					throw new Error('setting getAllHeroes fail');
				}
			});
			dfd.done(function() {
				
			});
		},
		show : function(){
			
			var $Obj = this.get('obj');
			var toTop = this.get('toTop');

			$Obj.animate({
				top:toTop
			},1000);
		},
		hide : function(_arg){
			
			var $Obj = this.get('obj');
			var fromTop = this.get('fromTop');

			var m = this.get('main');
			m.set({heroSelected:_arg});

			$Obj.animate({
				top:fromTop
			},1000);
		},
		add : function(_model, _opClass) {

		}
	});
	var setting = new Setting();
	mainModelObj.add(setting,'.ops_setting');
});
