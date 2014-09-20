<?php
$sqlOp = include '../phps/SqlOp.php';

$heroNamesArr = array(
'coco'=>"船长",
'xiaohei'=>"小黑",
'huonv'=>"火女",
'zues'=>"宙斯", 
'dianhun'=>"电魂", 
'ermowushi'=>"恶魔巫师", 
'tongkunvwang'=>"痛苦女王", 
'ok'=>"全能骑士", 
'xiubujiang'=>"修补匠", 
'sniper'=>"火枪", 
'wr'=>"风行", 
'cm'=>"冰女", 
'xiaonajia'=>"小娜迦", 
'dayuren'=>"大鱼人", 
'chaoxi'=>"潮汐", 
'meidusha'=>"美杜莎", 
'gugong'=>"骨弓", 
'gufa'=>"骨法", 
'kulouwang'=>"骷髅王", 
'silingfa'=>"死灵法师", 
'heiniao'=>"黑鸟", 
'anmu'=>"暗牧", 
'sf'=>"影魔", 
'panda'=>"熊喵酒仙", 
'xiaolu'=>"小鹿", 
'paipai'=>"拍拍熊", 
'lanpan'=>"蓝胖", 
'fuchou'=>"复仇", 
'xiaoniu'=>"神牛", 
'tiny'=>"小小", 
'yueqi'=>"月骑", 
'jugg'=>"剑圣", 
'alex'=>"斧王", 
'chengmo'=>"沉默", 
'baihu'=>"白虎", 
'lich'=>"巫妖", 
'shenling'=>"神灵武士", 
'shuangtou'=>"双头龙", 
'yalong'=>"亚龙", 
'guangfa'=>"光法", 
'feiji'=>"直升机", 
'loa'=>"死骑", 
'dp'=>"死亡先知", 
'am'=>"敌法", 
'jumo'=>"巨魔", 
'gangbei'=>"刚背猪", 
'wlk'=>"术士", 
'jiqiang'=>"机枪兵", 
'renma'=>"人马", 
'shengtang'=>"圣堂刺客", 
'fenghuang'=>"凤凰", 
'invoker'=>"召唤师", 
'houzi'=>"猴子"
);

$json = $_GET['heroNamesJson'];
$json = delete_slash($json);

$dataObj = json_decode($json);

$connectResult = $sqlOp->connectTo();
if($connectResult){
	
	$returnArr = array();
	
	foreach ($dataObj as $key => $heroName) {
		
		$selectResult = $sqlOp->queryTo("select * from hero where name='$heroName' ");
		if($selectResult){
		
			$heroArray = mysql_fetch_array($sqlOp->result);
			if($heroArray){
			
				$heroId = $heroArray['id'];
				$selectUpResult = $sqlOp->queryTo("select * from upgrade where heroId=$heroId ");
				if($selectUpResult){
				
					$upArray = mysql_fetch_array($sqlOp->result);
					if($upArray){
					
						$arr = array(
							$upArray['white'],
							$upArray['green'],
							$upArray['green1'],
							$upArray['blue'],
							$upArray['blue1'],
							$upArray['blue2'],
							$upArray['purple'],
							$upArray['purple1'],
							$upArray['purple2'],
							$upArray['purple3'],
							$upArray['purple4'],
							$upArray['orange']
						);
						$arrLen = count($arr);
						for ($i=0; $i < $arrLen; $i++) {
							$arr[$i] = unserialize($arr[$i]);
						}
						for ($i=0; $i < $arrLen; $i++) {
								 
							$len = count($arr[$i]);
							for ($j=0; $j < $len; $j++) { 
							
								$itemId = $arr[$i][$j];
								
								if($itemId==null){
									break;
								}
							
								$queryItemResult = $sqlOp->queryTo("select * from items where id=$itemId ");
								if($queryItemResult){
								
									$itemArr = mysql_fetch_array($sqlOp->result);
									if($itemArr){
									
										$arr[$i][$j] = $itemArr['prefix'].$itemArr['url'];
									}else{
										echo "$i $j $heroId array null";
									}
								}else{
									echo "$i $j $heroId query fail";
								}
							}
						}
					
						$heroArray = array(
							'name'=>$heroArray['name'],
							'avatar'=>$heroArray['prefix'].$heroArray['avatar'],
						);
						for ($i=0; $i < $arrLen; $i++) {
							 
							$len = count($arr[$i]);
							for ($j=0; $j < $len; $j++) { 
							
								$c = chr(97+$j);
								$arr[$i][$c] = $arr[$i][$j];
							}
						}
						$arr = array(
							'w' =>$arr[0],
							'g' =>$arr[1],
							'g1'=>$arr[2],
							'b' =>$arr[3],
							'b1'=>$arr[4],
							'b2'=>$arr[5],
							'p' =>$arr[6],
							'p1'=>$arr[7],
							'p2'=>$arr[8],
							'p3'=>$arr[9],
							'p4'=>$arr[10],
							'o' =>$arr[11],
						);
					
						$jsonArr = array(
							'hero'=>$heroArray,
							'items'=>$arr
						);
					
						$returnArr[$key] = $jsonArr;
					
					}else{
						echo 'upArr is null';
					}
				}
			}else{
				echo 'hero select null';
			}
		}else{
			echo "hero select fail";
		}
	}
	
	if(count($returnArr)==0){
		echo 'the length of is 0';
	}else{
		echo json_encode($returnArr);
	}
	
}else{
	echo "connect db fail";
}
































?>