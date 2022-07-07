<?php

namespace pedidos;

use Illuminate\Database\Eloquent\Model;

class lPedidosDigMest extends Model
{
    //
    protected $connection = 'oracle';
    protected $table = 'pedido_dig_mest';
    public $timestamps = false;
    
    protected $primaryKey = null;
    public $incrementing = false;
    
    protected $fillable = ['COD_EMPRESA' ,'NUM_PEDIDO' ,'COD_NAT_OPER' ,'DAT_EMIS_REPRES' ,'COD_CLIENTE' ,'COD_REPRES' ,'IES_COMISSAO' ,'IES_FINALIDADE' ,'IES_PRECO' ,'NUM_LIST_PRECO' ,'COD_CND_PGTO' ,'PCT_DESC_FINANC' ,'NUM_PEDIDO_CLI' ,'NUM_PEDIDO_REPRES' ,'IES_FRETE' ,'COD_REPRES_ADIC' ,'COD_TRANSPOR' ,'COD_CONSIG' ,'IES_EMBAL_PADRAO' ,'IES_TIP_ENTREGA' ,'IES_ACEITE_FINAN' ,'IES_ACEITE_COMER' ,'DAT_PRAZO_ENTREGA' ,'PCT_COMISSAO' ,'IES_SIT_PEDIDO' ,'COD_TIP_VENDA' ,'COD_MOEDA' ,'PCT_DESC_ADIC' ,'DAT_DIGITACAO' ,'IES_SIT_INFORMACAO' ,'NOM_USUARIO' ,'PCT_FRETE' ,'PCT_DESC_BRUTO' ,'COD_TIP_CARTEIRA' ,'NUM_VERSAO_LISTA' ,'HORA_DIGITACAO' ,'DAT_LIBERACAO_FIN' ,'HORA_LIBERACAO_FIN' ,'DAT_LIBERACAO_COM' ,'HORA_LIBERACAO_COM' ,'COD_LOCAL_ESTOQ'];

}
