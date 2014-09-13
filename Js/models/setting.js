(function() {

	var Setting = Backbone.Model.extend({

		defaults : {
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
			$.get('http://localhost/dotalegend/phps2/getAllHeroes.php', function(_data, _result) {

				if (_result == 'success') {

					var allHeroObj = JSON.parse(_data);
					
					var isSelected  = false;
					var selectedArr = new Array();

					$set_heroes.height(allHeight - $set_title.height() - $set_select.height() - $set_upto.height());
			
					for (var one in allHeroObj) {

						var obj = allHeroObj[one];

						var $avatar_li = $('<li></li>').attr('l_name', obj.avatar);
						var $avatar_img = $('<img>').attr('src', obj.pre + obj.avatar).attr('width', '100%').attr('height', '100%');
						$avatar_li.append($avatar_img);

						$set_heroes.append($avatar_li);
					}
					$($set_heroes.children()).click(function() {

						var p = this.children[0].parentElement;

						if (!p.style.backgroundColor || p.style.backgroundColor == '') {
							selectedArr.push(p);
							p.style.backgroundColor = '#7EE67E';
						} else {
							p.style.backgroundColor = '';
							
							var i =selectedArr.indexOf(p);
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
						o.hide();
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
		hide : function(){
			var $Obj = this.get('obj');
			var fromTop = this.get('fromTop');

			$Obj.animate({
				top:fromTop
			},1000);
		},
		add : function(_model, _opClass) {

		}
	});
	var setting = new Setting();
	mainObj.add(setting,'.ops_setting');
}());
