<?php

namespace pedidos;

use Illuminate\Database\Eloquent\Model;

class VdpCliParametro extends Model
{
    protected $connection = 'oracle';
    protected $table='vdp_cli_parametro';
}
