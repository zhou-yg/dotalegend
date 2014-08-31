<?php
$sqlOp = include'SqlOp.php';

$jsonData = $_POST['data'];
$jsonData = delete_slash($jsonData);
$jsonObj = json_decode($jsonData);

$nameObj = $jsonObj->name;
$avatarObj = $jsonObj->avatar;
$equipsObj = $jsonObj->equips;

//----------------------------
$name = $nameObj->name;
$avatar = $avatarObj->avatar;

//levels:b,b1,p,p1.p2,p3,p4,o
//slot:a,b,c,d,e,f
$e_b = Array(
	'a'=>$equipsObj->b->a,
	'b'=>$equipsObj->b->b,
	'c'=>$equipsObj->b->c,
	'd'=>$equipsObj->b->d,
	'e'=>$equipsObj->b->e,
	'f'=>$equipsObj->b->f,
);
$e_b1 = Array(
	'a'=>$equipsObj->b1->a,
	'b'=>$equipsObj->b1->b,
	'c'=>$equipsObj->b1->c,
	'd'=>$equipsObj->b1->d,
	'e'=>$equipsObj->b1->e,
	'f'=>$equipsObj->b1->f,
);
$e_b2 = Array(
	'a'=>$equipsObj->b2->a,
	'b'=>$equipsObj->b2->b,
	'c'=>$equipsObj->b2->c,
	'd'=>$equipsObj->b2->d,
	'e'=>$equipsObj->b2->e,
	'f'=>$equipsObj->b2->f,
);
$e_p = Array(
	'a'=>$equipsObj->p->a,
	'b'=>$equipsObj->p->b,
	'c'=>$equipsObj->p->c,
	'd'=>$equipsObj->p->d,
	'e'=>$equipsObj->p->e,
	'f'=>$equipsObj->p->f,
);
$e_p1 = Array(
	'a'=>$equipsObj->p1->a,
	'b'=>$equipsObj->p1->b,
	'c'=>$equipsObj->p1->c,
	'd'=>$equipsObj->p1->d,
	'e'=>$equipsObj->p1->e,
	'f'=>$equipsObj->p1->f,
);
$e_p2 = Array(
	'a'=>$equipsObj->p2->a,
	'b'=>$equipsObj->p2->b,
	'c'=>$equipsObj->p2->c,
	'd'=>$equipsObj->p2->d,
	'e'=>$equipsObj->p2->e,
	'f'=>$equipsObj->p2->f,
);
$e_p3 = Array(
	'a'=>$equipsObj->p3->a,
	'b'=>$equipsObj->p3->b,
	'c'=>$equipsObj->p3->c,
	'd'=>$equipsObj->p3->d,
	'e'=>$equipsObj->p3->e,
	'f'=>$equipsObj->p3->f,
);
$e_p4 = Array(
	'a'=>$equipsObj->p4->a,
	'b'=>$equipsObj->p4->b,
	'c'=>$equipsObj->p4->c,
	'd'=>$equipsObj->p4->d,
	'e'=>$equipsObj->p4->e,
	'f'=>$equipsObj->p4->f,
);
$e_o = Array(
	'a'=>$equipsObj->o->a,
	'b'=>$equipsObj->o->b,
	'c'=>$equipsObj->o->c,
	'd'=>$equipsObj->o->d,
	'e'=>$equipsObj->o->e,
	'f'=>$equipsObj->o->f,
);
//-----------学列花处理-----------
/*

echo($name);
echo '<br>';
echo($avatar);
echo '<br>';
echo($e_b['a']);
echo '<br>';
print_r($e_b1);
echo '<br>';
print_r($e_p);
echo '<br>';
print_r($e_p1);
echo '<br>';
print_r($e_p2);
echo '<br>';
print_r($e_p3);
echo '<br>';
print_r($e_p4);
echo '<br>';
print_r($e_o);

*/
$updateArr = Array(
	0=>TRUE,
	1=>TRUE,
	2=>TRUE,
	3=>TRUE,
	4=>TRUE,
	5=>TRUE,
	6=>TRUE,
	7=>TRUE,
	8=>TRUE,
);
if($e_b['a']===''){
	$updateArr[0] = FALSE;
}
if($e_b1['a']===''){
	$updateArr[1] = FALSE;
}
if($e_b2['a']===''){
	$updateArr[2] = FALSE;
}
if($e_p['a']===''){
	$updateArr[3] = FALSE;
}
if($e_p1['a']===''){
	$updateArr[4] = FALSE;
}
if($e_p2['a']===''){
	$updateArr[5] = FALSE;
}
if($e_p3['a']===''){
	$updateArr[6] = FALSE;
}
if($e_p4['a']===''){
	$updateArr[7] = FALSE;
}
if($e_o['a']===''){
	$updateArr[8] = FALSE;
}

