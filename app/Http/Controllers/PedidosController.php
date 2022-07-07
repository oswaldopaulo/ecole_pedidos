<?php

namespace pedidos\Http\Controllers;

use Request;
use pedidos\Pedidos;
use pedidos\PedidosItem;
use pedidos\Clientes;
use pedidos\Itens;
use pedidos\Representates;
use pedidos\CondPgto;

use pedidos\lPedidos;
use pedidos\lPedidosDigMest;
use pedidos\VdpCliParametro;
use pedidos\Cidades;
use pedidos\lPedidosDigItem;
use pedidos\Arquivos;
use File;

class PedidosController extends Controller
{
    //
    
	function importExcel(){
		
	}
	
	function index(){
		$t= Pedidos::where(['check'=>'0','integrado'=>'0'])->get();
		$arq = Arquivos::where(['integrado'=>'0'])->take(3)->orderBy('id', 'desc')->get();
		return view('pedidos/index')->with(['t'=>$t,'arq' => $arq]);
		
	}
	
	function remover(){
		
	}
	function removeritem(){
		
	}
	
	function novo(){
	    return view ('pedidos/novo');
	}
	
	function novomanual() {
	    
	}
	function editar($id){
		$r=Pedidos::find($id);
		$ri=PedidosItem::where(['id_pedido'=>$id])->get();
		
		return view('pedidos/editar')->with(['r'=>$r,'ri'=>$ri]);
		
	}
	
	function update(){
	    
	    $p = Pedidos::find(Request::input('id'));
	    
	    $entrega = date_format(date_create_from_format('Y-m-d', Request::input('entrega')), 'd/m/Y');
	    
	    $p->update([
	           'cnpj_repres' => Request::input('cliente'),
	           'cnpj_trans'=>Request::input('trans'),
	           'cod_repres'=>Request::input('repres'),
	           'cod_cond_pgto'=>Request::input('cond'),
               'entrega'=>$entrega	        
	             
	        
	        ]);
	    
	   
	    
	    $ids = Request::input('iditens');
	    $qtd = Request::input('qtd');
	    $preco_negociado = Request::input('preco_negociado');
	    
	  
	    for($i=0;$i < count($ids);$i++){
	        
	        //return var_dump($ids[$i]);
	        $pi = PedidosItem::find($ids[$i]);
	        $pi->update(['qtd'=>$qtd[$i],'preco_negociado'=>$preco_negociado[$i]]); 
	    }
	    
	    return redirect()->action('PedidosController@index');
	}
	
