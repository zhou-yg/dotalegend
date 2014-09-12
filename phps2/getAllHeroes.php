<?php
$sqlOp = include '../phps/SqlOp.php';

$heroArr;

$connectTo = $sqlOp->connectTo();
if($connectTo){
	
	
	$queryResult = $sqlOp->queryTo('select * from hero');
	if($queryResult){
		
		$i=0;
		$j=0;
		$array = mysql_fetch_array($sqlOp->result);
		while($array){
			
			$len = intval($i++/26);
			$c = chr(97+($j++%26));
			
			for ($k=0; $k < $len; $k++) { 
				$c = chr(97+(($len-1)%26)).$c;
			}

			$heroArr[$c] = array(
				'name'=>$array['name'],
				'avatar'=>$array['prefix'].$array['avatar']
			);
			
			$array = mysql_fetch_array($sqlOp->result);
		}
		
		echo json_encode($heroArr);
		
	}else{
		echo "query fail";
	}
}else{
	echo "connect db fail";
}
?>