$heroId = null;

$e_b  = serialize($e_b);
$e_b1 = serialize($e_b1);
$e_b2 = serialize($e_b2);
$e_p  = serialize($e_p);
$e_p1 = serialize($e_p1);
$e_p2 = serialize($e_p2);
$e_p3 = serialize($e_p3);
$e_p4 = serialize($e_p4);
$e_o  = serialize($e_o);

$connectResult = $sqlOp->connectTo();
if($connectResult){
	//if hero already exitsted,update else insert
	$queryResult = $sqlOp->queryTo("select * from hero where name='$name' ");
	
	if($queryResult){

		$array = mysql_fetch_array($sqlOp->result);
		if($array){
			
			$heroId = $array['id'];

		}else{
			
			if($name===''||$name===null){
				echo 'null hero name,can not insert';
				return;
			}
			
			$queryInsertHeroResult = $sqlOp->queryTo("insert into hero values(null,'$name','$avatar',null)");
		
			if($queryInsertHeroResult){
	
				$queryLastIdResult = $sqlOp->queryTo('select last_insert_id() from hero');
			
				if($queryLastIdResult){
		
					$array = mysql_fetch_array($sqlOp->result);
					$heroId = $array[0];
				}else{
				
					echo 'can not get last id';
				}
			}else{
				echo 'can not insert into';
			}
		}
	}else{
		echo 'query select fail';
	}
}
if($heroId===null){
	echo '$heroId is null';
}else{
	//check if hero existed,then update else insert into;
	$queryCheckResult = $sqlOp->queryTo("select * from upgrade where heroId='$heroId' ");
	if($queryCheckResult){
		
		$array = mysql_fetch_array($sqlOp->result);
		if($array){
			//update
			$id = $array['id'];
			$updateStr = 'update upgrade set ';
			
			if($updateArr[0]==TRUE){
				$updateStr = $updateStr."blue='$e_b',";
			}
			if($updateArr[1]==TRUE){
				$updateStr = $updateStr."blue1='$e_b1',";
			}
			if($updateArr[2]==TRUE){
				$updateStr = $updateStr."blue2='$e_b2',";
			}
			if($updateArr[3]==TRUE){
				$updateStr = $updateStr."purple='$e_p',";
			}
			if($updateArr[4]==TRUE){
				$updateStr = $updateStr."purple1='$e_p1',";
			}
			if($updateArr[5]==TRUE){
				$updateStr = $updateStr."purple2='$e_p2',";
			}
			if($updateArr[6]==TRUE){
				$updateStr = $updateStr."purple3='$e_p3',";
			}
			if($updateArr[7]==TRUE){
				$updateStr = $updateStr."purple4='$e_p4',";
			}
			if($updateArr[8]==TRUE){
				$updateStr = $updateStr."orange='$e_o',";
			}
			$updateStrLen = strlen($updateStr);
			if($updateStr[ $updateStrLen-1 ]==',' ){
				$updateStr[ $updateStrLen-1 ] = '';
			}
			//echo '<br>---------------<br>';
			$updateArr = $updateStr." where id='$id' ";
			$updateResult = $sqlOp->queryTo($updateStr);
			if($updateResult){
				echo 'update_success';
			}else{
				echo 'update_fail';
			}		
		}else{
			//insert
			$queryInsertResult = $sqlOp->queryTo("insert into upgrade values(null,'$heroId','$e_b','$e_b1','$e_b2','$e_p','$e_p1','$e_p2','$e_p3','$e_p4','$e_o')");
			if($queryInsertResult){
				
				echo 'insert into success';
			}else{
				echo 'query insert result fail';
			}
		}
	}else{
		echo 'query Check Result fail';
	}
}
?>