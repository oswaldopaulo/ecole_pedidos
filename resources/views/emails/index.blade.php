@extends('layouts.app')
@section('content')
@include('layouts.datatable')
<script type="text/javascript">

<!--
function novo(){
	window.location="{{url('/emails/novo')}}";
}
//-->
</script>
<script type="text/javascript" src="{{ asset('/js/excluir.js')}}"></script>
<div class="panel panel-default" style="padding: 30px">
<!-- Default panel contents -->
<div class="panel-heading" style="margin: 10px" ><h2>Emails</h2></div>


@if(old('nome_estado'))
	<div class="alert alert-success">
	<strong>Sucesso!</strong>
	O registo {{ old('nome_estado') }} foi gravado.
	</div>
@endif

<table  id="tabela" class="table table-striped table-bordered nowrap">
<thead>
<tr>
	<th>Tipo</th>
	<th>Servidor</th>
	<th>Porta</th>
	<th>Caixa</th>
	<th>E-mail</th>
	<th>Parametros</th>
	<th>Uid</th>
	<th>U. Atualização</th>
	<th>Status</th>
	<th></th>
	
	</tr>
</thead>

<tbody>
@foreach ($t as $r)
<tr>
<td>{{$r->tipo}}</td>
<td>{{$r->servidor}}</td>
<td>{{$r->porta}}</td>
<td>{{$r->caixa}}</td>
<td>{{$r->email}}</td>
<td>{{$r->parametros}}</td>
<td>{{$r->uid}}</td>
<td>{{$r->updated_at}}</td>
<td><a href="#" title="{{ $r->log . base64_decode($r->senha)}}"><span class="glyphicon glyphicon-info-sign" style="color: {{ $r->check==0?'red':'blue'}}"></span> {{substr($r->log,0,20)}} </a></td>
<td>
<a href="{{url('emails/check/'. $r->id)}}"><span class="glyphicon glyphicon-refresh"></span></a>
<a href="{{url('emails/editar/'. $r->id)}}"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="javascript:confirma_exclusao('{{action('EmailController@remover', $r->id)}}')"><span class="glyphicon glyphicon-trash"></span></a>

</td>

</tr>
@endforeach
</tbody>
</table>

</div>
@stop
