<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>刀塔传奇数据查询</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>	
		<style>
		*{
			margin:0;
			padding:0;
		}
		hr{
			background:#aaaaaa;
			border:none;
			height:5px;
		}
		.main{
			border: solid #7EE67E 2px;
		}
		.hero_select{
			min-width: 80px;
			text-align: center;
		}
		/*-----------------------------*/
		.avator_selected{
			color:#FF0000;
			width:100px;
			height:100px;
			display: inline-block;
		}
		.hero_avator{
			width: 100%;
		}
		.hero_avator li{
			list-style: none;
			width: 80px;
			height: 80px;
			display: inline-block;
		}
		/*--------------------------*/
		.hero_equipments{
			width: 100%;
		}
		.hero_equipments li{
			list-style: none;
			width: 50px;
			height: 50px;
			display: inline-block;
		}
		.current_level{
			min-width: 80px;
			text-align: center;
		}
		.levels .theE{
			height: 40px;
			display: inline-block;
		}
		</style>
	</head>
	<body>
		<section class="main">
			<h3>hero editor</h3>
			<label>英雄选择 名称:</label>
			<select class="hero_select"></select>
			<hr />
			<div>
				<label>英雄选择 头像:</label>
				<span class="avator_selected"></span>
				<ul class="hero_avator">
				</ul>
			</div>
			<hr />
			<div>
				<label>英雄选择 进阶装备:</label>
				<ul class="hero_equipments"></ul>
				<span>为当前的等级选择装备:</span>
				<select class="current_level">
					<option value="0" selected="true">蓝</option>
					<option value="1">蓝+1</option>
					<option value="2">紫</option>
					<option value="3">紫+1</option>
					<option value="4">紫+2</option>
					<option value="5">紫+3</option>
					<option value="6">紫+4</option>
					<option value="7">橙</option>
				</select>
				<ul class="levels">
					<li id='blue'>
						蓝色__:<span class="theE"></span>
					</li>
					<li id='blue1'>
						蓝色+1:<span class="theE"></span>
					</li>
					<li id='purple'>
						紫色__:<span class="theE"></span>
					</li>
					<li id='purple1'>
						紫色+1:<span class="theE"></span>
					</li>
					<li id='purple2'>
						紫色+2:<span class="theE"></span>
					</li>
					<li id='purple3'>
						紫色+3:<span class="theE"></span>
					</li>
					<li id='purple4'>
						紫色+4:<span class="theE"></span></li>
					<li id='orange'>
						橙色__:<span class="theE"></span>
					</li>
				</ul>
			</div>
		</section>
	</body>
	<script src="../jquery2x.js"></script>
	<script>
		var heroName;
		var heroAvatorUrl;
		var equipmentsArr;
		//init names
		$(function(){
			
			var namesArr = ['火枪',
			'风行',
			'冰女',
			'娜迦',
			'大鱼',
			'潮汐',
			'美杜莎',
			'骨弓',
			'古法',
			'骷髅王',
			'船长',
			'死灵法',
			'黑鸟',
			'巫医',
			'影魔',
			'熊猫',
			'小鹿',
			'拍拍',
			'食人魔法师',
			'复仇',
			'小牛',
			'小黑',
			'小小',
			'露娜',
			'剑圣',
			'斧王',
			'沉默',
			'米拉娜',
			'巫妖',
			'单车',
			'双头龙',
			'毒龙',
			'火女',
			'光老头',
			'飞机',
			'死骑',
			'dp',
			'敌法师',
			'巨魔',
			'刚被猪',
			'术士',
			'星际机枪兵',
			'宙斯',
			'人马',
			'圣堂刺客',
			'凤凰',
			'祈求着',
			'电魂',
			'恶魔巫师',
			'痛苦女王',
			'全能骑士',
			'修补匠'];
			var $select = $('.hero_select');
			
			namesArr.forEach(function(_el,_i){
				$op = $('<option value='+_el+'>'+_el+'</option>');
				$select.append($op);
			});
			
			$select.on('change',function(){
				heroName = parseInt( $(this[this.selectedIndex]).val() );
			});
		});
		//init avator
		$(function(){
			
			var $heroAvator = $('.hero_avator');
			var $yourSelect = $('.avator_selected');
			var $selectedAvator;
			
			for(var i=0;i<=51;i++){(function(_i){
			
					$avatar_li = $('<li></li>').attr('l_index',i);
					$avatar_img = $('<img/>').attr('src','../avatar95/'+i+'_95_95.jpg').attr('m_index',i).attr('width','100%').attr('height','100%');
					$avatar_li.append($avatar_img);
			
					$heroAvator.append($avatar_li);
				})(i);
			}
			$($heroAvator.children()).click(function(){
				
				$selectedAvator = $(this.innerHTML);
				heroAvatorUrl = $selecedAavator.attr('src');
				
				$yourSelect.html($selectedAvator);
			});
		});
		//init equipments
		$(function(){
			
			var levelArr = ['#blue','#blue1','#purple','#purple1','#purple2','#purple3','#purple4','#orange'];
			var equipArr = [[],[],[],[],[],[]];

			var $heroEquipments = $('.hero_equipments');
			var $currentLevel = $('.current_level');
			
			var currentSelectObjId = levelArr[0];
			var currentEquipArr = equipArr[0];

			equipmentsArr = equipArr;
			
			$currentLevel.on('change',function(){
				
				var index = parseInt( $(this[this.selectedIndex]).val() );
				if(!isNaN(index)){
					
					currentSelectObjId = levelArr[index];
					currentEquipArr = equipArr[index];
					
				}else{
					throw new Error('can not get the selected current_level');
				}
			});
			
			
			for(var i=0;i<=230;i++){(function(_i){
			
					$e_li = $('<li></li>').attr('e_index',i);
					$e_img = $('<img/>').attr('src','../equipments/'+i+'_e.png').attr('m_index',i).attr('width','100%').attr('height','100%');
					$e_li.append($e_img);
			
					$heroEquipments.append($e_li);
				})(i);
			}
			
			$($heroEquipments.children()).click(function(){
				
				var $theE  = $(currentSelectObjId + ' .theE');
				var children = $theE.children();
				
				var $e = $(this.innerHTML).attr('width','40px').attr('height','40px');
				
				var l = children.length;
				if(l ==6){

					currentEquipArr[0] = $e.attr('m_index');

					$theE.html($e);
					
				}else if(l<6){

					currentEquipArr[l] = $e.attr('m_index');
					currentEquipArr[0] = $e.attr('m_index');

					$theE.append($e);
				}
			});
		});
		function logInfo(){
			console.log('heroName:',heroName);
			console.log('heroAvatorUrl:',heroAvatorUrl);
			console.log('equipmentsArr:',equipmentsArr);
		}
	</script>
</html>