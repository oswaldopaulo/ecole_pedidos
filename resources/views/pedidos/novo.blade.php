@extends('layouts.app')
@section('content')

<div class="panel panel-default" style="padding: 20px" >
<!-- Default panel contents -->
<div class="panel-heading" style="margin: 20px" ><h2>Novo Pedido </h2></div>

@if (!empty($errors->all())) 
	<div class="alert alert-danger">
	<ul>
	@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
	</ul>
	</div>
@endif



<form action="{{url('pedidos/novo')}}" method="post" style="margin: 60px">

	<input type="hidden"
	name="_token" value="{{{ csrf_token() }}}" />
	
	

	  {{ csrf_field() }}
					    <input type="hidden"
                        name="_token" value="{{{ csrf_token() }}}" />
					       <div class="form-group">
							   <label>	Selecione os pedodidos xls que deseja colocar</label>
							    <input type="file" name="arquivos[]" multiple class="form-control-file" aria-describedby="fileHelp"/>
							    <small id="fileHelp" class="form-text text-muted">Voce pode colocar variaos xls.</small>
							</div>
							   <button type="submit" class="btn btn-primary">Enviar</button>

</form>




</div>
@stop
