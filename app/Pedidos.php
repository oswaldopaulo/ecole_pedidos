<?php

namespace pedidos;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    //
	//protected $x=explode('cliente, endereco, cidade, telefone, transportadora, cnpj_trans, cond_pgto, entrega, cod_repres, nome_repres, tel_repres, cnpj_repres, ie_repres, num_repres, bairro_repres, uf_repres, contato_repres, suframa, email, preco_base, tipo_desconto, regiao_uf, desconto_regiao, observacao, inf_adicional, dat_emissao, repres_num_pedido');
    protected $fillable = ['cliente', 'cnpj_trans','transportadora','cond_pgto', 'entrega', 'cod_repres', 'cnpj_repres','cod_cond_pgto','check','integrado','dat_emissao','erros']; 


}
