@extends('layouts.app')
@section('content')
@include('layouts.datatable')
<script type="text/javascript">

<!--
function novo(){
	window.location="{{url('/pedidos/novo')}}";
}
//-->
</script>
<script type="text/javascript" src="{{ asset('/js/excluir.js')}}"></script>
<div class="panel panel-default" style="padding: 30px">
<!-- Default panel contents -->
<div class="panel-heading" style="margin: 10px" ><h2>Pedidos Item {{ $m->id }}</h2></div>

@if(old('nome_estado'))
	<div class="alert alert-success">
	<strong>Sucesso!</strong>
	O registo {{ old('nome_estado') }} foi gravado.
	</div>
@endif

@php 
$campos = explode(', ',"qtd, cod_item, descricao, unid_venda_des, unid_venda, ipi, caixa_master, preco_tabela, preco_desc_reg, preco_negociado, preco_final, total")
@endphp

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

<!--
 <a href="javascript:confirma_exclusao('{{action('PedidosController@remover', $r->id)}}')"><span class="glyphicon glyphicon-trash"></span></a>
  -->

</td>

@foreach($campos as $c)
<td>
  @if($c == 'preco_negociado' )
    	<div class="p-3 mb-2 bg-danger text-white">{{$c}}</div>
    @else
    	{{$c}}
    @endif

</td>
@endforeach



</tr>
@endforeach
</tbody>
</table>

</div>
@stop
