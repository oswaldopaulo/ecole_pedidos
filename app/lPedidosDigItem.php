<?php

namespace pedidos;

use Illuminate\Database\Eloquent\Model;

class lPedidosDigItem extends Model
{
    //
    protected $connection = 'oracle';
    protected $table = 'pedido_dig_item';
    public $timestamps = false;
    
    protected $primaryKey = null;
    public $incrementing = false;
    
    protected  $fillable = [
        'COD_EMPRESA',
        'NUM_PEDIDO',
        'NUM_SEQUENCIA',
        'COD_ITEM',
        'QTD_PECAS_SOLIC',
        'PRE_UNIT',
        'PCT_DESC_ADIC',
        'PCT_DESC_BRUTO',
        'PRZ_ENTREGA',
        'VAL_SEGURO_UNIT',
        'VAL_FRETE_UNIT'
    ];
}
