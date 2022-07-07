@extends('layouts.app')
@section('content')
<<script type="text/javascript">

function getTrans(){
 
	$.get("{{ url('pedidos/getTrans/')}}" + "/" + document.getElementById("btrans").value, 
			//{ option: document.getElementById("bcliente").value }, 
			function(data) {
				var trans = $('#trans');
				trans.empty();

				$.each(data, function(index, element) {
		            trans.append("<option value='"+ element.cod_cliente +"'>" + element.cod_cliente + " " + element.nom_cliente +"</option>");
		        });
			});
}

function getClientes(){

	$.get("{{ url('pedidos/getClientes/')}}" + "/" + document.getElementById("bcliente").value, 
			//{ option: document.getElementById("bcliente").value }, 
			function(data) {
				var cliente = $('#cliente');
				cliente.empty();

				$.each(data, function(index, element) {
		            cliente.append("<option value='"+ element.cod_cliente +"'>" + element.cod_cliente + " " + element.nom_cliente + "</option>");
		        });
			});
}

function getRepres(){
	
	$.get("{{ url('pedidos/getRepres/')}}" + "/" + document.getElementById("brepres").value, 
			//{ option: document.getElementById("bcliente").value }, 
			function(data) {
				var repres = $('#repres');
				repres.empty();

				$.each(data, function(index, element) {
		            repres.append("<option value='"+ element.cod_repres +"'>" + element.cod_repres + " " + element.raz_social + "</option>");
		        });
			});
}

function getCond(){
	id = document.getElementById("bcond").value;

	if(id=="") id="*";


	
	$.get("{{ url('pedidos/getCond/')}}" + "/" + id, 
			//{ option: document.getElementById("bcliente").value }, 
			function(data) {
				var cond = $('#cond');
				cond.empty();

				$.each(data, function(index, element) {
		            cond.append("<option value='"+ element.cod_cnd_pgto +"'>" + element.cod_cnd_pgto + " " + element.den_cnd_pgto + "</option>");
		        });
			});
}
</script>
<div class="panel panel-default" style="padding: 20px" >
<!-- Default panel contents -->
<div class="panel-heading" style="margin: 20px" ><h2>Editar Cadastro</h2></div>

@if (!empty($errors->all())) 
	<div class="alert alert-danger">
	<ul>
	@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
	</ul>
	</div>
@endif



