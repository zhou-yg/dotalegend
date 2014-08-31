<?php
function delete_slash($string){
	$str = "";
	for ($i=0; $i < strlen($string); $i++) {
		if($string[$i] == "\\"){
		}else{
			$str = $str.$string[$i];
		}
	}
	return $str;
}
class SqlOp{
	
	private $adress;
	private $port = ":3306";
	private $account;
	private $password;
	
	private $db;
	private $db_name = 'dotalegend';

	public $connect;
	public $result;
		
	function __construct() {
		$this->adress = "localhost".$this->port;
		$this->account = "root";
		$this->password = 123456;
	}
	public function setProperty($_ad,$_ac,$_ps){
		$this->adress = $_ad.$this->port;
		$this->account = $_ac;
		$this->password = $_ps;
		return TRUE;
	}
	public function connectTo(){
		$this->connect = mysql_connect($this->adress,$this->account,$this->password);
		mysql_set_charset('utf8',$this->connect);
		if($this->connect){
			$this->db = mysql_select_db($this->db_name);
			if($this->db){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	public function queryTo($_str){
		$this->result = mysql_query($_str,$this->connect);
		if($this->result!=FALSE){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function close(){
		mysql_close($this->connect);
	}
	public function reset(){
		$this->result = null;
	}
}
$sqlOp = new SqlOp();
return $sqlOp;
?>