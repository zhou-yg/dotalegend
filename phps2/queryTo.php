<?php
$heroId = array("船长", "小黑", "火女", "宙斯", "电魂", "恶魔巫师", "痛苦女王", "全能骑士", "修补匠", "火枪", "风行", "冰女", "小娜迦", "大鱼人", "潮汐", "美杜莎", "骨弓", "骨法", "骷髅王", "死灵法师", "黑鸟", "暗牧", "影魔", "熊喵酒仙", "小鹿", "拍拍熊", "蓝胖", "复仇", "神牛", "小小", "月骑", "剑圣", "斧王", "沉默", "白虎", "巫妖", "神灵武士", "双头龙", "亚龙", "光法", "直升机", "死骑", "死亡先知", "敌法", "巨魔", "刚背猪", "术士", "机枪兵", "人马", "圣堂刺客", "凤凰", "召唤师", "猴子");

$htmlTexts = '<a href="/daotadata/equipment?id=11"><b style="background:url(/static/510006-dota/images/data/white3.png) no-repeat;" onMouseOver="position(this,11,50)" onmouseout="hide()"></b><img src="http://d.longtugame.com/uploadimg/dotaData/equipment/pic/11.png "></a>';


$url = 'http://d.longtugame.com/daotadata/hero?id=1';
$html = file_get_contents($url);
$htmlTexts = htmlentities($html, ENT_NOQUOTES, 'UTF-8');
echo $htmlTexts;
$htmlTexts = $html;
echo "<br>||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||<br>";
//<img src="http://d.longtugame.com/uploadimg/dotaData/equipment/pic/2.png">
//<img src="http://longtugame.com/uploadimg/dotaData/equipment/pic/219.png">
$pattern = '/<img src="http:\/\/(d.)?longtugame.com\/uploadimg\/dotaData\/equipment\/pic\/[0-9]*.png[\s\S]?[\s\S]?">/';

$count = preg_match_all($pattern, $htmlTexts,$m);
echo 'count:'.$count.'<br>';
echo 'countLeng:'.count($m[0]).'<br>';

$f = FALSE;
$t = '_';

for ($i=0; $i < count($m[0]); $i++) {
	for ($j=0; $j < strlen($m[0][$i]); $j++) {
		$s = $m[0][$i][$j];
		if($s==' '){
			echo $t;
			$f = TRUE;
		}else{
			if($f){
				echo $t;
				$f = FALSE;
			}else{
				echo ' ';
			}
			echo $s;
		}
	}
	echo "<br>--------------------------------$i------------------------------<br>";
}

?>