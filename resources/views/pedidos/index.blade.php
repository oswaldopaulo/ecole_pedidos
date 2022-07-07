@extends('layouts.app')
@section('content')
@include('layouts.datatable_pedidos')
<script type="text/javascript">

function novo(){
	window.location="{{url('/pedidos/novo')}}";
}

function envialogix(){
	document.getElementById("envia").submit();
}






</script>
<script type="text/javascript" src="{{ asset('/js/excluir.js')}}"></script>
<div class="panel panel-default" style="padding: 30px">
<!-- Default panel contents -->
<div class="panel-heading" style="margin: 10px" ><h2>Pedidos</h2></div>

@if(count($arq)>0)
	<div class="alert alert-warning">
	<h3>Arquivos recebido com problema (3 ultimos) </h3> <a href="{{ url('pedidos/arquivos') }}"> clique aqui para detalhes/todos </a>
	<p></p>
	<p>
	@foreach($arq as $arquivo)
		@php 
			$data = date('d/m/Y', strtotime($arquivo->created_at));
			echo "<a href=$arquivo->caminho><strong>$data</strong>  $arquivo->caminho</a><br>" ;
		@endphp	
	@endforeach
	</p>
	</div>
@endif

@php 
$thead = explode(', ',"id, D.Recebimento, C. Cliente, Nome cliente, C. trans, Transportadora, C. repres, Nome Repres, C.C Pgto, Cond pgto, Entrega, Observacao, Arquivo,  Cidade, Telefone, Tel Repres, Suframa, Email, Preco base, Tipo desconto, Regiao Uf, Desconto Regiao, Inf Adicional, Dat emissao, Repres num pedido");
$campos = explode(', ',"id, updated_at, cnpj_repres, cliente, cnpj_trans, transportadora, cod_repres, nome_repres, cod_cond_pgto, cond_pgto, entrega, observacao, arquivo, cidade, telefone, tel_repres, suframa, email, preco_base, tipo_desconto, regiao_uf, desconto_regiao, inf_adicional, dat_emissao, repres_num_pedido");
@endphp

<form id="envia" action="{{url('pedidos/envialogix')}}" method="post">
<input type="hidden"
	name="_token" value="{{{ csrf_token() }}}" />
<table  id="tabela" class="table table-striped table-bordered dt-responsive nowrap">
<thead>
<tr>
<th></th>
<th></th>
@foreach($thead as $c)
	<th>{{$c}}</th>
@endforeach
	
	
	</tr>
</thead>

<tbody>
@foreach ($t as $r)
<tr>

<td>

<a href="{{url('pedidos/editar/'. $r->id)}}"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="{{url('pedidos/detalhes/'. $r->id)}}"><span class="glyphicon glyphicon-search"></span></a>
<!--
 <a href="javascript:confirma_exclusao('{{action('PedidosController@remover', $r->id)}}')"><span class="glyphicon glyphicon-trash"></span></a>
  -->

</td>
<td><input id="id[]" type="checkbox" name="id[]" value="{{$r->id}}"></td>

@foreach($campos as $c)
<td>{{$r->$c}}</td>
@endforeach



</tr>
@endforeach
</tbody>
</table>
</form>
</div>
@stop
