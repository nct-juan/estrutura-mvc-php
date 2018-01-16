<?php

namespace lib;
use PDO;

class ApplicationDB 
{
	
protected static $pdo;

	      protected $host = '127.0.0.1',
	      			$db_name   = 'service', 
	     			$password  = '345333asd*.',
	     			$user      = 'postgres',
					//$charset   = 'ISO-8859-1',  //Charset da base de dados
					$drive     = 'pgsql',
	      			$error     = null,
	      			$debug     = false,
		  			$last_id   = null;
	      
	
public function __construct()
{
	try 
	{
		self::$pdo = new \PDO("$this->drive:host=".$this->host." dbname=".$this->db_name." user=".$this->user." password=".$this->password."");
	} 
	catch (PDOException $e) 
	{
		print $e->getMessage();
	}
}
	   
	
public function query($smtp, $data_array = null) 
{	
		
		$query = self::$pdo->prepare( $smtp );
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

public function insert( $table ) {
	// Configura o array de colunas
	$cols = array();

	// Configura o valor inicial do modelo
	$place_holders = '(';

	// Configura o array de valores
	$values = array();

	// O $j will assegura que colunas serão configuradas apenas uma vez
	$j = 1;

	// Obtém os argumentos enviados
	$data = func_get_args();

	// É preciso enviar pelo menos um array de chaves e valores
	if ( ! isset( $data[1] ) || ! is_array( $data[1] ) ) {
		return;
	}

	// Faz um laço nos argumentos
	for ( $i = 1; $i < count( $data ); $i++ ) {

		// Obtém as chaves como colunas e valores como valores
		foreach ( $data[$i] as $col => $val ) {
				
			// A primeira volta do laço configura as colunas
			if ( $i === 1 ) {
				$cols[] = "$col";
			}

			if ( $j <> $i ) {
				// Configura os divisores
				$place_holders .= '), (';
			}

			// Configura os place holders do PDO
			$place_holders .= '?, ';

			// Configura os valores que vamos enviar
			$values[] = $val;

			$j = $i;
		}
			
		// Remove os caracteres extra dos place holders
		$place_holders = substr( $place_holders, 0, strlen( $place_holders ) - 2 );
	}

	// Separa as colunas por vírgula
	$cols = implode(', ', $cols);

	// Cria a declaração para enviar ao PDO
	$stmt = "INSERT INTO $table ( $cols ) VALUES $place_holders) ";

	//print($stmt .",". $values[0]);

	// Insere os valores
	$insert = $this->query( $stmt, $values );

	// Verifica se a consulta foi realizada com sucesso
	if ( $insert ) {
			
		// Verifica se temos o último ID enviado
		if ( method_exists( self::$pdo, 'lastInsertId' )
				&& self::$pdo->lastInsertId()
				) {
					// Configura o último ID
					$this->last_id = self::$pdo->lastInsertId();
				}
					
				// Retorna a consulta
				return $insert;
	}

	// The end :)
	return;
} // insert


public function update( $table, $where_field, $where_field_value, $values ) {
	// Você tem que enviar todos os parâmetros
	if ( empty($table) || empty($where_field) || empty($where_field_value)  ) {
		return;
	}

	// Começa a declaração
	$stmt = " UPDATE $table SET ";

	// Configura o array de valores
	$set = array();

	// Configura a declaração do WHERE campo=valor
	$where = " WHERE $where_field = ? ";

	// Você precisa enviar um array com valores
	if ( ! is_array( $values ) ) {
		return;
	}

	// Configura as colunas a atualizar
	foreach ( $values as $column => $value ) {
		$set[] = " $column = ?";
	}

	// Separa as colunas por vírgula
	$set = implode(', ', $set);

	// Concatena a declaração
	$stmt .= $set . $where;

	// Configura o valor do campo que vamos buscar
	$values[] = $where_field_value;

	// Garante apenas números nas chaves do array
	$values = array_values($values);

	// Atualiza
	$update = $this->query( $stmt, $values );

	// Verifica se a consulta está OK
	if ( $update ) {
		// Retorna a consulta
		return $update;
	}

	// The end :)
	return;
} // update


public function delete( $table, $where_field, $where_field_value ) {
	// Você precisa enviar todos os parâmetros
	if ( empty($table) || empty($where_field) || empty($where_field_value)  ) {
		return;
	}

	// Inicia a declaração
	$stmt = " DELETE FROM $table ";

	// Configura a declaração WHERE campo=valor
	$where = " WHERE $where_field = ? ";

	// Concatena tudo
	$stmt .= $where;

	// O valor que vamos buscar para apagar
	$values = array( $where_field_value );

	// Apaga
	$delete = $this->query( $stmt, $values );

	// Verifica se a consulta está OK
	if ( $delete ) {
		// Retorna a consulta
		return $delete;
	}

	// The end :)
	return;
} // delete

}