<form action="{{url('pedidos/editar')}}" method="post" style="margin: 60px">

	<input type="hidden"
	name="_token" value="{{{ csrf_token() }}}" />
	
	<input type="hidden"
	name="id" value="{{ $r->id }}" />
	
	

	
	<div class="form-inline">
		<label>Cliente</label>
		<input  id="bcliente" name="bcliente" class="form-control" placeholder="Pesquisa: Nome ou COD" value="{{ str_replace(['.',',','/','-'], '',$r->cnpj_repres) }}" >
		<span><a  href="javascript:getClientes()"   class="glyphicon glyphicon-refresh" role="button" style="color:green"></a></span>
		<select id="cliente" name="cliente"   class="form-control" placeholder="Faça uma busca" required>
		</select>
			
	</div>
	
	<div class="form-inline ">
		<label>Transportadora</label>
		<input id="btrans" name="btrans" class="form-control" placeholder="Pesquisa: Nome ou COD" value="{{ str_replace(['.',',','/','-'], '',$r->cnpj_trans) }}"">
		<span><a  href="javascript:getTrans()"   class="glyphicon glyphicon-refresh" role="button" style="color:green"></a></span>
		<select id="trans" name="trans"   class="form-control" placeholder="Faça uma busca" required>
		</select>
			
	</div>
	
	<div class="form-inline ">
		<label>Representante</label>
		<input id="brepres" name="brepres" class="form-control" placeholder="Pesquisa: Nome ou COD" value="{{ str_replace(['.',',','/','-'], '',$r->cod_repres) }}">
		<span><a  href="javascript:getRepres()"   class="glyphicon glyphicon-refresh" role="button" style="color:green"></a></span>
		<select id="repres" name="repres"   class="form-control" placeholder="Faça uma busca" required>
		</select>
			
	</div>
	
	<div class="form-inline ">
		<label>Condição de Pgto</label>
		{{ $r->cond_pgto}}
		<input id="bcond" name="bcond" class="form-control" placeholder="Pesquisa: Des ou COD" value="{{ $r->cod_cond_pgto }}">
		<span><a  href="javascript:getCond()"   class="glyphicon glyphicon-refresh" role="button" style="color:green"></a></span>
		<select id="cond" name="cond"   class="form-control" placeholder="Faça uma busca" required>
		</select>
			
	</div>
	
	<div class="form-inline ">
		<label>Date de Entrega</label>
		<?php $entrega = ''; ?>
		@if (DateTime::createFromFormat('Y-m-d', $r->entrega) !== FALSE) 
			$entrega = date_format(date_create_from_format('d/m/Y', $r->entrega), 'Y-m-d');
		
		@elseif (DateTime::createFromFormat('d/m/Y', $r->entrega) !== FALSE) 
			$entrega = date_format(date_create_from_format('Y-m-d', $r->entrega), 'd/m/Y');
		@endif
		
		<input id="entrega" name="entrega" type="date" class="form-control" placeholder="Data " value="{{ $entrega }}" required>
		{{ $r->entrega }}
		</select>
			
	</div>
	
		<table  id="tabela" class="table table-striped table-bordered nowrap">
		<thead>
		<tr>
			<th>Qtd</th>
			<th>Codigo</th>
			<th>Descrição</th>
			<th>Uni Des</th>
			<th>Uni. Vend</th>
			<th>IPI</th>
			<th>C. Master</th>
			<th>Preço Tabela</th>
			<th>Pre. Des. Regional</th>
			<th>Pre. Negociado</th>
			<th>Pre. Final</th>
			<th>Total</th>
			<th></th>
			
			</tr>
		</thead>
		
	
		<tbody>
		@foreach ($ri as $l)
		<tr>
		<td>
			<input type="hidden" name="iditens[]" value="{{ $l->id }}" />
			<input id="qtd[]" name="qtd[]" value="{{$l->qtd}}" type="number" required>
		</td>
		<td>{{$l->cod_item}}</td>
		<td>{{$l->den_item}}</td>
		<td>{{$l->unid_venda_des}}</td>
		<td>{{$l->unid_venda}}</td>
		<td>{{$l->ipi}}</td>
		<td>{{$l->caixa_master}}</td>
		<td>{{$l->preco_tabela}}</td>
		<td>{{$l->preco_desc_reg}}</td>
		
		<?php 
		
		if($l->preco_negociado	< $l->preco_desc_reg) {
		      $pclass = 'p-3 mb-2 bg-danger text-white';
		} elseif($l->preco_negociado	> $l->preco_desc_reg){
		    $pclass = 'p-3 mb-2 bg-primary text-white';
		} else {
		    $pclass = 'p-3 mb-2 bg-success text-white';
		}
		
		
		  ?>
		
		<td><input class="{{ $pclass }}" id="preco_negociado[]" name="preco_negociado[]" value="{{$l->preco_negociado}}" type="number" step=".01" required></td>
		<td>{{$l->preco_final}}</td>
		<td>{{$l->total}}</td>
		<td>
		<a href="javascript:confirma_exclusao('{{action('PedidosController@removeritem', $l->id)}}')"><span class="glyphicon glyphicon-trash"></span></a>
		
		</td>
		
		</tr>
		@endforeach
		</tbody>
		</table>
	
	<button type="submit" class="btn btn-primary">Gravar</button>
	<span><a  href="{{ URL::previous() }}"   class="btn btn-primary" role="button" >Cancelar</a></span>

</form>

<script type="text/javascript">
getTrans();
getClientes();
getRepres()
getCond()
</script>


</div>
@stop
