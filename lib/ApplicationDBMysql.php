<?php

namespace lib;
use PDO;

class ApplicationDBMysql 
{
	protected static $pdoMysql;
	
public function __construct()
{
	try
	{
		self::$pdoMysql = new \PDO( 'mysql:host=localhost;dbname=service;charset=utf8', 'root', '345333asd*.' );
		//new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	}
	catch ( PDOException $e )
	{
		echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
	}
}

public function query($smtp, $data_array = null) 
{	
		
		$query = self::$pdoMysql->prepare( $smtp );
		$check_exec = $query->execute( $data_array );

		if ($check_exec)
		{
			return $query;
		} 
		else
		{	
			echo "<script>alert('Dados incorretos, favor verifique as informações novamente.')</script>";
			$error = $query->errorInfo ();
			$this->error = $error [2];
			return false;
		}
}

}