	function check(){
	    $sucess = Request::get('sucess');
	    $terros='';
	    $t = Pedidos::where(['check'=>'1','integrado'=>'0'])->get();
	    return view('pedidos/check')->with(['terros'=>$terros,'t'=>$t,'sucess'=>$sucess]);
	}
	function envialogix(){
		$check = false;
		$terros = '';
		
		if (empty(Request::input('id'))) return "Nenhum selecionado"	;
	
		$ids = Request::input('id');
		
		
		foreach ($ids as $id){
			$erros = '';
			
			$p = Pedidos::find($id);
			$cnpj = str_replace(['.',',','/','-'], '', $p->cnpj_repres);
			if(strlen($cnpj)==14) $cnpj = '0' . $cnpj;
			
			
			$cnpj = str_replace(['.',',','/','-'], '', $p->cnpj_repres);
			if(strlen($cnpj)==14) $cnpj = '0' . $cnpj;
			
			$cnpj_trans = str_replace(['.',',','/','-'], '', $p->cnpj_trans);
			if(strlen($cnpj_trans)==14) $cnpj_trans = '0' . $cnpj_trans;
			
			
			$c = Clientes::where('cod_cliente','=',$cnpj)->count();
			if($c==0){
				$erros .= "Pedido $p->id, Cliente $cnpj não encontrado no logix <br>";				
			}
			
			$trans = Clientes::where(['cod_cliente'=>$cnpj_trans,'cod_tip_cli'=>'99'])->count();
			if($trans==0){
				$erros .= "Pedido $p->id, Transportadora $cnpj_trans não encontrado no logix <br>";
			}
			
			$re =  Representates::where(['cod_repres'=>$p->cod_repres])->count();
			if($re==0){
				$erros .= "Pedido $p->id, Representante $p->cod_repres não encontrado no logix <br>";
			}
			
			$cond =  CondPgto::where(['cod_cnd_pgto'=>$p->cod_cond_pgto])->count();
			if($cond==0){
			    $erros .= "Pedido $p->id,  Cond. Pgto $p->cod_pgto não encontrado no logix <br>";
			}
			
			$entrega = str_replace ('-','/', $p->entrega);
			$entrega = str_replace(['imediata','IMEDIATA','IMEDIATO','imediato'],date("d/m/Y"),$entrega);
			$entrega = str_replace(' ','',$entrega);
			
			$dat_emissao = str_replace ('-','/', $p->dat_emissao);
			$dat_emissao = str_replace (' ','', $dat_emissao);
			
			 
			
		
			
		
			if(strlen($dat_emissao)==8) $dat_emissao = date_format(date_create_from_format('d/m/y', $dat_emissao), 'd/m/Y');
			if(strlen($entrega)==8) $entrega = date_format(date_create_from_format('d/m/y', $entrega), 'd/m/Y');
			
		
			
		
			
			
			$d = explode ('/',$entrega);
			
			if(count($d)==3) {
			
    			if (checkdate($d[1],$d[0],$d[2])) {
    			    //$entrega = date_format(date_create_from_format('d/m/y', $entrega), 'd/m/Y');
    			    $p->update(['entrega'=>$entrega]);
    			} else {
    			    $erros .= "Pedido $p->id, Data Entrega $entrega invalida <br>";
    			}
			} else {
			    $erros .= "Pedido $p->id, Data  Entrega $entrega invalida <br>";
			}
			
			
			$d = explode ('/',$dat_emissao);
			
			if(count($d)==3) {
			    
			    if (checkdate($d[1],$d[0],$d[2])) {
			        //$entrega = date_format(date_create_from_format('d/m/y', $entrega), 'd/m/Y');
			        $p->update(['dat_emissao'=>$dat_emissao]);
			    } else {
			        $p->update(['dat_emissao'=>date('d/m/Y')]);
			    }
			} else {
			    $p->update(['dat_emissao'=>date('d/m/Y')]);
			}
			
			$pi = PedidosItem::where(['id_pedido'=>$p->id])->get();
			
			
			if(empty($pi)) {
				$erros .= "Pedido $p->id, Não existe itens <br>";
			} else {
				foreach($pi  as $r){
					
					$item = Itens::where('cod_item','like',$r->cod_item . '%')->where('cod_empresa','=','05')->count();
										
					
					if($item==0){
						
						$erros .= "Pedido $p->id, Item $r->cod_item $item não encontrado no logix <br>";
					}
					
					if($r->qtd==0){
						$erros .= "Pedido $p->id, Item $r->cod_item quantidade 0 <br>";
					}
					
					
				}
			}
			
			
			
			
			
			$p->update(['erros'=>$erros]);	
			
			if(empty($erros)) {
			    $p->update(['check'=>'1']);
			    
			    
			}
			
			$terros .= $erros;
		}
		
		
		
		$t = Pedidos::where(['check'=>'1','integrado'=>'0'])->get();
		return view('pedidos/check')->with(['terros'=>$terros,'t'=>$t]);
	}
	
