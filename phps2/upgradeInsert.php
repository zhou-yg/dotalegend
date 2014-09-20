<?php
$sqlOp = include '../phps/SqlOp.php';
$heroNames = array("船长", "小黑", "火女", "宙斯", "电魂", "恶魔巫师", "痛苦女王", "全能骑士", "修补匠", "火枪", "风行", "冰女", "小娜迦", "大鱼人", "潮汐", "美杜莎", "骨弓", "骨法", "骷髅王", "死灵法师", "黑鸟", "暗牧", "影魔", "熊喵酒仙", "小鹿", "拍拍熊", "蓝胖", "复仇", "神牛", "小小", "月骑", "剑圣", "斧王", "沉默", "白虎", "巫妖", "神灵武士", "双头龙", "亚龙", "光法", "直升机", "死骑", "死亡先知", "敌法", "巨魔", "刚背猪", "术士", "机枪兵", "人马", "圣堂刺客", "凤凰", "召唤师", "猴子");

$num = count($heroNames);

$connectResult = $sqlOp->connectTo();

if($connectResult){
	for ($hi=0; $hi < $num; $hi++) { 
	
		$heroName = $heroNames[$hi];
		
		$url = 'http://d.longtugame.com/daotadata/hero?id='.$hi;
		
		$texts = file_get_contents($url);
		$itemRexp = '/<img src="http:\/\/(d.)?longtugame.com\/uploadimg\/dotaData\/equipment\/pic\/[0-9]*.png[\s\S]?[\s\S]?">/';
		
		$count = preg_match_all($itemRexp, $texts,$m);
		
		if($count!=0){
			
			$equipArr = $m[0];
			$equipArrLen = count($equipArr);
			
			$equipIdArr = array();
			
			for ($ei=0; $ei < $equipArrLen; $ei++) {
				 
					$str = $equipArr[$ei];
				
	
					$srcBegin = strpos($str, 'src="') + 5;
					$srcEnd = strripos($str, '"');
	
					$imgSrc = substr($str, $srcBegin,$srcEnd - $srcBegin);

					$preEnd = strripos($imgSrc, '/')+1;

					$srcPre = substr($imgSrc, 0,$preEnd);	
					$name = substr($imgSrc, $preEnd,strlen($imgSrc));
					if($name[strlen($name)-1]!='g'){
						$name = substr($name, 0,strlen($name)-1);
					}
					
					$isEquipExistedResult = $sqlOp->queryTo("select * from items where url='$name' ");
					if($isEquipExistedResult){
						
						$arr = mysql_fetch_array($sqlOp->result);
						
						if($arr){
							$equipIdArr[$ei] = $arr[0];
						}else{
							
							$itemInserResult = $sqlOp->queryTo("insert into items values(null,null,null,null,'$srcPre','$name')");
							if($itemInserResult){
								
								$queryLastIdResult = $sqlOp->queryTo('select last_insert_id() from items');
								if($queryLastIdResult){
									$lastArr = mysql_fetch_array($sqlOp->result);
									if($lastArr){
										$equipIdArr[$ei] = $lastArr[0];
									}else{
										echo "$hi lastArr null".'<br>';
									}
									
								}else{
									echo "$hi queryLastIdResult fail".'<br>';
								}
							}else{
								echo "$hi itemInserResult fail".'<br>';
							}
						}
					}else{
						echo '$hi isEquipExistedResult fail'.'<br>';
					}
			}
			echo "<span style='color:red;'>$hi</span> : ";
			print_r($equipIdArr);
			print_r($equipArr);
			
			$upGradeArr;
			$upGradeChildArr;
			$equipIdArrLen = count($equipIdArr);
			echo "<br>---------$equipIdArrLen-------------<br>";
			for ($eii=0; $eii < $equipIdArrLen; $eii++) {
				 
				$i = intval($eii/6);
				$ii = $eii%6;
				
				if( $ii==0 && $eii!=0 ){
					$upGradeArr[$i-1] = $upGradeChildArr;
					$upGradeChildArr[$ii] = $equipIdArr[$eii];
				}else{
					$upGradeChildArr[$ii] = $equipIdArr[$eii];
				}
				if($eii == $equipIdArrLen-1){

					$last = $equipArrLen%6;
					
					if($last){
						$upGradeChildArr[$last] = null;
					}
					$upGradeArr[$i] = $upGradeChildArr;
				}
			}
			
			$upGradeArrLen = count($upGradeArr);
			for ($ui=0; $ui < $upGradeArrLen; $ui++) {
				echo '等级'.$ui.': ';
				print_r($upGradeArr[$ui]);
				echo "<br>"; 
				$upGradeArr[$ui] = serialize($upGradeArr[$ui]);
			}
			
			$insertGradeStr = "insert into upgrade values(null,$hi";
			for ($ui=0; $ui < $upGradeArrLen; $ui++) { 
				$insertGradeStr = $insertGradeStr.",'$upGradeArr[$ui]'";
			}
			$insertGradeStr = $insertGradeStr.')';
			
			echo '<br>'."$insertGradeStr".'<br>';
			
			$gradeInsertResult = $sqlOp->queryTo($insertGradeStr);
			if($gradeInsertResult){
				echo "$hi grade insert success".'<br>';
			}else{
				echo "$hi gradeInsertResult fail".'<br>';
			}
			
		}else{
			echo "$hi search find 0".'<br>';
		}
	}
}else{
	echo 'connect fail';
}


?>