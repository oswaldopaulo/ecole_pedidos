@extends('layouts.app')
@section('content')

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



<form action="{{url('emails/editar')}}" method="post" style="margin: 60px">

	<input type="hidden"
	name="_token" value="{{{ csrf_token() }}}" />
	
	<input type="hidden"
	name="id" value="{{ $r->id }}" />
	
	

	<div class="form-group ">
		<label>Tipo</label>
		<select name="tipo" required>
              <option value="IMAP">IMAP</option>
              <option value="POP">POP</option>
         </select>
	</div>
	<div class="form-group ">
		<label>Servidor</label>
		<input id="servidor" name="servidor"  value="{{ $r->servidor }}" class="form-control" required>
		
		<label>Porta</label>
		<input id="porta" name="porta" value="{{  $r->porta }}" class="form-control">
		
		
		
	</div>
	
	<div class="form-group " >
		<label>Caixa</label>
		<input id="caixa" name="caixa" value="{{  $r->caixa }}" class="form-control" required>
	</div>
	
	<div class="form-group " >
		<label>E-mail</label>
		<input id="email" name="email" value="{{  $r->email }}" type="email" class="form-control" required>
	</div>
	
	<div class="form-group " >
		<label>Senha</label>
		<input id="senha" name="senha" type="password" class="form-control">
		
		<label>Confirma Senha</label>
		<input id="csenha" name="csenha" type="password" class="form-control">
	</div>
	
	<div class="form-group ">
				
		<label>Parametros</label>
		<input id="parametros" name="parametros"  value="{{ $r->parametros }}" class="form-control" required>
		
		<label>UID</label>
		<input id="uid" name="uid" value="{{ $r->uid }}" class="form-control">
			
	</div>
	
	
	<button type="submit" class="btn btn-primary">Gravar</button>
	<span><a  href="{{ URL::previous() }}"   class="btn btn-primary" role="button" >Cancelar</a></span>

</form>




</div>
@stop
