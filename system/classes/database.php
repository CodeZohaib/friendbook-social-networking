<?php
 
class database{
	public $host     =   HOST;
	public $user     =   USER;
	public $database =   DATABASE;
	public $password =   PASSWORD;
	public $con;

	public function __construct()
	{
		try{
			return $this->con=new PDO("mysql:host=$this->host;dbname=$this->database",$this->user,$this->password);
		}
		catch(PDOException $e){
			echo "Database Connection Error ".$e->getMessage();
			exit();
		}
	}
}

?>