var allWidth = $(document).width();
var allHeight = $(document).height();

var heroSelectedArr = [];
//init
$(function(){

	$('body').height(allHeight);
	$('.main').height(allHeight);
	$('.setting').height(allHeight);;
	$('.hero_query').height(allHeight);
});
//操作
$(function(){
	
	var $set        = $('.setting'); 
	var $opsSetting = $('.main .ops_setting');
	var $set_upto   = $('.setting .set_upto');

	var $test       = $('.window_ops .ops_test');
	var $heroQuery  = $('.hero_query');
	var $leftTo     = $('.hero_query .leftto');
	
	$opsSetting.click(function(){
		$set.animate({
			top:-allHeight
		},1000);
	});
	$set_upto.click(function(){
		$set.animate({
			top:0
		},1000);
	});
	$test.click(function(){
		$heroQuery.animate({
			left:0
		},1000);
	});
	$leftTo.click(function(){
		$heroQuery.animate({
			left:'100%'
		},1000);
	});
});
//设置
$(function(){

	var $set        = $('.setting');
	var $set_title  = $('.main_title');
	var $set_select = $('.setting .set_select');
	var $set_heroes = $('.setting .heroes');
	var $set_upto   = $('.setting .set_upto');

	var isSelected  = false;
	var selectedArr = new Array();
	
	$set_heroes.height(allHeight - $set_title.height() - $set_select.height() - $set_upto.height());
	
	for(var i=0;i<=51;i++){(function(_i){
			
			$avatar_li = $('<li></li>').attr('l_index',i);
			$avatar_img = $('<img>').attr('src','avatar95/'+i+'_95_95.jpg').attr('m_index',i).attr('width','100%').attr('height','100%');
			$avatar_li.append($avatar_img);
			
			$set_heroes.append($avatar_li);
		})(i);
	}
	$($set_heroes.children()).click(function(){
		
		var p = this.children[0].parentElement;
		
		if(!p.style.backgroundColor || p.style.backgroundColor == ''){
			selectedArr.push(p);
			p.style.backgroundColor = '#00FF30';
		}else{
			p.style.backgroundColor = '';
			var arr = [];
			selectedArr.forEach(function(_e){
				if(_e!=p){
					arr.push(_e);
				}
			});
			selectedArr = arr;
		}
		if(!isSelected){
			$('.set_upto').css('backgroundImage','url(up.png)');
			isSelected = !isSelected;
		}
		if(selectedArr.length==0){
			$('.set_upto').css('backgroundImage','url(cancel.png)');
			isSelected=false;
		}
	});

});
//equipments upgrade
$(function(){
	
	var opEquip = $('.ops_equipment');
	
	opEquip.click(function(){
		
		
		
	});
});
