<?php
$sqlOp = include '../phps/SqlOp.php';

$heroNames = array("船长", "小黑", "火女", "宙斯", "电魂", "恶魔巫师", "痛苦女王", "全能骑士", "修补匠", "火枪", "风行", "冰女", "小娜迦", "大鱼人", "潮汐", "美杜莎", "骨弓", "骨法", "骷髅王", "死灵法师", "黑鸟", "暗牧", "影魔", "熊喵酒仙", "小鹿", "拍拍熊", "蓝胖", "复仇", "神牛", "小小", "月骑", "剑圣", "斧王", "沉默", "白虎", "巫妖", "神灵武士", "双头龙", "亚龙", "光法", "直升机", "死骑", "死亡先知", "敌法", "巨魔", "刚背猪", "术士", "机枪兵", "人马", "圣堂刺客", "凤凰", "召唤师", "猴子");
$heroNamesLen = count($heroNames);

$url = 'http://d.longtugame.com/daotadata/allhero';
$htmls = file_get_contents($url);
$heroRexp = '/<img src="http:\/\/(d.)?longtugame.com\/uploadimg\/dotaData\/hero\/pic2\/[0-9]{0,2}.jpg"[\s\S]{0,5}alt[\s\S]{0,10}>/';
$c = preg_match_all($heroRexp, $htmls,$m);

$heroPreArr;
$heroUrlArr;
$heroArrLen;

if($c!=0){
		
	$heroArr = $m[0];
	$heroArrLen = count($heroArr);
	
	for ($hi=0; $hi < $heroArrLen; $hi++) {
		
		$img = $heroArr[$hi];
		
		$srcBegin = strpos($img, 'src="')+5;
		$srcEnd = strpos($img, 'jpg')+3;
		
		$src = substr($img, $srcBegin,$srcEnd-$srcBegin);	 
		
		$srcBegin = strrpos($src, '/')+1;
		$srcEnd = strrpos($src, '.jpg');
		
		$pre = substr($src, 0,$srcBegin);
		$name = substr($src, $srcBegin,$srcEnd-$srcBegin);

		$heroPreArr[$hi] = $pre;
		$heroUrlArr[$hi] = intval($name);
	}
	//快速排序
	function quickSort(&$arr,$s,$e,&$arr2){
		if($s<$e){
				
			$a = $s;
			$b = $e;
			$x = $arr[$s];
			$x2 = $arr2[$s];

			while($a<$b){

				while($a<$b && $arr[$b]>=$x){
					$b--;
				}
				if($a<$b){
					$arr[$a++] = $arr[$b];
					$arr2[$a] = $arr2[$b];
				}
				while($a<$b && $arr[$a]<$x){
					$a++;
				}
				if($a<$b){
					$arr[$b--] = $arr[$a];
					$arr2[$b] = $arr2[$a];
				}
			}
			$arr[$a] = $x;
			$arr2[$a] = $x2;
			
			quickSort($arr, $s, $a-1,$arr2);
			quickSort($arr, $a+1, $e,$arr2);
		}
	}	
	$s = quickSort($heroUrlArr, 0, count($heroUrlArr)-1,$heroPreArr);
	
	print_r($heroUrlArr);
	
	for ($i=0; $i < $heroArrLen; $i++) { 
		$heroUrlArr[$i] = $heroUrlArr[$i].'.jpg';
	}
	for ($i=0; $i < $heroArrLen; $i++) {
		echo '<img src="'.$heroPreArr[$i].$heroUrlArr[$i].'">'.'<br>';
	}
		
}else{
	echo "$c search find 0";
}


$connectResult = $sqlOp->connectTo();
if($connectResult){
	
	for ($i=0; $i < $heroArrLen; $i++) { 
		
		$insertResult = $sqlOp->queryTo("insert into hero values(null,'$heroNames[$i]','$heroPreArr[$i]','$heroUrlArr[$i]')");
		if($insertResult){
			echo "$i insert hero success".'<br>';
		}else{
			echo "$i insert hero fail".'<br>';
		}
	}
	
}else{
	echo 'connect db fail'.'<br>';
}

?>