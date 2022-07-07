<?php /* Database connection information */
	$gaSql['user']       = "ebras_pedidos";
	$gaSql['password']   = "ebras123";
	$gaSql['db']         = "ebras_pedidos";
	$gaSql['server']     = "127.0.0.1";
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * MySQL connection
	 */
	$gaSql['link'] =  mysql_connect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	//mysql_select_db( $gaSql['db']);
	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );
        
        
 ?>
