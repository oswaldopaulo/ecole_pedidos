<?php

namespace pedidos;

use Illuminate\Database\Eloquent\Model;


class Clientes extends Model{
	
	// define binary/blob fields
	//protected $binaries = ['content'];
	
	// define the sequence name used for incrementing
	// default value would be {table}_{primaryKey}_seq if not set
	//protected $sequence = null;
	protected $table = 'clientes';
	protected $connection = 'oracle';
	
}