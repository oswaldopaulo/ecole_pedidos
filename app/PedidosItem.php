<?php

namespace pedidos;

use Illuminate\Database\Eloquent\Model;

class PedidosItem extends Model
{
    //
    protected $table = "pedidos_item";
    protected $fillable = ['qtd', 'preco_negociado'];
}