	function integrar(){
	 
	    
	   $sucess='';
	    $numped = lPedidos::where(['cod_empresa'=>'05'])->max('num_pedido');
	    $numpedd = lPedidosDigMest::where(['cod_empresa'=>'05'])->max('num_pedido');
	    
	    if($numpedd > $numped) $numped = $numpedd;
	    
	    $numped++;
	    
	    $pedmy = Pedidos::where(['check'=>'1','integrado'=>'0'])->get();
	    
	    foreach($pedmy as $l){
	        
	          
	        
	        $cli = Clientes::where(['cod_cliente'=>str_replace(['.',',','/','-'], '', $l->cnpj_repres)])->get();
	        
	       
	        $cli = $cli[0];
	        $suframa = $cli->num_suframa;
	       
	        
	      
	        
	        $validade_suframa = VdpCliParametro::select('dat_parametro')->where(['cliente'=>$cli->cod_cliente, 'PARAMETRO'=>'dat_validade_suframa'])->get();
	        $validade_suframa =  $validade_suframa[0];
	        $validade_suframa = $validade_suframa->dat_parametro;
	        $cidade = Cidades::where(['cod_cidade'=>$cli->cod_cidade])->get();
	        $cidade = $cidade[0];
	        
	        
	        $cidade->cod_uni_feder=='SP'?$frete='1':$frete='3';
	        
	               
	        
	        $ufs = ['AC','AP','AM','RR','RO'];
	        
	     
	        
	        if(in_array($cidade->cod_uni_feder,$ufs)){
	            
	          
	            
	            if(in_array($cidade->cod_cidade,['AM000'])){
	                $cod_nat_oper = '90';
	            } elseif($cidade->cod_cidade=='RO012'){
	                $cod_nat_oper = '95';
	            } elseif(in_array($cidade->cod_cidade,['RR003','RR002'])){
	                $cod_nat_oper = '96';
	            } elseif(in_array($cidade->cod_cidade,['AP000','AP002','AP003'])){
	                $cod_nat_oper = '97';
	            } elseif(in_array($cidade->cod_cidade,['AC001','AC002','AC005'])){
	                $cod_nat_oper = '98';
	            } else {
	                if(!empty($suframa) && $validade_suframa > date('Y-m-d') ){
	                    $cod_nat_oper='88';
	                }  else {
	                       $cod_nat_oper = '99';
	                }
	            }
	        
	        } else {
	            $cod_nat_oper = '1';
	        }
	        
	       
	        
	        lPedidosDigMest::Create([
	            'COD_EMPRESA'=>'05',
	            'NUM_PEDIDO'=>$numped,
	            'COD_NAT_OPER'=>$cod_nat_oper,
	            'DAT_EMIS_REPRES'=>date_format(date_create_from_format('d/m/Y', $l->dat_emissao), 'Y-m-d'),
	            'COD_CLIENTE'=>str_replace(['.',',','/','-'], '', $l->cnpj_repres),
	            'COD_REPRES'=>$l->cod_repres,
	            'IES_COMISSAO'=>'S',
	            'IES_FINALIDADE'=>'1',
	            'IES_PRECO'=>'F',
	            'COD_CND_PGTO'=>$l->cod_cond_pgto ,
	            'PCT_DESC_FINANC'=>0,
	            'NUM_PEDIDO_REPRES'=>$l->repres_num_ped ,
                'IES_FRETE'=>$frete, 
	            'COD_TRANSPOR'=>str_replace(['.',',','/','-'], '', $l->cnpj_trans),
	            'IES_EMBAL_PADRAO'=>'3',
	            'IES_TIP_ENTREGA'=>3,
	            'IES_ACEITE_FINAN'=>'N',
	            'IES_ACEITE_COMER'=>'N',
	            'DAT_PRAZO_ENTREGA'=>date_format(date_create_from_format('d/m/Y', $l->entrega), 'Y-m-d'),
	            'PCT_COMISSAO'=>0,
	            'IES_SIT_PEDIDO'=>'N',
	            'COD_TIP_VENDA'=>1,
	            'COD_MOEDA'=>1,
	            'PCT_DESC_ADIC'=>0,
	            'DAT_DIGITACAO'=>date('Y-m-d'),
	            'IES_SIT_INFORMACAO'=>'C' ,
	            'NOM_USUARIO'=>'admlog',
	            'PCT_FRETE'=>0 ,
	            'PCT_DESC_BRUTO'=>0,
	            'COD_TIP_CARTEIRA'=>'10',
	            'NUM_VERSAO_LISTA'=>'0',
	            'HORA_DIGITACAO'=>date("H:i:s")
	           
	        ]);
	        
	   
	        
	        $itens = PedidosItem::where(['id_pedido'=>$l->id])->get();
	        $seq = 1;
	        foreach($itens as $it){
	            lPedidosDigItem::Create([
	                'COD_EMPRESA'=>'05',
	                'NUM_PEDIDO'=>$numped,
	                'NUM_SEQUENCIA'=>$seq,
	                'COD_ITEM'=>$it->cod_item,
	                'QTD_PECAS_SOLIC'=>$it->qtd,
	                'PRE_UNIT'=>$it->preco_negociado,
	                'PCT_DESC_ADIC'=>0,
	                'PCT_DESC_BRUTO'=>0,
	                'PRZ_ENTREGA'=>date_format(date_create_from_format('d/m/Y', $l->entrega), 'Y-m-d'),
	                'VAL_SEGURO_UNIT'=>0,
	                'VAL_FRETE_UNIT'=>0
	                
	            ]);
	            
	            $seq++;
	        }
	        
	        $l->update(['integrado'=>'1']);
	        
	        $sucess .= "Pedido <span> $l->id </span> integrado no logix  com numero <span> $numped <span> <br>";
	        $numped++;
	    }
	    
	    
	    return redirect()->action('PedidosController@check',['sucess' => $sucess]);
	}
	
