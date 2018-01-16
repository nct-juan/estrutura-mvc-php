<?php



function chk_array ( $array, $key ) {
	// Verifica se a chave existe no array
	if ( isset( $array[ $key ] ) && ! empty( $array[ $key ] ) ) {
		// Retorna o valor da chave
		return $array[ $key ];
	}
	
	// Retorna nulo por padrão
	return null;
} // chk_array

function __autoload($class_name) {
	$file = ABSPATH . '/library/class-' . $class_name . '.php';
	echo $file;
	
	if ( ! file_exists( $file ) ) {
		require_once ABSPATH . '/includes/404.php';
		return;
	}
	
	// Inclui o arquivo da classe
    require_once $file;
} // __autoload
