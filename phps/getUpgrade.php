<?php
$sqlOp = include'SqlOp.php';

$queryHeroName = $_GET['heroName'];
$isOnlyJSON = $_GET['onlyjson'];

$jsonArray = null;
$heroId = null;
$heroAvatar = null;
$e_b  = null;
$e_b2 = null;
$e_b2 = null;
$e_p  = null;
$e_p1 = null;
$e_p2 = null;
$e_p3 = null;
$e_p4 = null;
$e_o  = null;


$connectResult = $sqlOp->connectTo();
if($connectResult){
	
	$queryHeroResult = $sqlOp->queryTo("select * from hero where name='$queryHeroName' ");
	if($queryHeroResult){
		
		$array = mysql_fetch_array($sqlOp->result);
		if($array){
			
			$heroId = $array['id'];
			$heroAvatar = $array['avatar'];
		}else{
			echo 'heroName: '.$queryHeroName.'<br>';
			echo 'this hero is not existed';
			return;
		}
	}else{
		echo 'query hero fail';
			return;
	}
	//query equipments
	$queryEquipsResult = $sqlOp->queryTo("select * from upgrade where heroId='$heroId' ");
	if($queryEquipsResult){
		
		$array = mysql_fetch_array($sqlOp->result);
		if($array){
			
			$e_b  = $array['blue'];
			$e_b1 = $array['blue1'];
			$e_b2 = $array['blue2'];
			$e_p  = $array['purple'];
			$e_p1 = $array['purple1'];
			$e_p2 = $array['purple2'];
			$e_p3 = $array['purple3'];
			$e_p4 = $array['purple4'];
			$e_o  = $array['orange'];
			
			$e_b  = unserialize($e_b);
			$e_b1 = unserialize($e_b1);
			$e_b2 = unserialize($e_b2);
			$e_p  = unserialize($e_p);
			$e_p1 = unserialize($e_p1);
			$e_p2 = unserialize($e_p2);
			$e_p3 = unserialize($e_p3);
			$e_p4 = unserialize($e_p4);
			$e_o  = unserialize($e_o);
			
			//display
			if($isOnlyJSON != 'yes'){
				echo "<img src='".$heroAvatar."' width='75px'>";
				echo '<br><hr>';
				$allArr = array($e_b,$e_b1,$e_b2,$e_p,$e_p1,$e_p2,$e_p3,$e_p4,$e_o);
				for($i=0;$i<count($allArr);$i++){
				
					$arr = $allArr[$i];
					echo "<img src='../equipments/".$arr['a']."' width='45px'>";
					echo "<img src='../equipments/".$arr['b']."' width='45px'>";
					echo "<img src='../equipments/".$arr['c']."' width='45px'>";
					echo "<img src='../equipments/".$arr['d']."' width='45px'>";
					echo "<img src='../equipments/".$arr['e']."' width='45px'>";
					echo "<img src='../equipments/".$arr['f']."' width='45px'>";
					echo '<br><hr>';
				}
			}
			//------------------------------
			$jsonArray = array(
				'hero'=>array(
					'name'=>$queryHeroName,
					'avatar'=>$heroAvatar
				),
				'equips'=>array(
					'blue'   =>$e_b,
					'blue1 ' =>$e_b1,
					'blue2'  =>$e_b2,
					'purple' =>$e_p,
 					'purple1'=>$e_p1,
					'purple2'=>$e_p2,
					'purple3'=>$e_p3,
					'purple4'=>$e_p4,
					'orange' =>$e_o
				)
			);
			$jsonStr = json_encode($jsonArray);
			echo $jsonStr;
			
		}else{
			echo 'this hero has not data of equipments';	
			return;
		}
	}else{
		echo 'query this hero equips fail';
		return;
	}
}else{
	echo 'connect to db fail';
	return;
}


?>