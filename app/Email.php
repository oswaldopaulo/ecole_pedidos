<?php

namespace pedidos;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //
   protected $fillable=[
   		'tipo',
   		'servidor',
   		'porta',
   		'caixa',
   		'email',
   		'senha',
   		'parametros',
   		'uid',
   		'ativo'
   ];
}
