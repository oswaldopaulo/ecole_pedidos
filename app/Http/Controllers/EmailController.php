<?php

namespace pedidos\Http\Controllers;

use Request;
use pedidos\Email;
use pedidos\Http\Requests\EmailRequest;

class EmailController extends Controller
{
    //
    function index()
    {

        $t = Email::all();
        return view('emails/index')->with(['t' => $t]);

    }

    function novo()
    {
        return view('emails/novo');
    }

    function gravar(EmailRequest $r)
    {

        Email::Create([
            'tipo' => Request::input('tipo'),
            'servidor' => Request::input('servidor'),
            'porta' => Request::input('porta'),
            'caixa' => Request::input('caixa'),
            'email' => Request::input('email'),
            'senha' => base64_encode(Request::input('senha')),
            'parametros' => Request::input('parametros'),
            'uid' => Request::input('uid'),
            'ativo' => 1

        ]);

        return redirect()->action('EmailController@index');
    }

    function remover($id)
    {

        $r = Email::find($id);
        $r->delete();
        return redirect()->action('EmailController@index');
    }

    function editar($id)
    {
        $r = Email::find($id);
        return view('emails/editar')->with(['r' => $r]);
    }

    function update(EmailRequest $r)
    {

        if (!empty(Request::input('id'))) {

            $r = Email::find(Request::input('id'));
            $r->update([
                'tipo' => Request::input('tipo'),
                'servidor' => Request::input('servidor'),
                'porta' => Request::input('porta'),
                'caixa' => Request::input('caixa'),
                'email' => Request::input('email'),

                'parametros' => Request::input('parametros'),
                'uid' => Request::input('uid'),
                'ativo' => 1

            ]);


            if (!empty(Request::input('senha'))) {

                $r->update(['senha' => base64_encode(Request::input('senha'))]);

            }


            return redirect()->action('EmailController@index');

        }
    }

    function check($id)
    {
        $r = Email::find($id);
        $a = '{' . $r->servidor . ':' . $r->porta . '/' . $r->tipo . '/' . $r->parametros . '}' . $r->caixa;
        try {
            $mbox = imap_open($a, $r->email, base64_decode($r->senha)) or ($err =  imap_last_error());

            if(!empty($err)){
                return $err;
            }
        } catch (Exception $e) {
            return $e;
        } catch (ErrorException $e) {
            return $e;
        }
        return var_dump($mbox);
    }

}
