<?php
//插入或更新数据库中的装备信息，从equipments文件夹
$sqlOp = include'SqlOp.php';

$connectResult = $sqlOp->connectTo();
if($connectResult){
		
	$queryResult = $sqlOp->queryTo('select * from equipment');
	if($queryResult){
		
		$array = mysql_fetch_array($sqlOp->result);
		if($array){
			for($i=0;$i<count($array);$i++){
				
				echo $array[$i]['url'];
			}
		}else{
			echo 'no data';
		}
	}else{
		echo 'query fail';
	}
	echo '<br>';
	//----------------------------------------------
	$itemPre = 0;
	$itemPost = '_e.png';
	$itemAllNum = 231;
	
	for($i=0;$i<$itemAllNum;$i++){
		
		$itemName = $i.$itemPost;
		$id = $i+1;
		$level = 0;
		$name = $itemName;
		$url = '../equipments/'.$name;

		$updateResult = $sqlOp->queryTo('update equipment set url="'.$url.'" where id='.$id);
		if($updateResult){
			echo $i.' success'.'<br>';
		}
	}
	
}else{
	echo 'connect failed';
}
?>