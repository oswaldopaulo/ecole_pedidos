@extends('layouts.app')
@section('content')
@include('layouts.datatable_check')
<script type="text/javascript">



function intregarlogix(){
	window.location="{{url('/pedidos/integrar')}}";
}






</script>
<script type="text/javascript" src="{{ asset('/js/excluir.js')}}"></script>
<div class="panel panel-default" style="padding: 30px">
<!-- Default panel contents -->
<div class="panel-heading" style="margin: 10px" ><h2>Pedidos checados</h2></div>
@if(!empty($sucess))
	<div class="alert alert-success" role="alert">
  	<h4 class="alert-heading"><strong>Pedidos Integrados</strong></h4>
  <p>@php echo $sucess @endphp</p>
</div>
@endif

@if(!empty($terros))
	<div class="alert alert-danger" role="alert">
  	<h4 class="alert-heading"><strong>Erros de consistencia</strong></h4>
  <p>@php echo $terros @endphp</p>
</div>
@endif
<h4>Pedidos ja checado mas ainda não integrado</h3>
@php 
$campos = explode(', ',"id, cliente, cidade, telefone, transportadora, cnpj_trans, cond_pgto, entrega, cod_repres, nome_repres, tel_repres, cnpj_repres, ie_repres, num_repres, bairro_repres, uf_repres, contato_repres, suframa, email, preco_base, tipo_desconto, regiao_uf, desconto_regiao, observacao, inf_adicional, dat_emissao, repres_num_pedido")
@endphp

<form id="envia" action="{{url('pedidos/envialogix')}}" method="post">
<input type="hidden"
	name="_token" value="{{{ csrf_token() }}}" />
<table  id="tabela" class="table table-striped table-bordered dt-responsive nowrap">
<thead>
<tr>
<th></th>

@foreach($campos as $c)
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
