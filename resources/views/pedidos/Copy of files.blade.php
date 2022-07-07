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

	<th></th>
	
	</tr>
</thead>

<tbody>
@foreach ($t as $r)
<tr>
<td>XLS</td>
<td>{{ $r }}</td>

<td></td>

</tr>
@endforeach
</tbody>
</table>

</div>
@stop
