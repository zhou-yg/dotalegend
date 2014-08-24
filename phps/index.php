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
			min-width: 60px;
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
		</style>
	</head>
	<body>
		<section class="main">
			<h3>hero editor</h3>
			<label>英雄选择 名称:</label>
			<select class="hero_select">
			</select>
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
			</div>
		</section>
	</body>
	<script src="../jquery2x.js"></script>
	<script>
		//init names
		$(function(){
			
			var namesArr = ['火枪','风行','冰女'];
			var $select = $('.hero_select');
			
			namesArr.forEach(function(_el,_i){
				$op = $('<option value='+_el+'>'+_el+'</option>');
				$select.append($op);
			});
		});
		//init avator
		$(function(){
			
			$heroAvator = $('.hero_avator');
			$yourSelect = $('.avator_selected');
			
			for(var i=0;i<=51;i++){(function(_i){
			
					$avatar_li = $('<li></li>').attr('l_index',i);
					$avatar_img = $('<img/>').attr('src','../avatar95/'+i+'_95_95.jpg').attr('m_index',i).attr('width','100%').attr('height','100%');
					$avatar_li.append($avatar_img);
			
					$heroAvator.append($avatar_li);
				})(i);
			}
			$($heroAvator.children()).click(function(){
				$yourSelect.html(this.innerHTML);
			});
		});
		//init equipments
		$(function(){
			
			$heroEquipments = $('.hero_equipments');
			
			for(var i=1;i<=50;i++){(function(_i){
			
					$e_li = $('<li></li>').attr('e_index',i);
					$e_img = $('<img/>').attr('src','../equipments/'+i+'_e.png').attr('m_index',i).attr('width','100%').attr('height','100%');
					$e_li.append($e_img);
			
					$heroEquipments.append($e_li);
				})(i);
			}
		});
	</script>
</html>