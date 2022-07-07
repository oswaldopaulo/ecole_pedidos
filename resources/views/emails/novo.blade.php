@extends('layouts.app')
@section('content')

<div class="panel panel-default" style="padding: 20px" >
<!-- Default panel contents -->
<div class="panel-heading" style="margin: 20px" ><h2>Novo Cadastro</h2></div>

@if (!empty($errors->all())) 
	<div class="alert alert-danger">
	<ul>
	@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
	</ul>
	</div>
@endif



<form action="{{url('emails/novo')}}" method="post" style="margin: 60px">

	<input type="hidden"
	name="_token" value="{{{ csrf_token() }}}" />
	
	

	<div class="form-group ">
		<label>Tipo</label>
		<select name="tipo" required>
              <option value="IMAP">IMAP</option>
              <option value="POP">POP</option>
         </select>
	</div>
	<div class="form-group ">
		<label>Servidor</label>
		<input id="servidor" name="servidor"  value="{{ old('servidor') }}" class="form-control" required>
		
		<label>Porta</label>
		<input id="porta" name="porta" value="{{ empty(old('porta'))?'993':old('porta') }}" class="form-control">
		
		
		
	</div>
	
	<div class="form-group " >
		<label>Caixa</label>
		<input id="caixa" name="caixa" value="{{ empty(old('caixa'))?'INBOX':old('caixa') }}" class="form-control" required>
	</div>
	
	<div class="form-group " >
		<label>E-mail</label>
		<input id="email" name="email" value="{{ old('email') }}" type="email" class="form-control" required>
	</div>
	
	<div class="form-group " >
		<label>Senha</label>
		<input id="senha" name="senha" type="password" class="form-control" required>
		
		<label>Confirma Senha</label>
		<input id="csenha" name="csenha" type="password" class="form-control" required>
	</div>
	
	<div class="form-group ">
				
		<label>Parametros</label>
		<input id="parametros" name="parametros"  value="{{ empty(old('parametros'))?'ssl/novalidate-cert/norsh':old('parametros') }}" class="form-control" required>
		
		<label>UID</label>
		<input id="uid" name="uid" value="{{ empty(old('uid'))?'0':old('uid') }}" class="form-control">
			
	</div>
	
	
	<button type="submit" class="btn btn-primary">Gravar</button>
	<span><a  href="{{ URL::previous() }}"   class="btn btn-primary" role="button" >Cancelar</a></span>

</form>




</div>
@stop
