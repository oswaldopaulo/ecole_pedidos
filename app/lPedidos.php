<?php

namespace pedidos;

use Illuminate\Database\Eloquent\Model;

class lPedidos extends Model
{
    //
    protected $connection = 'oracle';
    protected $table ='pedidos';
}
