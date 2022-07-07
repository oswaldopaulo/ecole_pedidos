@extends('layouts.app')
@section('content')
@include('layouts.datatable')
<script type="text/javascript">





</script>
<script type="text/javascript" src="{{ asset('/js/excluir.js')}}"></script>
<div class="panel panel-default" style="padding: 30px">
<!-- Default panel contents -->
<div class="panel-heading" style="margin: 10px" ><h2>Arquivos</h2></div>


@php 
$thead = explode(', ',"id, caminho, integrado, log"); 
$campos = explode(', ',"id, caminho, integrado, log"); 
@endphp


<input type="hidden"
	name="_token" value="{{{ csrf_token() }}}" />
<table  id="tabela" class="table table-striped table-bordered dt-responsive nowrap">
<thead>
<tr>
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


<a href="javascript:confirma_exclusao('{{action('PedidosController@removerarquivo', $r->id)}}')"><span class="glyphicon glyphicon-trash"></span></a>

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

</div>
@stop
