<?php

namespace pedidos;

use Illuminate\Database\Eloquent\Model;

class Itens extends Model
{
	//
	protected $connection='oracle';
	protected $table = 'item';
}
