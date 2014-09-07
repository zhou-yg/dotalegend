<?php
$localhostSqlOp = include 'SqlOp.php';
$serverSqlOp = new SqlOp();


$dbParamsArr = array(
	'localhost'=>array('localhost','root',123456,'dotalegend'),
	'server'=>array('125.88.190.53','a0831182501',71516741,'a0831182501')
);
$dbSqlArr = array(
	'localhost'=>$localhostSqlOp,
	'server'=>$serverSqlOp
);

$tableArr = array('equipment','hero','upgrade');

$syncPosition = $_GET['to'];

$fromDbParamArr;
$toDbParamArr;

$fromSqlOp;
$toSqlOp;

if($syncPosition=='localhost'){
	
	$fromDbParamArr = $dbParamsArr['server'];
	$toDbParamArr   = $dbParamsArr['localhost'];
	
	$fromSqlOp = $serverSqlOp;
	$fromSqlOp->setProperty($fromDbParamArr[0],$fromDbParamArr[1],$fromDbParamArr[2],$fromDbParamArr[3]);
	$toSqlOp = $localhostSqlOp;
	$toSqlOp->setProperty($toDbParamArr[0],$toDbParamArr[1],$toDbParamArr[2],$toDbParamArr[3]);
}
if($syncPosition=='server'){
	
	$fromDbParamArr = $dbParamsArr['localhost'];
	$toDbParamArr   = $dbParamsArr['server'];
	
	$fromSqlOp = $localhostSqlOp;
	$fromSqlOp->setProperty($fromDbParamArr[0],$fromDbParamArr[1],$fromDbParamArr[2],$fromDbParamArr[3]);
	$toSqlOp = $serverSqlOp;
	$toSqlOp->setProperty($toDbParamArr[0],$toDbParamArr[1],$toDbParamArr[2],$toDbParamArr[3]);
}

if($fromDbParamArr && $fromSqlOp && $toDbParamArr  && $toSqlOp){
	
	$connectResultF = $fromSqlOp->connectTo();
	$connectResultT = true;//$toSqlOp->connectTo();
	
	if($connectResultT && $connectResultF){
		echo 'connect true';
	}else{
		echo 'connect fail';
	}
	
}else{
	echo "4 null";
}
?>