	function detalhes($id){
		$m = Pedidos::find($id);
		$t = PedidosItem::where(['id_pedido'=>$id])->get();
		
		return view('pedidos/detalhes')->with(['m'=>$m,'t'=>$t]);
		
	}
	function arquivos(){
		
		$t = Arquivos::all();
				
		return view("pedidos/files")->with(['t'=>$t]);
	}
	
	function removerarquivo($id){
	    
	    $arq = Arquivos::find($id);
	    $arq->delete();
	    return redirect()->action('PedidosController@arquivos');
	    
	}
	

	function getTrans($id){
		
		$trans = Clientes::select(['cod_cliente','nom_cliente'])
						->where(['cod_tip_cli'=>'99','ies_situacao'=>'A'])
						->where("nom_cliente", "like", '%' . strtoupper($id) . '%' )
						->orWhere('cod_cliente','like','%' .  strtoupper($id) . '%')
						->get();
		return $trans;
		
		
	}
	
	function getClientes($id){
		
		$cons = Clientes::select(['cod_cliente','nom_cliente'])
		->where(['ies_situacao'=>'A'])
		->where("nom_cliente", "like", '%' . strtoupper($id) . '%' )
		->orWhere('cod_cliente','like','%' .  strtoupper($id) . '%')
		->get();
		
		return $cons;
		
		
	}
	
	function getRepres($id){
		
		$cons = Representates::select(['cod_repres','raz_social'])
		->where(['ies_situacao'=>'N'])
		->where("raz_social", "like", '%' . strtoupper($id) . '%' )
		->orWhere('cod_repres','like','%' .  strtoupper($id) . '%')
		->get();
		
		return $cons;
		
		
	}
	
	function getCond($id){
		if ($id=='*'){
			$cons = CondPgto::select(['cod_cnd_pgto','den_cnd_pgto'])->get();
		} else {
			$cons = CondPgto::select(['cod_cnd_pgto','den_cnd_pgto'])
			->where("cod_cnd_pgto", "like", '%' . strtoupper($id) . '%' )
			->orWhere('den_cnd_pgto','like','%' .  strtoupper($id) . '%')
			->orderby('den_cnd_pgto')
			->get();
		}
		
		return $cons;
		
		
	}
}
