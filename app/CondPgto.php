<?php

namespace pedidos;

use Illuminate\Database\Eloquent\Model;

class CondPgto extends Model
{
    //
    protected $connection = 'oracle';
    protected $table='cond_pgto';
}
